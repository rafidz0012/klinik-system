<!-- Kunjungan -->
<div class="tab-pane fade show active" id="kunjungan" role="tabpanel">
    <!-- Search & Add -->
    <div class="d-flex justify-content-between mb-4">
        <form action="{{ route('tindakan-kunjungan.index') }}" method="GET" class="flex-grow-1 me-2 position-relative">
            <input type="text" name="search" 
                   class="form-control rounded-pill ps-5 shadow-sm" 
                   placeholder="🔍 Cari pasien..." 
                   value="{{ request('search') }}">
        </form>
        <button class="btn btn-primary rounded-pill shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#modalTambahKunjungan">
            <i class="bi bi-plus-lg me-1"></i> Tambah
        </button>
    </div>

    <!-- Table -->
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kunjungans as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($kunjungans->currentPage()-1)*$kunjungans->perPage() }}</td>
                            <td>{{ $item->pasien->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</td>
                            <td><span class="badge bg-info text-dark">{{ $item->tipe_kunjungan }}</span></td>
                            <td>
                                @if($item->status == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#modalEditKunjungan{{ $item->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#modalHapusKunjungan{{ $item->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEditKunjungan{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content rounded-4 shadow">
                                        <form action="{{ route('kunjungan.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header bg-warning text-dark rounded-top-4">
                                                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i> Edit Kunjungan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Pasien</label>
                                                    <select name="pasien_id" class="form-select" required>
                                                        @foreach($pasien as $p)
                                                        <option value="{{ $p->id }}" {{ $p->id == $item->pasien_id ? 'selected' : '' }}>
                                                            {{ $p->nama }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Kunjungan</label>
                                                    <input type="date" name="tanggal_kunjungan" class="form-control" value="{{ $item->tanggal_kunjungan }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tipe Kunjungan</label>
                                                    <input type="text" name="tipe_kunjungan" class="form-control" value="{{ $item->tipe_kunjungan }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Hapus -->
                            <div class="modal fade" id="modalHapusKunjungan{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content rounded-4 shadow">
                                        <form action="{{ route('kunjungan.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header bg-danger text-white rounded-top-4">
                                                <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i> Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Yakin ingin menghapus kunjungan pasien 
                                                <b>{{ $item->pasien->nama }}</b> pada tanggal 
                                                <b>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</b>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $kunjungans->links() }}
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambahKunjungan">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow">
                <form action="{{ route('kunjungan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title"><i class="bi bi-plus-lg me-2"></i> Tambah Kunjungan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pasien</label>
                            <select name="pasien_id" class="form-select" required>
                                @foreach($pasien as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Kunjungan</label>
                            <input type="date" name="tanggal_kunjungan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipe Kunjungan</label>
                            <select name="tipe_kunjungan" class="form-select" required>
                                <option value="Umum">Umum</option>
                                <option value="Gigi">Gigi</option>
                                <option value="KIA">KIA</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
