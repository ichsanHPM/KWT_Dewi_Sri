<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_pemesanans', function (Blueprint $table) {
        $table->id(); // id_riwayat
        
        // Simpan datanya sebagai arsip (history)
        // Supaya saat user dihapus, riwayat transaksi tetap ada untuk laporan keuangan.
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('produk_id');
        
        $table->date('tanggal_pesan');
        
        $table->integer('jumlah_pesanan');
        $table->decimal('total_harga', 10, 2);
        $table->string('status')->default('Selesai');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pemesanans');
    }
};
