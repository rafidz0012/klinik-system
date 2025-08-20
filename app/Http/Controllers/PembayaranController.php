<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with('kunjungan.pasien')->latest()->get();
        $kunjungans = Kunjungan::with('pasien')->get();

        return view('pembayaran', compact('pembayarans', 'kunjungans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'total' => 'required|numeric|min:0',
            'status_bayar' => 'required|in:lunas,belum',
            'tanggal_bayar' => 'required|date',
        ]);

        Pembayaran::create($request->all());

        return redirect()->back()->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'total' => 'required|numeric|min:0',
            'status_bayar' => 'required|in:lunas,belum',
            'tanggal_bayar' => 'required|date',
        ]);

        $pembayaran->update($request->all());

        return redirect()->back()->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->back()->with('success', 'Pembayaran berhasil dihapus.');
    }
}
