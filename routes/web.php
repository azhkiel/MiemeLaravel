<?php

use App\Http\Middleware\islogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Customer\ChartController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;

Route::get('/',[LandingController::class, 'index'])->name('index');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/owner/dashboard', fn() => 'Admin Dashboard')->middleware('auth')->name('admin.dashboard');
Route::get('/admin/dashboard', fn() => 'Owner Dashboard')->middleware('auth')->name('owner.dashboard');


Route::middleware([islogin::class.':admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});

// Route::middleware([islogin::class.':customer'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard.customer.dashboard');
//     })->name('customer.dashboard');
// });

Route::middleware([islogin::class.':customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/menu', [DashboardController::class, 'menu'])->name('menu');
    
    // Chart routes
    Route::prefix('chart')->group(function () {
        Route::get('/', [ChartController::class, 'index'])->name('chart');
        Route::post('/add', [ChartController::class, 'addToCart'])->name('chart.add');
        Route::get('/update', [ChartController::class, 'updateQuantity'])->name('chart.update');
        Route::post('/checkout', [ChartController::class, 'checkout'])->name('chart.checkout');
        Route::delete('/clear', [ChartController::class, 'clear'])->name('chart.clear');
    });
    
    // Order routes
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders');
        Route::post('/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    });

});
// atau multi-role sekaligus:
Route::middleware([islogin::class.':admin,owner'])->group(function () {
    Route::get('/owner/dashboard', function () { return view('dashboard.owner.dashboard');})->name('owner.dashboard');
    Route::get('/menu',[MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu',[MenuController::class, 'store'])->name('menu.simpan');
    Route::get('/menu/{kodeMenu}/edit',[MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{kodeMenu}/update',[MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{kodeMenu}/delete',[MenuController::class, 'destroy'])->name('menu.hapus');
    Route::get('/staff', [UserController::class, 'user'])->name('user.index');
    Route::post('/staff/register', [UserController::class, 'register'])->name('user.register');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::middleware([islogin::class.':staff'])->prefix('staff')->name('staff.')->group(function () {
    // Show the attendance form
    Route::get('/attendance', [AttendanceController::class, 'showAttendanceForm'])->name('dashboard');
    Route::post('/attendance', [AttendanceController::class, 'storeAttendance'])->name('attendance.store');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
