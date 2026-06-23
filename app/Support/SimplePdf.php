<?php

namespace App\Support;

class SimplePdf
{
    /**
     * @param  array{
     *     number: string,
     *     school: string,
     *     student: string,
     *     nis: string,
     *     class: string,
     *     major: string,
     *     material: string,
     *     score: string,
     *     raw_score: string,
     *     date: string,
     *     signer: string,
     *     description: string,
     *     topics: array<int, string>,
     *     evaluation: string,
     *     status: string,
     *     total: string,
     *     correct: string
     * } $data
     */
    public static function certificate(array $data): string
    {
        return self::build([
            self::certificatePage($data),
            self::detailPage($data),
            self::evaluationPage($data),
        ]);
    }

    /**
     * @param  array<int, string>  $lines
     */
    public static function make(array $lines): string
    {
        $content = self::rect(36, 36, 770, 522, 'S', '0.72 0.81 0.97', 1.4);
        $content .= self::rect(640, 488, 166, 70, 'f', '0.06 0.24 0.59');
        $content .= self::text('Sertifikat Digital', 72, 506, 20, '0.06 0.17 0.37');

        foreach ($lines as $index => $line) {
            $content .= self::text($line, 72, 468 - ($index * 28), $index === 0 ? 18 : 12);
        }

        return self::build([$content]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private static function certificatePage(array $data): string
    {
        $content = '';
        $content .= self::rect(28, 28, 786, 538, 'S', '0.72 0.81 0.97', 1.3);
        $content .= self::rect(44, 44, 754, 506, 'S', '0.83 0.89 1', 0.7);
        $content .= self::rect(640, 494, 158, 56, 'f', '0.06 0.24 0.59');
        $content .= self::text('LULUS', 688, 516, 13, '1 1 1');
        $content .= self::rect(64, 492, 44, 44, 'f', '0.12 0.39 1');
        $content .= self::text('MD', 77, 509, 15, '1 1 1');
        $content .= self::text((string) $data['school'], 120, 517, 13, '0.06 0.17 0.37');
        $content .= self::text('Modul Digital Informatika', 120, 499, 9, '0.36 0.46 0.58');
        $content .= self::text('Nomor Sertifikat', 500, 518, 9, '0.36 0.46 0.58');
        $content .= self::text((string) $data['number'], 500, 500, 11, '0.06 0.17 0.37');

        $content .= self::text('SERTIFIKAT KOMPETENSI KELULUSAN', 245, 405, 13, '0.12 0.39 1');
        $content .= self::text('Diberikan kepada', 350, 368, 12, '0.36 0.46 0.58');
        $content .= self::text(self::fit((string) $data['student'], 34), 210, 316, 36, '0.06 0.17 0.37');
        $content .= self::text('Telah menyelesaikan latihan '.self::fit((string) $data['material'], 44), 210, 274, 13, '0.28 0.38 0.50');
        $content .= self::text('dengan nilai akhir '.$data['score'].'.', 324, 250, 13, '0.28 0.38 0.50');

        $content .= self::meta(64, 126, 'NIS/NISN', (string) $data['nis']);
        $content .= self::meta(206, 126, 'Kelas', (string) $data['class']);
        $content .= self::meta(348, 126, 'Jurusan', (string) $data['major']);
        $content .= self::meta(490, 126, 'Tanggal', (string) $data['date']);
        $content .= self::text('Guru', 650, 154, 9, '0.36 0.46 0.58');
        $content .= self::line(622, 110, 760, 110, '0.06 0.17 0.37', 0.8);
        $content .= self::text((string) $data['signer'], 650, 90, 11, '0.06 0.17 0.37');

        return $content;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private static function detailPage(array $data): string
    {
        $content = self::infoHeader('HALAMAN 2', 'Detail Materi Pembelajaran');
        $content .= self::wrappedText((string) $data['description'], 64, 430, 86, 12, 20);
        $content .= self::text('Topik yang Dipelajari', 64, 326, 18, '0.06 0.17 0.37');

        $x = 64;
        $y = 286;
        foreach (array_slice((array) $data['topics'], 0, 9) as $topic) {
            $content .= self::pill((string) $topic, $x, $y);
            $x += 238;
            if ($x > 560) {
                $x = 64;
                $y -= 44;
            }
        }

        $content .= self::stat(64, 92, 'Total Soal', (string) $data['total']);
        $content .= self::stat(306, 92, 'Jawaban Benar', (string) $data['correct']);
        $content .= self::stat(548, 92, 'Nilai Siswa', (string) $data['score']);

        return $content;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private static function evaluationPage(array $data): string
    {
        $content = self::infoHeader('HALAMAN 3', 'Evaluasi Pembelajaran');
        $content .= self::wrappedText((string) $data['evaluation'], 64, 430, 86, 13, 22);
        $content .= self::stat(64, 258, 'Status Kelulusan', (string) $data['status']);
        $content .= self::stat(306, 258, 'Statistik Latihan', (string) $data['raw_score']);
        $content .= self::stat(548, 258, 'Nilai Akhir', (string) $data['score']);
        $content .= self::line(64, 128, 778, 128, '0.83 0.89 1', 1);
        $content .= self::text('Sertifikat ini diterbitkan otomatis setelah peserta memenuhi standar kelulusan latihan.', 64, 96, 12, '0.36 0.46 0.58');
        $content .= self::text((string) $data['number'], 64, 70, 12, '0.12 0.39 1');

        return $content;
    }

    private static function infoHeader(string $kicker, string $title): string
    {
        $content = self::rect(28, 28, 786, 538, 'S', '0.72 0.81 0.97', 1.3);
        $content .= self::rect(640, 494, 158, 56, 'f', '0.06 0.24 0.59');
        $content .= self::text($kicker, 64, 506, 11, '0.12 0.39 1');
        $content .= self::text($title, 64, 466, 28, '0.06 0.17 0.37');

        return $content;
    }

    private static function meta(float $x, float $y, string $label, string $value): string
    {
        return self::rect($x, $y, 124, 54, 'f', '0.97 0.98 1')
            .self::rect($x, $y, 124, 54, 'S', '0.84 0.89 1', 0.6)
            .self::text($label, $x + 10, $y + 34, 8, '0.36 0.46 0.58')
            .self::text(self::fit($value, 18), $x + 10, $y + 14, 10, '0.06 0.17 0.37');
    }

    private static function stat(float $x, float $y, string $label, string $value): string
    {
        return self::rect($x, $y, 210, 96, 'f', '0.97 0.98 1')
            .self::rect($x, $y, 210, 96, 'S', '0.84 0.89 1', 0.6)
            .self::text($label, $x + 18, $y + 62, 10, '0.36 0.46 0.58')
            .self::text(self::fit($value, 24), $x + 18, $y + 28, 20, '0.06 0.17 0.37');
    }

    private static function pill(string $text, float $x, float $y): string
    {
        return self::rect($x, $y, 214, 30, 'f', '0.97 0.98 1')
            .self::rect($x, $y, 214, 30, 'S', '0.75 0.83 1', 0.6)
            .self::text(self::fit($text, 28), $x + 12, $y + 10, 10, '0.06 0.17 0.37');
    }

    private static function wrappedText(string $text, float $x, float $y, int $width, int $size, int $leading): string
    {
        $content = '';
        $lines = explode("\n", wordwrap($text, $width, "\n"));

        foreach (array_slice($lines, 0, 5) as $index => $line) {
            $content .= self::text($line, $x, $y - ($index * $leading), $size, '0.28 0.38 0.50');
        }

        return $content;
    }

    private static function text(string $text, float $x, float $y, int $size = 12, string $color = '0 0 0'): string
    {
        return "{$color} rg\nBT\n/F1 {$size} Tf\n{$x} {$y} Td\n(".self::escape($text).") Tj\nET\n";
    }

    private static function rect(float $x, float $y, float $width, float $height, string $mode, string $color, float $lineWidth = 1): string
    {
        $operator = $mode === 'f' ? 'rg' : 'RG';

        return "{$color} {$operator}\n{$lineWidth} w\n{$x} {$y} {$width} {$height} re {$mode}\n";
    }

    private static function line(float $x1, float $y1, float $x2, float $y2, string $color, float $lineWidth = 1): string
    {
        return "{$color} RG\n{$lineWidth} w\n{$x1} {$y1} m\n{$x2} {$y2} l\nS\n";
    }

    /**
     * @param  array<int, string>  $pages
     */
    private static function build(array $pages): string
    {
        $objects = [
            "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n",
        ];

        $pageObjectIds = [];
        $fontObjectId = (count($pages) * 2) + 3;

        foreach ($pages as $index => $content) {
            $pageObjectId = ($index * 2) + 3;
            $contentObjectId = ($index * 2) + 4;
            $pageObjectIds[] = $pageObjectId.' 0 R';
            $objects[] = "{$pageObjectId} 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 842 595] /Resources << /Font << /F1 {$fontObjectId} 0 R >> >> /Contents {$contentObjectId} 0 R >>\nendobj\n";
            $objects[] = "{$contentObjectId} 0 obj\n<< /Length ".strlen($content)." >>\nstream\n{$content}\nendstream\nendobj\n";
        }

        array_splice($objects, 1, 0, "2 0 obj\n<< /Type /Pages /Kids [".implode(' ', $pageObjectIds).'] /Count '.count($pages)." >>\nendobj\n");
        $objects[] = "{$fontObjectId} 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $xrefPosition = strlen($pdf);
        $pdf .= "xref\n0 ".(count($objects) + 1)."\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= str_pad((string) $offsets[$i], 10, '0', STR_PAD_LEFT)." 00000 n \n";
        }

        $pdf .= "trailer\n<< /Size ".(count($objects) + 1)." /Root 1 0 R >>\n";
        $pdf .= "startxref\n{$xrefPosition}\n%%EOF";

        return $pdf;
    }

    private static function fit(string $text, int $length): string
    {
        return strlen($text) > $length ? substr($text, 0, max(0, $length - 3)).'...' : $text;
    }

    private static function escape(string $text): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }
}
