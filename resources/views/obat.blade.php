@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm rounded-3">
        <h2 class="fw-bold text-primary mb-0"><i class="bi bi-capsule me-2"></i>  Daftar Obat</h2>
        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahModal">
            <i class="fas fa-plus"></i> Tambah Obat
        </button>
    </div>

    <!-- Card Table -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama Obat</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($obats as $obat)
                        <tr>
                            <td class="fw-semibold text-secondary">{{ $obat->id }}</td>
                            <td class="fw-bold">{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->stok }}</td>
                            <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                            <td>{{ $obat->deskripsi ?? '-' }}</td>
                            <td class="text-center">
                                <!-- Tombol Edit -->
                                <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $obat->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <!-- Tombol Hapus -->
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $obat->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $obat->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content rounded-3 shadow-lg border-0">
                                        <!-- Header -->
                                        <div class="modal-header bg-warning text-dark">
                                            <h5 class="modal-title fw-bold">
                                                <i class="fas fa-edit me-2"></i> Edit Obat
                                            </h5>
                                            <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Body -->
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nama Obat</label>
                                                <input type="text" name="nama_obat" value="{{ $obat->nama_obat }}" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Stok</label>
                                                <input type="number" name="stok" value="{{ $obat->stok }}" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Harga</label>
                                                <input type="number" name="harga" value="{{ $obat->harga }}" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Deskripsi</label>
                                                <textarea name="deskripsi" class="form-control" rows="3">{{ $obat->deskripsi }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i> Batal
                                            </button>
                                            <button type="submit" class="btn btn-warning text-dark">
                                                <i class="fas fa-save me-1"></i> Simpan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal{{ $obat->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <form action="{{ route('obat.destroy', $obat->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content rounded-3 shadow">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus <strong>{{ $obat->nama_obat }}</strong> ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
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
<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('obat.store') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow-lg rounded-4">
                <!-- Header -->
                <div class="modal-header border-0 bg-light py-3 px-4">
                    <h5 class="modal-title fw-bold text-primary">
                        <i class="fas fa-pills me-2"></i> Tambah Obat
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body px-4 py-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Nama Obat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-capsules text-muted"></i></span>
                                <input type="text" name="nama_obat" class="form-control" placeholder="Masukkan nama obat" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stok</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-boxes text-muted"></i></span>
                                <input type="number" name="stok" class="form-control" placeholder="Jumlah stok" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-tag text-muted"></i></span>
                                <input type="number" name="harga" class="form-control" placeholder="Harga satuan" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="form-control" placeholder="Tulis deskripsi obat"></textarea>
                        </div>
                    </div>
                </div>


                <!-- Footer -->
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-3">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
