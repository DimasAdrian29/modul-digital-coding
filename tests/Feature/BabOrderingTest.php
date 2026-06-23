<?php

namespace Tests\Feature;

use App\Models\Materi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BabOrderingTest extends TestCase
{
    use RefreshDatabase;

    private ?User $siswa = null;

    public function test_home_page_displays_bab_in_number_order(): void
    {
        $this->createMateri('Bab 3', 'JavaScript');
        $this->createMateri('Bab 1', 'HTML');
        $this->createMateri('Bab 2', 'CSS');

        DB::table('materi')->insert([
            'judul' => 'Laravel',
            'deskripsi' => 'Materi Laravel',
            'bab' => '4',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAsSiswa()
            ->get('/')
            ->assertOk()
            ->assertSeeInOrder(['Bab 1', 'Bab 2', 'Bab 3', 'Bab 4']);
    }

    public function test_numeric_bab_input_is_saved_with_bab_prefix(): void
    {
        $materi = $this->createMateri('4', 'Laravel');

        $this->assertSame('Bab 4', $materi->fresh()->bab);
    }

    public function test_next_bab_is_locked_until_previous_bab_is_completed(): void
    {
        $this->createMateri('Bab 1', 'HTML');
        $this->createMateri('Bab 2', 'CSS');

        $this->actingAsSiswa()
            ->get('/bab/bab-2')
            ->assertRedirect('/');

        $this->actingAsSiswa()
            ->postJson('/bab/bab-1/selesai', ['completed' => true])
            ->assertOk()
            ->assertJson([
                'message' => 'Bab selesai. Bab berikutnya sudah terbuka.',
            ]);

        $this->actingAsSiswa()
            ->get('/bab/bab-2')
            ->assertOk()
            ->assertSee('Bab 2');
    }

    public function test_bab_progress_is_saved_per_user_after_login_again(): void
    {
        $this->createMateri('Bab 1', 'HTML');
        $this->createMateri('Bab 2', 'CSS');

        $firstUser = User::factory()->create(['role' => 'siswa']);
        $secondUser = User::factory()->create(['role' => 'siswa']);

        $this->actingAs($firstUser)
            ->postJson('/bab/bab-1/selesai', ['completed' => true])
            ->assertOk();

        $this->post('/logout');

        $this->actingAs($firstUser)
            ->get('/bab/bab-2')
            ->assertOk()
            ->assertSee('Bab 2');

        $this->actingAs($secondUser)
            ->get('/bab/bab-2')
            ->assertRedirect('/');
    }

    public function test_guru_can_open_all_bab_without_student_progress(): void
    {
        $this->createMateri('Bab 1', 'HTML');
        $this->createMateri('Bab 2', 'CSS');

        $guru = User::factory()->create(['role' => 'guru']);

        $this->actingAs($guru)
            ->get('/bab/bab-2')
            ->assertOk()
            ->assertSee('Bab 2');
    }

    private function actingAsSiswa(): self
    {
        return $this->actingAs($this->siswa ??= User::factory()->create([
            'role' => 'siswa',
        ]));
    }

    private function createMateri(string $bab, string $judul): Materi
    {
        return Materi::create([
            'judul' => $judul,
            'deskripsi' => 'Deskripsi '.$judul,
            'bab' => $bab,
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);
    }
}
