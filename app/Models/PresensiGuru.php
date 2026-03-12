<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresensiGuru extends Model
{
    protected $table = 'presensi_guru';

    public $timestamps = false; // tabel tidak punya created_at/updated_at

    protected $fillable = [
        'guru_id',
        'tanggal',
        'jam_ke',
        'mapel',
        'kelas',
        'jurusan',
        'subkelas',
        'status',
        'keterangan',
        'jam_masuk',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}