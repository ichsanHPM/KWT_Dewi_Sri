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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('produk_id')->constrained('produks');
            $table->text('alamat_pengiriman');
            $table->date('tanggal_pesan');
            $table->integer('jumlah_pesanan')->default(1);
            $table->decimal('total_harga', 10, 2);
            $table->string('status')->default('Menunggu Pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
