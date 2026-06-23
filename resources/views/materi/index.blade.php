@extends('layouts.app')

@section('title', 'Daftar Materi')

@section('content')
    <section class="page-header">
        <span class="eyebrow">Daftar Materi</span>
        <h1>Pelajari informatika per bab dengan tampilan sederhana dan terstruktur.</h1>
        <p>Pilih materi yang ingin dipelajari lalu lanjutkan ke video dan penjelasan lengkap.</p>
    </section>

    <section class="card-grid">
        @forelse ($materiList as $materi)
            <article class="learning-card">
                <span class="badge">{{ $materi->bab }}</span>
                <h3>{{ $materi->judul }}</h3>
                <p>{{ Str::limit($materi->deskripsi, 150) }}</p>
                <a href="{{ route('materi.show', $materi) }}" class="card-link">Lihat detail</a>
            </article>
        @empty
            <div class="empty-state full-width">
                <h3>Belum ada materi</h3>
                <p>Guru dapat menambahkan data materi melalui dashboard admin.</p>
            </div>
        @endforelse
    </section>
@endsection
