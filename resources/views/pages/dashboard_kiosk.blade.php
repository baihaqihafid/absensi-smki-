@extends('layouts.app')
@section('content')

<div class="container mt-4" style="max-width:500px;">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <h4 class="mb-3"><i class="fas fa-fingerprint me-2"></i>Presensi Kiosk</h4>

            @if($pesan ?? null)
                <div class="alert alert-info">{{ $pesan }}</div>
            @endif

            <form method="POST" action="{{ route('kiosk.proses') }}">
                @csrf
                <div class="mb-3 text-start">
                    <label class="form-label fw-bold">Username Siswa</label>
                    <input type="text" name="username" class="form-control form-control-lg"
                           placeholder="Masukkan username..." required autofocus>
                </div>
                <button type="submit" class="btn btn-success btn-lg w-100">
                    <i class="fas fa-check-circle me-2"></i>Absen
                </button>
            </form>

            <p class="text-muted mt-3 small">Waktu saat ini: <strong id="jamKiosk"></strong></p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function updateJam() {
    let now = new Date();
    document.getElementById("jamKiosk").textContent = now.toLocaleTimeString('id-ID', { hour12: false });
}
setInterval(updateJam, 1000);
updateJam();
</script>
@endpush
