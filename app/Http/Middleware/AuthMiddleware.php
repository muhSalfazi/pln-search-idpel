<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // Redirect ke halaman login jika tidak terautentikasi
            return redirect()->route('auth-login-basic')->with('error', 'Please log in to access this page.');
        }

        return $next($request);
    }
}
