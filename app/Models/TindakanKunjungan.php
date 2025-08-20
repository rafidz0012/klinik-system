<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakanKunjungan extends Model
{
    protected $fillable = ['kunjungan_id', 'tindakan_id', 'biaya', 'catatan'];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function tindakan()
    {
        return $this->belongsTo(Tindakan::class);
    }
}
