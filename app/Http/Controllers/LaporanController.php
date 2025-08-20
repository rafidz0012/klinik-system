<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\TindakanKunjungan;
use App\Models\ObatKunjungan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', date('m')); // default bulan sekarang
        $tahun = $request->input('tahun', date('Y')); // default tahun sekarang

        // Jumlah kunjungan per hari
        $kunjunganHarian = Kunjungan::select(
                DB::raw('DATE(tanggal_kunjungan) as tanggal'),
                DB::raw('COUNT(*) as total')
            )
            ->whereMonth('tanggal_kunjungan', $bulan)
            ->whereYear('tanggal_kunjungan', $tahun)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Jumlah kunjungan per bulan
        $kunjunganBulanan = Kunjungan::select(
                DB::raw('DATE_FORMAT(tanggal_kunjungan, "%Y-%m") as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('tanggal_kunjungan', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        // Tindakan terbanyak
        $tindakanTerbanyak = TindakanKunjungan::select('tindakan_id', DB::raw('COUNT(*) as total'))
            ->groupBy('tindakan_id')
            ->with('tindakan')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Obat terbanyak (top 5 global)
        $obatTerbanyak = ObatKunjungan::select('obat_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('obat_id')
            ->with('obat')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Obat per hari (bulan & tahun terpilih)
        $obatHarian = ObatKunjungan::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(jumlah) as total')
            )
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Obat per bulan (selama 1 tahun)
        $obatBulanan = ObatKunjungan::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as bulan'),
                DB::raw('SUM(jumlah) as total')
            )
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        return view('laporan', compact(
            'kunjunganHarian',
            'kunjunganBulanan',
            'tindakanTerbanyak',
            'obatTerbanyak',
            'obatHarian',
            'obatBulanan',
            'bulan',
            'tahun'
        ));
    }
}
