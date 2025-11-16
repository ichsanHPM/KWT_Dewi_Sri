<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    //Daftar kolom yang Boleh diisi secara massal.
    protected $fillable = [
        'nama_produk',
        'harga_produk',
        'deskripsi_produk',
        'spesifikasi',
        'foto',
    ];
}
