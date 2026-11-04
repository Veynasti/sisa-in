<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminMerchantController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MerchantProductController;

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

        // Dashboard
        Route::get('/dashboard', function () {
            return view('merchant.dashboard');
        })->name('dashboard');

        // Manajemen Produk
        Route::get('/products', [MerchantProductController::class, 'index'])
            ->name('products.index');

        Route::get('/products/create', [MerchantProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [MerchantProductController::class, 'store'])
            ->name('products.store');

        Route::get('/products/{product}/edit', [MerchantProductController::class, 'edit'])
            ->name('products.edit');

        Route::put('/products/{product}', [MerchantProductController::class, 'update'])
            ->name('products.update');

        Route::delete('/products/{product}', [MerchantProductController::class, 'destroy'])
            ->name('products.destroy');

    });


// ==================================================
// ADMIN
// ==================================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Daftar dan Verifikasi Merchant
        Route::get('/merchants', [AdminMerchantController::class, 'index'])
            ->name('merchants.index');

        // Proses persetujuan atau penolakan merchant
        Route::patch('/merchants/{merchant}/verification', [AdminMerchantController::class, 'updateStatus'])
            ->name('merchants.update-status');

    });
