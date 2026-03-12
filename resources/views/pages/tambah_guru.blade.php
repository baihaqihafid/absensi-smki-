@extends('layouts.app')
@section('content')

<h3>Tambah Guru</h3>

<form method="POST" action="{{ route('guru.store') }}" class="mt-3" style="max-width:500px;">
    @csrf
    <div class="mb-3">
        <label class="form-label">NIP</label>
        <input type="text" name="nip" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Mata Pelajaran (pisahkan dengan koma)</label>
        <input type="text" name="mapel" class="form-control" placeholder="Matematika,Fisika">
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('guru.index') }}" class="btn btn-secondary ms-2">Batal</a>
</form>

@endsection
