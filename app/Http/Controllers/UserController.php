<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\KonfirmasiPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Kita butuh ini untuk tahu siapa yg login

class UserController extends Controller
{
    /**
     * Memproses pesanan produk.
     * Ini dipanggil dari Rute: Route::post('/pesan/{id}', ...)
     */
    public function pesan(Request $request, $id)
    {
        // 1. Validasi input (jika Anda punya input jumlah, dll.)
        $request->validate([
            'jumlah_pesanan' => 'required|integer|min:1'
        ]);

        // 2. Ambil data produk yg mau dibeli
        $produk = Produk::findOrFail($id);

        // 3. Ambil data user yg sedang login
        $user = Auth::user();

        // 4. Hitung total harga
        $total_harga = $produk->harga * $request->jumlah_pesanan;

        // 5. Buat pesanan baru di database
        Pesanan::create([
            'user_id' => $user->id,
            'produk_id' => $produk->id,
            'tanggal_pesan' => now(), // Ambil tanggal hari ini
            'jumlah_pesanan' => $request->jumlah_pesanan,
            'total_harga' => $total_harga,
            'status' => 'Menunggu Pembayaran',
        ]);

        // 6. Arahkan user ke halaman riwayat pesanan (atau halaman lain)
        return redirect()->route('pesanan.riwayat')->with('success', 'Pesanan Anda telah dibuat!');
    }

    /**
     * Menampilkan halaman riwayat pesanan milik user.
     * Ini dipanggil dari Rute: Route::get('/riwayat-pesanan', ...)
     */
    public function riwayat()
    {
        // Ambil hanya pesanan milik user yang sedang login
        $pesanans = Pesanan::where('user_id', Auth::id())
                           ->latest() // Urutkan dari yg terbaru
                           ->get();

        return view('user.riwayat', compact('pesanans'));
    }

    /**
     * Menampilkan formulir untuk konfirmasi pembayaran.
     * Ini dipanggil dari Rute: Route::get('/pesanan/{id}/konfirmasi', ...)
     */
    public function formKonfirmasi($id)
    {
        // Ambil data pesanan yg mau dikonfirmasi
        $pesanan = Pesanan::findOrFail($id);

        // Cek apakah pesanan ini milik user yg login (keamanan)
        if ($pesanan->user_id != Auth::id()) {
            return redirect()->route('pesanan.riwayat')->with('error', 'Ini bukan pesanan Anda.');
        }

        return view('user.konfirmasi', compact('pesanan'));
    }

    /**
     * Menyimpan data konfirmasi pembayaran.
     * Ini dipanggil dari Rute: Route::post('/pesanan/{id}/konfirmasi', ...)
     */
    public function simpanKonfirmasi(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Cek keamanan lagi
        if ($pesanan->user_id != Auth::id()) {
            return redirect()->route('pesanan.riwayat')->with('error', 'Ini bukan pesanan Anda.');
        }

        // 1. Validasi
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048', // maks 2MB
            'tanggal_konfirmasi' => 'required|date',
        ]);

        // 2. Handle upload foto
        $namaFileFoto = '';
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $namaFileFoto = time() . '_' . $file->getClientOriginalName();
            // Simpan ke folder 'storage/app/public/bukti_pembayaran'
            $file->storeAs('public/bukti_pembayaran', $namaFileFoto);
        }

        // 3. Simpan data konfirmasi
        KonfirmasiPembayaran::create([
            'pesanan_id' => $pesanan->id,
            'tanggal_konfirmasi' => $request->tanggal_konfirmasi,
            'bukti_transfer' => $namaFileFoto,
            'status' => 'Menunggu Verifikasi',
        ]);

        // 4. Update status pesanan
        $pesanan->update(['status' => 'Menunggu Verifikasi']);

        // 5. Kembalikan ke riwayat
        return redirect()->route('pesanan.riwayat')->with('success', 'Konfirmasi pembayaran telah terkirim.');
    }
}