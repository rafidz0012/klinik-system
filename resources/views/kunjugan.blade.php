@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Kunjungan Pasien</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Search & Tambah -->
    <div class="d-flex justify-content-between mb-3">
        <form action="{{ route('kunjungan.index') }}" method="GET" class="flex-grow-1 me-2">
            <input type="text" name="search" class="form-control" placeholder="Cari pasien..." value="{{ request('search') }}">
        </form>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Kunjungan</button>
    </div>

    <!-- Tabel -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-secondary">
                <tr>
                    <th>#</th>
                    <th>Nama Pasien</th>
                    <th>Tanggal Kunjungan</th>
                    <th>Tipe Kunjungan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kunjungans as $item)
                <tr>
                    <td>{{ $loop->iteration + ($kunjungans->currentPage() - 1) * $kunjungans->perPage() }}</td>
                    <td>{{ $item->pasien->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d-m-Y') }}</td>
                    <td>{{ $item->tipe_kunjungan }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">Edit</button>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $item->id }}">Hapus</button>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('kunjungan.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kunjungan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Pasien</label>
                                        <select name="pasien_id" class="form-control" required>
                                            @foreach($pasien as $p)
                                                <option value="{{ $p->id }}" {{ $p->id==$item->pasien_id?'selected':'' }}>{{ $p->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tanggal Kunjungan</label>
                                        <input type="date" name="tanggal_kunjungan" class="form-control" value="{{ $item->tanggal_kunjungan }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tipe Kunjungan</label>
                                        <input type="text" name="tipe_kunjungan" class="form-control" value="{{ $item->tipe_kunjungan }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Status</label>
                                        <input type="text" name="status" class="form-control" value="{{ $item->status }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Hapus -->
                <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('kunjungan.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Hapus Kunjungan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus kunjungan pasien <strong>{{ $item->pasien->nama ?? '-' }}</strong> pada tanggal <strong>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d-m-Y') }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $kunjungans->links() }}
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('kunjungan.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kunjungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Pasien</label>
                        <select name="pasien_id" class="form-control" required>
                            @foreach($pasien as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Kunjungan</label>
                        <input type="date" name="tanggal_kunjungan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tipe Kunjungan</label>
                        <input type="text" name="tipe_kunjungan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <input type="text" name="status" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
