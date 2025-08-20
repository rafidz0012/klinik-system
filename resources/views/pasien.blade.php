@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white rounded-3 shadow-sm">
        <h2 class="fw-bold text-gradient m-0">
            <i class="bi bi-people-fill me-2 text-primary"></i> Daftar Pasien
        </h2>
        <button class="btn btn-primary rounded-pill shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pasien
        </button>
    </div>

    <!-- Search -->
    <form action="{{ route('pasien.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
            <input type="text" name="search" class="form-control" placeholder="Cari pasien..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    <!-- Card Table -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Nomor Identitas</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pasiens as $pasien)
                        <tr>
                            <td>{{ $loop->iteration + ($pasiens->currentPage() - 1) * $pasiens->perPage() }}</td>
                            <td>{{ $pasien->nama }}</td>
                            <td>{{ $pasien->no_identitas }}</td>
                            <td>
                                <span class="badge 
                                    @if($pasien->jenis_kelamin === 'Laki-laki') bg-primary-subtle text-primary border 
                                    @else bg-pink text-danger border @endif">
                                    {{ $pasien->jenis_kelamin }}
                                </span>
                            </td>
                            <td>{{ $pasien->tanggal_lahir->format('d-m-Y') }}</td>
                            <td>{{ $pasien->alamat }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $pasien->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $pasien->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit{{ $pasien->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <form action="{{ route('pasien.update', $pasien->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content rounded-4 shadow-lg border-0">
                                        <div class="modal-header bg-warning text-dark border-0">
                                            <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i> Edit Pasien</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nama</label>
                                                <input type="text" name="nama" class="form-control" value="{{ $pasien->nama }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nomor Identitas</label>
                                                <input type="number" name="no_identitas" class="form-control" value="{{ $pasien->no_identitas }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-select" required>
                                                    <option value="L" {{ $pasien->jenis_kelamin=='L'?'selected':'' }}>Laki-laki</option>
                                                    <option value="P" {{ $pasien->jenis_kelamin=='P'?'selected':'' }}>Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ $pasien->tanggal_lahir->format('Y-m-d') }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Alamat</label>
                                                <textarea name="alamat" class="form-control" rows="3">{{ $pasien->alamat }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Batal</button>
                                            <button type="submit" class="btn btn-warning text-dark rounded-3"><i class="fas fa-save me-1"></i> Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="modalHapus{{ $pasien->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <form action="{{ route('pasien.destroy', $pasien->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content rounded-4 shadow-lg border-0">
                                        <div class="modal-header bg-danger text-white border-0">
                                            <h5 class="modal-title fw-bold"><i class="fas fa-trash me-2"></i> Hapus Pasien</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <p class="mb-0">Apakah Anda yakin ingin menghapus pasien <strong>{{ $pasien->nama }}</strong>?</p>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Batal</button>
                                            <button type="submit" class="btn btn-danger rounded-3"><i class="fas fa-trash me-1"></i> Hapus</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Tidak ada data pasien</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $pasiens->links() }}
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('pasien.store') }}" method="POST">
            @csrf
            <div class="modal-content rounded-4 shadow-lg border-0">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-2"></i> Tambah Pasien</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor Identitas</label>
                        <input type="number" name="no_identitas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3"><i class="fas fa-save me-1"></i> Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    .text-gradient {
        background: linear-gradient(90deg, #4e73df, #1cc88a);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
@endsection
