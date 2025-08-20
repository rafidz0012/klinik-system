<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObatKunjungan;
use App\Models\Kunjungan;
use App\Models\Obat;

class ObatKunjunganController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'kunjungan_id' => 'required|exists:kunjungans,id',
        'obat_id' => 'required|exists:obats,id',
        'jumlah' => 'required|integer|min:1',
        'dosis' => 'required|string|max:255',
    ]);

    // Simpan obatkunjungan
    $obatKunjungan = ObatKunjungan::create([
        'kunjungan_id' => $request->kunjungan_id,
        'obat_id' => $request->obat_id,
        'jumlah' => $request->jumlah,
        'dosis' => $request->dosis,
    ]);

    // Update status kunjungan jadi selesai
    $kunjungan = Kunjungan::find($request->kunjungan_id);
    if ($kunjungan) {
        $kunjungan->update(['status' => 'selesai']);
    }

    return redirect()->back()->with('success', 'Obat berhasil ditambahkan dan kunjungan diselesaikan.');
}


    /**
     * Update data obat kunjungan.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'obat_id' => 'required|exists:obats,id',
            'dosis' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $obatKunjungan = ObatKunjungan::findOrFail($id);
        $obatKunjungan->update($request->all());

        return redirect()->back()->with('success', 'Obat berhasil diperbarui.');
    }

    /**
     * Hapus data obat kunjungan.
     */
    public function destroy($id)
    {
        $obatKunjungan = ObatKunjungan::findOrFail($id);
        $obatKunjungan->delete();

        return redirect()->back()->with('success', 'Obat berhasil dihapus.');
    }
}
