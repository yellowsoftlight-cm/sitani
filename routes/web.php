<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\StatistikController;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Endpoint statistik publik — dipakai grafik pada landing page. Hanya
// data agregat (total per musim/komoditas/bulan), tidak ada data pribadi.
Route::prefix('statistik')->name('statistik.')->group(function () {
    Route::get('/panen-per-musim', [StatistikController::class, 'panenPerMusim'])->name('panen');
    Route::get('/pertumbuhan-anggota', [StatistikController::class, 'pertumbuhanAnggota'])->name('anggota');
    Route::get('/komposisi-komoditas', [StatistikController::class, 'komposisiKomoditas'])->name('komoditas');
    Route::get('/ringkasan', [StatistikController::class, 'ringkasan'])->name('ringkasan');
});

// Jalur login khusus Admin. Sengaja diberi slug acak dan TIDAK ditautkan
// di navbar, footer, maupun halaman publik manapun — hanya admin yang
// mengetahui URL ini secara langsung yang bisa membukanya. Endpoint POST
// diberi rate limit (throttle) untuk mempersulit percobaan brute force.
Route::middleware('guest')->prefix('portal-kendali-9x2a')->group(function () {
    Route::get('/masuk', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/masuk', [AdminAuthController::class, 'login'])
        ->middleware('throttle:5,1');
});

Route::middleware(['auth'])->group(function () {

    // Notifikasi real-time — tersedia untuk seluruh role yang sudah login.
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', [NotifikasiController::class, 'index'])->name('index');
        Route::get('/jumlah-belum-dibaca', [NotifikasiController::class, 'jumlahBelumDibaca'])->name('jumlah');
        Route::post('/{id}/baca', [NotifikasiController::class, 'tandaiDibaca'])->name('baca');
        Route::post('/baca-semua', [NotifikasiController::class, 'tandaiSemuaDibaca'])->name('baca-semua');
    });

    // Panel Petani — hanya bisa diakses oleh akun berperan Petani.
    Route::middleware(['role:Petani'])->group(function () {
        Route::get('/petani/dashboard', [PanenController::class, 'dashboard'])->name('petani.dashboard');
        Route::post('/petani/panen', [PanenController::class, 'store'])->name('petani.panen.store');
    });

    // Panel Pengurus — hanya bisa diakses oleh akun berperan Pengurus.
    Route::middleware(['role:Pengurus'])->group(function () {
        Route::get('/pengurus/dashboard', [PengurusController::class, 'dashboard'])->name('pengurus.dashboard');
        Route::post('/pengurus/panen/{panen}/setujui', [PengurusController::class, 'approve'])->name('pengurus.panen.approve');
        Route::post('/pengurus/panen/{panen}/tolak', [PengurusController::class, 'reject'])->name('pengurus.panen.reject');
        Route::post('/pengurus/distribusi', [PengurusController::class, 'storeDistribusi'])->name('pengurus.distribusi.store');
    });

    // Panel Admin — hanya bisa diakses oleh akun berperan Admin.
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/pengguna/{user}/role', [AdminController::class, 'updateRole'])->name('pengguna.role');
        Route::delete('/pengguna/{user}', [AdminController::class, 'destroy'])->name('pengguna.hapus');
        Route::get('/panen/ekspor', [AdminController::class, 'exportPanenCsv'])->name('panen.ekspor');
    });

});
