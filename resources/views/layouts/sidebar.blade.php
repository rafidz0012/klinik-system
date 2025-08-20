<div class="d-flex flex-column vh-100 bg-dark text-white px-4" style="width: 250px;">
    <!-- Header -->
    <div class="p-3 fw-bold fs-4 border-bottom border-secondary">
        Klinik System
    </div>

    <!-- Navigation -->
    <nav class="flex-column flex-grow-1 mt-3">
        {{-- Dashboard --}}
        @can('view dashboard')
        <a href="{{ route('home') }}"
           class="nav-link px-3 py-2 text-white d-block rounded {{ request()->routeIs('home') ? 'bg-secondary fw-bold' : 'text-white-50' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        @endcan

        {{-- Master Data --}}
        @can('manage master data')
        <div class="mt-4">
            <small class="text-secondary text-uppercase ps-3 d-block mb-2">Master Data</small>

            <a href="{{ route('wilayah.index') }}"
               class="nav-link px-3 py-2 text-white d-block rounded {{ request()->routeIs('wilayah.*') ? 'bg-secondary fw-bold' : 'text-white-50' }}">
                <i class="bi bi-geo-alt me-2"></i> Wilayah
            </a>
            <a href="{{ route('user.index') }}"
               class="nav-link px-3 py-2 text-white d-block rounded {{ request()->routeIs('user.*') ? 'bg-secondary fw-bold' : 'text-white-50' }}">
                <i class="bi bi-people me-2"></i> User
            </a>
            <a href="{{ route('pegawai.index') }}"
               class="nav-link px-3 py-2 text-white d-block rounded {{ request()->routeIs('pegawai.*') ? 'bg-secondary fw-bold' : 'text-white-50' }}">
                <i class="bi bi-person-badge me-2"></i> Pegawai
            </a>
            <a href="{{ route('tindakan.index') }}"
               class="nav-link px-3 py-2 text-white d-block rounded {{ request()->routeIs('tindakan.*') ? 'bg-secondary fw-bold' : 'text-white-50' }}">
                <i class="bi bi-clipboard2-pulse me-2"></i> Tindakan
            </a>
            <a href="{{ route('obat.index') }}"
               class="nav-link px-3 py-2 text-white d-block rounded {{ request()->routeIs('obat.*') ? 'bg-secondary fw-bold' : 'text-white-50' }}">
                <i class="bi bi-capsule me-2"></i> Obat
            </a>
        </div>
        @endcan
        {{-- Pendaftaran Pasien --}}
        @can('register pasien')
        <div class="mt-3">
            <small class="text-secondary text-uppercase ps-3">Transaksi</small>
            <a href="{{ route('pasien.index') }}"
            class="nav-link px-3 py-2 text-white d-block rounded {{ request()->routeIs('pasien.*') ? 'bg-secondary fw-medium' : 'text-white-50' }}">
                Pendaftaran Pasien
            </a>
        </div>
        @endcan
        @can('manage tindakan')
            <a href="{{ route('tindakan-kunjungan.index') }}"
            class="nav-link px-3 py-2 text-white d-block rounded {{ request()->routeIs('tindakan-kunjungan.*') ? 'bg-secondary fw-medium' : 'text-white-50' }}">
                Tindakan & Resep Obat
            </a>
        @endcan
        {{-- Pembayaran --}}
        @can('manage pembayaran')
        <a href="{{ route('pembayaran.index') }}"
        class="nav-link px-3 py-2 text-white d-block rounded {{ request()->routeIs('pembayaran.*') ? 'bg-secondary fw-medium' : 'text-white-50'  }}">
            Pembayaran
        </a>
        @endcan
        {{-- Laporan --}}
        @can('view laporan')
        <a href="{{ route('laporan.index') }}"
        class="nav-link px-3 py-2 text-white d-block rounded {{ request()->routeIs('laporan.*') ? 'bg-secondary fw-medium' : 'text-white-50'  }}">
            Laporan
        </a>
        @endcan

    </nav>

    <!-- Logout -->
    <div class="mt-auto p-3 border-top border-secondary">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>
</div>
