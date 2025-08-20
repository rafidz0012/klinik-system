<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'kunjungan_id',
        'total',
        'status_bayar',
        'tanggal_bayar',
    ];

    // Relasi ke kunjungan
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }
}
