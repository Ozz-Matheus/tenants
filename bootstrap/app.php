<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            $centraldomain = config('tenancy.central_domains');

            foreach ($centraldomain as $domain) {

                Route::middleware('web')
                    ->domain($domain)
                    ->group(base_path('routes/web.php'));
            }

            Route::middleware('web')->group(base_path('routes/tenant.php'));

        },

        commands: __DIR__.'/../routes/console.php',
        health: '/up',

    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->group('universal', []);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
