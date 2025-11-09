<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        // 2. Cek apakah role user ada di dalam daftar $roles yang diizinkan
        if (! $request->user() || ! in_array($request->user()->role, $roles)) {
            
            // Jika tidak, melempar mereka ke halaman 'home'
            return redirect('home'); 
        }

        // Jika lolos, izinkan request ke langkah selanjutnya
        return $next($request);
    }
}
