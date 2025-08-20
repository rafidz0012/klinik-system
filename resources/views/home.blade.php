@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h3 class="fw-bold text-primary">🏥 Dashboard Klinik</h3>
            <p class="text-muted">Selamat datang di Sistem Informasi Klinik</p>
        </div>
    </div>

    {{-- Statistik Utama --}}
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center p-3 bg-light">
                <div class="fs-1 text-primary mb-2"><i class="bi bi-people"></i></div>
                <h5 class="fw-bold">120</h5>
                <p class="text-muted mb-0">Pasien Hari Ini</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center p-3 bg-light">
                <div class="fs-1 text-warning mb-2"><i class="bi bi-capsule"></i></div>
                <h5 class="fw-bold">85</h5>
                <p class="text-muted mb-0">Obat Tersedia</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center p-3 bg-light">
                <div class="fs-1 text-danger mb-2"><i class="bi bi-heart-pulse"></i></div>
                <h5 class="fw-bold">12</h5>
                <p class="text-muted mb-0">Tindakan Hari Ini</p>
            </div>
        </div>
    </div>

    {{-- Menu Cepat --}}
    <div class="row mt-5">
        <div class="col-md-4">
            <a href="{{ route('pasien.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 p-4 text-center h-100 hover-card">
                    <div class="fs-2 text-primary mb-3"><i class="bi bi-person-lines-fill"></i></div>
                    <h5 class="fw-bold">Manajemen Pasien</h5>
                    <p class="text-muted">Tambah, ubah, dan lihat data pasien.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('obat.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 p-4 text-center h-100 hover-card">
                    <div class="fs-2 text-warning mb-3"><i class="bi bi-capsule-pill"></i></div>
                    <h5 class="fw-bold">Manajemen Obat</h5>
                    <p class="text-muted">Kelola stok obat yang tersedia di klinik.</p>
                </div>
            </a>
        </div>
    </div>
</div>

{{-- Tambahan CSS untuk efek hover --}}
<style>
    .hover-card:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
</style>
@endsection
