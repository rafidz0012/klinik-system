@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm rounded-3">
        <h4 class="fw-bold text-primary mb-0">
            <i class="bi bi-people-fill me-2"></i> Daftar Pegawai
        </h4>
        <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#tambahModal">
            <i class="bi bi-person-plus"></i>
            <span>Tambah Pegawai</span>
        </button>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Telepon</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pegawais as $pegawai)
                        <tr>
                            <td>{{ $pegawai->id }}</td>
                            <td class="fw-semibold">{{ $pegawai->nama }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $pegawai->jabatan }}</span></td>
                            <td>{{ $pegawai->telepon }}</td>
                            <td>
                                <span class="badge 
                                    @if($pegawai->jenis_kelamin === 'Laki-laki') bg-primary-subtle text-primary border 
                                    @else bg-pink text-danger border @endif">
                                    {{ $pegawai->jenis_kelamin }}
                                </span>
                            </td>
                            <td>{{ $pegawai->alamat }}</td>
                            <td>{{ $pegawai->tanggal_lahir }}</td>
                            <td class="text-center">
                                <!-- Tombol Edit -->
                                <button class="btn btn-sm btn-outline-warning me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal{{ $pegawai->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <button class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#hapusModal{{ $pegawai->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $pegawai->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title fw-bold">Edit Pegawai</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" name="nama" class="form-control mb-2" value="{{ $pegawai->nama }}" required>
                                            <input type="text" name="jabatan" class="form-control mb-2" value="{{ $pegawai->jabatan }}" required>
                                            <input type="text" name="telepon" class="form-control mb-2" value="{{ $pegawai->telepon }}" required>
                                            <select name="jenis_kelamin" class="form-control mb-2" required>
                                                <option value="Laki-laki" @selected($pegawai->jenis_kelamin === 'Laki-laki')>Laki-laki</option>
                                                <option value="Perempuan" @selected($pegawai->jenis_kelamin === 'Perempuan')>Perempuan</option>
                                            </select>
                                            <textarea name="alamat" class="form-control mb-2" required>{{ $pegawai->alamat }}</textarea>
                                            <input type="date" name="tanggal_lahir" class="form-control mb-2" value="{{ $pegawai->tanggal_lahir }}" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal{{ $pegawai->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title fw-bold">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus pegawai <b>{{ $pegawai->nama }}</b>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada data pegawai</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('pegawai.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Tambah Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
                    <input type="text" name="jabatan" class="form-control mb-2" placeholder="Jabatan" required>
                    <input type="text" name="telepon" class="form-control mb-2" placeholder="Telepon" required>
                    <select name="jenis_kelamin" class="form-control mb-2" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <textarea name="alamat" class="form-control mb-2" placeholder="Alamat" required></textarea>
                    <input type="date" name="tanggal_lahir" class="form-control mb-2" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
