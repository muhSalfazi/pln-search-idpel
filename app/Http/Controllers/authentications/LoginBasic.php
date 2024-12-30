<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Riwayat; // Import model TblRiwayat

class LoginBasic extends Controller
{
  public function index()
  {
    // Jika pengguna sudah login, redirect ke dashboard
    if (Auth::check()) {
      return redirect()->route('pencarian');
  }
    return view('content.authentications.auth-login-basic');
  }

  public function login(Request $request)
  {
      // Validasi input
      $validator = Validator::make($request->all(), [
          'email' => 'required|email|min:5',
          'password' => 'required|min:8',
      ]);
  
      if ($validator->fails()) {
          return redirect()->back()
              ->withErrors($validator)
              ->withInput()
              ->with('error', 'Validasi gagal! Silakan periksa kembali input Anda.');
      }
  
      // Autentikasi pengguna
      if (Auth::attempt($request->only('email', 'password'))) {
          $user = Auth::user();
  
          // Hapus session halaman login saja (bukan semua session)
          $request->session()->forget('login_cache');
  
          // Redirect ke halaman dashboard atau halaman tertentu
          $response = redirect()->route('pencarian');
  
          // Cegah cache halaman login (agar "Back" tidak berfungsi)
          return $response->withHeaders([
             'Cache-Control' => 'no-store, must-revalidate',
          ]);
      } else {
          return redirect()->back()
              ->with('error', 'Email atau password salah.')
              ->withInput();
      }
  }
  


  public function logout(Request $request)
{
    // Logout pengguna
    Auth::logout();
    
    // Invalidate session dan token CSRF
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Hapus sesi cache halaman
    $request->session()->flush();

    // Redirect ke halaman login dengan mencegah cache
    return redirect()->route('auth-login-basic')
        ->with('success', 'Berhasil logout.')
        ->withHeaders([
            'Cache-Control' => 'no-store, must-revalidate',
        ]);
}
}