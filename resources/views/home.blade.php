@extends('layouts.app')

@section('title', 'Beranda | Modul Digital Informatika')

@section('content')
    <section class="hero">
        <div class="hero-copy">
            <span class="eyebrow">Platform Belajar Informatika</span>
            <h1>Mulai misi informatika kamu satu bab demi satu bab.</h1>
            <p>
                Pelajari materi, kerjakan latihan, diskusi dengan teman, lalu buka bab berikutnya
                seperti menyelesaikan level belajar.
            </p>
            <div class="hero-actions">
                <a href="#daftar-bab" class="secondary-button">Pilih Bab</a>
            </div>
        </div>

        <div class="hero-panel student-mission-panel">
            <div class="mission-orbit">
                <div class="mission-core">{{ $babList->where('is_completed', true)->count() }}/{{ max($babList->count(), 1) }}</div>
                <span class="orbit-dot dot-one"></span>
                <span class="orbit-dot dot-two"></span>
                <span class="orbit-dot dot-three"></span>
            </div>
            <div>
                <p class="panel-label">Progress Misi</p>
                <h3>Buka bab berikutnya dengan nilai latihan minimal 80%</h3>
                <div class="mission-stats">
                    <span>{{ $totalMateri }} materi</span>
                    <span>{{ $totalSoal }} soal</span>
                    <span>{{ $sertifikatList->count() }} sertifikat</span>
                </div>
            </div>
        </div>
    </section>

    @if ($sertifikatList->isNotEmpty())
        <section class="section-block">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Sertifikat Saya</span>
                    <h2>Download ulang sertifikat latihan yang sudah lulus</h2>
                </div>
            </div>

            <div class="certificate-list">
                @foreach ($sertifikatList as $sertifikat)
                    <article class="certificate-list-card">
                        <div>
                            <span class="badge">{{ $sertifikat->nomor_sertifikat }}</span>
                            <h3>{{ $sertifikat->nama_materi }}</h3>
                            <p>Nilai akhir {{ number_format((float) $sertifikat->nilai_akhir, 2) }}% pada {{ $sertifikat->tanggal_selesai->translatedFormat('d F Y') }}.</p>
                        </div>
                        <div class="certificate-actions">
                            <a href="{{ route('sertifikat.show', $sertifikat) }}" class="secondary-button">Lihat Sertifikat</a>
                            <a href="{{ route('sertifikat.download', $sertifikat) }}" class="primary-button">Download PDF</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <section class="section-block" id="daftar-bab">
        @if (session('locked_bab_message'))
            <div class="alert danger">
                {{ session('locked_bab_message') }}
            </div>
        @endif

        <div class="section-heading">
            <div>
                <span class="eyebrow">Daftar Bab</span>
                <h2>Pilih bab pembelajaran yang ingin dipelajari siswa</h2>
            </div>
        </div>

        <div class="card-grid">
            @forelse ($babList as $bab)
                <article class="learning-card {{ $bab['is_locked'] ? 'locked-card' : '' }}">
                    <div class="learning-card-top">
                        <div class="chapter-orb">{{ $loop->iteration }}</div>
                        <div>
                            <span class="badge">{{ $bab['nama'] }}</span>
                            <span class="status-badge {{ $bab['is_completed'] ? 'completed' : ($bab['is_locked'] ? 'locked' : 'open') }}">
                                {{ $bab['status_label'] }}
                            </span>
                        </div>
                    </div>
                    <h3>{{ $bab['judul_utama'] ?? 'Bab Pembelajaran' }}</h3>
                    <p>{{ $bab['deskripsi'] }}</p>
                    <div class="card-meta">{{ $bab['jumlah_materi'] }} materi tersedia</div>
                    @if ($bab['is_locked'])
                        <span class="card-link muted-link">Selesaikan bab sebelumnya</span>
                    @else
                        <a href="{{ route('bab.show', $bab['slug']) }}" class="card-link">Mulai Bab</a>
                    @endif
                </article>
            @empty
                <div class="empty-state">
                    <h3>Bab belum tersedia</h3>
                    <p>Tambahkan materi dari dashboard admin agar daftar bab otomatis terbentuk.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
