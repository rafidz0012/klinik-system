<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'harga',
    ];

    // Relasi ke TindakanKunjungan (pivot table/relasi ke kunjungan)
    public function tindakanKunjungans()
    {
        return $this->hasMany(TindakanKunjungan::class);
    }
}
