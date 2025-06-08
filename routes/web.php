<?php

use App\Http\Middleware\islogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Owner\MenuController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Customer\ChartController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\MejaController;
use App\Http\Controllers\Admin\AdminChartController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminMejaController;
use App\Http\Controllers\Staff\AttendanceController;
use App\Http\Controllers\Owner\UserController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/',[LandingController::class, 'index'])->name('index');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([islogin::class.':admin'])->group(function () {
    Route::get('admin/dashboard', function () { return view('dashboard.admin.dashboard');})->name('admin.dashboard');
    Route::get('admin/order',[AdminController::class, 'index'])->name('admin.order');
    Route::get('admin/dashboard/menu', [AdminController::class, 'menu'])->name('admin.menu');
    Route::get('orders/{orderId}/status', [AdminController::class, 'show'])->name('order.status');
    Route::post('orders/{orderId}/status/update', [AdminController::class, 'update'])->name('order.status.update');

     // Chart routes
    Route::prefix('chart')->group(function () {
        Route::get('/', [AdminChartController::class, 'index'])->name('admin.chart');
        Route::post('/add', [AdminChartController::class, 'addToCart'])->name('admin.chart.add');
        Route::get('/update', [AdminChartController::class, 'updateQuantity'])->name('admin.chart.update');
        Route::post('/checkout', [AdminChartController::class, 'checkout'])->name('admin.chart.checkout');
        Route::delete('/clear', [AdminChartController::class, 'clear'])->name('admin.chart.clear');
    });
    
    // Order routes
    Route::prefix('orders')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::post('/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');
    });
});


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
Route::middleware([islogin::class.':owner'])->group(function () {
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
    Route::post('/meja/{id}/make-available', [MejaController::class, 'makeAvailable'])->name('meja.makeAvailable');
    Route::get('/attendance', [AttendanceController::class, 'showAttendanceForm'])->name('dashboard');
    Route::post('/attendance', [AttendanceController::class, 'storeAttendance'])->name('attendance.store');
    Route::post('/attendance/checkout', [AttendanceController::class, 'checkoutAttendance'])->name('attendance.checkout');
});

