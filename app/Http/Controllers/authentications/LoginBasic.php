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
        return view('content.authentications.auth-login-basic');
    }

    public function login(Request $request)
    {
        // Validate input
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

        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // // Simpan ID user ke tbl_riwayat
            // Riwayat::create([
            //     'id_user' => $user->id,
            // ]);

            // Redirect based on the user's role
            if ($user->role == 'admin') {
                return redirect()->route('pencarian');
            } elseif ($user->role == 'user') {
                return redirect()->route('pencarian');
            } else {
                return redirect()->route('login')->with('error', 'Role tidak dikenali.');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid credentials.')->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::logout();
        return redirect()->route('auth-login-basic')->with('success', 'Berhasil logout.');
    }
}
