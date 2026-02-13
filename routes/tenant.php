<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\Files\FileServeController;
use App\Livewire\Auth\ResetPassword;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyBySubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // Route::get('/', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is '.tenant('id');
    // });

    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');

    Route::get('/secure-files/{file}', [FileServeController::class, 'show'])
        ->name('files.secure.show')
        ->middleware('signed');

});
