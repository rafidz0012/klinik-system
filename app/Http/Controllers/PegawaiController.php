<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pegawais = Pegawai::all(); 
        return view('pegawai', compact('pegawais'));
    }

    //     public function exportPdf()
    // {
    //     $pegawais = Pegawai::all();

    //     $pdf = Pdf::loadView('pegawai_pdf', compact('pegawais'))
    //             ->setPaper('a4', 'portrait');

    //     return $pdf->download('laporan-pegawai.pdf'); // kalau mau langsung download
    //     // return $pdf->stream('laporan-wilayah.pdf'); // kalau mau langsung tampil di browser
    // }
    /**
     * Show the form for creating a new resource.
     */ 
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'telepon' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        Pegawai::create($request->all());

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        $pegawai->update($request->all());
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        //
    }
}
