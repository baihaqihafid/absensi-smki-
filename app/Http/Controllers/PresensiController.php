<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\User;

class PresensiController extends Controller
{
    // Halaman presensi siswa — dari pages/presensi.php
    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $tanggal = date('Y-m-d');

        // Ambil presensi hari ini
        $presensi_hari_ini = Presensi::where('user_id', $user_id)
            ->where('tanggal', $tanggal)
            ->first();

        // Ambil riwayat 7 hari terakhir
        $riwayat = Presensi::where('user_id', $user_id)
            ->orderByDesc('tanggal')
            ->limit(7)
            ->get();

        return view('pages.presensi', compact('presensi_hari_ini', 'riwayat'));
    }

    // Proses absen masuk — dari proses/absen_masuk.php
    public function absenMasuk(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user_id     = $request->session()->get('user_id');
        $tanggal     = date('Y-m-d');
        $jam_masuk   = date('H:i:s');
        $status_form = $request->input('status', 'Hadir');
        $keterangan  = $request->input('keterangan') ?: null;

        // Tentukan status otomatis hanya jika status "Hadir"
        if ($status_form === 'Hadir') {
            $batas_jam_masuk = '07:00:00';
            $status = ($jam_masuk > $batas_jam_masuk) ? 'Terlambat' : 'Hadir';
        } else {
            $status = $status_form;
        }

        // Cek apakah sudah absen hari ini
        $cek = Presensi::where('user_id', $user_id)->where('tanggal', $tanggal)->first();
        if ($cek) {
            return redirect()->route('presensi.index')->with('pesan', 'Kamu sudah melakukan presensi hari ini.');
        }

        $result = Presensi::create([
            'user_id'    => $user_id,
            'tanggal'    => $tanggal,
            'jam_masuk'  => $jam_masuk,
            'status'     => $status,
            'keterangan' => $keterangan,
        ]);

        $pesan = $result
            ? '✅ Terima kasih sudah presensi masuk hari ini.'
            : '❌ Presensi gagal.';

        return redirect()->route('presensi.index')->with('pesan', $pesan);
    }

    // Proses absen keluar — dari proses/absen_keluar.php
    public function absenKeluar(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user_id    = $request->session()->get('user_id');
        $tanggal    = date('Y-m-d');
        $jam_keluar = date('H:i:s');

        $cek = Presensi::where('user_id', $user_id)
            ->where('tanggal', $tanggal)
            ->whereNotNull('jam_masuk')
            ->first();

        if (!$cek) {
            return redirect()->route('presensi.index')->with('pesan', 'Anda belum melakukan presensi masuk hari ini.');
        }

        if ($cek->jam_keluar !== null) {
            return redirect()->route('presensi.index')->with('pesan', 'Anda sudah melakukan presensi keluar hari ini.');
        }

        $update = $cek->update(['jam_keluar' => $jam_keluar]);

        $pesan = $update
            ? '✅ Terima kasih sudah presensi keluar hari ini.'
            : '❌ Presensi keluar gagal.';

        return redirect()->route('presensi.index')->with('pesan', $pesan);
    }

    // Halaman data presensi siswa — dari pages/data_presensi_siswa.php
    public function dataPresensiSiswa(Request $request)
    {
        $query = Presensi::with('user');

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        } else {
            $query->where('tanggal', date('Y-m-d'));
        }
        if ($request->filled('jurusan')) {
            $query->whereHas('user', fn($q) => $q->where('jurusan', $request->jurusan));
        }
        if ($request->filled('tingkat')) {
            $query->whereHas('user', fn($q) => $q->where('tingkat', $request->tingkat));
        }
        if ($request->filled('subkelas')) {
            $query->whereHas('user', fn($q) => $q->where('kelas', $request->subkelas));
        }

        $data = $query->orderByDesc('jam_masuk')->get();

        return view('pages.data_presensi_siswa', compact('data'));
    }

    // Halaman tambah manual presensi — dari pages/tambah_manual_presensi.php
    public function tambahManual(Request $request)
    {
        if ($request->isMethod('get')) {
            // Ambil semua siswa untuk autocomplete
            $siswa_list = User::where('role', 'siswa')
                ->orderBy('nama_lengkap')
                ->get(['id', 'nama_lengkap', 'tingkat', 'jurusan', 'kelas']);

            return view('pages.tambah_manual_presensi', compact('siswa_list'));
        }

        // POST — logika dari pages/tambah_manual_presensi.php
        $user_id = $request->input('user_id');
        $tanggal = date('Y-m-d');
        $status  = 'Alpha';

        // Cek apakah siswa sudah ada presensi hari ini
        $cek = Presensi::where('user_id', $user_id)->where('tanggal', $tanggal)->first();
        if ($cek) {
            return redirect()->route('presensi.data_siswa')->with('pesan', 'Siswa sudah tercatat hari ini.');
        }

        Presensi::create([
            'user_id'    => $user_id,
            'tanggal'    => $tanggal,
            'jam_masuk'  => null,
            'jam_keluar' => null,
            'status'     => $status,
        ]);

        return redirect()->route('presensi.data_siswa')->with('pesan', 'Siswa berhasil ditambahkan sebagai tidak hadir.');
    }

    // Halaman edit presensi siswa — dari pages/edit_presensi.php
    public function edit(Request $request, $id)
    {
        $presensi = Presensi::with('user')->findOrFail($id);

        // Simpan filter untuk redirect balik
        $filter = $request->only(['jurusan', 'tingkat', 'subkelas', 'tanggal']);

        return view('pages.edit_presensi', compact('presensi', 'filter'));
    }

    // Proses update presensi siswa — dari pages/edit_presensi.php (POST)
    public function update(Request $request, $id)
    {
        $presensi = Presensi::findOrFail($id);
        $presensi->update([
            'jam_masuk'  => $request->input('jam_masuk') ?: null,
            'jam_keluar' => $request->input('jam_keluar') ?: null,
            'status'     => $request->input('status'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('presensi.data_siswa', $request->only(['jurusan', 'tingkat', 'subkelas', 'tanggal']))
            ->with('pesan', 'Data presensi berhasil diperbarui.');
    }

    // Hapus presensi siswa — dari proses/hapus_presensi_siswa.php
    public function hapus($id)
    {
        Presensi::findOrFail($id)->delete();
        return redirect()->route('presensi.data_siswa')->with('pesan', 'Presensi siswa berhasil dihapus.');
    }
}
