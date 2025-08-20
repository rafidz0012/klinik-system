<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        return view('obat', compact('obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        Obat::create($request->all());

        return redirect()->back()->with('success', 'Obat berhasil ditambahkan.');
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        $obat->update($request->all());

        return redirect()->back()->with('success', 'Obat berhasil diperbarui.');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();
        return redirect()->back()->with('success', 'Obat berhasil dihapus.');
    }
}
