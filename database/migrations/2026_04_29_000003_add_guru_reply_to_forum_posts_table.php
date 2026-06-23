<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forum_posts', function (Blueprint $table): void {
            // Balasan guru dikelola dari panel admin dan ditampilkan di forum siswa.
            $table->text('guru_balasan')->nullable()->after('isi');
            $table->timestamp('guru_dibalas_pada')->nullable()->after('guru_balasan');
        });
    }

    public function down(): void
    {
        Schema::table('forum_posts', function (Blueprint $table): void {
            $table->dropColumn(['guru_balasan', 'guru_dibalas_pada']);
        });
    }
};
