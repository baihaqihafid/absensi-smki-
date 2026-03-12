<div class="minimal-sidebar" style="min-height:100vh;">
    <ul class="nav flex-column px-3">
        <li class="nav-item mb-1">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard.guru') ? 'active fw-bold' : '' }}" href="{{ route('dashboard.guru') }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('presensi.guru') ? 'active fw-bold' : '' }}" href="{{ route('presensi.guru') }}">
                <i class="fas fa-calendar-check me-2"></i> Isi Presensi
            </a>
        </li>
        <li class="nav-item mt-3">
            <a class="nav-link d-flex align-items-center" href="{{ route('ganti.password') }}">
                <i class="fas fa-key me-2"></i> Ganti Password
            </a>
        </li>
        <li class="nav-item mt-1">
            <a class="nav-link d-flex align-items-center {{ request()->routeIs('laporan.masalah') ? 'active fw-bold' : '' }}"
               href="{{ route('laporan.masalah') }}">
                <i class="fas fa-exclamation-circle me-2 text-danger"></i> Laporkan Masalah
            </a>
        </li>
    </ul>
</div>