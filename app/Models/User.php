<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    public $timestamps = false; // tabel tidak punya created_at/updated_at

    protected $fillable = [
        'nip',
        'username',
        'password',
        'nama_lengkap',
        'tingkat',
        'role',
        'jurusan',
        'kelas',
        'id_kelas',
        'mapel',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'user_id');
    }

    public function presensiGuru()
    {
        return $this->hasMany(PresensiGuru::class, 'guru_id');
    }

    public function kelasRelasi()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}