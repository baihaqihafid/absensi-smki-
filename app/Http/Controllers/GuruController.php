<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class GuruController extends Controller
{
    // Halaman kelola guru — dari pages/kelola_guru.php
    public function index()
    {
        $guru = User::where('role', 'guru')->orderBy('nama_lengkap')->get();
        return view('pages.kelola_guru', compact('guru'));
    }

    // Halaman tambah guru — dari pages/tambah_guru.php
    public function create()
    {
        return view('pages.tambah_guru');
    }

    // Proses tambah guru — dari proses/tambah_guru.php
    public function store(Request $request)
    {
        $username = $request->input('username');

        if (User::where('username', $username)->exists()) {
            return redirect()->route('guru.index')->with('error_msg', 'Username sudah digunakan!');
        }

        User::create([
            'nip'          => $request->input('nip'),
            'nama_lengkap' => $request->input('nama_lengkap'),
            'username'     => $username,
            'password'     => Hash::make($request->input('password')),
            'mapel'        => $request->input('mapel'),
            'role'         => 'guru',
            'status'       => 'aktif',
        ]);

        return redirect()->route('guru.index')->with('success_msg', 'Guru berhasil ditambahkan!');
    }

    // Halaman edit guru — dari pages/edit_guru.php
    public function edit($id)
    {
        $guru = User::where('id', $id)->where('role', 'guru')->firstOrFail();
        return view('pages.edit_guru', compact('guru'));
    }

    // Proses update guru — dari pages/edit_guru.php (POST)
    public function update(Request $request, $id)
    {
        $data = [
            'nip'          => $request->input('nip'),
            'nama_lengkap' => $request->input('nama'),
            'username'     => $request->input('username'),
            'mapel'        => $request->input('mapel'),
            'status'       => $request->input('status'),
        ];

        // Hanya update password kalau diisi
        if (!empty($request->input('password'))) {
            $data['password'] = Hash::make($request->input('password'));
        }

        User::where('id', $id)->update($data);

        return redirect()->route('guru.index')->with('success_msg', 'Data guru berhasil diperbarui!');
    }

    // Hapus guru — dari proses/hapus_guru.php
    public function hapus($id)
    {
        User::where('id', $id)->where('role', 'guru')->delete();
        return redirect()->route('guru.index')->with('success_msg', 'Guru berhasil dihapus.');
    }
}
