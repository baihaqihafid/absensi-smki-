<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('pages.login');
    }

    // Proses login — logika dari proses/login.php
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            $request->session()->put('user_id',      $user->id);
            $request->session()->put('username',     $user->username);
            $request->session()->put('nama_lengkap', $user->nama_lengkap);
            $request->session()->put('role',         $user->role);
            $request->session()->put('mapel',        $user->mapel); // untuk guru

            switch ($user->role) {
                case 'admin': return redirect()->route('dashboard.admin');
                case 'siswa': return redirect()->route('dashboard.siswa');
                case 'guru':  return redirect()->route('dashboard.guru');
                case 'kiosk': return redirect()->route('kiosk.index');
            }
        }

        return back()->with('error', 'Login gagal! Pastikan username dan password sesuai');
    }

    // Logout — logika dari proses/logout.php
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }

    // Logout kiosk — logika dari proses/logout_kiosk.php
    public function logoutKiosk(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }

    // Ganti password — logika dari proses/ganti_password.php
    public function gantiPassword(Request $request)
    {
        $user_id       = $request->session()->get('user_id');
        $password_lama = $request->input('password_lama');
        $password_baru = $request->input('password_baru');
        $konfirmasi    = $request->input('konfirmasi');

        $user = User::find($user_id);

        if (!$user || !Hash::check($password_lama, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai!');
        }

        if (strlen($password_baru) < 6) {
            return back()->with('error', 'Password baru minimal 6 karakter!');
        }

        if ($password_baru !== $konfirmasi) {
            return back()->with('error', 'Password baru dan konfirmasi tidak sama!');
        }

        $user->password = Hash::make($password_baru);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }
}
