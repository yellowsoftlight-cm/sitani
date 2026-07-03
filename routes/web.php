<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/petani/dashboard', function () {
        return view('petani');
    })->name('petani.dashboard');

    Route::get('/pengurus/dashboard', function () {
        return view('pengurus');
    })->name('pengurus.dashboard');

    Route::get('/admin/dashboard', function () {
        return "Selamat Datang di Dashboard Admin SiTani! Nama Anda: " . Auth::user()->name;
    })->name('admin.dashboard');

});