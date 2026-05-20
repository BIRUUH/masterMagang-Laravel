<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-primary px-3" href="/admin/beranda">
            <i class="bi bi-mortarboard-fill me-2"></i>MagangMaster
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            {{-- Navigasi halaman: hanya tampil di mobile/tablet (sidebar disembunyikan di ≤992px) --}}
            <ul class="navbar-nav me-auto px-2 d-lg-none">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.beranda') ? 'active fw-semibold' : '' }}" href="{{ route('admin.beranda') }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active fw-semibold' : '' }}" href="{{ route('admin.siswa.index') }}">
                        <i class="bi bi-people me-2"></i> Manajemen Siswa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.guru.*') ? 'active fw-semibold' : '' }}" href="{{ route('admin.guru.index') }}">
                        <i class="bi bi-person-badge me-2"></i> Manajemen Guru
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dudi.*') ? 'active fw-semibold' : '' }}" href="{{ route('admin.dudi.index') }}">
                        <i class="bi bi-building me-2"></i> Daftar Industri
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.magang.*') ? 'active' : '' }}" href="{{ route('admin.magang.index') ?? '#' }}">
                        <i class="bi bi-building-gear me-2"></i> Manajemen Magang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear me-2"></i> Pengaturan
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider my-1">
                </li>
            </ul>

            {{-- Profile dropdown: selalu tampil di kanan --}}
            <ul class="navbar-nav ms-auto px-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDrop" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i> Admin RPL
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="profileDrop">
                        <li><a class="dropdown-item" href="#">Profil Saya</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="#">Keluar</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>