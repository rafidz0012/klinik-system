<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasiens'; // <-- tambahkan ini

    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_identitas',
    ];
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi: Pasien memiliki banyak kunjungan
    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class);
    }
}
