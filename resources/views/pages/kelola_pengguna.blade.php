@extends('layouts.app')
@section('content')

<div class="container" style="max-width:900px;">
    <h4>Kelola Pengguna</h4>

    @if(session('pesan'))
        <div class="alert alert-info">{{ session('pesan') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('pengguna.create') }}" class="btn btn-success btn-sm">+ Tambah Pengguna</a>
        <form action="{{ route('pengguna.import') }}" method="POST" enctype="multipart/form-data" class="d-flex">
            @csrf
            <input type="file" name="file_excel" accept=".xlsx,.xls" class="form-control form-control-sm me-2" required>
            <button type="submit" class="btn btn-primary btn-sm">Import Excel</button>
        </form>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-success text-center">
            <tr>
                <th>No</th><th>Nama</th><th>Username</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengguna as $no => $p)
            <tr>
                <td class="text-center">{{ $no + 1 }}</td>
                <td>{{ $p->nama_lengkap }}</td>
                <td>{{ $p->username }}</td>
                <td class="text-center">
                    <a href="{{ route('pengguna.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('pengguna.hapus', $p->id) }}" class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus pengguna ini?')">Hapus</a>
                </td>
            </tr>
            @empty
                <tr><td colspan="4" class="text-center">Tidak ada data pengguna</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
