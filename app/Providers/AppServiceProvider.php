<?php

namespace App\Providers;

use App\Models\Tenant;
use App\Observers\TenantObserver;
use App\Services\TenantStorageInitializer;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Stancl\Tenancy\Events\TenancyBootstrapped;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $centralDomains = config('tenancy.central_domains', []);

        if (! in_array(request()->getHost(), $centralDomains)) {

            Livewire::setUpdateRoute(function ($handle) {
                return Route::post('/livewire/update', $handle)
                    ->middleware([
                        'web',
                        InitializeTenancyBySubdomain::class,
                    ]);
            });
        }

        Tenant::observe(TenantObserver::class);

        Event::listen(TenancyBootstrapped::class, function ($event) {

            $tenantId = tenant()?->getTenantKey();

            if (! $tenantId) {
                return;
            }

            app(TenantStorageInitializer::class)->ensureStorageStructure($tenantId);
        });

    }
}
