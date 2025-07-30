<?php

use App\Jobs\BackupAllTenants;
use App\Jobs\BackupCentral;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('notify:action-deadlines')->dailyAt('08:00');
Schedule::command('notify:task-deadlines')->dailyAt('08:10');

// Respaldo para el central
Schedule::job(new BackupCentral)->dailyAt('03:00');

// Respaldo para todos los tenants
Schedule::job(new BackupAllTenants)->dailyAt('05:00');

/* --------------------------------------------------------------- */

// Test Backup Central
// Schedule::job(new BackupCentral)->everyMinute();

// Test Backup All Tenants Database
// Schedule::job(new BackupAllTenants)->everyMinute();

/* --------------------------------------------------------------- */
