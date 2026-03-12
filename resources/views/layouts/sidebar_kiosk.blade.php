<div class="minimal-sidebar bg-dark" style="min-height:100vh; width:200px;">
    <div class="text-center py-4">
        <h5 class="text-white">SISTEM ABSENSI</h5>
        <p class="text-light small">SMK Islam Krembung</p>
    </div>
    <ul class="list-unstyled px-3">
        <li>
            <a href="{{ route('kiosk.index') }}" class="text-white py-3 d-block text-decoration-none">
                <i class="fas fa-users me-2"></i>Presensi Siswa
            </a>
        </li>
        <li>
            <a href="{{ route('logout.kiosk') }}" class="text-white py-3 d-block text-decoration-none"
               onclick="return confirm('Logout dari kiosk?')">
                <i class="fas fa-sign-out-alt me-2"></i>Logout Kiosk
            </a>
        </li>
    </ul>
</div>
