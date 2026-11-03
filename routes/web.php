<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminMerchantController;

// ==================================================
// HALAMAN UTAMA
// ==================================================

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->role) {
        'merchant' => redirect()->route('merchant.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        default => redirect()->route('dashboard'),
    };
});


// ==================================================
// AUTHENTICATION
// ==================================================

// Login
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ==================================================
// CUSTOMER
// ==================================================

Route::middleware(['auth', 'role:customer'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});


// ==================================================
// MERCHANT
// ==================================================

Route::middleware(['auth', 'role:merchant'])
    ->prefix('merchant')
    ->name('merchant.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('merchant.dashboard');
        })->name('dashboard');

    });


// ==================================================
// ADMIN
// ==================================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', function () {
            return 'Dashboard Admin akan dibuat.';
        })->name('dashboard');

        // Daftar dan Verifikasi Merchant
        Route::get('/merchants', [AdminMerchantController::class, 'index'])
            ->name('merchants.index');

        // Proses persetujuan atau penolakan merchant
        Route::patch('/merchants/{merchant}/verification', [AdminMerchantController::class, 'updateStatus'])
            ->name('merchants.update-status');

    });
