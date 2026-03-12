@extends('layouts.app')
@section('content')

<h3>Laporan Presensi Siswa</h3>

<ul class="nav nav-tabs" id="laporanTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#harian" type="button">Detail Harian</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#rekap" type="button">Rekap Per Siswa</button>
    </li>
</ul>

<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="harian">

        {{-- Summary Cards --}}
        @php
            $rekap = [
                'Hadir'  => $data->where('status', 'Hadir')->count() + $data->where('status', 'hadir')->count(),
                'Izin'   => $data->where('status', 'Izin')->count() + $data->where('status', 'izin')->count(),
                'Sakit'  => $data->where('status', 'Sakit')->count() + $data->where('status', 'sakit')->count(),
                'Alpha'  => $data->where('status', 'Alpha')->count() + $data->where('status', 'alpha')->count(),
            ];
        @endphp
        <div class="row text-center mb-4">
            @foreach($rekap as $status => $jumlah)
            <div class="col-md-3">
                <div class="card shadow-sm p-3">
                    <h6 class="{{ ['Hadir'=>'text-success','Izin'=>'text-warning','Sakit'=>'text-info','Alpha'=>'text-danger'][$status] }} mb-1">{{ $status }}</h6>
                    <h3>{{ $jumlah }}</h3>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Filter --}}
        <form method="GET" class="row g-3 mb-3">
            <div class="col-md-2">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tgl1" class="form-control" value="{{ request('tgl1', date('Y-m-d')) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="tgl2" class="form-control" value="{{ request('tgl2', date('Y-m-d')) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Jurusan</label>
                <select name="jurusan" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Jurusan</option>
                    @foreach(['TKJ','MP','TP','TSM','TITL'] as $j)
                        <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tingkat</label>
                <select name="tingkat" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Tingkat</option>
                    @foreach(['X','XI','XII'] as $t)
                        <option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <div class="d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-success">Filter</button>
                    <a href="{{ route('laporan.siswa') }}" class="btn btn-secondary">Reset</a>
                    <a href="{{ route('laporan.siswa.export', request()->all()) }}" class="btn btn-primary">Cetak Excel</a>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-striped mt-3">
            <thead class="table-success">
                <tr><th>No</th><th>Nama</th><th>Tingkat</th><th>Jurusan</th><th>Sub Kelas</th><th>Tanggal</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse($data as $no => $d)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td>{{ $d->user->nama_lengkap ?? '-' }}</td>
                        <td>{{ $d->user->tingkat ?? '-' }}</td>
                        <td>{{ $d->user->jurusan ?? '-' }}</td>
                        <td>{{ $d->user->kelas ?? '-' }}</td>
                        <td>{{ $d->tanggal }}</td>
                        <td>{{ $d->status }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Data tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- TAB REKAP --}}
    <div class="tab-pane fade" id="rekap">
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-light">
                <tr><th>Nama</th><th>Tingkat</th><th>Jurusan</th><th>Kelas</th><th>Hadir</th><th>Izin</th><th>Sakit</th><th>Alpha</th></tr>
            </thead>
            <tbody>
                @php
                    $grouped = $data->groupBy(fn($p) => $p->user_id);
                @endphp
                @forelse($grouped as $uid => $records)
                @php $user = $records->first()->user @endphp
                <tr>
                    <td>{{ $user->nama_lengkap ?? '-' }}</td>
                    <td>{{ $user->tingkat ?? '-' }}</td>
                    <td>{{ $user->jurusan ?? '-' }}</td>
                    <td>{{ $user->kelas ?? '-' }}</td>
                    <td>{{ $records->whereIn('status', ['Hadir','hadir'])->count() }}</td>
                    <td>{{ $records->whereIn('status', ['Izin','izin'])->count() }}</td>
                    <td>{{ $records->whereIn('status', ['Sakit','sakit'])->count() }}</td>
                    <td>{{ $records->whereIn('status', ['Alpha','alpha'])->count() }}</td>
                </tr>
                @empty
                    <tr><td colspan="8" class="text-center">Data rekap tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
