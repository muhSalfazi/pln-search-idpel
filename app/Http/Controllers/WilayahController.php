<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    // Fetch Kecamatan Karawang
    public function getKecamatan()
    {
        $response = Http::get('https://ibnux.github.io/data-indonesia/kecamatan/3215.json');
        if ($response->failed()) {
            return response()->json([], 500);
        }
        return response()->json($response->json());
    }

    // Fetch Desa Berdasarkan Kecamatan
    public function getDesa(Request $request)
    {
        $kecamatanId = $request->input('kecamatan_id');
        
        if (!$kecamatanId) {
            return response()->json([]);
        }

        $response = Http::get("https://ibnux.github.io/data-indonesia/kelurahan/{$kecamatanId}.json");
        
        if ($response->failed()) {
            return response()->json([], 500);
        }
        return response()->json($response->json());
    }
}