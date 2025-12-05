<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan; 
use App\Models\Produk;
use App\Models\User;
use App\Models\KegiatanGaleri;
use App\Models\RiwayatPemesanan;
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
        $jumlah_galeri = KegiatanGaleri::count();

        return view('admin.dashboard', compact(
            'jumlah_produk',
            'jumlah_pesanan',
            'jumlah_user',
            'jumlah_galeri'
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

    public function verifikasiPesanan($id)
    {$pesanan = Pesanan::findOrFail($id);

        // TAHAP 1: Jika status 'Menunggu Verifikasi', ubah jadi 'Dikirim'
        if ($pesanan->status == 'Menunggu Verifikasi') {
            $pesanan->update([
                'status' => 'Dikirim'
            ]);

            return redirect()->back()->with('success', 'Pembayaran diterima. Status berubah menjadi DIKIRIM.');
        }

        // TAHAP 2: Jika status sudah 'Dikirim', baru pindahkan ke Arsip (Selesai)
        elseif ($pesanan->status == 'Dikirim') {
            
            // A. Salin ke Arsip
            \App\Models\RiwayatPemesanan::create([
                'user_id' => $pesanan->user_id,
                'produk_id' => $pesanan->produk_id,
                'tanggal_pesan' => $pesanan->tanggal_pesan,
                'jumlah_pesanan' => $pesanan->jumlah_pesanan,
                'total_harga' => $pesanan->total_harga,
                'status' => 'Selesai',
            ]);

            // B. Hapus dari Tabel Aktif
            if ($pesanan->konfirmasi) {
                $pesanan->konfirmasi->delete();
            }
            $pesanan->delete();

            return redirect()->back()->with('success', 'Pesanan telah SELESAI dan diarsipkan.');
        }
        
        return redirect()->back();
    }

    /**
     * Menolak pesanan (Misal bukti bayar palsu).
     */
    public function tolakPesanan($id)
    {
        // 1. Cari pesanan
        $pesanan = Pesanan::findOrFail($id);

        // 2. Ubah status jadi 'Ditolak'
        // Opsi lain: Anda bisa menghapus bukti bayarnya saja agar user upload ulang
        // Tapi untuk sekarang kita set statusnya 'Ditolak' agar jelas.
        $pesanan->update([
            'status' => 'Ditolak'
        ]);

        // 3. Kembali dengan pesan
        return redirect()->route('admin.pesanan.index')
                         ->with('error', 'Pesanan telah ditolak.');
    }

    // Menampilkan daftar pesanan yg sudah selesai
    public function arsipPesanan()
    {
    $arsip = RiwayatPemesanan::with(['user', 'produk'])
                             ->latest()
                             ->get();

    return view('admin.pesanan.arsip', compact('arsip'));
    }
}