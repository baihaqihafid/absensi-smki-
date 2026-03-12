<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Presensi SMK Islam Krembung</title>
<link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
:root {
    --bs-primary-pastel: #333333;
    --bs-primary-pastel-hover: #79D1C3;
    --bs-font-color: #333333;
    --bs-body-bg: #f8f9fa;
}
body {
    background-color: var(--bs-body-bg);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: var(--bs-font-color);
    margin: 0; padding: 0;
    min-height: 100vh;
    display: flex; flex-direction: column;
}
.navbar {
    background: linear-gradient(135deg, #52b788 0%, #b7e4c7 100%) !important;
    box-shadow: 0 4px 15px rgba(45, 106, 79, 0.2);
    position: sticky; top: 0; z-index: 1000;
    border-bottom-left-radius: 1rem;
    border-bottom-right-radius: 1rem;
}
.page-content-wrapper { display: flex; flex-grow: 1; width: 100%; }
.minimal-sidebar {
    width: 220px; flex-shrink: 0;
    background-color: #FFFFFF !important;
    box-shadow: 2px 0 5px rgba(0,0,0,0.05);
    padding: 1.5rem 0;
    border-top-right-radius: 1rem;
    border-bottom-right-radius: 1rem;
    transition: all 0.3s ease;
}
.minimal-sidebar.hide { width: 0 !important; padding: 0 !important; overflow: hidden !important; }
.main-content-area { flex-grow: 1; padding: 1.5rem; overflow-y: auto; }
.card { border: none; border-radius: 1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: transform 0.2s; }
.card:hover { transform: translateY(-3px); }
.btn-primary-pastel {
    background-color: var(--bs-primary-pastel);
    border-color: var(--bs-primary-pastel);
    color: #fff; font-weight: 600;
}
.btn-primary-pastel:hover {
    background-color: var(--bs-primary-pastel-hover);
    border-color: var(--bs-primary-pastel-hover);
    color: #333;
}
.text-primary-pastel { color: var(--bs-primary-pastel) !important; }
.nav-card {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    text-decoration: none; color: var(--bs-font-color);
    min-height: 120px; transition: background-color 0.3s ease;
}
.nav-card:hover { background-color: var(--bs-primary-pastel); color: #FFF !important; }
.nav-card:hover .nav-card-icon, .nav-card:hover .nav-card-title { color: #FFF !important; }
.nav-card-icon { font-size: 2.5em; margin-bottom: 0.5rem; color: var(--bs-primary-pastel); }
.nav-card-title { font-weight: bold; font-size: 1.1em; }

/* ── MOBILE ONLY — desktop tidak terpengaruh ── */
@media (max-width: 768px) {
    .minimal-sidebar {
        position: fixed;
        top: 56; left: 0;
        height: 100vh;
        z-index: 999;
        width: 220px !important;
        padding: 1.5rem 0 !important;
        overflow-y: auto !important;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        border-radius: 0;
    }
    .minimal-sidebar.show-mobile {
        transform: translateX(0);
    }
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 998;
    }
    .sidebar-overlay.active { display: block; }
}
</style>
@stack('styles')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-light bg-white shadow-sm py-3">
<div class="container-fluid d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <button class="btn btn-outline-secondary me-2" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="40" class="me-2">
        <span class="fw-bold text-primary-pastel">SMK Islam Krembung</span>
    </div>
    <div class="d-flex align-items-center">
        <span class="me-3 fw-bold text-muted">{{ session('nama_lengkap') }}</span>
        <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger rounded-pill">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
        </a>
    </div>
</div>
</nav>

<!-- Overlay gelap saat sidebar mobile terbuka -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Main Content Wrapper -->
<div class="page-content-wrapper">

    <!-- Sidebar -->
    @include('layouts.sidebar_' . session('role', 'admin'))

    <!-- Content -->
    <div class="main-content-area container-fluid">
        @yield('content')
    </div>

</div>

<footer class="text-center mt-5 mb-3 text-muted">
    &copy; {{ date('Y') }} SMK Islam Krembung
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar   = document.querySelector('.minimal-sidebar');
    const overlay   = document.getElementById('sidebarOverlay');
    const isMobile  = () => window.innerWidth <= 768;

    if (!toggleBtn || !sidebar) return;

    toggleBtn.addEventListener('click', () => {
        if (isMobile()) {
            // Mobile: gunakan show-mobile + overlay
            sidebar.classList.toggle('show-mobile');
            overlay.classList.toggle('active');
        } else {
            // Desktop: tetap pakai hide seperti semula, tidak diubah sama sekali
            sidebar.classList.toggle('hide');
        }
    });

    // Klik overlay = tutup sidebar mobile
    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show-mobile');
            overlay.classList.remove('active');
        });
    }

    // Klik menu di sidebar = tutup otomatis di mobile saja
    sidebar.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            if (isMobile()) {
                sidebar.classList.remove('show-mobile');
                overlay.classList.remove('active');
            }
        });
    });
});
</script>
@stack('scripts')
</body>
</html>