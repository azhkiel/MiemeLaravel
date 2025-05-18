<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('menu');
});

Route::get('/menu',[MenuController::class, 'index'])->name('menu.index');
Route::post('/menu',[MenuController::class, 'store'])->name('menu.simpan');
Route::get('/menu/{id}/edit',[MenuController::class, 'edit'])->name('menu.edit');
Route::put('/menu/{id}/update',[MenuController::class, 'update'])->name('menu.update');
Route::delete('/menu/{id}/delete',[MenuController::class, 'destroy'])->name('menu.hapus');