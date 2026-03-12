@extends('layouts.app')
@section('content')

<div class="container" style="max-width:600px;">
    <h4>Edit Presensi Siswa</h4>

    <form method="POST" action="{{ route('presensi.update', $presensi->id) }}">
        @csrf
        {{-- Simpan filter supaya redirect balik ke halaman dengan filter --}}
        <input type="hidden" name="jurusan"  value="{{ $filter['jurusan'] ?? '' }}">
        <input type="hidden" name="tingkat"  value="{{ $filter['tingkat'] ?? '' }}">
        <input type="hidden" name="subkelas" value="{{ $filter['subkelas'] ?? '' }}">
        <input type="hidden" name="tanggal"  value="{{ $filter['tanggal'] ?? '' }}">

        <div class="mb-3">
            <label class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" value="{{ $presensi->user->nama_lengkap ?? '-' }}" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Jam Masuk</label>
            <input type="time" name="jam_masuk" class="form-control" value="{{ $presensi->jam_masuk }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Jam Keluar</label>
            <input type="time" name="jam_keluar" class="form-control" value="{{ $presensi->jam_keluar }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                @foreach(['Hadir','Terlambat','Alpha','Izin','Sakit'] as $s)
                    <option value="{{ $s }}" {{ $presensi->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ $presensi->keterangan }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('presensi.data_siswa', $filter ?? []) }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

@endsection
