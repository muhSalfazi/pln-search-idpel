<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UsersCT extends Controller
{
  public function index()
  {
    return view('content.Users.Users');
  }

  // Mengambil data untuk DataTables (Hanya role user)
  public function getData(Request $request)
{
    if ($request->ajax()) {
        $query = User::select(['id', 'username', 'email', 'no_telp', 'alamat', 'jabatan', 'role', 'status', 'desa', 'kecamatan'])
            ->where('role', 'user');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('alamat', function ($user) {
                // Gabungkan alamat, desa, dan kecamatan menjadi satu string
                $fullAddress = '';
                
                // Periksa apakah alamat ada
                if (!empty($user->alamat)) {
                    $fullAddress .= $user->alamat;
                }

                // Jika ada desa, tambahkan ke alamat
                if (!empty($user->desa)) {
                    $fullAddress .= ', ' . $user->desa;
                }

                // Jika ada kecamatan, tambahkan ke alamat
                if (!empty($user->kecamatan)) {
                    $fullAddress .= ', ' . $user->kecamatan . ', Karawang';
                }

                // Jika alamat lengkap kosong, tampilkan tanda '-'
                return $fullAddress ?: '-';
            })
            ->editColumn('status', function ($user) {
                $checked = $user->status == 'aktif' ? 'checked' : '';
                $statusText = $user->status == 'aktif' ? 'Aktif' : 'Nonaktif';
                $btnClass = $user->status == 'aktif' ? 'btn-success' : 'btn-danger';

                return '
                        <div class="d-flex align-items-center justify-content-center">
                            <button class="btn toggle-status ' . $btnClass . '" data-id="' . $user->id . '">
                                ' . $statusText . '
                            </button>
                        </div>
                    ';
            })
            ->addColumn('aksi', function ($user) {
                return '
                        <button class="btn btn-primary btn-sm edit-password" data-id="' . $user->id . '" data-name="' . $user->username . '">
                            Edit Password
                        </button>
                    ';
            })
            ->rawColumns(['status', 'aksi'])
            ->toJson();
    }
}

  
  public function updateStatus(Request $request, $id)
  {
    $user = User::findOrFail($id);
    $user->status = $request->status;
    $user->save();

    return response()->json(['message' => 'Status pengguna berhasil diperbarui']);

  }

  public function updatePassword(Request $request)
{
    $request->validate([
        'password' => 'required|min:8|confirmed',
        'user_id' => 'required|exists:users,id'
    ]);

    try {
        $user = User::findOrFail($request->user_id);
        $user->password = bcrypt($request->password);
        $user->save();

        // Return JSON success response
        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diperbarui.'
        ]);
    } catch (\Exception $e) {
        // Return JSON error response
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal memperbarui password!'
        ], 500);
    }
}




}