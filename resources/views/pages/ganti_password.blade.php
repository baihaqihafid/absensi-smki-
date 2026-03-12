@extends('layouts.app')
@section('content')

<div class="container" style="max-width:450px;">
    <h3>Ganti Password</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('ganti.password') }}" class="mt-3">
        @csrf
        <div class="mb-3">
            <label class="form-label">Password Lama</label>
            <input type="password" name="password_lama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password Baru (minimal 6 karakter)</label>
            <input type="password" name="password_baru" class="form-control" minlength="6" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="konfirmasi" class="form-control" minlength="6" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan Password</button>
    </form>
</div>

@endsection
