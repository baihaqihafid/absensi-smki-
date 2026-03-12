@extends('layouts.app')
@section('content')

<h3>Data Presensi Guru</h3>

@if(session('pesan'))
    <div class="alert alert-success text-center">{{ session('pesan') }}</div>
@endif

<form method="GET" class="row g-3 mb-4">
    <div class="col-md-2">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal', date('Y-m-d')) }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Nama Guru</label>
        <select name="guru_id" class="form-select">
            <option value="">-- Semua Guru --</option>
            @foreach($guru_list ?? [] as $g)
                <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>
                    {{ $g->nama_lengkap }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="">-- Semua --</option>
            @foreach(['Hadir','Terlambat','Alpha','Izin','Sakit'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 align-self-end">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-success text-center">
            <tr>
                <th>No</th><th>Tanggal</th><th>Jam Ke</th><th>Nama Guru</th><th>Mapel</th>
                <th>Kelas</th><th>Jurusan</th><th>Sub Kelas</th><th>Jam Masuk</th><th>Status</th><th>Keterangan</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $no => $p)
            <tr class="text-center">
                <td>{{ $no + 1 }}</td>
                <td>{{ $p->tanggal }}</td>
                <td>{{ $p->jam_ke }}</td>
                <td class="text-start">{{ $p->guru->nama_lengkap ?? '-' }}</td>
                <td>{{ $p->mapel }}</td>
                <td>{{ $p->kelas }}</td>
                <td>{{ $p->jurusan }}</td>
                <td>{{ $p->subkelas }}</td>
                <td>{{ $p->jam_masuk ? \Carbon\Carbon::parse($p->jam_masuk)->format('H:i') : '-' }}</td>
                <td>{{ $p->status }}</td>
                <td>{{ $p->keterangan ?? '-' }}</td>
                <td>
                    <a href="{{ route('presensi.guru.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('presensi.guru.hapus', $p->id) }}" class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
            @empty
                <tr><td colspan="12" class="text-center">Belum ada data presensi guru sesuai filter.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
