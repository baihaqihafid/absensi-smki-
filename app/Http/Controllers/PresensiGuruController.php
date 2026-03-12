<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresensiGuru;
use App\Models\User;

class PresensiGuruController extends Controller
{
    // Halaman form presensi guru — dari pages/presensi_guru.php
    public function index(Request $request)
    {
        $guru_id = $request->session()->get('user_id');

        // Riwayat 7 hari terakhir
        $tanggal_7_hari = date('Y-m-d', strtotime('-7 days'));
        $riwayat = PresensiGuru::where('guru_id', $guru_id)
            ->where('tanggal', '>=', $tanggal_7_hari)
            ->orderByDesc('tanggal')
            ->orderBy('jam_ke')
            ->get();

        return view('pages.presensi_guru', compact('riwayat'));
    }

    // Proses simpan presensi guru — dari proses/proses_simpan_presensi.php
    public function simpan(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $guru_id    = $request->session()->get('user_id');
        $jam_ke     = $request->input('jam_ke', '');
        $mapel      = $request->input('mapel', '');
        $kelas      = $request->input('kelas', '');
        $jurusan    = $request->input('jurusan', '');
        $subkelas   = $request->input('subkelas', '');
        $keterangan = $request->input('keterangan', '');
        $tanggal    = date('Y-m-d');

        // Validasi semua field wajib
        if (!$jam_ke || !$mapel || !$kelas || !$jurusan || !$subkelas) {
            return redirect()->route('presensi.guru')
                ->with('flash', ['type' => 'danger', 'msg' => 'Lengkapi semua field']);
        }

        // Cek duplikat presensi (per guru+tanggal+jam_ke+mapel)
        $cek = PresensiGuru::where('guru_id', $guru_id)
            ->where('tanggal', $tanggal)
            ->where('jam_ke', $jam_ke)
            ->where('mapel', $mapel)
            ->exists();

        if ($cek) {
            return redirect()->route('presensi.guru')
                ->with('flash', [
                    'type' => 'danger',
                    'msg'  => "Presensi jam ke $jam_ke untuk mapel $mapel sudah tercatat!"
                ]);
        }

        $jam_masuk_server = date('H:i');
        $hari = (int) date('N'); // 1=Senin ... 7=Minggu

        // Jadwal Senin-Kamis
        $jadwal_senin_kamis = [
            1 => '06:45', 2 => '07:30', 3 => '08:10', 4 => '08:50',
            5 => '10:10', 6 => '10:50', 7 => '12:10', 8 => '12:50', 9 => '13:30',
        ];

        // Jadwal Jumat
        $jadwal_jumat = [
            1 => '06:45', 2 => '07:30', 3 => '08:00', 4 => '08:30',
            5 => '09:00', 6 => '10:00', 7 => '10:30',
        ];

        $jadwal = ($hari == 5) ? $jadwal_jumat : $jadwal_senin_kamis;

        // Tentukan status otomatis (toleransi 10 menit)
        if (isset($jadwal[(int) $jam_ke])) {
            $batas_timestamp = strtotime($jadwal[(int) $jam_ke] . ' +10 minutes');
            $masuk_timestamp = strtotime($jam_masuk_server);
            $status = ($masuk_timestamp > $batas_timestamp) ? 'Terlambat' : 'Hadir';
        } else {
            return redirect()->route('presensi.guru')
                ->with('flash', ['type' => 'danger', 'msg' => "Jam ke $jam_ke tidak valid hari ini!"]);
        }

        $result = PresensiGuru::create([
            'guru_id'    => $guru_id,
            'tanggal'    => $tanggal,
            'jam_ke'     => $jam_ke,
            'mapel'      => $mapel,
            'kelas'      => $kelas,
            'jurusan'    => $jurusan,
            'subkelas'   => $subkelas,
            'status'     => $status,
            'keterangan' => $keterangan,
            'jam_masuk'  => date('H:i:s'),
        ]);

        $flash = $result
            ? ['type' => 'success', 'msg' => "Presensi jam ke $jam_ke untuk mapel $mapel berhasil disimpan. Status: $status"]
            : ['type' => 'danger',  'msg' => 'Gagal menyimpan presensi.'];

        return redirect()->route('presensi.guru')->with('flash', $flash);
    }

    // Halaman data presensi guru — dari pages/data_presensi_guru.php
    public function dataPresensiGuru(Request $request)
    {
        $query = PresensiGuru::with('guru');

        if ($request->filled('tanggal')) $query->where('tanggal', $request->tanggal);
        if ($request->filled('guru_id') && $request->guru_id > 0) $query->where('guru_id', $request->guru_id);
        if ($request->filled('kelas'))   $query->where('kelas', $request->kelas);
        if ($request->filled('jurusan')) $query->where('jurusan', $request->jurusan);
        if ($request->filled('subkelas')) $query->where('subkelas', $request->subkelas);
        if ($request->filled('status'))  $query->where('status', $request->status);

        $data      = $query->orderByDesc('tanggal')->orderBy('jam_ke')->get();
        $guru_list = User::where('role', 'guru')->orderBy('nama_lengkap')->get();

        return view('pages.data_presensi_guru', compact('data', 'guru_list'));
    }

    // Halaman edit presensi guru — dari pages/edit_presensi_guru.php
    public function edit($id)
    {
        $presensi = PresensiGuru::with('guru')->findOrFail($id);
        return view('pages.edit_presensi_guru', compact('presensi'));
    }

    // Proses update presensi guru — dari pages/edit_presensi_guru.php (POST)
    public function update(Request $request, $id)
    {
        PresensiGuru::findOrFail($id)->update([
            'tanggal'    => $request->input('tanggal'),
            'jam_ke'     => $request->input('jam_ke'),
            'mapel'      => $request->input('mapel'),
            'kelas'      => $request->input('kelas'),
            'jurusan'    => $request->input('jurusan'),
            'subkelas'   => $request->input('subkelas'),
            'jam_masuk'  => $request->input('jam_masuk') ?: null,
            'status'     => $request->input('status'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('presensi.data_guru')->with('pesan', 'Presensi guru berhasil diperbarui.');
    }

    // Hapus presensi guru — dari proses/hapus_presensi_guru.php
    public function hapus($id)
    {
        PresensiGuru::findOrFail($id)->delete();
        return redirect()->route('presensi.data_guru')->with('pesan', 'Presensi guru berhasil dihapus.');
    }
}
