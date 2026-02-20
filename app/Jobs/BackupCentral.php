<?php

namespace App\Jobs;

use App\Traits\LogsToSchedulerFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BackupCentral implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, LogsToSchedulerFile, Queueable, SerializesModels;

    public function handle(): void
    {
        // Declaramos la variable del directorio de los backups.
        $tempDirectoryCentral = '';

        try {
            // Pasamos la variable por referencia (&$tempDirectoryCentral) al closure.
            $connection = config('holdingtec.db_connection', 'mysql');

            // 1. Configurar nombres para el backup en Central.
            $dbName = config("database.connections.{$connection}.database");
            $backupName = 'central-'.$dbName;

            $tempDirectoryCentral = storage_path("app/backup-temp/{$backupName}");

            // Configuración del backup.
            config([
                'backup.backup.name' => $backupName,
                'backup.backup.temporary_directory' => $tempDirectoryCentral,
            ]);

            // 2. Ejecutar Backup.
            Artisan::call('backup:run', [
                '--only-db' => false, // Respalda BD y archivos.
                '--disable-notifications' => true,
            ]);

            // 3. Log Exitoso.
            $this->logToSchedulerFile(
                "✅ Backup Central [{$dbName}] completado",
                'backup-central.log'
            );

        } catch (\Exception $e) {
            // 4. Log de Error.
            $this->logToSchedulerFile(
                '⚠️ ERROR Backup Central: '.$e->getMessage(),
                'backup-central.log'
            );
        } finally {
            // Limpieza por si quedan carpetas vacías tras el backup en Central.
            if ($tempDirectoryCentral !== '') {
                File::deleteDirectory($tempDirectoryCentral);
            }
        }
    }
}
