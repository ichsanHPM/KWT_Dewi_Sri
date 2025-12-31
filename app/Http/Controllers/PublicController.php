<?php

namespace App\Http\Controllers;

use App\Models\Produk; // <-- Impor Model Produk
use App\Models\KegiatanGaleri; // <-- Impor Model Galeri
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Menampilkan halaman utama (landing page).
     */
    public function index()
    {
        // Ambil 6 produk terbaru yang STOKNYA ADA
        $produks = Produk::where('stok', '>', 0)->latest()->take(4)->get();

        return view('welcome', compact('produks'));
    }

    /**
     * Menampilkan halaman katalog semua produk.
     */
    public function produk()
    {
        $produks = Produk::where('stok', '>', 0)->latest()->paginate(9);

        return view('public.produk_list', compact('produks'));
    }

    /**
     * Menampilkan halaman detail satu produk.
     */
    public function showProduk($id)
    {
        $produk = Produk::findOrFail($id); // Cari produk, jika tidak ada, error 404

        return view('public.produk_detail', compact('produk'));
    }

    /**
     * Menampilkan halaman galeri.
     */
    public function galeri()
    {
        $galeris = KegiatanGaleri::all();
        return view('public.galeri_list', compact('galeris'));
    }
}