<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk; 
use Illuminate\Http\Request;

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
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
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
            $file->storeAs('public/produks', $namaFileFoto);
        }

        // 3. Simpan data ke database
        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
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
        // Kode untuk ambil produk yg mau diedit & tampilkan form edit
    }

    /**
     * Memperbarui data produk di database
     */
    public function update(Request $request, string $id)
    {
        // Kode untuk update data
    }

    /**
     * Menghapus produk dari database
     */
    public function destroy(string $id)
    {
        // Kode untuk hapus data
    }
}