<?php

use App\Http\Controllers\Api\V1\BlaskuLandingPublicController;
use App\Http\Controllers\Api\V1\LicenseController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/ping', fn () => response()->json([
    'ok' => true,
    'time' => now()->toISOString(),
]));

Route::prefix('v1/licenses')
    ->middleware(['resolve.application'])
    ->group(function () {
        Route::post('/activate', [LicenseController::class, 'activate'])
            ->middleware('throttle:license-critical');
        Route::post('/trial', [LicenseController::class, 'trial'])
            ->middleware('throttle:license-critical');

        Route::middleware(['auth.license'])->group(function () {
            Route::get('/status', [LicenseController::class, 'status']);
            Route::post('/renew', [LicenseController::class, 'renew'])
                ->middleware('throttle:license-critical');
            Route::post('/devices/deactivate', [LicenseController::class, 'deactivateDevice']);
            Route::get('/devices', [LicenseController::class, 'devices']);
        });
    });

Route::prefix('api/v1/public')->group(function () {
    Route::get('/pricing-plans', [BlaskuLandingPublicController::class, 'pricingPlans']);
    Route::get('/installer', [BlaskuLandingPublicController::class, 'installer']);
    Route::get('/trial', [BlaskuLandingPublicController::class, 'trial']);
    Route::get('/contact', [BlaskuLandingPublicController::class, 'contact']);
});
