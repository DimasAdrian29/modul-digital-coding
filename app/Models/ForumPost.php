<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumPost extends Model
{
    protected $fillable = [
        'bab',
        'nama',
        'judul',
        'isi',
        'guru_balasan',
        'guru_dibalas_pada',
    ];

    public function setBabAttribute(string $value): void
    {
        $this->attributes['bab'] = Materi::normalizeBabName($value);
    }

    public function getBabAttribute(string $value): string
    {
        return Materi::normalizeBabName($value);
    }

    protected $casts = [
        'guru_dibalas_pada' => 'datetime',
    ];

    public function replies(): HasMany
    {
        return $this->hasMany(ForumReply::class)->oldest();
    }
}
