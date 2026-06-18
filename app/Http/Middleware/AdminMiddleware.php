<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan kolom role-nya berisi 'admin' atau 'superadmin'
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            return $next($request);
        }

        // Jika bukan admin, kembalikan ke halaman utama
        return redirect('/')->with('error', 'Akses ditolak! Anda bukan Admin.');
    }
}