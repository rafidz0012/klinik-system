<div class="tab-pane fade show active" id="tindakan" role="tabpanel">
    <!-- Header & Search -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form action="{{ route('tindakan-kunjungan.index') }}" method="GET" class="d-flex flex-grow-1 me-2">
            <input type="text" 
                   name="search" 
                   class="form-control shadow-sm rounded-pill px-3" 
                   placeholder="🔍 Cari pasien..." 
                   value="{{ request('search') }}">
        </form>
        <button class="btn btn-primary rounded-pill shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
            ➕ Tambah Tindakan
        </button>
    </div>

    <!-- Tabel Modern -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Pasien</th>
                            <th>Tindakan</th>
                            <th>Biaya</th>
                            <th>Catatan</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tindakanKunjungans as $item)
                        <tr>
                            <td class="fw-bold text-muted">
                                {{ $loop->iteration + ($tindakanKunjungans->currentPage() - 1) * $tindakanKunjungans->perPage() }}
                            </td>
                            <td>{{ $item->kunjungan->pasien->nama ?? '-' }}</td>
                            <td><span class="badge bg-info text-dark px-3 py-2">{{ $item->tindakan->nama ?? '-' }}</span></td>
                            <td><span class="fw-semibold text-success">Rp {{ number_format($item->biaya,0,',','.') }}</span></td>
                            <td>{{ $item->catatan ?? '-' }}</td>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                    ✏️ Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $item->id }}">
                                    🗑️ Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <form action="{{ route('tindakan-kunjungan.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content rounded-4 shadow-lg">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">✏️ Edit Tindakan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Pasien</label>
                                                    <select name="kunjungan_id" class="form-select rounded-pill" required>
                                                        @foreach($kunjungans as $kunjungan)
                                                            <option value="{{ $kunjungan->id }}" {{ $kunjungan->id==$item->kunjungan_id?'selected':'' }}>
                                                                {{ $kunjungan->pasien->nama ?? '-' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Tindakan</label>
                                                    <select name="tindakan_id" class="form-select rounded-pill" required>
                                                        @foreach($tindakans as $tindakan)
                                                            <option value="{{ $tindakan->id }}" {{ $tindakan->id==$item->tindakan_id?'selected':'' }}>
                                                                {{ $tindakan->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Biaya</label>
                                                    <input type="number" name="biaya" class="form-control rounded-pill" value="{{ $item->biaya }}" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Catatan</label>
                                                    <textarea name="catatan" class="form-control rounded-3">{{ $item->catatan }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4">💾 Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('tindakan-kunjungan.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content rounded-4 shadow-lg">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold text-danger">🗑️ Hapus Tindakan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0">Apakah Anda yakin ingin menghapus tindakan 
                                                <strong>{{ $item->tindakan->nama }}</strong> 
                                                untuk pasien <strong>{{ $item->kunjungan->pasien->nama ?? '-' }}</strong>?
                                            </p>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger rounded-pill px-4">Hapus</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">🚫 Tidak ada data tindakan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $tindakanKunjungans->links() }}
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('tindakan-kunjungan.store') }}" method="POST">
                @csrf
                <div class="modal-content rounded-4 shadow-lg">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">➕ Tambah Tindakan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pasien</label>
                                <select name="kunjungan_id" class="form-select rounded-pill" required>
                                    @foreach($kunjungans as $kunjungan)
                                        <option value="{{ $kunjungan->id }}">{{ $kunjungan->pasien->nama ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tindakan</label>
                                <select name="tindakan_id" class="form-select rounded-pill" required>
                                    @foreach($tindakans as $tindakan)
                                        <option value="{{ $tindakan->id }}">{{ $tindakan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Biaya</label>
                                <input type="number" name="biaya" class="form-control rounded-pill" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Catatan</label>
                                <textarea name="catatan" class="form-control rounded-3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
