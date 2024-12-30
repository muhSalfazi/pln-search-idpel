<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PreventBack
{
    public function handle($request, Closure $next)
    {
        // Jika pengguna sudah login, redirect ke dashboard
        if (Auth::check()) {
            return redirect()->route('pencarian');
        }

        $response = $next($request);

        // Mencegah cache halaman login
        return $response->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ]);
    }
}