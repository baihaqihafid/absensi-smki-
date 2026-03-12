@extends('layouts.app')
@section('content')

@php
    $rekap = ['Hadir'=>0,'Alpha'=>0,'Izin'=>0,'Sakit'=>0,'Terlambat'=>0];
    foreach($data as $p) { if(isset($rekap[$p->status])) $rekap[$p->status]++; }
@endphp

<div class="row text-center mb-4">
    @foreach($rekap as $st => $jumlah)
    <div class="col-md-2 mb-2">
        <div class="card shadow-sm border-primary">
            <div class="card-body">
                <h6 class="text-muted">{{ $st }}</h6>
                <h3>{{ $jumlah }}</h3>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-3">Laporan Presensi Guru</h4>
        <form method="GET" class="row g-3 mb-3 align-items-end">
            <div class="col-md-2">
                <label>Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai', date('Y-m-d')) }}">
            </div>
            <div class="col-md-2">
                <label>Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir', date('Y-m-d')) }}">
            </div>
            <div class="col-md-3">
                <label>Nama Guru</label>
                <select name="guru_id" class="form-select">
                    <option value="">-- Semua Guru --</option>
                    @foreach($guru as $g)
                        <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="">-- Semua --</option>
                    @foreach(['Hadir','Terlambat','Izin','Sakit','Alpa'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 text-end mt-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('laporan.guru') }}" class="btn btn-secondary">Reset</a>
                <a href="{{ route('laporan.guru.export', request()->all()) }}" class="btn btn-success">Cetak Excel</a>
            </div>
        </form>
    </div>
</div>

<div style="overflow-x:auto;">
    <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th><th>Tanggal</th><th>Jam Masuk</th><th>Guru</th><th>Mapel</th>
                <th>Jam Ke</th><th>Kelas</th><th>Sub Kelas</th><th>Jurusan</th><th>Status</th><th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $no => $p)
            <tr>
                <td>{{ $no + 1 }}</td>
                <td>{{ $p->tanggal }}</td>
                <td>{{ $p->jam_masuk ? \Carbon\Carbon::parse($p->jam_masuk)->format('H:i') : '-' }}</td>
                <td>{{ $p->guru->nama_lengkap ?? '-' }}</td>
                <td>{{ $p->mapel }}</td>
                <td>{{ $p->jam_ke }}</td>
                <td>{{ $p->kelas }}</td>
                <td>{{ $p->subkelas }}</td>
                <td>{{ $p->jurusan }}</td>
                <td>{{ $p->status }}</td>
                <td>{{ $p->keterangan ?? '-' }}</td>
            </tr>
            @empty
                <tr><td colspan="11">Tidak ada data presensi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
