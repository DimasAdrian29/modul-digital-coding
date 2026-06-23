<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumPostController extends Controller
{
    public function index(): View
    {
        return view('admin.forum.index', [
            'forumPosts' => ForumPost::query()
                ->orderByRaw("CASE WHEN guru_balasan IS NULL OR TRIM(guru_balasan) = '' THEN 0 ELSE 1 END")
                ->latest()
                ->get(),
        ]);
    }

    public function edit(ForumPost $forum): View
    {
        return view('admin.forum.edit', [
            'forumPost' => $forum,
        ]);
    }

    public function update(Request $request, ForumPost $forum): RedirectResponse
    {
        $validated = $request->validate([
            'guru_balasan' => ['nullable', 'string', 'max:2000'],
        ]);

        $guruBalasan = blank($validated['guru_balasan'] ?? null)
            ? null
            : trim($validated['guru_balasan']);

        $forum->update([
            'guru_balasan' => $guruBalasan,
            'guru_dibalas_pada' => $guruBalasan === null
                ? null
                : ($forum->guru_balasan === $guruBalasan && $forum->guru_dibalas_pada
                    ? $forum->guru_dibalas_pada
                    : now()),
        ]);

        return redirect()
            ->route('admin.forum.index')
            ->with('success', 'Balasan guru berhasil diperbarui.');
    }

    public function destroy(ForumPost $forum): RedirectResponse
    {
        $forum->delete();

        return redirect()
            ->route('admin.forum.index')
            ->with('success', 'Diskusi forum berhasil dihapus.');
    }
}
