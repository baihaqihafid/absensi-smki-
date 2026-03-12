<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\PresensiGuruController;
use App\Http\Controllers\PresensiKioskController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanMasalahController;

/*
|--------------------------------------------------------------------------
| AUTH - tidak perlu login
|--------------------------------------------------------------------------
*/
Route::get('/',       [AuthController::class, 'showLogin'])->name('login');
Route::get('/login',  [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout-kiosk', [AuthController::class, 'logoutKiosk'])->name('logout.kiosk');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['role:admin'])->group(function () {

    Route::get('/dashboard/admin', fn() => view('pages.dashboard_admin'))->name('dashboard.admin');

    // Kelola Siswa
    Route::get('/siswa',                [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/tambah',         [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa/tambah',        [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id}/edit',      [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::post('/siswa/{id}/update',   [SiswaController::class, 'update'])->name('siswa.update');
    Route::get('/siswa/{id}/hapus',     [SiswaController::class, 'hapus'])->name('siswa.hapus');

    // Kelola Guru
    Route::get('/guru',                 [GuruController::class, 'index'])->name('guru.index');
    Route::get('/guru/tambah',          [GuruController::class, 'create'])->name('guru.create');
    Route::post('/guru/tambah',         [GuruController::class, 'store'])->name('guru.store');
    Route::get('/guru/{id}/edit',       [GuruController::class, 'edit'])->name('guru.edit');
    Route::post('/guru/{id}/update',    [GuruController::class, 'update'])->name('guru.update');
    Route::get('/guru/{id}/hapus',      [GuruController::class, 'hapus'])->name('guru.hapus');

    // Kelola Pengguna
    Route::get('/pengguna',                  [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/tambah',           [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/pengguna/tambah',          [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/{id}/edit',        [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::post('/pengguna/{id}/update',     [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::get('/pengguna/{id}/hapus',       [PenggunaController::class, 'hapus'])->name('pengguna.hapus');
    Route::post('/pengguna/import',          [PenggunaController::class, 'import'])->name('pengguna.import');

    // Data Presensi Siswa
    Route::get('/data-presensi/siswa',                      [PresensiController::class, 'dataPresensiSiswa'])->name('presensi.data_siswa');
    Route::match(['get','post'], '/data-presensi/siswa/tambah', [PresensiController::class, 'tambahManual'])->name('presensi.tambah_manual');
    Route::get('/data-presensi/siswa/{id}/edit',            [PresensiController::class, 'edit'])->name('presensi.edit');
    Route::post('/data-presensi/siswa/{id}/update',         [PresensiController::class, 'update'])->name('presensi.update');
    Route::get('/data-presensi/siswa/{id}/hapus',           [PresensiController::class, 'hapus'])->name('presensi.hapus');

    // Data Presensi Guru
    Route::get('/data-presensi/guru',                       [PresensiGuruController::class, 'dataPresensiGuru'])->name('presensi.data_guru');
    Route::get('/data-presensi/guru/{id}/edit',             [PresensiGuruController::class, 'edit'])->name('presensi.guru.edit');
    Route::post('/data-presensi/guru/{id}/update',          [PresensiGuruController::class, 'update'])->name('presensi.guru.update');
    Route::get('/data-presensi/guru/{id}/hapus',            [PresensiGuruController::class, 'hapus'])->name('presensi.guru.hapus');

    // Laporan
    Route::get('/laporan/siswa',         [LaporanController::class, 'laporanSiswa'])->name('laporan.siswa');
    Route::get('/laporan/guru',          [LaporanController::class, 'laporanGuru'])->name('laporan.guru');
    Route::get('/laporan/siswa/export',  [LaporanController::class, 'exportExcelSiswa'])->name('laporan.siswa.export');
    Route::get('/laporan/guru/export',   [LaporanController::class, 'exportExcelGuru'])->name('laporan.guru.export');

});

/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/
Route::middleware(['role:siswa'])->group(function () {

    Route::get('/dashboard/siswa', fn() => view('pages.dashboard_siswa'))->name('dashboard.siswa');

    Route::get('/presensi',          [PresensiController::class, 'index'])->name('presensi.index');
    Route::post('/presensi/masuk',   [PresensiController::class, 'absenMasuk'])->name('presensi.masuk');
    Route::post('/presensi/keluar',  [PresensiController::class, 'absenKeluar'])->name('presensi.keluar');

});

/*
|--------------------------------------------------------------------------
| GURU
|--------------------------------------------------------------------------
*/
Route::middleware(['role:guru'])->group(function () {

    Route::get('/dashboard/guru', fn() => view('pages.dashboard_guru'))->name('dashboard.guru');

    Route::get('/presensi-guru',     [PresensiGuruController::class, 'index'])->name('presensi.guru');
    Route::post('/presensi-guru',    [PresensiGuruController::class, 'simpan'])->name('presensi.guru.simpan');
});

/*
|--------------------------------------------------------------------------
| KIOSK
|--------------------------------------------------------------------------
*/
Route::middleware(['role:kiosk'])->group(function () {

    Route::get('/kiosk',        [PresensiKioskController::class, 'index'])->name('kiosk.index');
    Route::post('/kiosk/absen', [PresensiKioskController::class, 'proses'])->name('kiosk.proses');
});

/*
|--------------------------------------------------------------------------
| GANTI PASSWORD — bisa diakses admin, siswa, guru (1 route, 1 nama)
|--------------------------------------------------------------------------
*/
Route::middleware(['role:admin,siswa,guru'])->group(function () {
    Route::get('/ganti-password',  fn() => view('pages.ganti_password'))->name('ganti.password');
    Route::post('/ganti-password', [AuthController::class, 'gantiPassword'])->name('ganti.password.proses');
});

/*
|--------------------------------------------------------------------------
| LAPORAN MASALAH — siswa, guru, admin bisa lapor
|--------------------------------------------------------------------------
*/
Route::middleware(['role:admin,siswa,guru'])->group(function () {
    Route::get('/laporan-masalah',       [LaporanMasalahController::class, 'create'])->name('laporan.masalah');
    Route::post('/laporan-masalah',      [LaporanMasalahController::class, 'store'])->name('laporan.masalah.store');
});
 
// Khusus admin: lihat semua laporan & balas
Route::middleware(['role:admin'])->group(function () {
    Route::get('/laporan-masalah/admin',          [LaporanMasalahController::class, 'adminIndex'])->name('laporan.masalah.admin');
    Route::post('/laporan-masalah/{id}/balas',    [LaporanMasalahController::class, 'adminBalas'])->name('laporan.masalah.balas');
});