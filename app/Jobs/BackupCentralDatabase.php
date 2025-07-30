<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class BackupCentralDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        \Log::info('🔄 Iniciando respaldo de base central...');

        $defaultConn = config('database.default');
        $dbName = config("database.connections.{$defaultConn}.database");

        Config::set('backup.backup.name', 'central-'.$dbName);

        DB::purge($defaultConn);
        DB::reconnect($defaultConn);

        Artisan::call('backup:run', [
            '--only-db' => true,
            '--disable-notifications' => true,
        ]);

        \Log::info("✅ Backup completado para base central: {$dbName}");
    }
}
