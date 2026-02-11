<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Mail\TenantCredentialsMail;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Stancl\Tenancy\Jobs\MigrateDatabase;
use Stancl\Tenancy\Jobs\SeedDatabase;

class TenantCreatorService
{
    /**
     * Flujo completo para crear o importar un Tenant.
     */
    public static function create(array $data): Tenant
    {
        // 1. CREACIÓN DEL REGISTRO
        $tenant = DB::transaction(function () use ($data) {

            // Instanciamos
            $tenant = new Tenant;

            if (isset($data['id'])) {
                $tenant->id = $data['id'];
                $tenant->created_at = now()->toDateTimeString();
                $tenant->updated_at = now()->toDateTimeString();
                $tenant->tenancy_db_name = $data['id'];
            }

            // Llenamos datos básicos
            $tenant->fill(collect($data)->except(['domain', 'link_existing_db'])->toArray());

            // Guardamos silenciosamente
            // Esto evita conflictos con el paquete tenacy
            $tenant->saveQuietly();

            $tenant->domains()->create(['domain' => $data['domain']]);

            return $tenant;

        });

        // 2. Preparamos la base de datos del Tenant (Admin, Migraciones, etc.)
        try {
            self::setup(
                $tenant,
                runMigrations: true,
                runSeeds: true
            );
        } catch (\Throwable $e) {
            // Rollback manual si falla el setup
            $tenant->delete();
            Log::critical("Fallo setup Tenant {$tenant->id}: {$e->getMessage()}");
            throw $e;
        }

        return $tenant;
    }

    /**
     * Configuración del entorno del Tenant
     */
    public static function setup(

        Tenant $tenant,
        bool $runMigrations = true,
        bool $runSeeds = true

    ): void {

        // --- A. MIGRACIONES ---
        if ($runMigrations) {

            dispatch_sync(new MigrateDatabase($tenant));

        }

        // --- B. SEEDERS ---
        $tenant->run(function () use ($tenant, $runSeeds) {

            if ($runSeeds) {

                dispatch_sync(new SeedDatabase($tenant));
            }

            self::createSuperAdmin($tenant);

        });
    }

    /**
     * Crea o actualiza el Super Admin del sistema dentro del Tenant.
     */
    protected static function createSuperAdmin(Tenant $tenant): void
    {
        $superAdminMail = config('holdingtec.super_admin.email');
        $envPassword = config('holdingtec.super_admin.password');

        // Determina si se debe usar la contraseña del .env (solo en local y si existe)
        $useEnvPassword = app()->isLocal() && ! empty($envPassword);

        $superAdminPass = $useEnvPassword ? $envPassword : Str::random(16);

        $superAdmin = User::updateOrCreate(
            ['email' => $superAdminMail],
            [
                'name' => 'Tenant Admin',
                'password' => bcrypt($superAdminPass),
                'email_verified_at' => now(),
            ]
        );

        $superAdmin->assignRole(RoleEnum::SUPER_ADMIN);

        // Token de reset
        $token = Password::broker()->createToken($superAdmin);

        // 1. Obtenemos el subdominio guardado (ej: 'ocaso')
        $subdomain = $tenant->domains->first()->domain;

        // 2. Obtenemos el dominio central de la config (ej: 'holdingtec.test')
        $centralDomain = config('holdingtec.central_domain') ?? request()->getHost();

        // 3. Construimos el FQDN (Fully Qualified Domain Name) -> ocaso.holdingtec.test
        $fullDomain = $subdomain.'.'.$centralDomain;

        $resetUrl = tenant_route($fullDomain, 'password.reset', [
            'token' => $token,
            'email' => $superAdminMail,
        ]);

        // En producción: siempre envía el correo.
        // En local: solo si NO hay contraseña definida en el .env.
        if (app()->isProduction() || (app()->isLocal() && empty($envPassword))) {
            try {
                Mail::to($superAdminMail)->send(
                    new TenantCredentialsMail($tenant->name, $resetUrl)
                );
            } catch (\Throwable $e) {
                Log::warning("No se pudo enviar correo al SuperAdmin: {$e->getMessage()}");
            }
        }
    }
}
