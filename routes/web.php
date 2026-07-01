<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/petani/dashboard', function () {
    return view('petani');
})->name('petani.dashboard');

Route::get('/login', function () {
    return 'Halaman Login';
})->name('login');

Route::get('/register', function () {
    return 'Halaman Register';
})->name('register');