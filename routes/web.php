<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Middleware\islogin;

// Public Routes
Route::get('/', [LandingController::class, 'index'])->name('index');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware([islogin::class.':admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Owner Routes
Route::get('/owner/dashboard', fn() => 'Owner Dashboard')->middleware('auth')->name('owner.dashboard');

// Shared Admin/Owner Routes
Route::middleware([islogin::class.':admin,owner'])->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.simpan');
    Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{id}/update', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}/delete', [MenuController::class, 'destroy'])->name('menu.hapus');
});

// Customer Routes
Route::middleware([islogin::class.':customer'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');
    
    // Cart Routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('customer.cart');
        Route::post('/add', [CartController::class, 'addToCart'])->name('customer.cart.add');
        Route::get('/count', [CartController::class, 'getCartCount'])->name('customer.cart.count');
        Route::put('/update/{cart}', [CartController::class, 'update'])->name('customer.cart.update');
        Route::delete('/remove/{cart}', [CartController::class, 'destroy'])->name('customer.cart.remove');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('customer.cart.checkout');
    });
    
    // Order Routes
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('customer.orders');
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('customer.orders.status');
    });
});

// Logout Route (already exists at the top, no need to duplicate)
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
