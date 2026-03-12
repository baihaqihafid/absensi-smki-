@extends('layouts.app')
@section('content')

<h3><i class="fas fa-exclamation-circle me-2 text-danger"></i>Laporkan Masalah</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    {{-- Form Laporan --}}
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Form Laporan</h5>
                <form method="POST" action="{{ route('laporan.masalah.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="Bug/Error">🐛 Bug / Error</option>
                            <option value="Tampilan">🎨 Tampilan</option>
                            <option value="Fitur">💡 Saran Fitur</option>
                            <option value="Lainnya">📌 Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul Masalah</label>
                        <input type="text" name="judul" class="form-control"
                               placeholder="Contoh: Tidak bisa presensi keluar" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4"
                                  placeholder="Jelaskan masalah yang kamu alami secara detail..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Riwayat Laporan --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Riwayat Laporan Saya</h5>
                @forelse($riwayat as $r)
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-secondary mb-1">{{ $r->kategori }}</span>
                                <p class="fw-bold mb-1">{{ $r->judul }}</p>
                                <small class="text-muted">{{ $r->deskripsi }}</small>
                            </div>
                            <span class="badge ms-2
                                {{ $r->status == 'Selesai' ? 'bg-success' :
                                   ($r->status == 'Sedang Diproses' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ $r->status }}
                            </span>
                        </div>
                        @if($r->balasan)
                            <div class="alert alert-info mt-2 mb-0 py-2">
                                <small><strong>Balasan Admin:</strong> {{ $r->balasan }}</small>
                            </div>
                        @endif
                        <small class="text-muted d-block mt-1">
                            {{ \Carbon\Carbon::parse($r->created_at)->format('d M Y, H:i') }}
                        </small>
                    </div>
                @empty
                    <p class="text-muted text-center mt-3">Belum ada laporan yang dikirim.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection