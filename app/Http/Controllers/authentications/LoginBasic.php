<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginBasic extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('pencarian');
        }
        return view('content.authentications.auth-login-basic');
    }

    // Proses login
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

        // Cari pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Cek jika status pengguna sudah nonaktif
            if ($user->status == 'nonaktif') {
                return redirect()->back()
                    ->with('error', 'Akun Anda dinonaktifkan. Hubungi admin untuk mengaktifkan kembali.');
            }

            // Jika login berhasil dan status aktif
            if (Auth::attempt($request->only('email', 'password'))) {
                // Reset percobaan gagal saat login berhasil
                $request->session()->forget('login_attempts_'.$user->id);

                return redirect()->route('pencarian');
            } else {
                // Tambah jumlah percobaan gagal di session
                $attempts = $request->session()->get('login_attempts_'.$user->id, 0);
                $attempts++;

                if ($attempts >= 5) {
                    // Nonaktifkan akun jika gagal 5 kali
                    $user->update(['status' => 'nonaktif']);
                    $request->session()->forget('login_attempts_'.$user->id);

                    return redirect()->back()
                        ->with('error', 'Akun Anda telah dinonaktifkan karena terlalu banyak percobaan login. Hubungi admin untuk mengaktifkan kembali.');
                } else {
                    // Simpan jumlah percobaan gagal ke dalam session
                    $request->session()->put('login_attempts_'.$user->id, $attempts);

                    return redirect()->back()
                        ->with('error', 'Email atau password salah. Percobaan ke-'.$attempts.' dari 5.');
                }
            }
        }

        return redirect()->back()
            ->with('error', 'Email tidak terdaftar.');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();

        return redirect()->route('auth-login-basic')
            ->with('success', 'Berhasil logout.')
            ->withHeaders([
                'Cache-Control' => 'no-store, must-revalidate',
            ]);
    }
}