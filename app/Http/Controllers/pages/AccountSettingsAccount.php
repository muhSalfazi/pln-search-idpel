<?php
namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\File;
class AccountSettingsAccount extends Controller
{
    public function index()
    {
        $user = Auth::user();  // Ambil data user yang sedang login
        return view('content.pages.pages-account-settings-account', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
          'firstName' => 'required|string|max:255',
          'lastName' => 'required|string|max:255',
          'jabatan' => 'required|string|max:255',
          'phoneNumber' => 'required|string|max:15',
          'address' => 'required|string|max:255',
          'kecamatan' => 'required|string|max:255',
          'desa' => 'required|string|max:255',
          'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:800'
        ]);

        $user = Auth::user();  // Ambil data user yang sedang login

        // Update Profile menggunakan metode di model User
        if ($user->updateProfile($request)) {
            Log::info('Profil berhasil diperbarui:', ['user_id' => $user->id]);
            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        } else {
            Log::error('Gagal memperbarui profil', ['user_id' => $user->id]);
            return redirect()->back()->with('error', 'Gagal memperbarui profil.');
        }
    }

     // Hapus Akun Secara Permanen
     public function deleteAccount(Request $request)
     {
         $user = Auth::user();
     
         // Pastikan pengguna benar-benar mengonfirmasi
         if (!$request->has('accountActivation')) {
             return redirect()->back()->with('error', 'Silakan centang konfirmasi sebelum menghapus akun.');
         }
     
         // Hapus avatar jika ada
         if ($user->avatar) {
             $avatarPath = public_path($user->avatar); // Dapatkan path file avatar
             if (File::exists($avatarPath)) { // Periksa apakah file avatar ada
                 File::delete($avatarPath); // Hapus file avatar dari server
             }
         }
     
         // Hapus pengguna dari database
         $user->delete();
     
         // Logout pengguna
         Auth::logout();
     
         // Arahkan ke halaman login dengan pesan sukses
         return redirect('/')->with('success', 'Akun Anda telah dihapus beserta data-data terkait.');
     }
     
     
}