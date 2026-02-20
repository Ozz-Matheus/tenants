<?php

use App\Jobs\BackupAllTenants;
use App\Jobs\BackupCentral;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// PRODUCTION

// Respaldo para el central
// Schedule::job(new BackupCentral)->dailyAt('03:00');

// Respaldo para todos los tenants
// Schedule::job(new BackupAllTenants)->dailyAt('05:00');

// LOCAL

// Respaldo para el central
Schedule::job(new BackupCentral)->everyMinute()->withoutOverlapping();

// Respaldo para todos los tenants
Schedule::job(new BackupAllTenants)->everyMinute()->withoutOverlapping();
