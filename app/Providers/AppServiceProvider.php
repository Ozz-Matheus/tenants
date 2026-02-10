<?php

namespace App\Providers;

use App\Models\Tenant;
use App\Observers\TenantObserver;
use App\Services\TenantStorageInitializer;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Spatie\Permission\PermissionRegistrar;
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

        Filament::serving(function () {

            if ($user = auth()->user()) {

                $panelId = Filament::getCurrentPanel()->getId();
                $cacheKey = "spatie.permission.cache.{$panelId}.user.{$user->getAuthIdentifier()}";

                // Esto evita lecturas obsoletas del cache anterior
                app(PermissionRegistrar::class)->forgetCachedPermissions();

                // Esto asegura un cache aislado por panel + user
                app(PermissionRegistrar::class)->cacheKey = $cacheKey;
            }

        });

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
