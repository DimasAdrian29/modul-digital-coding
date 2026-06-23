<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soal';

    protected $fillable = [
        'bab',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'jawaban_benar',
    ];

    public function setBabAttribute(string $value): void
    {
        $this->attributes['bab'] = Materi::normalizeBabName($value);
    }

    public function getBabAttribute(string $value): string
    {
        return Materi::normalizeBabName($value);
    }
}
