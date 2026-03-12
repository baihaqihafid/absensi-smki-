@extends('layouts.app')
@section('content')

<div class="container" style="max-width:600px;">
    <h4>Tambah Manual Presensi (Siswa Tidak Hadir)</h4>

    <form method="POST" action="{{ route('presensi.tambah_manual') }}">
        @csrf
        <div class="mb-3">
            <label for="siswa" class="form-label">Nama Siswa</label>
            <input type="text" id="siswa" class="form-control"
                   placeholder="Ketik nama siswa yang tidak masuk..." required>
            <input type="hidden" name="user_id" id="user_id">
        </div>

        <input type="hidden" name="status" value="Alpha">
        <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('presensi.data_siswa') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function() {
    var siswaData = @json($siswa_list->map(fn($s) => [
        'id'    => $s->id,
        'value' => $s->nama_lengkap,
        'label' => $s->nama_lengkap . ' - ' . $s->tingkat . ' ' . $s->jurusan . ' ' . $s->kelas,
    ]));

    $("#siswa").autocomplete({
        source: siswaData,
        minLength: 1,
        select: function(event, ui) {
            $("#siswa").val(ui.item.label);
            $("#user_id").val(ui.item.id);
            return false;
        }
    });
});
</script>
@endpush
