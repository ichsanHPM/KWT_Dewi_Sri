<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KegiatanGaleri; // GANTI: Impor KegiatanGaleri
use Illuminate\Http\Request;
use Illuminate\Support\Str; // PENTING: Impor helper String

class GaleriController extends Controller // GANTI: Nama Class
{
    /**
     * Menampilkan daftar semua item galeri
     */
    public function index()
    {
        // GANTI: Variabel dan Model
        $galeris = KegiatanGaleri::all();

        // GANTI: Path View
        return view('admin.galeri.index', compact('galeris'));
    }

    /**
     * Menampilkan formulir untuk menambah item galeri baru
     */
    public function create()
    {
        // GANTI: Path View
        return view('admin.galeri.create');
    }

    /**
     * Menyimpan item galeri baru ke database.
     */
    public function store(Request $request)
    {
        // GANTI: Aturan Validasi
        $request->validate([
            'judul_kegiatan' => 'required|string|max:100',
            'deskripsi_kegiatan' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload foto
        $namaFileFoto = '';
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            
            // PERBAIKAN: Bersihkan nama file dari spasi
            $namaAsli = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $namaFileFoto = time() . '_' . Str::slug($namaAsli) . '.' . $file->getClientOriginalExtension();

            // GANTI: Path Upload
            $file->move(public_path('uploads/galeri'), $namaFileFoto);
        }

        // GANTI: Kolom Database
        KegiatanGaleri::create([
            'judul_kegiatan' => $request->judul_kegiatan,
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            'foto' => $namaFileFoto,
        ]);

        // GANTI: Route Redirect
        return redirect()->route('admin.galeri.index')
                         ->with('success', 'Item galeri baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu item galeri (Opsional, bisa dikosongkan)
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan formulir untuk mengedit item galeri
     */
    public function edit(string $id)
    {
        // GANTI: Variabel dan Model
        $galeri = KegiatanGaleri::findOrFail($id);

        // GANTI: Path View
        return view('admin.galeri.edit', compact('galeri'));
    }

    /**
     * Memperbarui data item galeri di database
     */
    public function update(Request $request, string $id)
    {
        // GANTI: Aturan Validasi
        $request->validate([
            'judul_kegiatan' => 'required|string|max:100',
            'deskripsi_kegiatan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // GANTI: Variabel dan Model
        $galeri = KegiatanGaleri::findOrFail($id);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            
            // A. Hapus foto lama
            if ($galeri->foto) {
                // GANTI: Path Hapus
                $fileLama = public_path('uploads/galeri/' . $galeri->foto);
                if (file_exists($fileLama)) {
                    unlink($fileLama);
                }
            }

            // B. Upload foto baru (dengan perbaikan nama file)
            $file = $request->file('foto');
            $namaAsli = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $namaFileFoto = time() . '_' . Str::slug($namaAsli) . '.' . $file->getClientOriginalExtension();
            
            // GANTI: Path Upload
            $file->move(public_path('uploads/galeri'), $namaFileFoto);
            $data['foto'] = $namaFileFoto;
        }

        // GANTI: Variabel
        $galeri->update($data);

        // GANTI: Route Redirect
        return redirect()->route('admin.galeri.index')
                         ->with('success', 'Item galeri berhasil diperbarui.');
    }

    /**
     * Menghapus item galeri dari database
     */
    public function destroy(string $id)
    {
        // GANTI: Variabel dan Model
        $galeri = KegiatanGaleri::findOrFail($id);

        // Hapus foto
        if ($galeri->foto) {
            // GANTI: Path Hapus
            $fileLama = public_path('uploads/galeri/' . $galeri->foto);
            if (file_exists($fileLama)) {
                unlink($fileLama);
            }
        }

        // GANTI: Variabel
        $galeri->delete();

        // GANTI: Route Redirect
        return redirect()->route('admin.galeri.index')
                         ->with('success', 'Item galeri berhasil dihapus.');
    }
}