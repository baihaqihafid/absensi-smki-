@extends('layouts.app')
@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Data Guru</h4>
            <a href="{{ route('guru.create') }}" class="btn btn-success">+ Tambah Guru</a>
        </div>

        @if(session('success_msg'))
            <div class="alert alert-success">{{ session('success_msg') }}</div>
        @endif
        @if(session('error_msg'))
            <div class="alert alert-danger">{{ session('error_msg') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center border">
                <thead class="table-success">
                    <tr>
                        <th>No</th><th>NIP</th><th>Nama</th><th>Username</th><th>Mapel</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guru as $no => $g)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td>{{ $g->nip ?? '-' }}</td>
                        <td class="text-start">{{ $g->nama_lengkap }}</td>
                        <td>{{ $g->username }}</td>
                        <td>{{ $g->mapel }}</td>
                        <td>{{ $g->status }}</td>
                        <td>
                            <a href="{{ route('guru.edit', $g->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                            <a href="{{ route('guru.hapus', $g->id) }}" class="btn btn-sm btn-danger"
                               onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="7">Belum ada data guru</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
