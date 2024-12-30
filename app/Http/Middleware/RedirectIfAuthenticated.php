<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Jika sudah login, tampilkan error 403
            abort(403, 'Anda sudah login. Tidak bisa mengakses halaman ini.');
        }

        return $next($request);
    }
}