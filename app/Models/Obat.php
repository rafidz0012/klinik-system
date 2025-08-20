<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    // Nama tabel (opsional kalau sesuai konvensi)
    protected $table = 'obats';

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'nama_obat',
        'stok',
        'harga',
        'deskripsi'
    ];
}
