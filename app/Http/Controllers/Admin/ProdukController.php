<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar semua produk
     * Halaman "Kelola Produk" 
     */
    public function index()
    {
        // 1. Ambil semua data produk dari database
        $produks = Produk::all();

        // 2. Tampilkan halaman view, dan kirim data $produks ke sana
        return view('admin.produk.index', compact('produks'));
    }

    /**
     * Menampilkan formulir untuk menambah produk baru
     */
    public function create()
    {
        // Langsung tampilkan halaman formulir
        return view('admin.produk.create');
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi data (pastikan data diisi dengan benar)
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga_produk' => 'required|numeric|min:0',
            'deskripsi_produk' => 'required|string',
            'spesifikasi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // foto maks 2MB
        ]);

        // 2. Handle upload foto
        $namaFileFoto = '';
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            // Buat nama file yang unik (misal: 1678886400_kripik_bayem.jpg)
            $namaFileFoto = time() . '_' . $file->getClientOriginalName();
            // Pindahkan file foto ke folder 'storage/app/public/produks'
            $file->move(public_path('uploads/produks'), $namaFileFoto);
        }

        // 3. Simpan data ke database
        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'spesifikasi' => $request->spesifikasi,
            'foto' => $namaFileFoto, // Simpan nama filenya ke database
        ]);

        // 4. Kembalikan ke halaman daftar produk dengan pesan sukses
        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu produk
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan formulir untuk mengedit produk
     */
    public function edit(string $id)
    {
        // 1. Cari produk di database berdasarkan ID
        // findOrFail akan otomatis error 404 jika ID tidak ditemukan
        $produk = Produk::findOrFail($id);

        // 2. Tampilkan view 'admin.produk.edit' dan kirim data produk
        return view('admin.produk.edit', compact('produk'));
    }

    /**
     * Memperbarui data produk di database
     */
    public function update(Request $request, string $id)
    {
        // 1. Validasi data (mirip dengan 'store', tapi foto tidak 'required')
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga_produk' => 'required|numeric|min:0',
            'deskripsi_produk' => 'required|string',
            'spesifikasi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // foto 'nullable' artinya boleh kosong
        ]);

        // 2. Cari produk yang ada di database
        $produk = Produk::findOrFail($id);

        // 3. Siapkan data untuk di-update
        $data = $request->except('foto'); // Ambil semua data KECUALI foto

        // 4. Cek apakah ada foto baru yang di-upload
        if ($request->hasFile('foto')) {
            
            // A. Hapus foto lama (jika ada) dari storage
            if ($produk->foto) {
                $fileLama = public_path('uploads/produks/' . $produk->foto);
                if (file_exists($fileLama)) {
                    unlink($fileLama);
                }
            }

            // B. Upload foto baru
            $file = $request->file('foto');
            $namaFileFoto = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/produks', $namaFileFoto);

            // C. Masukkan nama file foto baru ke data
            $data['foto'] = $namaFileFoto;
        }

        // 5. Update data produk di database
        $produk->update($data);

        // 6. Kembalikan ke halaman daftar produk dengan pesan sukses
        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari database
     */
    public function destroy(string $id)
    {
        // 1. Cari produknya
        $produk = Produk::findOrFail($id);

        // 2. Hapus fotonya dari storage (jika ada)
        if ($produk->foto) {
            $fileLama = public_path('uploads/produks/' . $produk->foto);
            if (file_exists($fileLama)) {
                unlink($fileLama);
            }
        }

        // 3. Hapus datanya dari database
        $produk->delete();

        // 4. Kembalikan ke halaman daftar produk dengan pesan sukses
        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }
}