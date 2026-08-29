<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==============================
// AUTH (LOGIN/REGISTER/LOGOUT)
// ==============================

Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UserAuthController::class, 'authenticate']);
Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

// ==============================
// USER ROUTES (REQUIRE LOGIN)
// ==============================

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/checkout-direct/{menu}', [CheckoutController::class, 'directCheckout'])->name('checkout.direct');

    Route::get('/payment', [CheckoutController::class, 'payment'])->name('payment');
    Route::post('/payment', [CheckoutController::class, 'processPayment'])->name('payment.process');

    Route::get('/riwayat-pesanan', [HomeController::class, 'orderHistory'])->name('order.history');
    Route::get('/order/{order}', [HomeController::class, 'orderDetail'])->name('order.detail');
});

// ==============================
// USER ROUTES (PUBLIC)
// ==============================

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');

Route::post('/cart/add/{menu}', [CartController::class, 'add'])->name('cart.add');

Route::get('/payment/success/{order}', [CheckoutController::class, 'success'])
    ->name('payment.success');

// ==============================
// LOGIN ADMIN (REDIRECT to unified login)
// ==============================

Route::redirect('/admin/login', '/login');

Route::post('/admin/login', [AdminAuthController::class, 'authenticate'])
    ->name('admin.login.post');

use Illuminate\Support\Facades\Auth;

// ==============================
// ADMIN (WAJIB LOGIN)
// ==============================

Route::middleware('admin.auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'index'])
            ->name('dashboard');

        // CRUD Menu
        Route::resource('menus', AdminMenuController::class);

        // Kelola Pesanan
        Route::resource('orders', OrderController::class)
            ->only([
                'index',
                'show',
                'update',
            ]);
    });

// ==============================
// DEBUG DATABASE
// (Boleh dihapus nanti jika project sudah selesai)
// ==============================

Route::get('/cek-db', function () {
    return [
        'env_database' => env('DB_DATABASE'),
        'env_username' => env('DB_USERNAME'),
        'env_password' => env('DB_PASSWORD'),
        'config_database' => config('database.connections.mysql.database'),
        'config_username' => config('database.connections.mysql.username'),
    ];
});
