<div class="tab-pane fade show active" id="obat" role="tabpanel">

    <!-- Header dengan Search + Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form action="{{ route('tindakan-kunjungan.index') }}" method="GET" class="d-flex flex-grow-1 me-3">
            <input type="text" name="search" class="form-control rounded-pill px-3 shadow-sm" 
                   placeholder="🔍 Cari pasien..." value="{{ request('search') }}">
        </form>
        <button class="btn btn-primary rounded-pill shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalTambahObat">
            <i class="bi bi-plus-lg me-1"></i> Tambah Obat
        </button>
    </div>

    <!-- Card Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nama Pasien</th>
                            <th>Obat</th>
                            <th>Dosis</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($obatKunjungans as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($obatKunjungans->currentPage() - 1) * $obatKunjungans->perPage() }}</td>
                            <td>{{ $item->kunjungan->pasien->nama ?? '-' }}</td>
                            <td><span class="badge bg-info text-dark">{{ $item->obat->nama_obat ?? '-' }}</span></td>
                            <td>{{ $item->dosis ?? '-' }}</td>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#modalEditObat{{ $item->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#modalHapusObat{{ $item->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit Obat -->
                        <div class="modal fade" id="modalEditObat{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <form action="{{ route('obat-kunjungan.update', $item->id) }}" method="POST" class="modal-content shadow-lg">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header bg-warning text-white">
                                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Obat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Pasien</label>
                                            <select name="kunjungan_id" class="form-select" required>
                                                @foreach($kunjungans as $kunjungan)
                                                    <option value="{{ $kunjungan->id }}" {{ $kunjungan->id==$item->kunjungan_id?'selected':'' }}>
                                                        {{ $kunjungan->pasien->nama ?? '-' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Obat</label>
                                            <select name="obat_id" class="form-select" required>
                                                @foreach($obats as $obat)
                                                    <option value="{{ $obat->id }}" {{ $obat->id==$item->obat_id?'selected':'' }}>
                                                        {{ $obat->nama_obat }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Dosis</label>
                                            <input type="text" name="dosis" class="form-control" value="{{ $item->dosis }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning text-white">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Hapus Obat -->
                        <div class="modal fade" id="modalHapusObat{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <form action="{{ route('obat-kunjungan.destroy', $item->id) }}" method="POST" class="modal-content shadow-lg">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Hapus Obat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus <strong>{{ $item->obat->nama_obat ?? '-' }}</strong> 
                                        untuk pasien <strong>{{ $item->kunjungan->pasien->nama ?? '-' }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $obatKunjungans->links() }}
    </div>

    <!-- Modal Tambah Obat -->
    <div class="modal fade" id="modalTambahObat" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('obat-kunjungan.store') }}" method="POST" class="modal-content shadow-lg">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Obat</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pasien</label>
                        <select name="kunjungan_id" class="form-select" required>
                            @foreach($kunjungans as $kunjungan)
                                <option value="{{ $kunjungan->id }}">{{ $kunjungan->pasien->nama ?? '-' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Obat</label>
                        <select name="obat_id" class="form-select" required>
                            @foreach($obats as $obat)
                                <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dosis</label>
                        <input type="text" name="dosis" class="form-control" required>
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
