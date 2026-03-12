@extends('layouts.app')
@section('content')

<h3>Edit Presensi Guru</h3>

<form method="POST" action="{{ route('presensi.guru.update', $presensi->id) }}" class="mt-3" style="max-width:500px;">
    @csrf
    <div class="mb-3">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="{{ $presensi->tanggal }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Jam Ke</label>
        <select name="jam_ke" class="form-control" required>
            @for($i = 1; $i <= 9; $i++)
                <option value="{{ $i }}" {{ $presensi->jam_ke == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Mapel</label>
        <input type="text" name="mapel" class="form-control" value="{{ $presensi->mapel }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Kelas</label>
        <select name="kelas" class="form-control" required>
            @foreach(['X','XI','XII'] as $k)
                <option value="{{ $k }}" {{ $presensi->kelas == $k ? 'selected' : '' }}>{{ $k }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Jurusan</label>
        <select name="jurusan" class="form-control" required>
            @foreach(['TKJ','MP','TP','TSM','TITL'] as $j)
                <option value="{{ $j }}" {{ $presensi->jurusan == $j ? 'selected' : '' }}>{{ $j }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Sub Kelas</label>
        <input type="text" name="subkelas" class="form-control" value="{{ $presensi->subkelas }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Jam Masuk</label>
        <input type="time" name="jam_masuk" class="form-control" value="{{ $presensi->jam_masuk }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control" required>
            @foreach(['Hadir','Terlambat','Izin','Sakit','Alpa'] as $s)
                <option value="{{ $s }}" {{ $presensi->status == $s ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Keterangan</label>
        <input type="text" name="keterangan" class="form-control" value="{{ $presensi->keterangan }}">
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
    <a href="{{ route('presensi.data_guru') }}" class="btn btn-secondary ms-2">Batal</a>
</form>

@endsection
