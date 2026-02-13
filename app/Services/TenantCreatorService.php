<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Mail\TenantCredentialsMail;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Stancl\Tenancy\Jobs\CreateDatabase;
use Stancl\Tenancy\Jobs\MigrateDatabase;
use Stancl\Tenancy\Jobs\SeedDatabase;

class TenantCreatorService
{
    /**
     * Flujo completo para crear o importar un Tenant.
     */
    public static function create(array $data): Tenant
    {
        $linkExistingDb = $data['link_existing_db'] ?? false;

        // Si NO vamos a vincular una Db (es local/VPS), entonces debemos crear el contenedor físico.
        // Si SÍ vinculamos ( Hosting ), el contenedor ya existe (vacío).
        $shouldCreateDb = ! $linkExistingDb;

        // 1. CREACIÓN DEL REGISTRO
        $tenant = DB::transaction(function () use ($data, $linkExistingDb) {

            // Validación para conservar o encriptar el ID del tenant.
            $tenantId = $linkExistingDb ? $data['id'] : Str::uuid()->toString();

            // Instanciamos
            $tenant = new Tenant;

            // Agregamos los identificadores y el usuario que es dueño del tenant.
            $tenant->id = $tenantId;
            $tenant->owner_by_id = auth()->id();

            // Llenamos datos básicos excluyendo los calculados y el Toggle 'link_existing_db'
            $tenant->fill(collect($data)->except(['id', 'domain', 'link_existing_db'])->toArray());

            // Se asignan los metadatos necesarios para el campo tipo array data.
            $now = now();
            $tenant->tenancy_db_name = $tenantId;
            $tenant->created_at = $now;
            $tenant->updated_at = $now;

            // Guardamos silenciosamente
            // Esto evita conflictos con el paquete tenacy
            $tenant->saveQuietly();

            // Guardamos la relación de dominio en nuestro caso, subdominio.
            $tenant->domains()->create(['domain' => $data['domain']]);

            Log::info("Tenant {$tenant->id} creado. DB Existente: ".($linkExistingDb ? 'SÍ' : 'NO'));

            return $tenant;

        });

        // 2. Preparamos la base de datos del Tenant
        try {
            self::setup($tenant, createDatabase: $shouldCreateDb);

        } catch (\Throwable $e) {
            // Rollback manual si falla el setup
            $tenant->deleteQuietly();
            Log::critical("Fallo setup Tenant {$tenant->id}: {$e->getMessage()}");
            throw $e;
        }

        return $tenant;
    }

    /**
     * Configuración del entorno del Tenant
     */
    public static function setup(Tenant $tenant, bool $createDatabase = true): void
    {
        // --- A. CREATE DATABASE (Solo si aplica) ---
        if ($createDatabase) {
            dispatch_sync(new CreateDatabase($tenant));
        }

        // --- B. MIGRACIONES ---
        // Se ejecuta siempre porque la regla es que la DB viene vacía.
        dispatch_sync(new MigrateDatabase($tenant));

        // --- C. SEEDERS ---
        // Se ejecuta siempre para crear roles y el Admin inicial.
        $tenant->run(function () use ($tenant) {

            dispatch_sync(new SeedDatabase($tenant));

            self::createAdminTenant($tenant);
        });
    }

    /**
     * Crea o actualiza el Admin del Tenant.
     */
    protected static function createAdminTenant(Tenant $tenant): void
    {
        // Guardamos en variables para mayor claridad
        $tenantName = $tenant->name;
        $mail = config('holdingtec.admin.email');
        $envPassword = config('holdingtec.admin.password');

        // Determina si se debe usar la contraseña del .env (solo en local y si existe)
        $useEnvPassword = app()->isLocal() && ! empty($envPassword);
        $password = $useEnvPassword ? $envPassword : Str::random(16);

        // Creamos el usuario
        $adminTenant = User::firstOrCreate(
            ['email' => $mail],
            [
                'name' => $tenantName ? 'Admin: '.$tenantName : 'Tenant Admin',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        // Asignamos el rol con las capacidades necesarias.
        $adminTenant->assignRole(RoleEnum::SUPER_ADMIN);

        // Token de reset
        $token = Password::broker()->createToken($adminTenant);

        // 1. Obtenemos el subdominio guardado (ej: 'ocaso')
        $subdomain = $tenant->domains->first()->domain;

        // 2. Obtenemos el dominio central de la config (ej: 'holdingtec.test')
        $centralDomain = config('holdingtec.central_domain') ?? request()->getHost();

        // 3. Construimos dominio completo -> ocaso.holdingtec.test
        $fullDomain = $subdomain.'.'.$centralDomain;

        // 4. Armamos la URL que se enviará vía correo electrónico.
        $resetUrl = tenant_route($fullDomain, 'password.reset', [
            'token' => $token,
            'email' => $mail,
        ]);

        // En producción: siempre envía el correo.
        // En local: solo si NO hay contraseña definida en el .env.
        if (app()->isProduction() || (app()->isLocal() && empty($envPassword))) {
            try {
                Mail::to($mail)->send(
                    new TenantCredentialsMail($tenantName, $resetUrl)
                );
            } catch (\Throwable $e) {
                Log::warning("No se pudo enviar la notificación para acceder al tenant: {$e->getMessage()}");
            }
        }
    }
}
