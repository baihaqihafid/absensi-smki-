@extends('layouts.app')
@section('content')

<h3>Tambah Siswa</h3>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('siswa.store') }}" class="mt-3" style="max-width:500px;">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Tingkat</label>
        <select name="tingkat" class="form-select" required>
            <option value="">-- Pilih Tingkat --</option>
            @foreach(['X','XI','XII'] as $t)
                <option value="{{ $t }}">{{ $t }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Jurusan</label>
        <select name="jurusan" class="form-select" required>
            <option value="">-- Pilih Jurusan --</option>
            @foreach(['TKJ','MP','TP','TSM','TITL'] as $j)
                <option value="{{ $j }}">{{ $j }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Sub Kelas</label>
        <input type="text" name="kelas" class="form-control" placeholder="Contoh: TKJ 1" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <p class="text-muted small">Password default: <strong>123456</strong></p>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('siswa.index') }}" class="btn btn-secondary ms-2">Batal</a>
</form>

@endsection
