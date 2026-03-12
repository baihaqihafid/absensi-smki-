@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row">
    <h3 class="fw-bold text-dark">Dashboard Siswa</h3>
    <p class="text-muted mb-0">Selamat datang kembali, <span class="fw-bold text-primary-pastel">{{ session('nama_lengkap') }}</span>!</p>
</div>

<div class="alert alert-info rounded-3 mb-4" role="alert">
    <i class="fas fa-info-circle me-2"></i>
    Jangan lupa <strong>presensi tepat waktu</strong> ya!
    Presensi pagi dimulai pukul <strong>07:00 WIB</strong>.
    Kalau terlambat, tetap absen tapi usahakan jangan sering-sering ya 😉.
</div>

<hr class="my-4">

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4 d-flex align-items-center">
                <i class="fas fa-calendar-alt fa-3x text-primary-pastel me-3"></i>
                <div>
                    <p class="mb-0 text-muted">Hari dan Tanggal</p>
                    <p class="fw-bold mb-0 text-dark">
                        {{ ['Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu','Sunday'=>'Minggu'][date('l')] }},
                        {{ date('j') }} {{ ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][(int)date('n')] }} {{ date('Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('ganti.password') }}" class="btn btn-outline-primary mb-4">Ganti Password</a>

@endsection
