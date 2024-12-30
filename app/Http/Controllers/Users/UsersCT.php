<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;


class UsersCT extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $totalData = User::count();
      $totalFiltered = $totalData;

      $limit = $request->input('length') ?: 10;
      $start = $request->input('start') ?: 0;
      $orderColumn = $request->input('order.0.column', 1);
      $orderDir = $request->input('order.0.dir', 'asc');

      $columns = [
        1 => 'username',
        2 => 'email',
        3 => 'alamat',
        4 => 'no_telp',
        5 => 'jabatan'
      ];

      $order = $columns[$orderColumn] ?? 'created_at';

      $query = User::query();

      // Pencarian
      if ($search = $request->input('search.value')) {
        $query->where('username', 'LIKE', "%{$search}%")
          ->orWhere('email', 'LIKE', "%{$search}%")
          ->orWhere('alamat', 'LIKE', "%{$search}%")
          ->orWhere('no_telp', 'LIKE', "%{$search}%")
          ->orWhere('jabatan', 'LIKE', "%{$search}%");
        $totalFiltered = $query->count();
      }

      $users = $query->offset($start)
        ->limit($limit)
        ->orderBy($order, $orderDir)
        ->get();

      $data = [];
      $fakeId = $start + 1;

      foreach ($users as $user) {
        $nestedData['fake_id'] = $fakeId++;
        $nestedData['username'] = $user->username ?? '-';
        $nestedData['email'] = $user->email ?? '-';
        $nestedData['alamat'] = $user->alamat ?? '-';
        $nestedData['no_telp'] = $user->no_telp ?? '-';
        $nestedData['jabatan'] = $user->jabatan ?? '-';
        $data[] = $nestedData;
      }

      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $totalData,
        'recordsFiltered' => $totalFiltered,
        'data' => $data
      ]);
    }

    return view('content.Users.Users');
  }

  // Mengambil data untuk DataTables
  public function getData(Request $request)
  {
    try {
      $query = User::where('role', 'user')  // Filter hanya role user
        ->select(['username', 'email', 'alamat', 'no_telp', 'jabatan']);

      return DataTables::of($query)
        ->addIndexColumn()  // Tambahkan index otomatis
        ->editColumn('alamat', function ($user) {
          return $user->alamat ?? '<span class="text-muted">-</span>';
        })
        ->editColumn('no_telp', function ($user) {
          return $user->no_telp ?? '<span class="text-muted">-</span>';
        })
        ->editColumn('jabatan', function ($user) {
          return $user->jabatan ?? '<span class="text-muted">-</span>';
        })
        ->rawColumns(['alamat', 'no_telp', 'jabatan'])
        ->toJson();
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);  // Tampilkan error sebagai JSON
    }
  }

}