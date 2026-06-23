<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';

    protected $fillable = [
        'judul',
        'deskripsi',
        'bab',
        'video_url',
    ];

    public function setBabAttribute(string $value): void
    {
        $this->attributes['bab'] = self::normalizeBabName($value);
    }

    public function getBabAttribute(string $value): string
    {
        return self::normalizeBabName($value);
    }

    public static function normalizeBabName(string $bab): string
    {
        $bab = trim($bab);

        if (preg_match('/^\d+$/', $bab) === 1) {
            return 'Bab '.(int) $bab;
        }

        if (preg_match('/^bab\s+(\d+)$/i', $bab, $matches) === 1) {
            return 'Bab '.(int) $matches[1];
        }

        return $bab;
    }

    public static function compareBabNames(string $firstBab, string $secondBab): int
    {
        $firstNumber = self::extractBabNumber($firstBab);
        $secondNumber = self::extractBabNumber($secondBab);

        if ($firstNumber !== null && $secondNumber !== null) {
            return $firstNumber <=> $secondNumber ?: strnatcasecmp($firstBab, $secondBab);
        }

        if ($firstNumber !== null) {
            return -1;
        }

        if ($secondNumber !== null) {
            return 1;
        }

        return strnatcasecmp($firstBab, $secondBab);
    }

    private static function extractBabNumber(string $bab): ?int
    {
        if (preg_match('/\d+/', $bab, $matches) !== 1) {
            return null;
        }

        return (int) $matches[0];
    }

    public function getEmbedVideoUrlAttribute(): string
    {
        if (str_contains($this->video_url, 'embed/')) {
            return $this->video_url;
        }

        preg_match(
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/',
            $this->video_url,
            $matches
        );

        $videoId = $matches[1] ?? null;

        return $videoId
            ? 'https://www.youtube.com/embed/'.$videoId
            : $this->video_url;
    }
}
