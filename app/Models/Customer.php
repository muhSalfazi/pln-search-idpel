<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Customer extends Model
{
    // Tentukan nama tabel
    protected $table = 'customers';

    // Jika primary key bukan 'id', tentukan di sini
    protected $primaryKey = 'id';

    // Jika primary key bukan auto-incrementing, tambahkan ini
    public $incrementing = false;

    // Jika primary key bukan tipe integer
    protected $keyType = 'string';

    // Matikan timestamps jika tabel tidak punya kolom created_at dan updated_at
    public $timestamps = false;

    // Tentukan kolom-kolom yang dapat diisi melalui mass-assignment
    protected $fillable = [
        'no_pelanggan',
        'tarif',
        'daya',
        'jenis_layanan',
        'nomer_meter',
        'status'
    ];

    public function history()
    {
        return $this->hasMany(History::class, 'id_customer', 'id');
    }
}
