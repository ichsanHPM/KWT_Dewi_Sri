<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KegiatanGaleri; // <-- Impor Model KegiatanGaleri
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    /**
     * Menampilkan daftar semua item galeri.
     */
    public function index()
    {
        $galeris = KegiatanGaleri::all();
        // Nanti kita akan buat view di: 'admin.galeri.index'
        return view('admin.galeri.index', compact('galeris'));
    }

    /**
     * Menampilkan formulir untuk menambah item galeri baru.
     */
    public function create()
    {
        // Nanti kita akan buat view di: 'admin.galeri.create'
        return view('admin.galeri.create');
    }

    /**
     * Menyimpan item galeri baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'judul' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Handle upload foto
        $namaFileFoto = '';
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFileFoto = time() . '_' . $file->getClientOriginalName();
            // Simpan ke folder 'storage/app/public/galeri'
            $file->storeAs('public/galeri', $namaFileFoto);
        }

        // 3. Simpan data ke database
        KegiatanGaleri::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto' => $namaFileFoto, // Simpan nama filenya
        ]);

        // 4. Kembalikan ke halaman daftar galeri
        return redirect()->route('admin.galeri.index')
                         ->with('success', 'Item galeri baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit item galeri.
     */
    public function edit(string $id)
    {
        $galeri = KegiatanGaleri::findOrFail($id);
        // Nanti kita akan buat view di: 'admin.galeri.edit'
        return view('admin.galeri.edit', compact('galeri'));
    }

    /**
     * Memperbarui data item galeri di database.
     */
    public function update(Request $request, string $id)
    {
        // (Logika untuk update akan mirip dengan store, tapi kita handle foto lama)
    }

    /**
     * Menghapus item galeri dari database.
     */
    public function destroy(string $id)
    {
        // (Logika untuk menghapus data dan file fotonya)
    }
}