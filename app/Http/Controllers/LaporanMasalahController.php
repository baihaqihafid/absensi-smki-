<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanMasalah;

class LaporanMasalahController extends Controller
{
    public function create(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $riwayat = LaporanMasalah::where('user_id', $user_id)
            ->orderByDesc('created_at')->get();
        return view('pages.laporan_masalah', compact('riwayat'));
    }

    public function store(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        LaporanMasalah::create([
            'user_id'   => $user_id,
            'judul'     => $request->input('judul'),
            'deskripsi' => $request->input('deskripsi'),
            'kategori'  => $request->input('kategori', 'Lainnya'),
            'status'    => 'Belum Ditangani',
        ]);
        return redirect()->route('laporan.masalah')->with('success', 'Laporan berhasil dikirim!');
    }

    public function adminIndex()
    {
        $laporan = LaporanMasalah::with('user')->orderByDesc('created_at')->get();
        return view('pages.laporan_masalah_admin', compact('laporan'));
    }

    public function adminBalas(Request $request, $id)
    {
        LaporanMasalah::findOrFail($id)->update([
            'status'  => $request->input('status'),
            'balasan' => $request->input('balasan'),
        ]);
        return redirect()->route('laporan.masalah.admin')->with('success', 'Balasan berhasil disimpan.');
    }
}