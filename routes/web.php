<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Dashboard routes
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/users', [UserController::class, 'index'])->middleware('auth')->name('list.users');

// Buku routes
Route::get('/koleksi-buku', [BookController::class, 'infoBuku'])->name('buku.info');

// Peminjaman routes (user)
Route::middleware('auth')->prefix('perpustakaan')->group(function () {
    Route::get('/pinjam', [PeminjamanController::class, 'index'])->name('perpustakaan.pinjam');
    Route::post('/pinjam', [PeminjamanController::class, 'store'])->name('perpustakaan.store');
    Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])->name('perpustakaan.riwayat');
    Route::get('/detail/{id}', [PeminjamanController::class, 'show'])->name('perpustakaan.detail');
    Route::post('/kembalikan/{id}', [PeminjamanController::class, 'requestReturn'])->name('perpustakaan.return');
    Route::post('/hilang/{id}', [PeminjamanController::class, 'reportLost'])->name('perpustakaan.lost');
});

// Admin routes - hanya bisa diakses oleh admin
Route::middleware(['auth', 'admin.only'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
});
// route export laporan
Route::get('/export-stock', [LaporanController::class, 'exportStock'])->name('export.stock');
Route::get('/export-peminjaman', [LaporanController::class, 'exportPeminjaman'])->name('export.peminjaman');