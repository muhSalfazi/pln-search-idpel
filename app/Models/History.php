<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;

class History extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'histories';

    // Kolom yang dapat diisi
    protected $fillable = [
        'id_user',
        'id_customer',
        'no_pelanggan',
        'tarif',
        'daya',
        'jenis_layanan',
        'nomer_meter',
        'status'
    ];

    // Relasi ke tabel `dtks`
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_user', 'id');
    }

    // HistoryController.php

}
