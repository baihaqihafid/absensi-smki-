<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\PresensiGuru;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class LaporanController extends Controller
{
    // Halaman laporan siswa — dari pages/laporan_siswa.php
    public function laporanSiswa(Request $request)
    {
        $tgl1             = $request->input('tgl1', date('Y-m-d'));
        $tgl2             = $request->input('tgl2', date('Y-m-d'));
        $jurusan_filter   = $request->input('jurusan', 'all');
        $tingkat_filter   = $request->input('tingkat', 'all');
        $subkelas_filter  = $request->input('subkelas', 'all');
        $search           = $request->input('search', '');

        $query = Presensi::with('user')
            ->whereBetween('tanggal', [$tgl1, $tgl2]);

        if ($jurusan_filter  !== 'all') $query->whereHas('user', fn($q) => $q->where('jurusan', $jurusan_filter));
        if ($tingkat_filter  !== 'all') $query->whereHas('user', fn($q) => $q->where('tingkat', $tingkat_filter));
        if ($subkelas_filter !== 'all') $query->whereHas('user', fn($q) => $q->where('kelas', $subkelas_filter));
        if ($search)                    $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%$search%"));

        $data = $query->orderByDesc('tanggal')->orderByDesc('jam_masuk')->get();

        return view('pages.laporan_siswa', compact('data'));
    }

    // Halaman laporan guru — dari pages/laporan_guru.php
    public function laporanGuru(Request $request)
    {
        $tanggal_mulai  = $request->input('tanggal_mulai', date('Y-m-d'));
        $tanggal_akhir  = $request->input('tanggal_akhir', date('Y-m-d'));
        $jurusan_filter = $request->input('jurusan', '');
        $tingkat_filter = $request->input('tingkat', '');
        $subkelas_filter = $request->input('subkelas', '');
        $status_filter  = $request->input('status', '');
        $search         = $request->input('search', '');

        $query = PresensiGuru::with('guru')
            ->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir]);

        if ($jurusan_filter)  $query->where('jurusan', $jurusan_filter);
        if ($tingkat_filter)  $query->where('kelas', $tingkat_filter);
        if ($subkelas_filter) $query->where('subkelas', $subkelas_filter);
        if ($status_filter)   $query->where('status', $status_filter);
        if ($search)          $query->whereHas('guru', fn($q) => $q->where('nama_lengkap', 'like', "%$search%"));

        $data = $query->orderByDesc('tanggal')->orderBy('jam_ke')->get();
        $guru = User::where('role', 'guru')->orderBy('nama_lengkap')->get();

        return view('pages.laporan_guru', compact('data', 'guru'));
    }

    // Export Excel laporan siswa — dari pages/laporan_excel_siswa.php
    public function exportExcelSiswa(Request $request)
    {
        $tgl1            = $request->input('tgl1', date('Y-m-01'));
        $tgl2            = $request->input('tgl2', date('Y-m-d'));
        $jurusan_filter  = $request->input('jurusan', 'all');
        $tingkat_filter  = $request->input('tingkat', 'all');
        $subkelas_filter = $request->input('subkelas', 'all');
        $search          = $request->input('search', '');

        $query = Presensi::with('user')->whereBetween('tanggal', [$tgl1, $tgl2]);

        if ($jurusan_filter  !== 'all') $query->whereHas('user', fn($q) => $q->where('jurusan', $jurusan_filter));
        if ($tingkat_filter  !== 'all') $query->whereHas('user', fn($q) => $q->where('tingkat', $tingkat_filter));
        if ($subkelas_filter !== 'all') $query->whereHas('user', fn($q) => $q->where('kelas', $subkelas_filter));
        if ($search)                    $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%$search%"));

        $data = $query->orderByDesc('tanggal')->orderBy(
            User::select('nama_lengkap')->whereColumn('users.id', 'presensi.user_id')
        )->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->fromArray(['No','Nama','Tingkat','Jurusan','Sub Kelas','Tanggal','Status'], null, 'A1');

        // Data
        $row_num = 2;
        $no = 1;
        foreach ($data as $p) {
            $sheet->fromArray([
                $no,
                $p->user->nama_lengkap ?? '-',
                $p->user->tingkat ?? '-',
                $p->user->jurusan ?? '-',
                $p->user->kelas ?? '-',
                $p->tanggal,
                $p->status,
            ], null, "A$row_num");
            $row_num++;
            $no++;
        }

        // AutoFilter & auto width
        $sheet->setAutoFilter($sheet->calculateWorksheetDimension());
        foreach (range('A', 'G') as $col) $sheet->getColumnDimension($col)->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan_presensi_siswa_' . date('Ymd') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // Export Excel laporan guru — dari pages/laporan_excel_guru.php
    public function exportExcelGuru(Request $request)
    {
        $tanggal_mulai  = $request->input('tanggal_mulai', date('Y-m-01'));
        $tanggal_akhir  = $request->input('tanggal_akhir', date('Y-m-d'));
        $jurusan_filter = $request->input('jurusan', '');
        $kelas          = $request->input('kelas', '');
        $subkelas       = $request->input('subkelas', '');
        $search         = $request->input('search', '');

        $query = PresensiGuru::with('guru')->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir]);

        if ($jurusan_filter) $query->where('jurusan', $jurusan_filter);
        if ($kelas)          $query->where('kelas', $kelas);
        if ($subkelas)       $query->where('subkelas', $subkelas);
        if ($search)         $query->whereHas('guru', fn($q) => $q->where('nama_lengkap', 'like', "%$search%"));

        $data = $query->orderByDesc('tanggal')->orderBy('jam_ke')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray(['No','Tanggal','Jam Masuk','Guru','Mapel','Jam Ke','Kelas','Sub Kelas','Jurusan','Status','Keterangan'], null, 'A1');

        $row_num = 2;
        $no = 1;
        foreach ($data as $p) {
            $sheet->fromArray([
                $no,
                $p->tanggal,
                $p->jam_masuk ?? '-',
                $p->guru->nama_lengkap ?? '-',
                $p->mapel ?? '-',
                $p->jam_ke,
                $p->kelas ?? '-',
                $p->subkelas ?? '-',
                $p->jurusan ?? '-',
                $p->status ?? '-',
                $p->keterangan ?? '-',
            ], null, "A$row_num");
            $row_num++;
            $no++;
        }

        $sheet->setAutoFilter($sheet->calculateWorksheetDimension());
        foreach (range('A', 'K') as $col) $sheet->getColumnDimension($col)->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan_presensi_guru_' . date('Ymd') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
