# STRUKTUR FOLDER LARAVEL — ABSEN SMKI
# ======================================
# Ini struktur folder Laravel yang benar.
# Copy setiap file ke folder yang sesuai di project Laravel kamu.

absen_smki_laravel/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          ← login, logout, ganti password
│   │   │   ├── PresensiController.php       ← absen masuk/keluar siswa
│   │   │   ├── PresensiGuruController.php   ← presensi guru
│   │   │   ├── PresensiKioskController.php  ← kiosk
│   │   │   ├── SiswaController.php          ← kelola siswa
│   │   │   ├── GuruController.php           ← kelola guru
│   │   │   ├── PenggunaController.php       ← kelola pengguna/admin
│   │   │   └── LaporanController.php        ← laporan + export excel
│   │   │
│   │   └── Middleware/
│   │       └── RoleMiddleware.php           ← cek role per route
│   │
│   └── Models/
│       ├── User.php
│       ├── Presensi.php
│       ├── PresensiGuru.php
│       ├── Jurusan.php
│       └── Kelas.php
│
├── database/
│   └── migrations/
│       ├── 2024_01_01_000001_create_jurusan_table.php
│       ├── 2024_01_01_000002_create_kelas_table.php
│       ├── 2024_01_01_000003_create_users_table.php
│       ├── 2024_01_01_000004_create_presensi_table.php
│       └── 2024_01_01_000005_create_presensi_guru_table.php
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php               ← layout utama (navbar+sidebar+footer)
│       │   ├── sidebar_admin.blade.php
│       │   ├── sidebar_siswa.blade.php
│       │   ├── sidebar_guru.blade.php
│       │   └── sidebar_kiosk.blade.php
│       │
│       └── pages/
│           ├── login.blade.php
│           ├── dashboard_admin.blade.php
│           ├── dashboard_siswa.blade.php
│           ├── dashboard_guru.blade.php
│           ├── dashboard_kiosk.blade.php
│           ├── presensi.blade.php
│           ├── presensi_guru.blade.php
│           ├── kelola_siswa.blade.php
│           ├── tambah_siswa.blade.php
│           ├── edit_siswa.blade.php
│           ├── kelola_guru.blade.php
│           ├── tambah_guru.blade.php
│           ├── edit_guru.blade.php
│           ├── kelola_pengguna.blade.php
│           ├── tambah_pengguna.blade.php
│           ├── edit_pengguna.blade.php
│           ├── data_presensi_siswa.blade.php
│           ├── tambah_manual_presensi.blade.php
│           ├── edit_presensi.blade.php
│           ├── data_presensi_guru.blade.php
│           ├── edit_presensi_guru.blade.php
│           ├── laporan_siswa.blade.php
│           ├── laporan_guru.blade.php
│           └── ganti_password.blade.php
│
├── routes/
│   └── web.php                             ← semua route
│
└── bootstrap/
    └── app.php                             ← daftarkan RoleMiddleware di sini

# ======================================
# TIDAK ADA folder proses/ atau layout/
# Di Laravel semua logika ada di Controllers
# Semua tampilan ada di resources/views
# ======================================
