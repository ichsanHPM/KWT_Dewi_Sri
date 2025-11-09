<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan; // <-- Impor Model Pesanan
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard Admin.
     * Ini dipanggil dari Rute: Route::get('/dashboard', ...)
     */
    public function index()
    {
        // Ambil beberapa data ringkasan (contoh)
        $jumlah_produk = Produk::count();
        $jumlah_pesanan = Pesanan::count();
        $jumlah_user = User::where('role', 'user')->count(); // Hanya user biasa

        return view('admin.dashboard', compact(
            'jumlah_produk',
            'jumlah_pesanan',
            'jumlah_user'
        ));
    }

    /**
     * Menampilkan daftar semua pesanan dari semua user.
     * Sesuai Use Case: "Lihat Riwayat Pemesanan" (dari sisi Admin)
     * Ini dipanggil dari Rute: Route::get('/pesanan', ...)
     */
    public function daftarPesanan()
    {
        // Ambil semua pesanan, dan juga data 'user' dan 'produk' yang terkait
        // 'with()' digunakan agar lebih efisien (mengurangi query ke database)
        $pesanans = Pesanan::with(['user', 'produk'])
                           ->latest() // Urutkan dari yg terbaru
                           ->get();

        return view('admin.pesanan.index', compact('pesanans'));
    }
}