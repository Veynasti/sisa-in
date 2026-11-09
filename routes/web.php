<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminMerchantController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MerchantProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MerchantQrisController;
use App\Http\Controllers\MerchantOrderController;
use App\Http\Controllers\MerchantDashboardController;


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

Route::middleware('guest')->group(function () {

    // Login
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

    // ----------------------------------------------
    // DASHBOARD DAN KATALOG
    // ----------------------------------------------

    Route::get('/dashboard', [CustomerController::class, 'index'])
        ->name('dashboard');


    // ----------------------------------------------
    // PEMESANAN PRODUK
    // ----------------------------------------------

    Route::get('/pesan/{productId}', [CustomerOrderController::class, 'create'])
        ->name('orders.create');

    Route::post('/pesan/{productId}', [CustomerOrderController::class, 'store'])
        ->name('orders.store');


    // ----------------------------------------------
    // PESANAN SAYA
    // ----------------------------------------------

    Route::get('/pesanan', [CustomerOrderController::class, 'index'])
        ->name('orders.index');


    // ----------------------------------------------
    // PEMBAYARAN
    // ----------------------------------------------

    // Halaman pilihan metode pembayaran
    Route::get('/pesanan/{orderId}/pembayaran', [PaymentController::class, 'method'])
        ->name('payments.method');

    // Menyimpan pilihan metode pembayaran
    Route::post('/pesanan/{orderId}/pembayaran', [PaymentController::class, 'storeMethod'])
        ->name('payments.store-method');

    // Mengunggah bukti pembayaran QRIS
    Route::post('/pesanan/{orderId}/pembayaran/bukti', [PaymentController::class, 'uploadProof'])
        ->name('payments.upload-proof');

});


// ==================================================
// MERCHANT
// ==================================================

Route::middleware(['auth', 'role:merchant'])
    ->prefix('merchant')
    ->name('merchant.')
    ->group(function () {

        // ------------------------------------------
        // DASHBOARD
        // ------------------------------------------
        Route::get('/dashboard', [MerchantDashboardController::class, 'index'])
            ->name('dashboard');

        // ------------------------------------------
        // PENGATURAN QRIS
        // ------------------------------------------

        Route::get('/qris', [MerchantQrisController::class, 'index'])
            ->name('qris.index');

        Route::post('/qris', [MerchantQrisController::class, 'store'])
            ->name('qris.store');

        // Pesanan Merchant
        Route::get('/pesanan', [MerchantOrderController::class, 'index'])
            ->name('orders.index');

        Route::post('/pesanan/{orderId}/konfirmasi-pembayaran', [MerchantOrderController::class, 'confirmPayment'])
            ->name('orders.confirm-payment');

        // ------------------------------------------
        // MANAJEMEN PRODUK
        // ------------------------------------------

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

        // ------------------------------------------
        // DASHBOARD
        // ------------------------------------------

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');


        // ------------------------------------------
        // VERIFIKASI MERCHANT
        // ------------------------------------------

        Route::get('/merchants', [AdminMerchantController::class, 'index'])
            ->name('merchants.index');

        Route::patch('/merchants/{merchant}/verification', [AdminMerchantController::class, 'updateStatus'])
            ->name('merchants.update-status');

    });
