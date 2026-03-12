<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SiswaController extends Controller
{
    // Halaman kelola siswa — dari pages/kelola_siswa.php
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        if ($request->filled('jurusan'))  $query->where('jurusan', $request->jurusan);
        if ($request->filled('tingkat'))  $query->where('tingkat', $request->tingkat);
        if ($request->filled('subkelas')) $query->where('kelas', $request->subkelas);
        if ($request->filled('search'))   $query->where('nama_lengkap', 'like', '%' . $request->search . '%');

        $siswa = $query->orderBy('nama_lengkap')->get();

        return view('pages.kelola_siswa', compact('siswa'));
    }

    // Halaman tambah siswa — dari pages/tambah_siswa.php
    public function create()
    {
        return view('pages.tambah_siswa');
    }

    // Proses tambah siswa — dari proses/tambah_siswa.php
    public function store(Request $request)
    {
        $nama_lengkap = trim($request->input('nama_lengkap'));
        $tingkat      = trim($request->input('tingkat'));
        $jurusan      = trim($request->input('jurusan'));
        $kelas        = trim($request->input('kelas'));
        $username     = trim($request->input('username'));

        if (!$nama_lengkap || !$tingkat || !$jurusan || !$kelas || !$username) {
            return back()->with('error', 'Semua field harus diisi');
        }

        if (User::where('username', $username)->exists()) {
            return back()->with('error', 'Username sudah digunakan!');
        }

        User::create([
            'username'     => $username,
            'password'     => Hash::make('123456'), // password default
            'nama_lengkap' => $nama_lengkap,
            'tingkat'      => $tingkat,
            'jurusan'      => $jurusan,
            'kelas'        => $kelas,
            'role'         => 'siswa',
        ]);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan!');
    }

    // Halaman edit siswa — dari pages/edit_siswa.php
    public function edit(Request $request, $id)
    {
        $siswa = User::where('id', $id)->where('role', 'siswa')->firstOrFail();

        $filter_jurusan  = $request->input('jurusan', '');
        $filter_tingkat  = $request->input('tingkat', '');
        $filter_subkelas = $request->input('subkelas', '');

        return view('pages.edit_siswa', compact('siswa', 'filter_jurusan', 'filter_tingkat', 'filter_subkelas'));
    }

    // Proses update siswa — dari proses/edit_siswa.php
    public function update(Request $request, $id)
    {
        User::where('id', $id)->where('role', 'siswa')->update([
            'nama_lengkap' => $request->input('nama_lengkap'),
            'tingkat'      => $request->input('tingkat'),
            'jurusan'      => $request->input('jurusan'),
            'kelas'        => $request->input('kelas'),
        ]);

        // Redirect dengan filter yang sama supaya balik ke halaman dengan filter
        $params = ['pesan' => 'update_sukses'];
        if ($request->input('filter_jurusan'))  $params['jurusan']  = $request->input('filter_jurusan');
        if ($request->input('filter_tingkat'))  $params['tingkat']  = $request->input('filter_tingkat');
        if ($request->input('filter_subkelas')) $params['subkelas'] = $request->input('filter_subkelas');

        return redirect()->route('siswa.index', $params);
    }

    // Hapus siswa — dari pages/hapus_siswa.php
    public function hapus($id)
    {
        User::where('id', $id)->where('role', 'siswa')->delete();
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
