<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPemesanan extends Model
{
    use HasFactory;

    // Daftar kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'produk_id',
        'tanggal_pesan',
        'jumlah_pesanan',
        'total_harga',
        'status',
    ];

    // Relasi ke User
    public function user() {
        return $this->belongsTo(User::class); 
    }

    // Relasi ke produk
    public function produk() {
        return $this->belongsTo(Produk::class);
    }
}
