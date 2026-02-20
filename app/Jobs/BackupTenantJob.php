<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Traits\LogsToSchedulerFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BackupTenantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, LogsToSchedulerFile, Queueable, SerializesModels;

    public function __construct(
        public Tenant $tenant
    ) {}

    public function handle(): void
    {
        // Declaramos la variable del directorio de los backups.
        $tempDirectoryTenant = '';

        try {
            // Pasamos la variable por referencia (&$tempDirectoryTenant) al closure.
            $this->tenant->run(function () use (&$tempDirectoryTenant) {

                // 1. Configurar nombres para el backup.
                $identifier = $this->tenant->id;
                $backupName = 'tenant-'.$identifier;
                $connection = config('holdingtec.db_connection', 'mysql');

                $tempDirectoryTenant = storage_path("app/backup-temp/{$backupName}");

                // Configuración del backup.
                config([
                    "database.connections.{$connection}.database" => $identifier,
                    'backup.backup.name' => $backupName,
                    'backup.backup.temporary_directory' => $tempDirectoryTenant,
                ]);

                // 2. Ejecutar Backup.
                Artisan::call('backup:run', [
                    '--only-db' => true, // Respalda BD sin los archivos.
                    '--disable-notifications' => true,
                ]);

                // 3. Log Exitoso.
                $this->logToSchedulerFile(
                    "✅ Backup completado para [{$identifier}]",
                    'backup-tenants.log'
                );

            });

        } catch (\Exception $e) {
            // 4. Log de Error.
            $this->logToSchedulerFile(
                "⚠️ ERROR Backup tenant {$this->tenant->id}: ".$e->getMessage(),
                'backup-tenants.log'
            );
        } finally {
            // Limpieza por si quedan carpetas vacías tras el backup.
            if ($tempDirectoryTenant !== '') {
                File::deleteDirectory($tempDirectoryTenant);
            }
        }
    }
}
