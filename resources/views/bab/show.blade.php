@extends('layouts.app')

@section('title', $babName . ' | Ruang Belajar')

@section('content')
    <section class="page-header">
        <span class="eyebrow">Ruang Belajar</span>
        <h1>{{ $babName }}</h1>
        <p>Di dalam bab ini siswa dapat memilih materi pembelajaran, latihan soal, atau forum diskusi.</p>
        <div class="page-header-actions">
            <a href="{{ route('home') }}" class="secondary-button">Kembali ke Daftar Bab</a>
        </div>
    </section>

    <section class="choice-grid">
        <a href="{{ $firstMateri ? route('materi.show', $firstMateri) : route('bab.materi', $babSlug) }}" class="choice-card">
            <span class="choice-icon">01</span>
            <h3>Materi</h3>
            <p>Buka daftar materi lengkap beserta video pembelajaran pada bab ini.</p>
        </a>
        <a href="{{ route('bab.latihan', $babSlug) }}" class="choice-card">
            <span class="choice-icon">02</span>
            <h3>Latihan</h3>
            <p>Kerjakan latihan interaktif untuk menguji pemahaman setelah belajar.</p>
        </a>
        <a href="{{ route('bab.forum', $babSlug) }}" class="choice-card">
            <span class="choice-icon">03</span>
            <h3>Forum Diskusi</h3>
            <p>Lihat ruang tanya jawab dan diskusi yang berkaitan dengan bab ini.</p>
        </a>
    </section>
@endsection
