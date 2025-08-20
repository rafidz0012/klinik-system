<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Pasien;

class KunjunganController extends Controller
{
    // Index
    public function index(Request $request)
    {
        $query = Kunjungan::with('pasien');

        if ($request->filled('search')) {
            $query->whereHas('pasien', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $kunjungans = $query->orderBy('tanggal_kunjungan', 'desc')->paginate(10);
        $pasien = Pasien::all();

        return view('kunjungan', compact('kunjungans', 'pasien'));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'tanggal_kunjungan' => 'required|date',
            'tipe_kunjungan' => 'required|string',
            // 'status' dihapus dari validasi karena kita set otomatis
        ]);

        Kunjungan::create([
            'pasien_id'        => $request->pasien_id,
            'tanggal_kunjungan'=> $request->tanggal_kunjungan,
            'tipe_kunjungan'   => $request->tipe_kunjungan,
            'status'           => 'Menunggu', // otomatis
        ]);

        return redirect()->back()->with('success', 'Kunjungan berhasil ditambahkan.');
    }

    // Update
    public function update(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'tanggal_kunjungan' => 'required|date',
            'tipe_kunjungan' => 'required|string',
            // hapus status dari validasi kalau memang otomatis
        ]);

        $kunjungan->update([
            'pasien_id' => $request->pasien_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'tipe_kunjungan' => $request->tipe_kunjungan,
            'status' => 'Menunggu', // selalu overwrite
        ]);

        return redirect()->back()
            ->with('success', 'Kunjungan berhasil diupdate.');
    }
    // Destroy
    public function destroy(Kunjungan $kunjungan)
    {
        $kunjungan->delete();

        return redirect()->route('kunjungan.index')->with('success', 'Kunjungan berhasil dihapus.');
    }
}
