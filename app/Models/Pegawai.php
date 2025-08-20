<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin'
    ];
}
