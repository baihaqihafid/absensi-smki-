<div class="bg-light p-3 minimal-sidebar" style="min-height:100vh;">
  <ul class="nav flex-column">

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('dashboard.admin') ? 'active fw-bold' : '' }}" href="{{ route('dashboard.admin') }}">
        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('pengguna.*') ? 'active fw-bold' : '' }}" href="{{ route('pengguna.index') }}">
        <i class="fas fa-users-cog me-2"></i> Kelola Pengguna
      </a>
    </li>

    <!-- Siswa -->
    <li class="nav-item">
      <a class="nav-link d-flex justify-content-between align-items-center"
         data-bs-toggle="collapse" href="#menuSiswa" role="button"
         aria-expanded="{{ request()->routeIs('siswa.*') || request()->routeIs('presensi.data_siswa') || request()->routeIs('laporan.siswa*') ? 'true' : 'false' }}">
        <span><i class="fas fa-user-graduate me-2"></i> Siswa</span>
        <i class="fas fa-chevron-down small"></i>
      </a>
      <div class="collapse {{ request()->routeIs('siswa.*') || request()->routeIs('presensi.data_siswa') || request()->routeIs('laporan.siswa*') ? 'show' : '' }}" id="menuSiswa">
        <ul class="nav flex-column ms-3">
          <li><a class="nav-link {{ request()->routeIs('siswa.index') ? 'fw-bold' : '' }}" href="{{ route('siswa.index') }}">Kelola Siswa</a></li>
          <li><a class="nav-link {{ request()->routeIs('presensi.data_siswa') ? 'fw-bold' : '' }}" href="{{ route('presensi.data_siswa') }}">Data Presensi</a></li>
          <li><a class="nav-link {{ request()->routeIs('laporan.siswa') ? 'fw-bold' : '' }}" href="{{ route('laporan.siswa') }}">Laporan</a></li>
        </ul>
      </div>
    </li>

    <!-- Guru -->
    <li class="nav-item">
      <a class="nav-link d-flex justify-content-between align-items-center"
         data-bs-toggle="collapse" href="#menuGuru" role="button"
         aria-expanded="{{ request()->routeIs('guru.*') || request()->routeIs('presensi.data_guru') || request()->routeIs('laporan.guru*') ? 'true' : 'false' }}">
        <span><i class="fas fa-chalkboard-teacher me-2"></i> Guru</span>
        <i class="fas fa-chevron-down small"></i>
      </a>
      <div class="collapse {{ request()->routeIs('guru.*') || request()->routeIs('presensi.data_guru') || request()->routeIs('laporan.guru*') ? 'show' : '' }}" id="menuGuru">
        <ul class="nav flex-column ms-3">
          <li><a class="nav-link {{ request()->routeIs('guru.index') ? 'fw-bold' : '' }}" href="{{ route('guru.index') }}">Kelola Guru</a></li>
          <li><a class="nav-link {{ request()->routeIs('presensi.data_guru') ? 'fw-bold' : '' }}" href="{{ route('presensi.data_guru') }}">Data Presensi</a></li>
          <li><a class="nav-link {{ request()->routeIs('laporan.guru') ? 'fw-bold' : '' }}" href="{{ route('laporan.guru') }}">Laporan</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('ganti.password') }}">
        <i class="fas fa-key me-2"></i> Ganti Password
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('laporan.masalah.admin') ? 'active fw-bold' : '' }}"
         href="{{ route('laporan.masalah.admin') }}">
        <i class="fas fa-exclamation-circle me-2 text-danger"></i> Laporan Masalah
      </a>
    </li>

  </ul>
</div>