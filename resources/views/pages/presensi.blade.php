@extends('layouts.app')
@section('content')

<h3>Presensi Hari Ini</h3>

@if(session('pesan'))
    <div class="alert alert-info">{{ session('pesan') }}</div>
@endif

@if(!$presensi_hari_ini)
    <form action="{{ route('presensi.masuk') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="status" class="form-label">Pilih Status Kehadiran</label>
            <select name="status" id="status" class="form-select w-auto d-inline-block" style="min-width:150px;" required>
                <option value="Hadir">Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
                <option value="Alpha">Alpha</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (opsional)</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control"
                   placeholder="Isi alasan jika Izin/Sakit/Alpha">
        </div>
        <button type="submit" class="btn btn-success">Presensi Masuk</button>
    </form>

@else
    <p><strong>Presensi Masuk:</strong> {{ $presensi_hari_ini->jam_masuk ?? '-' }}</p>
    <p><strong>Status:</strong> {{ $presensi_hari_ini->status ?? '-' }}</p>
    <p><strong>Keterangan:</strong> {{ $presensi_hari_ini->keterangan ?? '-' }}</p>

    @if(empty($presensi_hari_ini->jam_keluar))
        <form action="{{ route('presensi.keluar') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Presensi Keluar</button>
        </form>
    @else
        <p><strong>Presensi Keluar:</strong> {{ $presensi_hari_ini->jam_keluar }}</p>
        <div class="alert alert-success mt-2">✅ Terima kasih, kamu sudah presensi lengkap hari ini.</div>
    @endif
@endif

<button class="btn btn-outline-primary btn-sm mt-4" onclick="toggleRiwayat()">
    Lihat Riwayat Presensi 7 Hari Terakhir
</button>

<div id="riwayatPresensi" style="display:none;" class="mt-3">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th><th>Jam Masuk</th><th>Jam Keluar</th><th>Status</th><th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $r)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($r->tanggal)) }}</td>
                        <td>{{ $r->jam_masuk ?? '-' }}</td>
                        <td>{{ $r->jam_keluar ?? '-' }}</td>
                        <td>{{ $r->status }}</td>
                        <td>{{ $r->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Belum ada data presensi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleRiwayat() {
    var x = document.getElementById("riwayatPresensi");
    x.style.display = (x.style.display === "none") ? "block" : "none";
}
</script>
@endpush
