@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-geo-alt-fill me-2"></i> Master Wilayah</h5>
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalWilayah">
                <i class="bi bi-plus-circle me-1"></i> Tambah Wilayah
            </button>
        </div>
        <div class="card-body">

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Provinsi</th>
                            <th>Kota / Kabupaten</th>
                            <th>Kecamatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wilayahs as $wilayah)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $wilayah->provinsi }}</td>
                                <td>{{ $wilayah->kota }}</td>
                                <td>{{ $wilayah->kecamatan }}</td>
                                <td class="text-center">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-sm btn-warning me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal{{ $wilayah->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{ $wilayah->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('wilayah.update', $wilayah->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header bg-warning text-white">
                                                        <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Wilayah</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label>Provinsi</label>
                                                            <input type="text" name="provinsi" class="form-control" 
                                                                value="{{ $wilayah->provinsi }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Kota / Kabupaten</label>
                                                            <input type="text" name="kota" class="form-control" 
                                                                value="{{ $wilayah->kota }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Kecamatan</label>
                                                            <input type="text" name="kecamatan" class="form-control" 
                                                                value="{{ $wilayah->kecamatan }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning text-white">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('wilayah.destroy', $wilayah->id) }}" 
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus wilayah ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data wilayah</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah Wilayah -->
<div class="modal fade" id="modalWilayah" tabindex="-1" aria-labelledby="modalWilayahLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Wilayah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('wilayah.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Provinsi</label>
                <input type="text" name="provinsi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kota / Kabupaten</label>
                <input type="text" name="kota" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kecamatan</label>
                <input type="text" name="kecamatan" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
