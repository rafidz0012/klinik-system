<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObatKunjungan extends Model
{
    protected $fillable = ['kunjungan_id', 'obat_id', 'jumlah', 'dosis'];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
