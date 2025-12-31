<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\KonfirmasiPembayaran;
use App\Models\RiwayatPemesanan;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            'jumlah_pesanan' => 'required|integer|min:1',
            'no_hp' => 'required|string|max:20',
            'dusun_id' => 'required_if:metode_pengiriman,antar',
            'alamat_detail' => 'required_if:metode_pengiriman,antar',
        ]);

        // 2. Ambil data produk yg mau dibeli
        $produk = Produk::findOrFail($id);

        // --- validasi stok
        if ($request->jumlah_pesanan > $produk->stok) {
            return redirect()->back()->with('error', 'Maaf, stok tidak mencukupi. Sisa stok: ' . $produk->stok);
        }

        // 3. Ambil data user yg sedang login
        $user = Auth::user();

        // --- LOGIKA BARU: Hitung Ongkir & Format Alamat ---
        $ongkir = 0;
        $alamat_final = 'Ambil Sendiri di Lokasi KWT (Pickup)'; // Default jika ambil sendiri

        // Cek jika user memilih 'Diantar Kurir'
        if ($request->metode_pengiriman == 'antar') {
            // Daftar dusun yang kena ongkir 5.000 (Zona Jauh)
            $zonaJauh = ['Banteng', 'Sanggrahan', 'Tambakan', 'Sumberan', 'Tiyasan', 'Pogung', 'Dayu', 'Pondok', 'Ploso Kuning'];
            
            // Cek apakah dusun yang dipilih ada di daftar Zona Jauh?
            if (in_array($request->dusun_id, $zonaJauh)) {
                $ongkir = 5000;
            } else {
                // Berarti Kentungan / Manukan (Zona Dekat)
                $ongkir = 0;
            }

            // Gabungkan Dusun dan Detail Alamat menjadi satu string rapi
            $alamat_final = "Dusun " . $request->dusun_id . " - " . $request->alamat_detail;
        }

        // 4. Hitung total harga (Produk + Ongkir)
        $total_harga = ($produk->harga_produk * $request->jumlah_pesanan) + $ongkir;

        // 5. Buat pesanan baru di database
        $pesananBaru = Pesanan::create([
            'user_id' => $user->id,
            'no_hp' => $request->no_hp,
            'produk_id' => $produk->id,
            'tanggal_pesan' => now(), 
            'alamat_pengiriman' => $alamat_final,
            'ongkir' => $ongkir,
            'jumlah_pesanan' => $request->jumlah_pesanan,
            'total_harga' => $total_harga,
            'status' => 'Menunggu Pembayaran',
        ]);

        //Kurangi stok
        $produk->decrement('stok', $request->jumlah_pesanan);

        //NOTIFIKASI WA (KE ADMIN)
        try {
            // Ganti nomor ini dengan NOMOR HP ADMIN yang asli (08xxx atau 62xxx)
            $nomorAdmin = '083894276457'; 

            $pesan = "*PESANAN BARU MASUK!* 🛍️\n\n" .
                     "No. Pesanan: #{$pesananBaru->id}\n" .
                     "Pelanggan: {$user->name} ({$request->no_hp})\n" .
                     "Produk: {$produk->nama_produk}\n" .
                     "Jumlah: {$request->jumlah_pesanan} pcs\n" .
                     "Total: Rp " . number_format($total_harga, 0, ',', '.') . "\n" .
                     "Pengiriman: {$alamat_final}\n\n" .
                     "Mohon segera cek dashboard admin untuk verifikasi.";

            FonnteService::kirimPesan($nomorAdmin, $pesan);
            
        } catch (\Exception $e) {
            // Biarkan kosong agar jika WA gagal, website tidak error
            Log::error("Gagal kirim notif WA: " . $e->getMessage());
        }
        // 6. Arahkan user ke halaman riwayat pesanan (atau halaman lain)
        return redirect()->route('pesanan.riwayat')->with('success', 'Pesanan Anda telah dibuat!');
    }

    /**
     * Membatalkan pesanan (Menghapus data).
     */
    public function batalkanPesanan($id)
    {
        // 1. Cari pesanan
        $pesanan = Pesanan::findOrFail($id);

        // 2. Cek Keamanan:
        // - Apakah ini punya user yang sedang login?
        // - Apakah statusnya masih 'Menunggu Pembayaran'?
        if ($pesanan->user_id != Auth::id() || $pesanan->status != 'Menunggu Pembayaran') {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        // 3. Hapus pesanan
        $pesanan->delete();

        // 4. Kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Menampilkan halaman riwayat pesanan milik user.
     * Ini dipanggil dari Rute: Route::get('/riwayat-pesanan', ...)
     */
    public function riwayat()
    {
        $userId = Auth::id();

        // 1. Ambil pesanan yang masih AKTIF (Belum selesai/Ditolak)
        $pesanan_aktif = Pesanan::where('user_id', $userId)
                                ->with('produk') // Load data produk biar tidak error
                                ->get();

        // 2. Ambil pesanan yang sudah SELESAI (Dari tabel Arsip)
        $pesanan_selesai = RiwayatPemesanan::where('user_id', $userId)
                                        ->with('produk')
                                        ->get();

        // 3. GABUNGKAN keduanya (Merge)
        // Kita gabung, lalu urutkan berdasarkan tanggal terbaru
        $pesanans = $pesanan_aktif->concat($pesanan_selesai)->sortByDesc('created_at');

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

        // 2. Handle upload foto (PERBAIKAN: Gunakan move ke public/uploads)
        $namaFileFoto = '';
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            
            // Bersihkan nama file (opsional tapi bagus)
            $namaAsli = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // Tambahkan timestamp agar unik
            $namaFileFoto = time() . '_' . preg_replace('/[^A-Za-z0-9\-]/', '', $namaAsli) . '.' . $file->getClientOriginalExtension();
            
            // PINDAHKAN ke folder public/uploads/bukti_pembayaran
            $file->move(public_path('uploads/bukti_pembayaran'), $namaFileFoto);
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