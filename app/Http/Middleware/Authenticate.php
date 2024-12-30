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
        if (!Auth::check()) {
            return redirect()->route('auth-login-basic')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah role yang dibutuhkan sesuai
        if (!empty($roles) && !in_array(Auth::user()->role, $roles)) {
          return redirect()->route('auth-login-basic')
              ->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
      }
      

        return $next($request);
    }
}