<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicController; 
use App\Http\Controllers\UserController; 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;

//Rute Publik (Bisa diakses semua orang, tidak perlu login)
// Halaman Utama / Landing Page
Route::get('/', [PublicController::class, 'index'])->name('landing');

// Halaman untuk melihat semua produk (Katalog)
Route::get('/produk', [PublicController::class, 'produk'])->name('produk.list');

// Halaman untuk melihat detail satu produk
Route::get('/produk/{id}', [PublicController::class, 'showProduk'])->name('produk.detail');

// Halaman untuk melihat galeri/kegiatan
Route::get('/galeri', [PublicController::class, 'galeri'])->name('galeri.list');

Auth::routes();

Route::middleware(['auth', 'role:user'])->group(function () {

    // Halaman dashboard 'user' setelah login
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Proses untuk memesan produk
    // Sesuai Use Case: "Pesan Produk"
    Route::post('/pesan/{id}', [UserController::class, 'pesan'])->name('pesan.store');

    // Halaman untuk konfirmasi pembayaran
    // Sesuai Use Case: "Konfirmasi Pembayaran"
    Route::get('/pesanan/{id}/konfirmasi', [UserController::class, 'formKonfirmasi'])->name('konfirmasi.form');
    Route::post('/pesanan/{id}/konfirmasi', [UserController::class, 'simpanKonfirmasi'])->name('konfirmasi.store');
    
    // Halaman untuk melihat riwayat pesanan si user
    Route::get('/riwayat-pesanan', [UserController::class, 'riwayat'])->name('pesanan.riwayat');

});


//Rute Admin (WAJIB login sebagai 'admin')
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Halaman dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk Kelola Produk (CRUD)
    Route::resource('produk', AdminProdukController::class);

    // Rute untuk Kelola Galeri (CRUD)
    Route::resource('galeri', AdminGaleriController::class);

    // Rute untuk melihat riwayat semua pesanan user
    Route::get('/pesanan', [DashboardController::class, 'daftarPesanan'])->name('pesanan.index');

});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
