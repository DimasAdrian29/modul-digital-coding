<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MateriController extends Controller
{
    public function index(): View
    {
        return view('admin.materi.index', [
            'materiList' => Materi::latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.materi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'bab' => ['required', 'string', 'max:100'],
            'video_url' => ['nullable', 'url', 'max:255'],
        ]);

        $validated['video_url'] ??= '';

        Materi::create($validated);

        return redirect()
            ->route('admin.materi.index')
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Materi $materi): View
    {
        return view('admin.materi.edit', [
            'materi' => $materi,
        ]);
    }

    public function update(Request $request, Materi $materi): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'bab' => ['required', 'string', 'max:100'],
            'video_url' => ['nullable', 'url', 'max:255'],
        ]);

        $validated['video_url'] ??= '';

        $materi->update($validated);

        return redirect()
            ->route('admin.materi.index')
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi): RedirectResponse
    {
        $materi->delete();

        return redirect()
            ->route('admin.materi.index')
            ->with('success', 'Materi berhasil dihapus.');
    }
}
