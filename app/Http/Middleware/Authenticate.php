<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika pengguna tidak login
        if (!Auth::check()) {
            // Invalidate session tanpa menghapus semua data
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect ke halaman login
            return redirect()->route('auth-login-basic')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek role pengguna (jika middleware menerima role sebagai parameter)
        if (!empty($roles) && !in_array(Auth::user()->role, $roles)) {
            return redirect()->route('auth-login-basic')
                ->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $response = $next($request);

        // Cegah cache untuk semua halaman yang memerlukan autentikasi
        return $response->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ]);
    }
}