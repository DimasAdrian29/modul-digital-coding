<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('siswa')->after('password');
            $table->string('nis_nisn', 50)->nullable()->after('role');
            $table->string('kelas', 50)->nullable()->after('nis_nisn');
            $table->string('jurusan', 100)->nullable()->after('kelas');
            $table->string('nip_nuptk', 50)->nullable()->after('jurusan');
            $table->string('jabatan', 100)->nullable()->after('nip_nuptk');
            $table->string('mata_pelajaran', 100)->nullable()->after('jabatan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'nis_nisn',
                'kelas',
                'jurusan',
                'nip_nuptk',
                'jabatan',
                'mata_pelajaran',
            ]);
        });
    }
};
