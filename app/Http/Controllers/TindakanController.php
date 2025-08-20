<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use Illuminate\Http\Request;

class TindakanController extends Controller
{
    public function index()
    {
        $tindakans = Tindakan::all();
        return view('tindakan', compact('tindakans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:tindakans,kode',
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
        ]);

        Tindakan::create($request->all());

        return redirect()->back()->with('success', 'Tindakan berhasil ditambahkan');
    }

    public function update(Request $request, Tindakan $tindakan)
    {
        $request->validate([
            'kode' => 'required|unique:tindakans,kode,' . $tindakan->id,
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
        ]);

        $tindakan->update($request->all());

        return redirect()->back()->with('success', 'Tindakan berhasil diperbarui');
    }

    public function destroy(Tindakan $tindakan)
    {
        $tindakan->delete();
        return redirect()->route('tindakan')->with('success', 'Tindakan berhasil dihapus');
    }
}
