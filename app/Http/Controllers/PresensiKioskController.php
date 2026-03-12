<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\User;

class PresensiKioskController extends Controller
{
    // Halaman kiosk — dari pages/dashboard_kiosk.php
    public function index(Request $request)
    {
        return view('pages.dashboard_kiosk');
    }

    // Proses absen kiosk — dari proses/proses_presensi_kiosk.php
    public function proses(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $username  = $request->input('username');
        $tanggal   = date('Y-m-d');
        $jam_masuk = date('H:i:s');

        $siswa = User::where('username', $username)->where('role', 'siswa')->first();

        if (!$siswa) {
            return redirect()->route('kiosk.index')->with('pesan', '❌ Siswa tidak ditemukan!');
        }

        $cek = Presensi::where('user_id', $siswa->id)->where('tanggal', $tanggal)->first();
        if ($cek) {
            return redirect()->route('kiosk.index')->with('pesan', "⚠️ {$siswa->nama_lengkap} sudah absen hari ini.");
        }

        $batas  = '07:00:00';
        $status = ($jam_masuk > $batas) ? 'Terlambat' : 'Hadir';

        Presensi::create([
            'user_id'   => $siswa->id,
            'tanggal'   => $tanggal,
            'jam_masuk' => $jam_masuk,
            'status'    => $status,
        ]);

        return redirect()->route('kiosk.index')
            ->with('pesan', "✅ {$siswa->nama_lengkap} berhasil absen dengan status: $status");
    }
}
