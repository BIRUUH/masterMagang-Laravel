<div class="sidebar border-end">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.beranda') ? 'active' : '' }}" href="{{ route('admin.beranda') ?? '#' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}" href="{{ route('admin.siswa.index') ?? '#' }}">
                <i class="bi bi-people me-2"></i> Manajemen Siswa
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}" href="{{ route('admin.guru.index') ?? '#' }}">
                <i class="bi bi-person-badge me-2"></i> Manajemen Guru
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dudi.*') ? 'active' : '' }}" href="{{ route('admin.dudi.index') ?? '#' }}">
                <i class="bi bi-building me-2"></i> Daftar Industri
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.magang.*') ? 'active' : '' }}" href="{{ route('admin.magang.index') ?? '#' }}">
                <i class="bi bi-building-gear me-2"></i> Manajemen Magang
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}" href="{{ route('admin.pengaturan.index') ?? '#' }}">
                <i class="bi bi-gear me-2"></i> Pengaturan
            </a>
        </li>
    </ul>
</div>