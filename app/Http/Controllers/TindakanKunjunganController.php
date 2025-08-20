<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TindakanKunjungan;
use App\Models\Kunjungan;
use App\Models\Tindakan;
use App\Models\ObatKunjungan;
use App\Models\Pasien;
use App\Models\Obat;

class TindakanKunjunganController extends Controller
{
    public function index(Request $request)
    {
        $kunjungans = Kunjungan::with('pasien')->orderBy('tanggal_kunjungan', 'desc')->paginate(10);
        $tindakanKunjungans = TindakanKunjungan::with('kunjungan.pasien','tindakan')->paginate(10);
        $obatKunjungans = ObatKunjungan::with('kunjungan.pasien','obat')->paginate(10);

        $pasien = Pasien::all();
        $tindakans = Tindakan::all();
        $obats = Obat::all();

        return view('tindakan-kunjungan', compact(
            'kunjungans',
            'tindakanKunjungans',
            'obatKunjungans',
            'pasien',
            'tindakans',
            'obats'
        ));
    }

     // Store
    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'tindakan_id' => 'required|exists:tindakans,id',
            'biaya' => 'required|numeric',
            'catatan' => 'nullable|string',
        ]);

        TindakanKunjungan::create($request->all());

        return redirect()->route('tindakan-kunjungan.index')->with('success', 'Tindakan berhasil ditambahkan.');
    }

    // Update
    public function update(Request $request, TindakanKunjungan $tindakanKunjungan)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'tindakan_id' => 'required|exists:tindakans,id',
            'biaya' => 'required|numeric',
            'catatan' => 'nullable|string',
        ]);

        $tindakanKunjungan->update($request->all());

        return redirect()->route('tindakan-kunjungan.index')->with('success', 'Tindakan berhasil diupdate.');
    }

    // Destroy
    public function destroy(TindakanKunjungan $tindakanKunjungan)
    {
        $tindakanKunjungan->delete();
        return redirect()->route('tindakan-kunjungan.index')->with('success', 'Tindakan berhasil dihapus.');
    }
}
