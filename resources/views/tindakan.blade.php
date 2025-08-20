@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Header + Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm rounded-3">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-clipboard2-pulse text-primary me-2"></i> Daftar Tindakan
        </h4>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
            <i class="bi bi-plus-lg"></i> Tambah Tindakan
        </button>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tindakans as $tindakan)
                        <tr>
                            <td>{{ $tindakan->id }}</td>
                            <td>
                                <span class="badge border border-primary text-primary px-3 py-2 rounded-3">
                                    {{ $tindakan->kode }}
                                </span>
                            </td>
                            <td>{{ $tindakan->nama }}</td>
                            <td>{{ $tindakan->deskripsi }}</td>
                            <td><strong>Rp {{ number_format($tindakan->harga, 0, ',', '.') }}</strong></td>
                            <td class="text-center">
                                <!-- Tombol Edit -->
                                <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $tindakan->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $tindakan->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $tindakan->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('tindakan.update', $tindakan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content rounded-3">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="bi bi-pencil-square text-warning"></i> Edit Tindakan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" name="kode" class="form-control mb-2" value="{{ $tindakan->kode }}" required>
                                            <input type="text" name="nama" class="form-control mb-2" value="{{ $tindakan->nama }}" required>
                                            <textarea name="deskripsi" class="form-control mb-2" required>{{ $tindakan->deskripsi }}</textarea>
                                            <input type="number" name="harga" class="form-control mb-2" value="{{ $tindakan->harga }}" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal{{ $tindakan->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('tindakan.destroy', $tindakan->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content rounded-3">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-danger"><i class="bi bi-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah yakin ingin menghapus tindakan <strong>{{ $tindakan->nama }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
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
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('tindakan.store') }}" method="POST">
            @csrf
            <div class="modal-content rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-lg text-primary"></i> Tambah Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="kode" class="form-control mb-2" placeholder="Kode" required>
                    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
                    <textarea name="deskripsi" class="form-control mb-2" placeholder="Deskripsi" required></textarea>
                    <input type="number" name="harga" class="form-control mb-2" placeholder="Harga" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
