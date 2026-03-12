<div class="bg-light p-3 minimal-sidebar" style="min-height:100vh;">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard.siswa') ? 'active fw-bold' : '' }}" href="{{ route('dashboard.siswa') }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('presensi.index') ? 'active fw-bold' : '' }}" href="{{ route('presensi.index') }}">
                <i class="fas fa-user-clock me-2"></i> Presensi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('ganti.password') }}">
                <i class="fas fa-key me-2"></i> Ganti Password
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('laporan.masalah') ? 'active fw-bold' : '' }}"
               href="{{ route('laporan.masalah') }}">
                <i class="fas fa-exclamation-circle me-2 text-danger"></i> Laporkan Masalah
            </a>
        </li>
    </ul>
</div>