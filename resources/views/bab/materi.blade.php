@extends('layouts.app')

@section('title', 'Materi ' . $babName)

@section('content')
    <section class="page-header student-page-header material-page-header">
        <span class="eyebrow">Materi Bab</span>
        <h1>{{ $babName }}</h1>
        <p>Daftar materi lengkap beserta video pembelajaran untuk bab ini.</p>
        <div class="page-header-actions">
            <a href="{{ route('home') }}" class="secondary-button">Kembali ke Daftar Bab</a>
        </div>
    </section>

    <section class="section-block">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Daftar Materi</span>
                <h2>Pilih materi yang ingin dipelajari</h2>
            </div>
            <a href="{{ route('bab.show', $babSlug) }}" class="text-link">Kembali ke ruang bab</a>
        </div>

        <div class="card-grid material-card-grid">
            @forelse ($materiList as $materi)
                <a href="{{ route('materi.show', $materi) }}" class="learning-card clickable-card material-card">
                    <div class="learning-card-top">
                        <div class="chapter-orb">{{ $loop->iteration }}</div>
                        <span class="badge">{{ $materi->bab }}</span>
                    </div>
                    <h3>{{ $materi->judul }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($materi->deskripsi, 140) }}</p>
                    <span class="card-link">Buka Materi</span>
                </a>
            @empty
                <div class="empty-state">
                    <h3>Materi belum tersedia</h3>
                    <p>Bab ini sudah ada, tetapi isi materi dan video belum ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
