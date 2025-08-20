<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class WilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data wilayah
        $wilayahs = Wilayah::all();

        return view('wilayah', compact('wilayahs'));
    }
    public function exportPdf()
    {
        $wilayahs = Wilayah::all();

        $pdf = Pdf::loadView('wilayah_pdf', compact('wilayahs'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-wilayah.pdf'); // kalau mau langsung download
        // return $pdf->stream('laporan-wilayah.pdf'); // kalau mau langsung tampil di browser
    }
    public function store(Request $request)
    {
        $request->validate([
            'provinsi' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
        ]);

        Wilayah::create([
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
        ]);

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $wilayah = Wilayah::findOrFail($id);
        return view('wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'provinsi' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
        ]);

        $wilayah = Wilayah::findOrFail($id);
        $wilayah->update($request->all());

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $wilayah = Wilayah::findOrFail($id);
        $wilayah->delete();

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil dihapus!');
    }
}
