<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    // Daftar kolom yang boleh diisi
    protected $fillable = [
        'nama_produk',
        'harga_produk',
        'deskripsi_produk',
        'stok',
        'satuan',
        'spesifikasi',
        'foto',
    ];
}
