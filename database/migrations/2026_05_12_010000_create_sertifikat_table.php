<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nomor_sertifikat')->unique();
            $table->string('bab_slug');
            $table->string('nama_materi');
            $table->string('nama_siswa');
            $table->string('nis_nisn', 50)->nullable();
            $table->string('kelas', 50)->nullable();
            $table->string('jurusan', 100)->nullable();
            $table->unsignedInteger('nilai');
            $table->unsignedInteger('total_soal');
            $table->decimal('nilai_akhir', 5, 2);
            $table->string('nama_sekolah')->default('Modul Digital Informatika');
            $table->string('ditandatangani_oleh')->nullable();
            $table->timestamp('tanggal_selesai');
            $table->timestamps();

            $table->unique(['user_id', 'bab_slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
