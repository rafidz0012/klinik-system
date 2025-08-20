<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;


class PasienController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data pasien, bisa ditambahkan filter/search
        $query = Pasien::query();

        // contoh search by nama
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $pasiens = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pasien', compact('pasiens'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_identitas' => 'required|numeric',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'nullable|string',
        ]);

        Pasien::create($request->all());

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    // Update pasien
    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'nullable|string',
            'no_identitas' => 'required|numeric',
        ]);

        $pasien->update($request->all());

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil diupdate.');
    }

    // Hapus pasien
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil dihapus.');
    }
}
