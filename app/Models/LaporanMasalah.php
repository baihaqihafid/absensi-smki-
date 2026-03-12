<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanMasalah extends Model
{
    protected $table = 'laporan_masalah';

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'judul', 'deskripsi',
        'kategori', 'status', 'balasan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}