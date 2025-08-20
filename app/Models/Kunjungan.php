<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $fillable = [
        'pasien_id',
        'tanggal_kunjungan',
        'tipe_kunjungan',
        'status',
    ];

    // Relasi: Kunjungan milik satu pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    // Relasi ke pivot TindakanKunjungan
    public function tindakanKunjungans()
    {
        return $this->hasMany(TindakanKunjungan::class);
    }

    // Relasi ke pivot ObatKunjungan
    public function obatKunjungans()
    {
        return $this->hasMany(ObatKunjungan::class);
    }
        public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
    public function getTotalBiayaAttribute()
    {
        $biayaTindakan = $this->tindakanKunjungans->sum('biaya');

        $biayaObat = $this->obatKunjungans->sum(function ($item) {
            return $item->jumlah * ($item->obat->harga ?? 0);
        });

        return $biayaTindakan + $biayaObat;
    }
}
