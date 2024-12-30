<?php

namespace App\Http\Controllers\Pencarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Models\History;

class PencarianCT extends Controller
{
    public function index()
    {
        return view('content.Pencarian.Pencarian');
    }

    public function search(Request $request)
    {
        // Validasi input agar tidak kosong dan sanitasi
        $request->validate([
            'searchTerm' => 'required|string|max:255',
        ]);

        // Ambil input pencarian dari pengguna
        $searchTerm = trim($request->input('searchTerm'));

        // Cek apakah data ada di database berdasarkan no_pelanggan atau nomer_meter
        $result = Customer::where('no_pelanggan', $searchTerm)
            ->orWhere('nomer_meter', $searchTerm)
            ->first();

        // Default values jika tidak ditemukan
        $no_pelanggan = '-';
        $nomer_meter = '-';
        $tarif = '-';
        $daya = '-';
        $jenis_layanan = '-';

        // Jika data ditemukan, isi berdasarkan hasil pencarian
        if ($result) {
            $no_pelanggan = $result->no_pelanggan ?? '-';
            $nomer_meter = $result->nomer_meter ?? '-';
            $tarif = $result->tarif ?? '-';
            $daya = $result->daya ?? '-';
            $jenis_layanan = $result->jenis_layanan ?? '-';
        } else {
            // Jika data tidak ditemukan, masukkan sesuai aturan
            if (substr($searchTerm, 0, 4) == '5348') {
                $no_pelanggan = $searchTerm;
            } else {
                $nomer_meter = $searchTerm;
            }
        }

        // Siapkan data untuk disimpan di tabel histories
        $historyData = [
            'id_user' => Auth::id(),
            'no_pelanggan' => $no_pelanggan,
            'tarif' => $tarif,
            'daya' => $daya,
            'jenis_layanan' => $jenis_layanan,
            'nomer_meter' => $nomer_meter,
            'status' => $result ? 'ada' : 'tidak ada',  // Status tergantung ada/tidaknya data
            'id_customer' => $result->id ?? null,
        ];

        // Simpan ke dalam tabel histories
        History::create($historyData);

        // Redirect dengan pesan sukses atau error tergantung hasil pencarian
        if ($result) {
            return redirect()->route('pencarian')
                ->with('success', "Data \"$searchTerm\" berhasil ditemukan dan masuk TO.");
        } else {
            return redirect()->route('pencarian')
                ->with('error', "Data \"$searchTerm\" tidak ditemukan");
        }
    }
}
