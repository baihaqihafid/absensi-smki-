<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensi_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('jam_ke', 10);
            $table->string('mapel', 100);
            $table->string('kelas', 50);
            $table->string('jurusan', 50);
            $table->string('subkelas', 50);
            $table->enum('status', ['Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpa']);
            $table->text('keterangan')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi_guru');
    }
};
