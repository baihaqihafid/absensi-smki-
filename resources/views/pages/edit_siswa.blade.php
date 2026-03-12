@extends('layouts.app')
@section('content')

<h3>Edit Siswa</h3>

<form method="POST" action="{{ route('siswa.update', $siswa->id) }}" class="mt-3" style="max-width:500px;">
    @csrf
    <input type="hidden" name="filter_jurusan" value="{{ request('jurusan') }}">
    <input type="hidden" name="filter_tingkat" value="{{ request('tingkat') }}">
    <input type="hidden" name="filter_subkelas" value="{{ request('subkelas') }}">

    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control" value="{{ $siswa->nama_lengkap }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Tingkat</label>
        <select name="tingkat" class="form-select" required>
            @foreach(['X','XI','XII'] as $t)
                <option value="{{ $t }}" {{ $siswa->tingkat == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Jurusan</label>
        <select name="jurusan" class="form-select" required>
            @foreach(['TKJ','MP','TP','TSM','TITL'] as $j)
                <option value="{{ $j }}" {{ $siswa->jurusan == $j ? 'selected' : '' }}>{{ $j }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Sub Kelas</label>
        <input type="text" name="kelas" class="form-control" value="{{ $siswa->kelas }}" required>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
    <a href="{{ route('siswa.index') }}" class="btn btn-secondary ms-2">Batal</a>
</form>

@endsection
