@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm rounded-3">
        <h3 class="fw-bold mb-0">💳 Manajemen Pembayaran</h3>
        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pembayaran
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table id="pembayaranTable" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Pasien</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal Bayar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayarans as $bayar)
                        <tr>
                            <td class="fw-medium">{{ $bayar->kunjungan->pasien->nama ?? '-' }}</td>
                            <td class="text-success fw-bold">Rp {{ number_format($bayar->total,0,',','.') }}</td>
                            <td>
                                <span class="badge px-3 py-2 {{ $bayar->status_bayar == 'lunas' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($bayar->status_bayar) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $bayar->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('pembayaran.destroy', $bayar->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus pembayaran?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit{{ $bayar->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <form action="{{ route('pembayaran.update', $bayar->id) }}" method="POST" class="w-100">
                                    @csrf @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title">✏️ Edit Pembayaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Kunjungan</label>
                                                <select name="kunjungan_id" class="form-select" required>
                                                    @foreach($kunjungans as $kunjungan)
                                                        <option value="{{ $kunjungan->id }}" {{ $bayar->kunjungan_id == $kunjungan->id ? 'selected' : '' }}>
                                                            {{ $kunjungan->pasien->nama ?? '-' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Total</label>
                                                <input type="number" name="total" class="form-control" value="{{ $bayar->total }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Status Bayar</label>
                                                <select name="status_bayar" class="form-select">
                                                    <option value="lunas" {{ $bayar->status_bayar=='lunas'?'selected':'' }}>Lunas</option>
                                                    <option value="belum" {{ $bayar->status_bayar=='belum'?'selected':'' }}>Belum</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Bayar</label>
                                                <input type="date" name="tanggal_bayar" class="form-control" value="{{ $bayar->tanggal_bayar }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('pembayaran.store') }}" method="POST" class="w-100">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">➕ Tambah Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kunjungan</label>
                        <select id="kunjunganSelect" name="kunjungan_id" class="form-select" required>
                            @foreach($kunjungans as $kunjungan)
                                <option value="{{ $kunjungan->id }}" data-total="{{ $kunjungan->total_biaya }}">
                                    {{ $kunjungan->id . ' - ' . ($kunjungan->pasien->nama ?? '-') . ' - ' . ($kunjungan->tanggal_kunjungan ?? '-') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total</label>
                        <input type="number" id="totalInput" name="total" class="form-control fw-bold text-success" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Bayar</label>
                        <select name="status_bayar" class="form-select">
                            <option value="lunas">Lunas</option>
                            <option value="belum">Belum</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const select = document.getElementById("kunjunganSelect");
    const totalInput = document.getElementById("totalInput");

    if (select.selectedOptions.length > 0) {
        totalInput.value = select.selectedOptions[0].dataset.total;
    }

    select.addEventListener("change", function() {
        totalInput.value = this.selectedOptions[0].dataset.total;
    });

    // DataTables init
    new DataTable('#pembayaranTable', {
        responsive: true,
        pageLength: 5,
        ordering: true,
        language: {
            search: "🔍 Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            paginate: {
                first: "Awal", last: "Akhir", next: "➡", previous: "⬅"
            }
        }
    });
});
</script>
@endpush
@endsection
