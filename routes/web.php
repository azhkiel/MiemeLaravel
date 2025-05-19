<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LandingController;
use App\Http\Middleware\islogin;

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

Route::middleware([islogin::class.':customer'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user(); return view('dashboard.customer.dashboard',['user'=>$user]);
    })->name('customer.dashboard');
});

// atau multi-role sekaligus:
Route::middleware([islogin::class.':admin,owner'])->group(function () {
    Route::get('/menu',[MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu',[MenuController::class, 'store'])->name('menu.simpan');
    Route::get('/menu/{id}/edit',[MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{id}/update',[MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}/delete',[MenuController::class, 'destroy'])->name('menu.hapus');
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
