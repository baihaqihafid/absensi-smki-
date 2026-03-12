# PANDUAN SETUP LARAVEL — ABSEN SMKI
# =====================================

## LANGKAH 1 — Buat Project Laravel
```
composer create-project laravel/laravel absen_smki_laravel
cd absen_smki_laravel
```

## LANGKAH 2 — Hapus file bawaan Laravel yang bentrok
```
rm database/migrations/0001_01_01_000000_create_users_table.php
rm database/migrations/0001_01_01_000001_create_cache_table.php
rm database/migrations/0001_01_01_000002_create_jobs_table.php
```

## LANGKAH 3 — Setting .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absen_smki_laravel
DB_USERNAME=root
DB_PASSWORD=
```

## LANGKAH 4 — Buat file via Artisan
```
php artisan make:model User
php artisan make:model Presensi
php artisan make:model PresensiGuru
php artisan make:model Jurusan
php artisan make:model Kelas

php artisan make:controller AuthController
php artisan make:controller PresensiController
php artisan make:controller PresensiGuruController
php artisan make:controller PresensiKioskController
php artisan make:controller SiswaController
php artisan make:controller GuruController
php artisan make:controller PenggunaController
php artisan make:controller LaporanController

php artisan make:middleware RoleMiddleware
```

## LANGKAH 5 — Copy isi file dari zip ini
- models/User.php           → app/Models/User.php
- models/Presensi.php       → app/Models/Presensi.php
- models/PresensiGuru.php   → app/Models/PresensiGuru.php
- models/Jurusan.php        → app/Models/Jurusan.php
- models/Kelas.php          → app/Models/Kelas.php

- controllers/*.php         → app/Http/Controllers/
- middleware/RoleMiddleware.php → app/Http/Middleware/RoleMiddleware.php

- migrations/*.php          → database/migrations/
- routes/web.php            → routes/web.php (GANTI SEMUA isinya)

## LANGKAH 6 — Daftarkan Middleware di bootstrap/app.php
Buka file bootstrap/app.php, cari bagian ->withMiddleware dan tambahkan:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

## LANGKAH 7 — Install PhpSpreadsheet
```
composer require phpoffice/phpspreadsheet
```

## LANGKAH 8 — Buat database baru di phpMyAdmin
- Nama database: absen_smki_laravel
- Collation: utf8mb4_general_ci

## LANGKAH 9 — Jalankan Migration
```
php artisan migrate
```

## LANGKAH 10 — Import data lama
```
mysql -u root -p absen_smki_laravel < absen_smki.sql
```
Atau lewat phpMyAdmin: Import → pilih file absen_smki.sql

## LANGKAH 11 — Jalankan server
```
php artisan serve
```
Buka: http://localhost:8000

## LOGIN AKUN BAWAAN (dari data SQL lama)
- Admin   : username=admin01  | password=admin123
- Guru    : username=12345    | password=(sesuai data)
- Siswa   : username=siswa02  | password=123456 (default)
- Kiosk   : username=kiosk_tab
