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
        // Cek apakah user sudah login dan apakah role-nya 'admin'
        if ($request->user() && $request->user()->role === 'admin') {
            return $next($request); // Lolos, bolehkan akses
        }

        // Jika bukan admin (alias petugas), tolak mentah-mentah dengan status 403 (Forbidden)
        return response()->json([
            'status' => 'error',
            'message' => 'Akses Ditolak! Fitur ini hanya boleh diakses oleh Admin.'
        ], 403);
    }
}