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
        'no_hp',
        'produk_id',
        'tanggal_pesan',
        'alamat_pengiriman',
        'jumlah_pesanan',
        'ongkir',
        'total_harga',
        'status',
    ];

    // Relasi ke Produk withtrashed (soft delete agar riwayat pesanan tidak eror), belongsto (jenis relasi)
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id')->withTrashed();
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke KonfirmasiPembayaran
    public function konfirmasi()
    {
        return $this->hasOne(KonfirmasiPembayaran::class);
    }
}
