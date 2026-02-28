<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\ApplicationManagementController;
use App\Http\Controllers\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeviceManagementController;
use App\Http\Controllers\Admin\DocumentationController;
use App\Http\Controllers\Admin\LicenseManagementController;
use App\Http\Controllers\Admin\PlanManagementController;
use App\Http\Controllers\Admin\SerialManagementController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PublicController::class, 'companyProfile'])->name('public.home');
Route::redirect('/company-profile', '/');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'show'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'store'])
            ->middleware('throttle:admin-login')
            ->name('login.store');

        Route::get('/forgot-password', [AdminForgotPasswordController::class, 'showLinkRequestForm'])
            ->name('password.request');
        Route::post('/forgot-password', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('password.email');
        Route::get('/reset-password/{token}', [AdminResetPasswordController::class, 'showResetForm'])
            ->name('password.reset');
        Route::post('/reset-password', [AdminResetPasswordController::class, 'reset'])
            ->name('password.update');
    });

    Route::middleware(['auth:admin', 'admin.active'])->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');

        Route::get('/dashboard', DashboardController::class)
            ->middleware('can:view-dashboard')
            ->name('dashboard');

        Route::get('/docs', DocumentationController::class)
            ->middleware('can:view-docs')
            ->name('docs');

        Route::get('/admins', [AdminManagementController::class, 'index'])
            ->middleware('can:manage-admins')
            ->name('admins.index');
        Route::post('/admins', [AdminManagementController::class, 'store'])
            ->middleware('can:manage-admins')
            ->name('admins.store');
        Route::put('/admins/{admin}', [AdminManagementController::class, 'update'])
            ->middleware('can:manage-admins')
            ->name('admins.update');

        Route::get('/applications', [ApplicationManagementController::class, 'index'])
            ->middleware('can:manage-applications')
            ->name('applications.index');
        Route::post('/applications', [ApplicationManagementController::class, 'store'])
            ->middleware('can:manage-applications')
            ->name('applications.store');
        Route::put('/applications/{application}', [ApplicationManagementController::class, 'update'])
            ->middleware('can:manage-applications')
            ->name('applications.update');
        Route::post('/applications/{application}/rotate-token', [ApplicationManagementController::class, 'rotateToken'])
            ->middleware('can:manage-applications')
            ->name('applications.rotate-token');
        Route::post('/applications/{application}/reveal-token', [ApplicationManagementController::class, 'revealToken'])
            ->middleware('can:manage-applications')
            ->name('applications.reveal-token');

        Route::get('/plans', [PlanManagementController::class, 'index'])
            ->middleware('can:manage-plans')
            ->name('plans.index');
        Route::post('/plans', [PlanManagementController::class, 'store'])
            ->middleware('can:manage-plans')
            ->name('plans.store');
        Route::put('/plans/{plan}', [PlanManagementController::class, 'update'])
            ->middleware('can:manage-plans')
            ->name('plans.update');

        Route::get('/serials', [SerialManagementController::class, 'index'])
            ->middleware('can:manage-serials')
            ->name('serials.index');
        Route::post('/serials/generate', [SerialManagementController::class, 'generate'])
            ->middleware('can:manage-serials')
            ->name('serials.generate');
        Route::post('/serials/{serial}/reveal', [SerialManagementController::class, 'reveal'])
            ->middleware('can:manage-serials')
            ->name('serials.reveal');
        Route::post('/serials/{serial}/void', [SerialManagementController::class, 'void'])
            ->middleware('can:manage-serials')
            ->name('serials.void');

        Route::get('/licenses', [LicenseManagementController::class, 'index'])
            ->middleware('can:manage-licenses')
            ->name('licenses.index');
        Route::get('/licenses/{license}', [LicenseManagementController::class, 'show'])
            ->middleware('can:manage-licenses')
            ->name('licenses.show');
        Route::post('/licenses/{license}/toggle-revoke', [LicenseManagementController::class, 'toggleRevoke'])
            ->middleware('can:manage-licenses')
            ->name('licenses.toggle-revoke');

        Route::post('/devices/{deviceBinding}/deactivate', [DeviceManagementController::class, 'deactivate'])
            ->middleware('can:manage-devices')
            ->name('devices.deactivate');
    });
});
