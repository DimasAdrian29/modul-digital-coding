<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\Materi;
use App\Models\Sertifikat;
use App\Models\Soal;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalMateri = Materi::count();
        $totalSoal = Soal::count();
        $totalForumPost = ForumPost::count();
        $totalSertifikat = Sertifikat::count();
        $totalStudents = User::where('role', 'siswa')->count();
        $answeredForum = ForumPost::whereNotNull('guru_balasan')
            ->whereRaw("TRIM(guru_balasan) != ''")
            ->count();
        $unansweredForum = max($totalForumPost - $answeredForum, 0);
        $forumAnsweredPercent = $totalForumPost > 0
            ? (int) round(($answeredForum / $totalForumPost) * 100)
            : 0;
        $materiByBab = Materi::all()->countBy(fn (Materi $materi) => $materi->bab);
        $soalByBab = Soal::all()->countBy(fn (Soal $soal) => $soal->bab);
        $forumByBab = ForumPost::all()->countBy(fn (ForumPost $post) => $post->bab);
        $certificateByBab = Sertifikat::all()
            ->countBy(fn (Sertifikat $sertifikat) => Materi::normalizeBabName($sertifikat->nama_materi));

        $babInsights = collect([
            $materiByBab->keys(),
            $soalByBab->keys(),
            $forumByBab->keys(),
            $certificateByBab->keys(),
        ])
            ->flatten()
            ->filter()
            ->unique()
            ->sort(fn (string $firstBab, string $secondBab) => Materi::compareBabNames($firstBab, $secondBab))
            ->values()
            ->map(function (string $bab) use ($materiByBab, $soalByBab, $forumByBab, $certificateByBab, $totalStudents) {
                $materiCount = (int) ($materiByBab[$bab] ?? 0);
                $soalCount = (int) ($soalByBab[$bab] ?? 0);
                $forumCount = (int) ($forumByBab[$bab] ?? 0);
                $certificateCount = (int) ($certificateByBab[$bab] ?? 0);

                if ($materiCount === 0) {
                    $statusLabel = 'Belum ada materi';
                    $statusTone = 'critical';
                    $readinessPercent = 0;
                } elseif ($soalCount === 0) {
                    $statusLabel = 'Perlu tambah soal';
                    $statusTone = 'warning';
                    $readinessPercent = 45;
                } elseif ($soalCount < 5) {
                    $statusLabel = 'Soal belum lengkap';
                    $statusTone = 'warning';
                    $readinessPercent = 75;
                } else {
                    $statusLabel = 'Siap dipakai';
                    $statusTone = 'ready';
                    $readinessPercent = 100;
                }

                return [
                    'bab' => $bab,
                    'materi' => $materiCount,
                    'soal' => $soalCount,
                    'forum' => $forumCount,
                    'sertifikat' => $certificateCount,
                    'status_label' => $statusLabel,
                    'status_tone' => $statusTone,
                    'readiness_percent' => $readinessPercent,
                    'student_reach_percent' => $totalStudents > 0
                        ? (int) round(($certificateCount / $totalStudents) * 100)
                        : 0,
                ];
            });

        $activeBabCount = $babInsights->count();
        $readyBabCount = $babInsights->where('status_tone', 'ready')->count();
        $needsQuestionBabCount = $babInsights
            ->where('materi', '>', 0)
            ->where('status_tone', 'warning')
            ->count();
        $studentsWithCertificates = Sertifikat::query()
            ->distinct()
            ->count('user_id');
        $certificateStudentPercent = $totalStudents > 0
            ? (int) round(($studentsWithCertificates / $totalStudents) * 100)
            : 0;
        $averageQuestionsPerBab = $activeBabCount > 0
            ? round($totalSoal / $activeBabCount, 1)
            : 0;

        return view('admin.dashboard', [
            'totalMateri' => $totalMateri,
            'totalSoal' => $totalSoal,
            'totalForumPost' => $totalForumPost,
            'totalSertifikat' => $totalSertifikat,
            'totalStudents' => $totalStudents,
            'answeredForum' => $answeredForum,
            'unansweredForum' => $unansweredForum,
            'forumAnsweredPercent' => $forumAnsweredPercent,
            'activeBabCount' => $activeBabCount,
            'readyBabCount' => $readyBabCount,
            'needsQuestionBabCount' => $needsQuestionBabCount,
            'averageQuestionsPerBab' => $averageQuestionsPerBab,
            'studentsWithCertificates' => $studentsWithCertificates,
            'certificateStudentPercent' => $certificateStudentPercent,
            'babInsights' => $babInsights,
            'latestCertificates' => Sertifikat::latest()->take(5)->get(),
        ]);
    }
}
