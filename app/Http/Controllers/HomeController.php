<?php

namespace App\Http\Controllers;

use App\Models\BabProgress;
use App\Models\ForumPost;
use App\Models\Materi;
use App\Models\Sertifikat;
use App\Models\Soal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    private const FIXED_BAB_LIST = [
        [
            'nama' => 'Bab 1',
            'judul_utama' => 'Berpikir Komputasional',
            'deskripsi' => 'Bab ini membahas cara berpikir runtut dan logis untuk menyelesaikan masalah.',
        ],
        [
            'nama' => 'Bab 2',
            'judul_utama' => 'Algoritma dan Pemrograman',
            'deskripsi' => 'Bab ini membahas langkah penyelesaian masalah dan dasar pembuatan program.',
        ],
        [
            'nama' => 'Bab 3',
            'judul_utama' => 'Sistem Komputer',
            'deskripsi' => 'Bab ini membahas komponen komputer, cara kerja komputer, dan peran sistem operasi.',
        ],
        [
            'nama' => 'Bab 4',
            'judul_utama' => 'Pencarian Informasi Digital',
            'deskripsi' => 'Bab ini membahas cara mencari, memilih, dan memeriksa informasi digital.',
        ],
        [
            'nama' => 'Bab 5',
            'judul_utama' => 'Teknologi Informasi dan Komunikasi',
            'deskripsi' => 'Bab ini membahas pemanfaatan teknologi digital untuk membuat laporan, presentasi, dan pengolahan data.',
        ],
        [
            'nama' => 'Bab 6',
            'judul_utama' => 'Jaringan Komputer dan Internet',
            'deskripsi' => 'Bab ini membahas jaringan lokal, internet, komunikasi data, dan keamanan dasar saat terhubung ke jaringan.',
        ],
        [
            'nama' => 'Bab 7',
            'judul_utama' => 'Pemanfaatan Media Sosial',
            'deskripsi' => 'Bab ini membahas penggunaan media sosial untuk membuat konten, berpartisipasi, dan berkolaborasi secara bijak.',
        ],
        [
            'nama' => 'Bab 8',
            'judul_utama' => 'Perlindungan Data dari Kejahatan Digital',
            'deskripsi' => 'Bab ini membahas perlindungan data pribadi, kata sandi, privasi, dan keamanan akun digital.',
        ],
    ];

    private function orderedMateri()
    {
        return Materi::all()
            ->sort(function (Materi $first, Materi $second) {
                return Materi::compareBabNames($first->bab, $second->bab)
                    ?: $first->id <=> $second->id;
            })
            ->values();
    }

    private function orderedBabList(): Collection
    {
        $materiByBab = $this->orderedMateri()->groupBy('bab');

        return collect(self::FIXED_BAB_LIST)
            ->map(function (array $bab) use ($materiByBab) {
                $items = $materiByBab->get($bab['nama'], collect());

                return [
                    ...$bab,
                    'slug' => Str::slug($bab['nama']),
                    'jumlah_materi' => $items->count(),
                ];
            })
            ->concat($this->additionalBabFromMateri())
            ->values();
    }

    private function findFixedBab(string $bab): ?array
    {
        return collect(self::FIXED_BAB_LIST)
            ->first(fn (array $item) => Str::slug($item['nama']) === $bab);
    }

    private function orderedMateriForBab(string $babName): Collection
    {
        return $this->orderedMateri()
            ->filter(fn (Materi $materi) => $materi->bab === $babName)
            ->values();
    }

    private function additionalBabFromMateri(): Collection
    {
        $fixedBabNames = collect(self::FIXED_BAB_LIST)->pluck('nama')->all();

        return $this->orderedMateri()
            ->groupBy('bab')
            ->reject(fn ($items, $bab) => in_array($bab, $fixedBabNames, true))
            ->map(function ($items, $bab) {
                $first = $items->first();

                return [
                    'nama' => $bab,
                    'slug' => Str::slug($bab),
                    'jumlah_materi' => $items->count(),
                    'judul_utama' => $first?->judul,
                    'deskripsi' => Str::limit($first?->deskripsi ?? '', 110),
                ];
            })
            ->values();
    }

    private function completedBabSlugs(Request $request): array
    {
        if (! auth()->check()) {
            return [];
        }

        return BabProgress::where('user_id', auth()->id())
            ->where('completed', true)
            ->pluck('bab_slug')
            ->all();
    }

    private function isBabCompleted(Request $request, string $babSlug): bool
    {
        if ($this->canAccessAllBab()) {
            return false;
        }

        return in_array($babSlug, $this->completedBabSlugs($request), true);
    }

    private function isBabUnlocked(Request $request, string $babSlug): bool
    {
        if ($this->canAccessAllBab()) {
            return true;
        }

        $babList = $this->orderedBabList();
        $index = $babList->search(fn (array $bab) => $bab['slug'] === $babSlug);

        if ($index === false) {
            return false;
        }

        if ($index === 0) {
            return true;
        }

        $previousBab = $babList->get($index - 1);

        return $this->isBabCompleted($request, $previousBab['slug']);
    }

    private function ensureBabUnlocked(Request $request, string $babSlug): void
    {
        if ($this->canAccessAllBab()) {
            return;
        }

        if ($this->isBabUnlocked($request, $babSlug)) {
            return;
        }

        redirect()
            ->route('home')
            ->with('locked_bab_message', 'Bab ini masih terkunci. Selesaikan bab sebelumnya dengan nilai minimal 80% terlebih dahulu.')
            ->throwResponse();
    }

    private function canAccessAllBab(): bool
    {
        return in_array(auth()->user()?->role, ['guru', 'admin'], true);
    }

    private function findBabData(string $bab): array
    {
        $fixedBab = $this->findFixedBab($bab);

        if ($fixedBab !== null) {
            return [
                'babName' => $fixedBab['nama'],
                'materiList' => $this->orderedMateriForBab($fixedBab['nama']),
            ];
        }

        $babData = $this->additionalBabFromMateri()
            ->first(fn (array $item) => $item['slug'] === $bab);

        abort_if($babData === null, 404);

        return [
            'babName' => $babData['nama'],
            'materiList' => $this->orderedMateriForBab($babData['nama']),
        ];
    }

    public function index(): View
    {
        $babList = $this->orderedBabList()
            ->map(function (array $bab) {
                $isCompleted = $this->isBabCompleted(request(), $bab['slug']);
                $isLocked = ! $this->isBabUnlocked(request(), $bab['slug']);

                return [
                    ...$bab,
                    'is_completed' => $isCompleted,
                    'is_locked' => $isLocked,
                    'status_label' => $isCompleted ? 'Selesai' : ($isLocked ? 'Terkunci' : 'Terbuka'),
                ];
            });

        return view('home', [
            'babList' => $babList,
            'totalMateri' => Materi::count(),
            'totalSoal' => Soal::count(),
            'sertifikatList' => Sertifikat::where('user_id', auth()->id())->latest()->get(),
        ]);
    }

    public function materi(): View
    {
        return view('materi.index', [
            'materiList' => Materi::latest()->get(),
        ]);
    }

    public function showBab(string $bab): View
    {
        $this->ensureBabUnlocked(request(), $bab);
        $babData = $this->findBabData($bab);

        return view('bab.show', [
            'babName' => $babData['babName'],
            'babSlug' => $bab,
            'firstMateri' => $babData['materiList']->first(),
        ]);
    }

    public function babMateri(string $bab): View
    {
        $this->ensureBabUnlocked(request(), $bab);
        $babData = $this->findBabData($bab);

        return view('bab.materi', [
            'babName' => $babData['babName'],
            'babSlug' => $bab,
            'materiList' => $babData['materiList'],
        ]);
    }

    public function babLatihan(string $bab): View
    {
        $this->ensureBabUnlocked(request(), $bab);
        $babData = $this->findBabData($bab);
        $babSlug = Str::slug($babData['babName']);

        return view('bab.latihan', [
            'babName' => $babData['babName'],
            'babSlug' => $bab,
            'soalList' => Soal::where('bab', $babData['babName'])->latest()->get(),
            'previousAttempt' => $this->previousAttempt($babSlug),
            'sertifikat' => Sertifikat::where('user_id', auth()->id())->where('bab_slug', $babSlug)->first(),
        ]);
    }

    private function previousAttempt(string $babSlug): ?array
    {
        if (! auth()->check()) {
            return null;
        }

        $progress = BabProgress::where('user_id', auth()->id())
            ->where('bab_slug', $babSlug)
            ->first();

        if (! $progress || $progress->total < 1) {
            return null;
        }

        return [
            'answers' => $progress->answers ?? [],
            'score' => $progress->score,
            'total' => $progress->total,
            'passed' => $progress->passed,
            'completed_at_label' => $progress->completed_at?->translatedFormat('j F Y')
                ?? $progress->updated_at->translatedFormat('j F Y'),
        ];
    }

    public function storeBabAttempt(Request $request, string $bab): JsonResponse
    {
        $this->ensureBabUnlocked($request, $bab);
        $babData = $this->findBabData($bab);
        $babSlug = Str::slug($babData['babName']);
        $totalSoal = Soal::where('bab', $babData['babName'])->count();
        $passingScore = (int) ceil($totalSoal * 0.8);

        $validated = $request->validate([
            'answers' => ['required', 'array'],
            'score' => ['required', 'integer', 'min:0'],
        ]);

        $score = min((int) $validated['score'], $totalSoal);
        $attempt = [
            'answers' => array_values($validated['answers']),
            'score' => $score,
            'total' => $totalSoal,
            'passed' => $score >= $passingScore,
            'completed_at_label' => now()->translatedFormat('j F Y'),
        ];

        BabProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'bab_slug' => $babSlug,
            ],
            [
                'bab_name' => $babData['babName'],
                'answers' => $attempt['answers'],
                'score' => $score,
                'total' => $totalSoal,
                'passed' => $attempt['passed'],
                'completed' => $attempt['passed'],
                'completed_at' => $attempt['passed'] ? now() : null,
            ],
        );

        $sertifikat = $this->createSertifikatIfEligible($babSlug, $babData['babName'], $score, $totalSoal);

        return response()->json([
            'message' => 'Hasil latihan tersimpan.',
            'attempt' => $attempt,
            'certificate' => $sertifikat ? [
                'number' => $sertifikat->nomor_sertifikat,
                'show_url' => route('sertifikat.show', $sertifikat),
                'download_url' => route('sertifikat.download', $sertifikat),
            ] : null,
        ]);
    }

    private function createSertifikatIfEligible(string $babSlug, string $babName, int $score, int $totalSoal): ?Sertifikat
    {
        if (! auth()->check() || $totalSoal < 1) {
            return null;
        }

        $nilaiAkhir = round(($score / $totalSoal) * 100, 2);

        if ($nilaiAkhir < 70) {
            return null;
        }

        $user = auth()->user();
        $existing = Sertifikat::where('user_id', $user->id)
            ->where('bab_slug', $babSlug)
            ->first();

        if ($existing) {
            return $existing;
        }

        return Sertifikat::create([
            'user_id' => $user->id,
            'nomor_sertifikat' => $this->generateCertificateNumber(),
            'bab_slug' => $babSlug,
            'nama_materi' => $babName,
            'nama_siswa' => $user->name,
            'nis_nisn' => $user->nis_nisn,
            'kelas' => $user->kelas,
            'jurusan' => $user->jurusan,
            'nilai' => $score,
            'total_soal' => $totalSoal,
            'nilai_akhir' => $nilaiAkhir,
            'nama_sekolah' => config('app.name', 'Modul Digital Informatika'),
            'ditandatangani_oleh' => 'Guru',
            'tanggal_selesai' => now(),
        ]);
    }

    private function generateCertificateNumber(): string
    {
        do {
            $number = 'MDC-'.now()->format('Ymd').'-'.strtoupper(Str::random(6));
        } while (Sertifikat::where('nomor_sertifikat', $number)->exists());

        return $number;
    }

    public function completeBab(Request $request, string $bab): JsonResponse
    {
        $this->ensureBabUnlocked($request, $bab);
        $babData = $this->findBabData($bab);
        $babSlug = Str::slug($babData['babName']);

        BabProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'bab_slug' => $babSlug,
            ],
            [
                'bab_name' => $babData['babName'],
                'completed' => true,
                'passed' => true,
                'completed_at' => now(),
            ],
        );

        return response()->json([
            'message' => 'Bab selesai. Bab berikutnya sudah terbuka.',
        ]);
    }

    public function babForum(string $bab): View
    {
        $this->ensureBabUnlocked(request(), $bab);
        $babData = $this->findBabData($bab);

        return view('bab.forum', [
            'babName' => $babData['babName'],
            'babSlug' => $bab,
            'posts' => ForumPost::with('replies')
                ->where('bab', $babData['babName'])
                ->latest()
                ->get(),
            'forumTopics' => [
                [
                    'judul' => 'Perkenalan dan tujuan belajar pada '.$babData['babName'],
                    'isi' => 'Siswa dapat memakai forum ini untuk berbagi target belajar, kesulitan, dan progres selama mempelajari materi.',
                ],
                [
                    'judul' => 'Tanya jawab konsep yang belum dipahami',
                    'isi' => 'Gunakan ruang diskusi ini untuk membahas istilah, sintaks, atau latihan yang masih membingungkan.',
                ],
                [
                    'judul' => 'Berbagi hasil latihan atau mini project',
                    'isi' => 'Forum ini dapat dipakai guru dan siswa untuk memberi umpan balik terhadap tugas atau percobaan modul digital informatika sederhana.',
                ],
            ],
        ]);
    }

    public function storeForumPost(Request $request, string $bab): RedirectResponse
    {
        $this->ensureBabUnlocked($request, $bab);
        $babData = $this->findBabData($bab);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'judul' => ['required', 'string', 'max:150'],
            'isi' => ['required', 'string', 'max:2000'],
        ]);

        ForumPost::create([
            ...$validated,
            'bab' => $babData['babName'],
        ]);

        return redirect()
            ->route('bab.forum', $bab)
            ->with('success', 'Diskusi berhasil dikirim.');
    }

    public function storeForumReply(Request $request, string $bab, ForumPost $post): RedirectResponse
    {
        $this->ensureBabUnlocked($request, $bab);
        $babData = $this->findBabData($bab);

        abort_unless($post->bab === $babData['babName'], 404);

        $validated = $request->validate([
            'isi' => ['required', 'string', 'max:1500'],
        ], [
            'isi.required' => 'Balasan wajib diisi.',
            'isi.max' => 'Balasan maksimal 1500 karakter.',
        ]);

        $post->replies()->create([
            'user_id' => auth()->id(),
            'nama' => auth()->user()?->name ?? 'Siswa',
            'isi' => $validated['isi'],
        ]);

        return redirect()
            ->route('bab.forum', $bab)
            ->with('success', 'Balasan berhasil dikirim.');
    }

    public function showMateri(Materi $materi): View
    {
        $this->ensureBabUnlocked(request(), Str::slug($materi->bab));

        return view('materi.show', [
            'materi' => $materi,
            'babSlug' => Str::slug($materi->bab),
        ]);
    }

    public function quiz(): View
    {
        return view('quiz.index', [
            'soalList' => Soal::latest()->get(),
        ]);
    }
}
