@extends('layouts.app')
@section('content')

@if(isset($flash))
    <div class="alert alert-{{ $flash['type'] }} alert-dismissible fade show text-center" role="alert">
        {{ $flash['msg'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-3 text-center">Isi Presensi Guru</h4>
        <form method="POST" action="{{ route('presensi.guru.simpan') }}">
            @csrf
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>Tanggal</label>
                    <input type="text" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Jam Masuk</label>
                    <input type="text" id="jamRealtime" class="form-control" readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Jam Ke</label>
                    <select name="jam_ke" class="form-control" required>
                        <option value="">-- Pilih Jam Ke --</option>
                        @for($i = 1; $i <= 9; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Mata Pelajaran</label>
                    <select name="mapel" class="form-control" required>
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach(explode(',', session('mapel', '')) as $m)
                            @if(trim($m))
                                <option value="{{ trim($m) }}">{{ trim($m) }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>Kelas</label>
                    <select name="kelas" class="form-control" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach(['X','XI','XII'] as $k)
                            <option value="{{ $k }}">{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Jurusan</label>
                    <select name="jurusan" class="form-control" required>
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach(['TKJ','MP','TP','TSM','TITL'] as $j)
                            <option value="{{ $j }}">{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Sub Kelas</label>
                    <input type="text" name="subkelas" class="form-control" placeholder="TKJ 1 / TP 2 ..." required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Status Kehadiran</label>
                    <select name="status" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        @foreach(['Hadir','Alpha','Sakit','Izin'] as $s)
                            <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label>Keterangan (Opsional)</label>
                <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Sakit demam / Izin pulang cepat">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">Simpan Presensi</button>
            </div>
        </form>
    </div>
</div>

{{-- Riwayat 7 hari terakhir --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <button class="btn btn-primary mb-3" id="tombolRiwayat">Tampilkan Riwayat 7 Hari Terakhir</button>
        <div id="riwayatPresensi" style="display:none; overflow-x:auto;">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th><th>Jam Masuk</th><th>Jam Ke</th><th>Mata Pelajaran</th>
                        <th>Kelas</th><th>Jurusan</th><th>Sub Kelas</th><th>Status</th><th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat ?? [] as $p)
                        <tr>
                            <td>{{ $p->tanggal }}</td>
                            <td>{{ $p->jam_masuk ?? '-' }}</td>
                            <td>{{ $p->jam_ke }}</td>
                            <td>{{ $p->mapel }}</td>
                            <td>{{ $p->kelas }}</td>
                            <td>{{ $p->jurusan }}</td>
                            <td>{{ $p->subkelas }}</td>
                            <td>{{ $p->status }}</td>
                            <td>{{ $p->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center">Belum ada presensi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('tombolRiwayat').addEventListener('click', function(){
    var r = document.getElementById('riwayatPresensi');
    if(r.style.display==='none'){
        r.style.display='block';
        this.textContent='Sembunyikan Riwayat';
    } else {
        r.style.display='none';
        this.textContent='Tampilkan Riwayat 7 Hari Terakhir';
    }
});
function updateJam() {
    let now = new Date();
    document.getElementById("jamRealtime").value = now.toLocaleTimeString('id-ID', { hour12: false });
}
setInterval(updateJam, 1000);
updateJam();
</script>
@endpush
