<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    /**
     * Kirim pesan WhatsApp via Fonnte
     *
     * @param string $target Nomor HP Tujuan
     * @param string $message Isi Pesan
     * @return mixed Response dari Fonnte
     */
    public static function kirimPesan($target, $message)
    {
        // 1. Ambil token dari file .env
        $token = env('FONNTE_TOKEN');

        // Jika token belum diisi di .env, batalkan pengiriman
        if (!$token) {
            Log::warning('Fonnte Token belum diatur di .env');
            return false;
        }

        try {
            // 2. Kirim Request ke API Fonnte
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Otomatis ubah 08xx jadi 628xx
            ]);

            return $response->json();
            
        } catch (\Exception $e) {
            // Jika gagal koneksi, catat error di Log Laravel
            Log::error('Gagal kirim WA Fonnte: ' . $e->getMessage());
            return false;
        }
    }
}