<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'nomor_sertifikat',
    'bab_slug',
    'nama_materi',
    'nama_siswa',
    'nis_nisn',
    'kelas',
    'jurusan',
    'nilai',
    'total_soal',
    'nilai_akhir',
    'nama_sekolah',
    'ditandatangani_oleh',
    'tanggal_selesai',
])]
class Sertifikat extends Model
{
    protected $table = 'sertifikat';

    protected function casts(): array
    {
        return [
            'nilai_akhir' => 'decimal:2',
            'tanggal_selesai' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
