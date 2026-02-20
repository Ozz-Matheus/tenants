<?php

namespace App\Jobs;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BackupAllTenants implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Msg Temp : lazy() procesa en lotes pequeños mejorando el uso de RAM.
        Tenant::query()->lazy()->each(function (Tenant $tenant) {
            BackupTenantJob::dispatch($tenant);
        });
    }
}
