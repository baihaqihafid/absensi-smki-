@extends('layouts.app')
@section('content')

<h3>Kelola Siswa</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(request('pesan') == 'update_sukses')
    <div class="alert alert-success">Data siswa berhasil diperbarui!</div>
@endif

{{-- Filter --}}
<form method="GET" class="row g-3 mb-3 align-items-center">
    <div class="col-md-2">
        <select name="jurusan" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Jurusan</option>
            @foreach(['TKJ','MP','TP','TSM','TITL'] as $j)
                <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="tingkat" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Tingkat</option>
            @foreach(['X','XI','XII'] as $t)
                <option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="subkelas" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Sub Kelas</option>
            @foreach($siswa->pluck('kelas')->unique()->sort() as $sk)
                <option value="{{ $sk }}" {{ request('subkelas') == $sk ? 'selected' : '' }}>{{ $sk }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Cari nama siswa..." value="{{ request('search') }}">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-success w-100">Tampilkan</button>
        <a href="{{ route('siswa.index') }}" class="btn btn-secondary w-100 mt-1">Reset</a>
    </div>
</form>

<div class="mb-3 d-flex gap-2 align-items-center">
    <a href="{{ route('siswa.create') }}" class="btn btn-success">Tambah Siswa</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-success">
        <tr>
            <th>No</th><th>Nama</th><th>Username</th><th>Tingkat</th><th>Jurusan</th><th>Sub Kelas</th><th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($siswa as $no => $s)
        <tr>
            <td>{{ $no + 1 }}</td>
            <td>{{ $s->nama_lengkap }}</td>
            <td>{{ $s->username }}</td>
            <td>{{ $s->tingkat }}</td>
            <td>{{ $s->jurusan }}</td>
            <td>{{ $s->kelas }}</td>
            <td>
                <a href="{{ route('siswa.edit', $s->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <a href="{{ route('siswa.hapus', $s->id) }}" class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin ingin menghapus siswa ini?')">Hapus</a>
            </td>
        </tr>
        @empty
            <tr><td colspan="7" class="text-center">Tidak ada data siswa.</td></tr>
        @endforelse
    </tbody>
</table>

@endsection
