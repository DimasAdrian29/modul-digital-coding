@extends('layouts.admin')

@section('title', 'Edit Forum')
@section('page_heading', 'Edit Diskusi Forum')

@section('content')
    <section class="panel-card">
        <div class="panel-header">
            <div>
                <h2>Balas Pertanyaan Siswa</h2>
                <p class="muted">Pertanyaan siswa ditampilkan sebagai referensi dan tidak dapat diubah dari halaman guru.</p>
            </div>
        </div>

        <div class="forum-question-preview">
            <div class="forum-question-preview-head">
                <div>
                    <span class="badge">{{ $forumPost->bab }}</span>
                    <h3>{{ $forumPost->judul }}</h3>
                    <p class="muted">Oleh {{ $forumPost->nama }} • {{ $forumPost->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
            <p>{{ $forumPost->isi }}</p>
        </div>

        <form action="{{ route('admin.forum.update', $forumPost) }}" method="POST" class="dashboard-form">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="guru_balasan">Balasan Guru</label>
                    <textarea
                        id="guru_balasan"
                        name="guru_balasan"
                        rows="6"
                        placeholder="Tulis jawaban, arahan, atau umpan balik guru untuk pertanyaan siswa ini.">{{ old('guru_balasan', $forumPost->guru_balasan) }}</textarea>
                    @error('guru_balasan')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="primary-button">Simpan Balasan</button>
                <a href="{{ route('admin.forum.index') }}" class="ghost-button">Kembali</a>
            </div>
        </form>
    </section>
@endsection
