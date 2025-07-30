<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use TomatoPHP\FilamentTenancy\Models\Tenant;

class BackupAllTenants implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $originalDatabase;

    protected ?string $originalBackupName;

    public function handle(): void
    {
        \Log::info('🔄 Iniciando BackupAllTenants Job desde schedule:run');

        $defaultConn = config('database.default');
        $this->originalDatabase = config("database.connections.{$defaultConn}.database");
        $this->originalBackupName = config('backup.backup.name');

        $tenants = Tenant::all();
        \Log::info('🧾 Cantidad de tenants encontrados: '.$tenants->count());

        $tenants->each(function ($tenant) use ($defaultConn) {
            try {
                $this->backupTenant($tenant, $defaultConn);
            } catch (\Throwable $e) {
                \Log::error("❌ Error al respaldar el tenant [{$tenant->id}]: {$e->getMessage()}");
            } finally {
                $this->clearTenantContext();
            }
        });

        // Restaurar conexión original
        Config::set("database.connections.{$defaultConn}.database", $this->originalDatabase);
        Config::set('backup.backup.name', $this->originalBackupName);
        DB::purge($defaultConn);

        \Log::info('✅ BackupAllTenants Job finalizado.');
    }

    protected function backupTenant(Tenant $tenant, string $defaultConn): void
    {
        $dbName = $tenant->tenancy_db_name ?? $tenant->database ?? $tenant->id;

        if (! $dbName || ! $this->tenantDbExists($dbName)) {
            \Log::warning("🚫 Base de datos no válida para tenant: {$tenant->id}");

            return;
        }

        $this->initializeTenantContext($tenant);

        Config::set("database.connections.{$defaultConn}.database", $dbName);
        DB::purge($defaultConn);
        DB::reconnect($defaultConn);

        Config::set('backup.backup.name', 'tenant-'.$dbName);

        Artisan::call('backup:run', [
            '--only-db' => true,
            '--disable-notifications' => true,
        ]);

        \Log::info("✅ Backup completado para tenant: {$dbName}");
    }

    protected function tenantDbExists(string $dbName): bool
    {
        return collect(DB::select("SHOW DATABASES LIKE '".addslashes($dbName)."'"))->isNotEmpty();
    }

    protected function initializeTenantContext(Tenant $tenant): void
    {
        App::forgetInstance('tenant');
        App::instance('tenant', $tenant);
        Config::set('tenancy.tenant', $tenant);
    }

    protected function clearTenantContext(): void
    {
        App::forgetInstance('tenant');
        Config::offsetUnset('tenancy.tenant');
    }
}
