@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📊 Laporan Klinik</h3>

    <!-- Filter Bulan & Tahun -->
    <form method="GET" action="{{ route('laporan.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">Bulan</label>
            <select name="bulan" class="form-select">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tahun</label>
            <select name="tahun" class="form-select">
                @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="row">
        <!-- Chart Kunjungan Harian -->
        <div class="col-md-6 mb-4">
            <div class="card p-3">
                <h5>Jumlah Kunjungan per Hari ({{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }})</h5>
                <canvas id="kunjunganHarianChart"></canvas>
            </div>
        </div>

        <!-- Chart Kunjungan Bulanan -->
        <div class="col-md-6 mb-4">
            <div class="card p-3">
                <h5>Jumlah Kunjungan per Bulan ({{ $tahun }})</h5>
                <canvas id="kunjunganBulananChart"></canvas>
            </div>
        </div>

        <!-- Chart Tindakan -->
        <div class="col-md-6 mb-4">
            <div class="card p-3">
                <h5>Tindakan Terbanyak</h5>
                <canvas id="tindakanChart"></canvas>
            </div>
        </div>

        <!-- Chart Obat -->
        <div class="col-md-6 mb-4">
            <div class="card p-3">
                <h5>Obat Paling Sering Diresepkan</h5>
                <canvas id="obatChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Kunjungan Harian
    new Chart(document.getElementById('kunjunganHarianChart'), {
        type: 'line',
        data: {
            labels: @json($kunjunganHarian->pluck('tanggal')),
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: @json($kunjunganHarian->pluck('total')),
                borderColor: 'blue',
                backgroundColor: 'lightblue',
                fill: true
            }]
        }
    });

    // Kunjungan Bulanan
    new Chart(document.getElementById('kunjunganBulananChart'), {
        type: 'bar',
        data: {
            labels: @json($kunjunganBulanan->pluck('bulan')),
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: @json($kunjunganBulanan->pluck('total')),
                backgroundColor: 'green'
            }]
        }
    });

    // Tindakan Terbanyak
    new Chart(document.getElementById('tindakanChart'), {
        type: 'bar',
        data: {
            labels: @json($tindakanTerbanyak->pluck('tindakan.nama')),
            datasets: [{
                label: 'Jumlah',
                data: @json($tindakanTerbanyak->pluck('total')),
                backgroundColor: 'orange'
            }]
        }
    });

    // Obat Terbanyak
    new Chart(document.getElementById('obatChart'), {
        type: 'bar',
        data: {
            labels: @json($obatTerbanyak->pluck('obat.nama_obat')),
            datasets: [{
                label: 'Jumlah',
                data: @json($obatTerbanyak->pluck('total')),
                backgroundColor: 'red'
            }]
        }
    });
</script>
@endsection
