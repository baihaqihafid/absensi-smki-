<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PenggunaController extends Controller
{
    // Halaman kelola pengguna — dari pages/kelola_pengguna.php
    public function index()
    {
        $pengguna = User::where('role', 'admin')->orderBy('nama_lengkap')->get();
        return view('pages.kelola_pengguna', compact('pengguna'));
    }

    // Halaman tambah pengguna — dari pages/tambah_pengguna.php
    public function create()
    {
        return view('pages.tambah_pengguna');
    }

    // Proses tambah pengguna — dari proses/tambah_pengguna.php
    public function store(Request $request)
    {
        $username = $request->input('username');

        if (User::where('username', $username)->exists()) {
            return back()->with('error', 'Username sudah digunakan!');
        }

        User::create([
            'nama_lengkap' => $request->input('nama_lengkap'),
            'username'     => $username,
            'password'     => Hash::make($request->input('password')),
            'role'         => 'admin',
        ]);

        return redirect()->route('pengguna.index');
    }

    // Halaman edit pengguna — dari pages/edit_pengguna.php
    public function edit($id)
    {
        $pengguna = User::where('id', $id)->where('role', 'admin')->firstOrFail();
        return view('pages.edit_pengguna', compact('pengguna'));
    }

    // Proses update pengguna — dari proses/edit_pengguna.php
    public function update(Request $request, $id)
    {
        $data = [
            'nama_lengkap' => $request->input('nama_lengkap'),
            'username'     => $request->input('username'),
        ];

        if (!empty($request->input('password'))) {
            $data['password'] = Hash::make($request->input('password'));
        }

        User::where('id', $id)->where('role', 'admin')->update($data);

        return redirect()->route('pengguna.index');
    }

    // Hapus pengguna — dari proses/hapus_pengguna.php
    public function hapus($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('pengguna.index')->with('pesan', 'User berhasil dihapus.');
    }

    // Import excel pengguna — dari proses/import_pengguna.php
    public function import(Request $request)
    {
        if (!$request->hasFile('file_excel') || $request->file('file_excel')->getError() !== 0) {
            return redirect()->route('pengguna.index')->with('pesan', 'File tidak ditemukan atau terjadi error saat upload.');
        }

        $file = $request->file('file_excel')->getRealPath();

        try {
            $spreadsheet = IOFactory::load($file);
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = $sheet->toArray();

            $success = 0;
            $failed  = 0;

            for ($i = 1; $i < count($rows); $i++) {
                $row      = $rows[$i];
                $nama     = trim($row[0] ?? ''); // Kolom A = Nama
                $username = trim($row[1] ?? ''); // Kolom B = Username
                $password = trim($row[2] ?? ''); // Kolom C = Password

                if ($nama && $username && $password) {
                    if (!User::where('username', $username)->exists()) {
                        User::create([
                            'nama_lengkap' => $nama,
                            'username'     => $username,
                            'password'     => Hash::make($password),
                            'role'         => 'admin',
                        ]);
                        $success++;
                    } else {
                        $failed++;
                    }
                } else {
                    $failed++;
                }
            }

            return redirect()->route('pengguna.index')->with('pesan', "Import selesai. Berhasil: $success, Gagal: $failed");
        } catch (\Exception $e) {
            return redirect()->route('pengguna.index')->with('pesan', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
