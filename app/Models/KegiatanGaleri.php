<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanGaleri extends Model
{
    use HasFactory;

    /**
     * Daftar kolom yang Boleh diisi secara massal.
     */
    protected $fillable = [
        'judul_kegiatan',
        'deskripsi_kegiatan',
        'foto',
    ];
}
