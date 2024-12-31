<?php

namespace App\Http\Controllers\Riwayat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RiwayatCT extends Controller
{
  // Tampilkan halaman utama
  public function index(Request $request)
  {
    // cek user apakah sudah komplit data profil
    $user = Auth::user();

    if ($user->role === 'user' && (
        is_null($user->first_name) || 
        is_null($user->last_name) || 
        is_null($user->avatar) || 
        is_null($user->alamat) || 
        is_null($user->no_telp) ||
        is_null($user->jabatan) ||
        is_null($user->kecamatan) ||
        is_null($user->desa)
    )){
      return redirect()->route('account-settings') // Redirect to the account settings page
          ->with('alert', 'Anda belum mengisi profil lengkap. Silakan lengkapi data Anda.'); // Show alert
  }
    if ($request->ajax()) {
      // Handle request dari DataTables AJAX
      $columns = [
        1 => 'no_pelanggan',
        2 => 'tarif',
        3 => 'daya',
        4 => 'jenis_layanan',
        5 => 'nomer_meter',
        6 => 'status',
      ];

      $userId = Auth::id();
      $totalData = History::where('id_user', $userId)->count();
      $totalFiltered = $totalData;

      $limit = $request->input('length') ?: 10;
      $start = $request->input('start') ?: 0;
      $orderColumnIndex = $request->input('order.0.column');
      $order = $columns[$orderColumnIndex] ?? 'created_at';
      $dir = $request->input('order.0.dir') ?? 'desc';
      // Pastikan 'fake_id' tidak digunakan sebagai kolom order
      if ($order === 'fake_id') {
        $order = 'created_at'; // Default order by jika fake_id dipilih
      }
      if (empty($request->input('search.value'))) {
        $histories = History::where('id_user', $userId)
          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();
      } else {
        $search = $request->input('search.value');
        $histories = History::where('id_user', $userId)
          ->where(function ($query) use ($search) {
            $query->where('no_pelanggan', 'LIKE', "%{$search}%")
              ->orWhere('nomer_meter', 'LIKE', "%{$search}%")
              ->orWhere('jenis_layanan', 'LIKE', "%{$search}%")
              ->orWhere('status', 'LIKE', "%{$search}%");
          })
          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();

        $totalFiltered = History::where('id_user', $userId)
          ->where(function ($query) use ($search) {
            $query->where('no_pelanggan', 'LIKE', "%{$search}%")
              ->orWhere('nomer_meter', 'LIKE', "%{$search}%")
              ->orWhere('jenis_layanan', 'LIKE', "%{$search}%")
              ->orWhere('status', 'LIKE', "%{$search}%");
          })
          ->count();
      }

      $data = [];
      $fakeId = $start + 1;

      foreach ($histories as $history) {
        $nestedData['id'] = $history->id;
        $nestedData['fake_id'] = $fakeId++;
        $nestedData['no_pelanggan'] = $history->no_pelanggan ?? '-';
        $nestedData['tarif'] = $history->tarif ?? '-';
        $nestedData['daya'] = $history->daya ?? '-';
        $nestedData['jenis_layanan'] = $history->jenis_layanan ?? '-';
        $nestedData['nomer_meter'] = $history->nomer_meter ?? '-';
        $nestedData['status'] = $history->status;

        $data[] = $nestedData;
      }

      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $totalData,
        'recordsFiltered' => $totalFiltered,
        'data' => $data,
      ]);
    }

    // Jika bukan AJAX request, return view
    return view('content.Riwayat.Riwayat');
  }

  // Mengambil data untuk DataTables
  public function getData(Request $request)
  {
    $userId = Auth::id();

    // Query data berdasarkan user yang login
    $query = History::where('id_user', $userId)->orderBy('created_at', 'desc');

    return DataTables::of($query)
      ->addIndexColumn()
      ->editColumn('no_pelanggan', function ($history) {
        return $history->no_pelanggan ?? '<span class="text-muted">Tidak ditemukan</span>';
      })
      ->editColumn('tarif', function ($history) {
        return $history->tarif ?? '<span class="text-muted">-</span>';
      })
      ->editColumn('daya', function ($history) {
        return $history->daya ?? '<span class="text-muted">-</span>';
      })
      ->editColumn('jenis_layanan', function ($history) {
        return $history->jenis_layanan ?? '<span class="text-muted">-</span>';
      })
      ->editColumn('status', function ($history) {
        return $history->status;
      })
      ->rawColumns(['status', 'no_pelanggan', 'tarif', 'daya', 'jenis_layanan'])
      ->make(true);
  }

  public function delete($id)
  {
    $history = History::find($id);

    if ($history) {
      $history->delete();
      return response()->json(['success' => 'Data berhasil dihapus']);
    }

    return response()->json(['error' => 'Data tidak ditemukan'], 404);
  }
}