@extends('layouts.app')
@section('content')

<h3><i class="fas fa-clipboard-list me-2"></i>Laporan Masalah</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Summary cards --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center border-0" style="background:#fff3cd;">
            <div class="card-body py-3">
                <h4 class="fw-bold text-warning mb-0">{{ $laporan->where('status','Belum Ditangani')->count() }}</h4>
                <small class="text-muted">Belum Ditangani</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center border-0" style="background:#cfe2ff;">
            <div class="card-body py-3">
                <h4 class="fw-bold text-primary mb-0">{{ $laporan->where('status','Sedang Diproses')->count() }}</h4>
                <small class="text-muted">Sedang Diproses</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center border-0" style="background:#d1e7dd;">
            <div class="card-body py-3">
                <h4 class="fw-bold text-success mb-0">{{ $laporan->where('status','Selesai')->count() }}</h4>
                <small class="text-muted">Selesai</small>
            </div>
        </div>
    </div>
</div>

{{-- Tabel laporan --}}
@forelse($laporan as $l)
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <span class="badge bg-secondary me-1">{{ $l->kategori }}</span>
                <span class="badge
                    {{ $l->status == 'Selesai' ? 'bg-success' :
                       ($l->status == 'Sedang Diproses' ? 'bg-warning text-dark' : 'bg-danger') }}">
                    {{ $l->status }}
                </span>
                <p class="fw-bold mt-2 mb-1">{{ $l->judul }}</p>
                <small class="text-muted">
                    Dari: <strong>{{ $l->user->nama_lengkap ?? '-' }}</strong>
                    ({{ ucfirst($l->user->role ?? '-') }})
                    · {{ \Carbon\Carbon::parse($l->created_at)->format('d M Y, H:i') }}
                </small>
                <p class="mt-2 mb-0">{{ $l->deskripsi }}</p>
            </div>
        </div>

        @if($l->balasan)
            <div class="alert alert-info mt-3 mb-2 py-2">
                <small><strong>Balasan kamu:</strong> {{ $l->balasan }}</small>
            </div>
        @endif

        {{-- Form balas --}}
        <form method="POST" action="{{ route('laporan.masalah.balas', $l->id) }}" class="mt-3">
            @csrf
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small mb-1">Update Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="Belum Ditangani" {{ $l->status == 'Belum Ditangani' ? 'selected' : '' }}>Belum Ditangani</option>
                        <option value="Sedang Diproses" {{ $l->status == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="Selesai"         {{ $l->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-7">
                    <label class="form-label small mb-1">Balasan</label>
                    <input type="text" name="balasan" class="form-control form-control-sm"
                           placeholder="Tulis balasan untuk pelapor..."
                           value="{{ $l->balasan }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success btn-sm w-100">
                        <i class="fas fa-reply me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@empty
    <div class="alert alert-info text-center">Belum ada laporan masuk.</div>
@endforelse

@endsection