<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    // Daftar kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'produk_id',
        'tanggal_pesan',
        'alamat_pengiriman',
        'jumlah_pesanan',
        'ongkir',
        'total_harga',
        'status',
    ];

    // Relasi ke Produk (ambil nama produk/foto)
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function konfirmasi()
    {
        return $this->hasOne(KonfirmasiPembayaran::class);
    }
}
