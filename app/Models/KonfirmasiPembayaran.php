<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfirmasiPembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'tanggal_konfirmasi',
        'bukti_transfer',
        'status',
    ];
}
