@extends('layouts.app')
@section('content')

<h3>Edit Pengguna</h3>

<form method="POST" action="{{ route('pengguna.update', $pengguna->id) }}" class="mt-3" style="max-width:400px;">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control" value="{{ $pengguna->nama_lengkap }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" value="{{ $pengguna->username }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="form-control">
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
    <a href="{{ route('pengguna.index') }}" class="btn btn-secondary ms-2">Batal</a>
</form>

@endsection
