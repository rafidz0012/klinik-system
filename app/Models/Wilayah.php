<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayahs';

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'provinsi',
        'kota',
        'kecamatan',
    ];
}
