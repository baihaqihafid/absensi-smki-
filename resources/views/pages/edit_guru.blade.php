@extends('layouts.app')
@section('content')

<h3>Edit Guru</h3>

<form method="POST" action="{{ route('guru.update', $guru->id) }}" class="mt-3" style="max-width:500px;">
    @csrf
    <div class="mb-3">
        <label class="form-label">NIP</label>
        <input type="text" name="nip" class="form-control" value="{{ $guru->nip }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" value="{{ $guru->nama_lengkap }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" value="{{ $guru->username }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Mata Pelajaran</label>
        <input type="text" name="mapel" class="form-control" value="{{ $guru->mapel }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="aktif" {{ $guru->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ $guru->status == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
    <a href="{{ route('guru.index') }}" class="btn btn-secondary ms-2">Batal</a>
</form>

@endsection
