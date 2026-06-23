<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Soal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class SoalController extends Controller
{
    private function babOptions(): Collection
    {
        return Materi::all()
            ->pluck('bab')
            ->unique()
            ->sort(fn (string $first, string $second) => Materi::compareBabNames($first, $second))
            ->values();
    }

    public function index(): View
    {
        return view('admin.soal.index', [
            'soalList' => Soal::all()
                ->sort(function (Soal $first, Soal $second) {
                    return Materi::compareBabNames($first->bab, $second->bab)
                        ?: $second->id <=> $first->id;
                })
                ->values(),
        ]);
    }

    public function create(): View
    {
        return view('admin.soal.create', [
            'babOptions' => $this->babOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'questions' => ['required', 'array', 'min:1'],
            'questions.*.bab' => ['required', 'string', 'max:100'],
            'questions.*.pertanyaan' => ['required', 'string'],
            'questions.*.pilihan_a' => ['required', 'string', 'max:255'],
            'questions.*.pilihan_b' => ['required', 'string', 'max:255'],
            'questions.*.pilihan_c' => ['required', 'string', 'max:255'],
            'questions.*.pilihan_d' => ['required', 'string', 'max:255'],
            'questions.*.jawaban_benar' => ['required', 'in:A,B,C,D'],
        ]);

        foreach ($validated['questions'] as $question) {
            Soal::create($question);
        }

        return redirect()
            ->route('admin.soal.index')
            ->with('success', count($validated['questions']).' soal berhasil ditambahkan.');
    }

    public function edit(Soal $soal): View
    {
        return view('admin.soal.edit', [
            'soal' => $soal,
            'babOptions' => $this->babOptions(),
        ]);
    }

    public function update(Request $request, Soal $soal): RedirectResponse
    {
        $validated = $request->validate([
            'bab' => ['required', 'string', 'max:100'],
            'pertanyaan' => ['required', 'string'],
            'pilihan_a' => ['required', 'string', 'max:255'],
            'pilihan_b' => ['required', 'string', 'max:255'],
            'pilihan_c' => ['required', 'string', 'max:255'],
            'pilihan_d' => ['required', 'string', 'max:255'],
            'jawaban_benar' => ['required', 'in:A,B,C,D'],
        ]);

        $soal->update($validated);

        return redirect()
            ->route('admin.soal.index')
            ->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Soal $soal): RedirectResponse
    {
        $soal->delete();

        return redirect()
            ->route('admin.soal.index')
            ->with('success', 'Soal berhasil dihapus.');
    }
}
