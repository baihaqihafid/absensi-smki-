@extends('layouts.app')
@section('content')

<h4 class="mb-3">Data Presensi Siswa</h4>

@if(session('pesan'))
    <div id="alertPesan" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('pesan') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<a href="{{ route('presensi.tambah_manual') }}" class="btn btn-danger mb-3">Tambah Siswa Tidak Hadir</a>

{{-- Filter --}}
<form method="GET" class="row g-3 mb-3 align-items-center">
    <div class="col-auto">
        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal', date('Y-m-d')) }}" onchange="this.form.submit()">
    </div>
    <div class="col-auto">
        <select name="jurusan" class="form-select" onchange="this.form.submit()">
            <option value="">-- Semua Jurusan --</option>
            @foreach(['TKJ','MP','TP','TSM','TITL'] as $j)
                <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
        <select name="tingkat" class="form-select" onchange="this.form.submit()">
            <option value="">-- Semua Tingkat --</option>
            @foreach(['X','XI','XII'] as $t)
                <option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-success text-center">
            <tr>
                <th>No</th><th>Nama</th><th>Tingkat</th><th>Jurusan</th><th>Kelas</th>
                <th>Tanggal</th><th>Jam Masuk</th><th>Jam Keluar</th><th>Status</th><th>Keterangan</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $no => $p)
            <tr>
                <td class="text-center">{{ $no + 1 }}</td>
                <td>{{ $p->user->nama_lengkap ?? '-' }}</td>
                <td class="text-center">{{ $p->user->tingkat ?? '-' }}</td>
                <td class="text-center">{{ $p->user->jurusan ?? '-' }}</td>
                <td class="text-center">{{ $p->user->kelas ?? '-' }}</td>
                <td class="text-center">{{ $p->tanggal }}</td>
                <td class="text-center">{{ $p->jam_masuk ?? '-' }}</td>
                <td class="text-center">{{ $p->jam_keluar ?? '-' }}</td>
                <td class="text-center">{{ $p->status }}</td>
                <td>{{ $p->keterangan ?? '-' }}</td>
                <td class="text-center">
                    <a href="{{ route('presensi.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('presensi.hapus', $p->id) }}" class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus presensi ini?')">Hapus</a>
                </td>
            </tr>
            @empty
                <tr><td colspan="11" class="text-center">Tidak ada data presensi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script>
setTimeout(function(){
    let alertBox = document.getElementById('alertPesan');
    if(alertBox) alertBox.remove();
}, 3000);
</script>
@endpush
