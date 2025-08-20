@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-gradient m-0">
            <i class="bi bi-clipboard-check text-primary me-2"></i> 
            Tindakan & Resep Obat
        </h2>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-pills mb-4 shadow-sm p-2 rounded-3 bg-white" id="kunjunganTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-pill px-4 fw-semibold" 
                id="kunjungan-tab" 
                data-bs-toggle="tab" 
                data-bs-target="#kunjungan" 
                type="button" 
                role="tab">
                <i class="bi bi-journal-medical me-2"></i> Kunjungan
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill px-4 fw-semibold" 
                id="tindakan-tab" 
                data-bs-toggle="tab" 
                data-bs-target="#tindakan" 
                type="button" 
                role="tab">
                <i class="bi bi-activity me-2"></i> Tindakan
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill px-4 fw-semibold" 
                id="obat-tab" 
                data-bs-toggle="tab" 
                data-bs-target="#obat" 
                type="button" 
                role="tab">
                <i class="bi bi-capsule-pill me-2"></i> Obat
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content bg-white shadow-sm rounded-4 p-4" id="kunjunganTabContent">
        <div class="tab-pane fade show active" id="kunjungan" role="tabpanel">
            <x-tab-kunjungan :kunjungans="$kunjungans" :pasien="$pasien" />
        </div>
        <div class="tab-pane fade" id="tindakan" role="tabpanel">
            <x-tab-tindakan 
                :tindakanKunjungans="$tindakanKunjungans" 
                :kunjungans="$kunjungans" 
                :tindakans="$tindakans" 
            />
        </div>
        <div class="tab-pane fade" id="obat" role="tabpanel">
            <x-tab-obat 
                :obatKunjungans="$obatKunjungans" 
                :kunjungans="$kunjungans" 
                :obats="$obats" />
        </div>
    </div>
</div>

<!-- Gradient Style -->
<style>
    .text-gradient {
        background: linear-gradient(45deg, #0d6efd, #6610f2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .nav-pills .nav-link.active {
        background: linear-gradient(45deg, #0d6efd, #6610f2);
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }
</style>
@endsection
