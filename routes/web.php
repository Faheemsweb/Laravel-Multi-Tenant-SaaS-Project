<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\Landlord\landlordController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\Auth\LoginController;
use App\Http\Controllers\welcome\welcome;
use Spatie\Multitenancy\Http\Middleware\NeedsTenant;
use Spatie\Multitenancy\Http\Middleware\EnsureValidTenantSession;
use App\Http\Middleware\CheckTenantStatus;

// public routes for welcome and onboarding
Route::domain(config('app.domain', 'myapp.test'))->group(function () {

    Route::get('/', [welcome::class, 'index'])->name('welcome');
    Route::get('/about', [welcome::class, 'about'])->name('about');
    Route::get('/privacy', [welcome::class, 'privacy'])->name('privacy');
    Route::get('/terms', [welcome::class, 'terms'])->name('terms');

    Route::get('/showStep1', [OnboardingController::class, 'showStep1'])->name('onboarding.step1.show');
    Route::post('/showStep1', [OnboardingController::class, 'storeStep1'])->name('onboarding.step1.store');

    Route::get('/step-2', [OnboardingController::class, 'showStep2'])->name('onboarding.step2.show');
    Route::post('/step-2', [OnboardingController::class, 'storeStep2'])->name('onboarding.step2.store');

    Route::get('/step-3', [OnboardingController::class, 'showStep3'])->name('onboarding.step3.show');
    Route::post('/step-3', [OnboardingController::class, 'storeStep3'])->name('onboarding.step3.store');

    Route::get('/step-4', [OnboardingController::class, 'showStep4'])->name('onboarding.step4.show');
    Route::post('/step-4', [OnboardingController::class, 'storeStep4'])->name('onboarding.step4.store');

    Route::get('/step-5', [OnboardingController::class, 'showStep5'])->name('onboarding.step5.show');
    Route::post('/step-5', [OnboardingController::class, 'storeStep5'])->name('onboarding.step5.store');

    Route::get('/provisioning', [OnboardingController::class, 'provisioning'])->name('onboarding.provisioning');
});

/*
|--------------------------------------------------------------------------
| Landlord Domain: Admin Panel (No Tenant Context)
|--------------------------------------------------------------------------
*/
Route::domain('landlord.' . config('app.domain', 'myapp.test'))
    ->group(function () {
        Route::middleware(['auth:landlord'])->group(function () {
            Route::get('/', [landlordController::class, 'index'])->name('dashboard');
            Route::post('/tenants/{tenant}/status', [landlordController::class, 'updateStatus'])->name('landlord.tenants.status');
            Route::delete('/tenants/{tenant}', [landlordController::class, 'destroy'])->name('landlord.tenants.destroy');
            Route::post('logout', [landlordController::class, 'logout'])->name('logout');
        });

        // Guest landlord routes
        Route::middleware(['guest:landlord'])->group(function () {
            Route::get('login', [landlordController::class, 'showLoginForm'])->name('login');
            Route::post('login', [landlordController::class, 'login']);
        });
    });

/*
|--------------------------------------------------------------------------
| Tenant Domain: Tenant Environment (Actual App)
|--------------------------------------------------------------------------
*/
Route::domain('{tenant}.' . config('app.domain', 'myapp.test'))
    ->middleware([
        'web',
        NeedsTenant::class,
        CheckTenantStatus::class,
    ])
    ->name('tenant.')
    ->group(function () {

        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

        Route::post('/login', [LoginController::class, 'login'])->name('login.store');

        // Authenticated tenant routes
        Route::middleware(['auth', EnsureValidTenantSession::class])->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        });
    });
