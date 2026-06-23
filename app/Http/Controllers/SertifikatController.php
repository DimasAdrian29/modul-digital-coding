<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Sertifikat;
use App\Support\SimplePdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\BinaryFileResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Symfony\Component\Process\Process;

class SertifikatController extends Controller
{
    public function index(): View
    {
        return view('admin.sertifikat.index', [
            'sertifikatList' => Sertifikat::with('user')->latest()->get(),
        ]);
    }

    public function show(Sertifikat $sertifikat): View
    {
        $this->authorizeAccess($sertifikat);

        if (in_array(Auth::user()->role, ['guru', 'admin'], true)) {
            return view('admin.sertifikat.show', [
                'sertifikat' => $sertifikat,
                'detail' => $this->certificateDetail($sertifikat),
            ]);
        }

        return view('sertifikat.show', [
            'sertifikat' => $sertifikat,
            'detail' => $this->certificateDetail($sertifikat),
        ]);
    }

    public function download(Sertifikat $sertifikat): Response|BinaryFileResponse
    {
        $this->authorizeAccess($sertifikat);

        $filename = 'sertifikat-'.$sertifikat->nomor_sertifikat.'.pdf';
        $detail = $this->certificateDetail($sertifikat);

        if ($browserPdf = $this->renderWithBrowser($sertifikat, $detail)) {
            return response()
                ->download($browserPdf, $filename, ['Content-Type' => 'application/pdf'])
                ->deleteFileAfterSend();
        }

        if (class_exists(Dompdf::class) && class_exists(Options::class)) {
            $options = new Options;
            $options->set('defaultFont', 'DejaVu Sans');
            $options->set('isRemoteEnabled', true);
            $options->set('isHtml5ParserEnabled', true);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml(view('sertifikat.pdf', [
                'sertifikat' => $sertifikat,
                'detail' => $detail,
            ])->render());
            $dompdf->setPaper('a4', 'landscape');
            $dompdf->render();

            $pdf = $dompdf->output();
        } else {
            $pdf = SimplePdf::certificate([
                'number' => $sertifikat->nomor_sertifikat,
                'school' => $sertifikat->nama_sekolah,
                'student' => $sertifikat->nama_siswa,
                'nis' => $sertifikat->nis_nisn ?? '-',
                'class' => $sertifikat->kelas ?? '-',
                'major' => $sertifikat->jurusan ?? '-',
                'material' => $sertifikat->nama_materi,
                'score' => number_format((float) $sertifikat->nilai_akhir, 2).'%',
                'raw_score' => $detail['score_label'],
                'date' => $sertifikat->tanggal_selesai->translatedFormat('d F Y'),
                'signer' => $sertifikat->ditandatangani_oleh ?? 'Guru',
                'description' => $detail['description'],
                'topics' => $detail['topics'],
                'evaluation' => $detail['evaluation'],
                'status' => $detail['status'],
                'total' => (string) $sertifikat->total_soal,
                'correct' => (string) $sertifikat->nilai,
            ]);
        }

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    /**
     * @param  array{description: string, topics: array<int, string>, evaluation: string, status: string, score_label: string}  $detail
     */
    private function renderWithBrowser(Sertifikat $sertifikat, array $detail): ?string
    {
        $browserPath = collect([
            'C:\Program Files\Google\Chrome\Application\chrome.exe',
            'C:\Program Files (x86)\Google\Chrome\Application\chrome.exe',
            'C:\Program Files\Microsoft\Edge\Application\msedge.exe',
            'C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe',
        ])->first(fn (string $path) => File::exists($path));

        if (! $browserPath) {
            return null;
        }

        $tempDirectory = storage_path('app/pdf');
        File::ensureDirectoryExists($tempDirectory);

        $htmlPath = $tempDirectory.DIRECTORY_SEPARATOR.'sertifikat-'.$sertifikat->id.'-'.uniqid().'.html';
        $pdfPath = $tempDirectory.DIRECTORY_SEPARATOR.'sertifikat-'.$sertifikat->id.'-'.uniqid().'.pdf';

        File::put($htmlPath, view('sertifikat.browser-pdf', [
            'sertifikat' => $sertifikat,
            'detail' => $detail,
            'appCss' => File::get(public_path('css/app.css')),
        ])->render());

        $process = new Process([
            $browserPath,
            '--headless=new',
            '--disable-gpu',
            '--no-sandbox',
            '--disable-dev-shm-usage',
            '--allow-file-access-from-files',
            '--no-pdf-header-footer',
            '--print-to-pdf='.$pdfPath,
            'file:///'.str_replace('\\', '/', $htmlPath),
        ]);
        $process->setTimeout(60);
        $process->run();

        File::delete($htmlPath);

        if (! $process->isSuccessful() || ! File::exists($pdfPath) || File::size($pdfPath) < 1000) {
            File::delete($pdfPath);

            return null;
        }

        return $pdfPath;
    }

    private function authorizeAccess(Sertifikat $sertifikat): void
    {
        $user = Auth::user();

        abort_unless($user, 403);

        if (in_array($user->role, ['guru', 'admin'], true)) {
            return;
        }

        abort_unless($sertifikat->user_id === $user->id, 403);
    }

    /**
     * @return array{description: string, topics: array<int, string>, evaluation: string, status: string, score_label: string}
     */
    private function certificateDetail(Sertifikat $sertifikat): array
    {
        $materiList = Materi::where('bab', $sertifikat->nama_materi)->get();
        $topics = $materiList->pluck('judul')->filter()->values()->all();

        if ($topics === []) {
            $topics = [
                'Pemahaman konsep dasar pada '.$sertifikat->nama_materi,
                'Penerapan materi melalui latihan soal',
                'Evaluasi hasil belajar mandiri',
            ];
        }

        $description = $materiList->pluck('deskripsi')->filter()->first()
            ?? 'Peserta telah menyelesaikan rangkaian latihan dan evaluasi pembelajaran pada '.$sertifikat->nama_materi.'.';

        $score = (float) $sertifikat->nilai_akhir;
        $evaluation = match (true) {
            $score >= 90 => 'Sangat baik. Peserta menunjukkan penguasaan materi yang kuat dan konsisten.',
            $score >= 80 => 'Baik. Peserta memahami materi dan mampu menjawab mayoritas soal dengan tepat.',
            default => 'Lulus. Peserta telah memenuhi standar kompetensi minimum pada latihan ini.',
        };

        return [
            'description' => $description,
            'topics' => $topics,
            'evaluation' => $evaluation,
            'status' => $score >= 70 ? 'Lulus' : 'Belum Lulus',
            'score_label' => $sertifikat->nilai.' dari '.$sertifikat->total_soal.' soal benar',
        ];
    }
}
