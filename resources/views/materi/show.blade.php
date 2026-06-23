@extends('layouts.app')

@section('title', $materi->judul)

@section('content')
    <section class="detail-layout">
        <article class="detail-card material-detail-card">
            <span class="badge">{{ $materi->bab }}</span>
            <h1>{{ $materi->judul }}</h1>
            <p class="detail-copy">{{ $materi->deskripsi }}</p>

            @if (filled($materi->video_url))
                <div class="video-frame">
                    <iframe
                        src="{{ $materi->embed_video_url }}"
                        title="{{ $materi->judul }}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            @endif

            <div class="detail-actions">
                <a href="{{ route('bab.show', $babSlug) }}" class="secondary-button">Kembali ke Pilihan Bab</a>
                <a href="{{ route('home') }}" class="secondary-button">Kembali ke Daftar Bab</a>
            </div>
        </article>
    </section>
@endsection
