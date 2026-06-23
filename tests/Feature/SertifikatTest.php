<?php

namespace Tests\Feature;

use App\Models\Materi;
use App\Models\Sertifikat;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SertifikatTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_mendapat_sertifikat_saat_nilai_memenuhi_syarat(): void
    {
        $siswa = User::factory()->create([
            'role' => 'siswa',
            'nis_nisn' => '12345',
            'kelas' => 'XI',
            'jurusan' => 'RPL',
        ]);

        $this->createLatihanBab();

        $this->actingAs($siswa)
            ->postJson('/bab/bab-1/latihan/hasil', [
                'answers' => ['A', 'A', 'A', 'B'],
                'score' => 3,
            ])
            ->assertOk()
            ->assertJsonPath('certificate.number', fn (?string $number) => filled($number));

        $this->assertDatabaseHas('sertifikat', [
            'user_id' => $siswa->id,
            'bab_slug' => 'bab-1',
            'nama_siswa' => $siswa->name,
            'nis_nisn' => '12345',
        ]);
    }

    public function test_sertifikat_tidak_digenerate_dua_kali_untuk_bab_yang_sama(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);

        $this->createLatihanBab();

        $payload = [
            'answers' => ['A', 'A', 'A', 'B'],
            'score' => 3,
        ];

        $this->actingAs($siswa)->postJson('/bab/bab-1/latihan/hasil', $payload)->assertOk();
        $this->actingAs($siswa)->postJson('/bab/bab-1/latihan/hasil', $payload)->assertOk();

        $this->assertSame(1, Sertifikat::where('user_id', $siswa->id)->where('bab_slug', 'bab-1')->count());
    }

    private function createLatihanBab(): void
    {
        Materi::create([
            'judul' => 'HTML Dasar',
            'deskripsi' => 'Materi HTML',
            'bab' => 'Bab 1',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        foreach (range(1, 4) as $index) {
            Soal::create([
                'bab' => 'Bab 1',
                'pertanyaan' => 'Pertanyaan '.$index,
                'pilihan_a' => 'A',
                'pilihan_b' => 'B',
                'pilihan_c' => 'C',
                'pilihan_d' => 'D',
                'jawaban_benar' => 'A',
            ]);
        }
    }
}
