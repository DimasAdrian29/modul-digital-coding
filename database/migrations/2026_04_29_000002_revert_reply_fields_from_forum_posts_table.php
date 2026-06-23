<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Migration ini dipertahankan untuk membersihkan jejak skema reply lama
        // sebelum skema final balasan guru diterapkan.
        Schema::table('forum_posts', function (Blueprint $table): void {
            if (Schema::hasColumn('forum_posts', 'parent_id')) {
                $table->dropConstrainedForeignId('parent_id');
            }

            if (Schema::hasColumn('forum_posts', 'peran')) {
                $table->dropColumn('peran');
            }
        });
    }

    public function down(): void
    {
        // Down hanya mengembalikan skema reply lama bila rollback diperlukan.
        Schema::table('forum_posts', function (Blueprint $table): void {
            if (! Schema::hasColumn('forum_posts', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->after('id')->constrained('forum_posts')->nullOnDelete();
            }

            if (! Schema::hasColumn('forum_posts', 'peran')) {
                $table->string('peran', 20)->default('siswa')->after('nama');
            }
        });
    }
};
