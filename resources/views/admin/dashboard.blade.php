@extends('layouts.admin')

@section('title', 'Dashboard Guru')
@section('page_heading', 'Dashboard Guru')

@section('content')
    <section class="admin-stats">
        <article class="admin-stat-card">
            <span>Total Materi</span>
            <strong>{{ $totalMateri }}</strong>
            <p>Jumlah materi yang bisa dibaca siswa.</p>
        </article>
        <article class="admin-stat-card">
            <span>Total Soal</span>
            <strong>{{ $totalSoal }}</strong>
            <p>Jumlah soal latihan untuk siswa.</p>
        </article>
        <article class="admin-stat-card">
            <span>Total Diskusi</span>
            <strong>{{ $totalForumPost }}</strong>
            <p>Jumlah pertanyaan atau diskusi dari siswa.</p>
        </article>
        <article class="admin-stat-card">
            <span>Total Sertifikat</span>
            <strong>{{ $totalSertifikat }}</strong>
            <p>Jumlah sertifikat yang sudah didapat siswa.</p>
        </article>
    </section>

    <section class="dashboard-analytics">
        <div class="panel-card analytics-card wide-analytics">
            <div class="panel-header">
                <div>
                    <span class="eyebrow">Kelengkapan Bab</span>
                    <h2>Bab yang sudah siap digunakan</h2>
                </div>
            </div>

            <div class="status-overview">
                @foreach ([
                    ['label' => 'Bab siap dipakai', 'value' => $readyBabCount, 'hint' => $activeBabCount . ' total bab', 'tone' => 'ready'],
                    ['label' => 'Bab belum lengkap', 'value' => $needsQuestionBabCount, 'hint' => 'perlu ditambah soal', 'tone' => 'warning'],
                ] as $item)
                    <article class="status-tile {{ $item['tone'] }}">
                        <span>{{ $item['label'] }}</span>
                        <strong>{{ $item['value'] }}</strong>
                        <small>{{ $item['hint'] }}</small>
                    </article>
                @endforeach
            </div>

            <div class="bar-chart-list compact-bars">
                @foreach ([
                    ['label' => 'Bab siap', 'value' => $readyBabCount, 'total' => $activeBabCount, 'class' => 'green'],
                    ['label' => 'Bab belum lengkap', 'value' => $needsQuestionBabCount, 'total' => $activeBabCount, 'class' => 'yellow'],
                ] as $item)
                    <div class="bar-chart-row">
                        <span>{{ $item['label'] }}</span>
                        <div class="bar-track">
                            <div class="bar-fill {{ $item['class'] }}" style="width: {{ $item['total'] > 0 ? max(8, ($item['value'] / $item['total']) * 100) : 8 }}%"></div>
                        </div>
                        <strong>{{ $item['value'] }}/{{ $item['total'] }}</strong>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel-card analytics-card">
            <div class="panel-header">
                <div>
                    <span class="eyebrow">Forum</span>
                    <h2>Pertanyaan siswa</h2>
                </div>
            </div>

            <div class="metric-stack">
                <div class="metric-pill">
                    <strong>{{ $forumAnsweredPercent }}%</strong>
                    <span>diskusi sudah dibalas</span>
                </div>
                <div class="metric-pill warning">
                    <strong>{{ $unansweredForum }}</strong>
                    <span>belum dijawab</span>
                </div>
            </div>

            <div class="bar-chart-list compact-bars">
                @foreach ([
                    ['label' => 'Sudah dibalas', 'value' => $answeredForum, 'total' => $totalForumPost, 'class' => 'blue'],
                    ['label' => 'Menunggu balasan', 'value' => $unansweredForum, 'total' => $totalForumPost, 'class' => 'yellow'],
                ] as $item)
                    <div class="bar-chart-row">
                        <span>{{ $item['label'] }}</span>
                        <div class="bar-track">
                            <div class="bar-fill {{ $item['class'] }}" style="width: {{ $item['total'] > 0 ? max(8, ($item['value'] / $item['total']) * 100) : 8 }}%"></div>
                        </div>
                        <strong>{{ $item['value'] }}</strong>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel-card analytics-card">
            <div class="panel-header">
                <div>
                    <span class="eyebrow">Siswa</span>
                    <h2>Siswa yang sudah dapat sertifikat</h2>
                </div>
            </div>

            <div class="metric-stack">
                <div class="metric-pill">
                    <strong>{{ $certificateStudentPercent }}%</strong>
                    <span>siswa sudah punya sertifikat</span>
                </div>
                <div class="metric-pill info">
                    <strong>{{ $studentsWithCertificates }}/{{ $totalStudents }}</strong>
                    <span>siswa sudah dapat sertifikat</span>
                </div>
            </div>

            <div class="mini-list">
                @forelse ($latestCertificates as $certificate)
                    <div>
                        <strong>{{ $certificate->nama_siswa }}</strong>
                        <span>{{ $certificate->nama_materi }} - {{ number_format((float) $certificate->nilai_akhir, 2) }}%</span>
                    </div>
                @empty
                    <p class="muted">Belum ada sertifikat diterbitkan.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="panel-card">
        <div class="panel-header">
            <div>
                <span class="eyebrow">Daftar Bab</span>
                <h2>Kelengkapan setiap bab</h2>
            </div>
        </div>

        <div class="chapter-insight-list">
            @forelse ($babInsights as $item)
                <article class="chapter-insight-card">
                    <div class="chapter-insight-head">
                        <div>
                            <span class="badge">{{ $item['bab'] }}</span>
                            <h3>{{ $item['status_label'] }}</h3>
                        </div>
                        <strong>{{ $item['readiness_percent'] }}%</strong>
                    </div>

                    <div class="bar-track">
                        <div class="bar-fill {{ $item['status_tone'] === 'ready' ? 'green' : ($item['status_tone'] === 'warning' ? 'yellow' : 'navy') }}" style="width: {{ max(8, $item['readiness_percent']) }}%"></div>
                    </div>

                    <div class="chapter-insight-metrics">
                        <span>{{ $item['materi'] }} materi</span>
                        <span>{{ $item['soal'] }} soal</span>
                        <span>{{ $item['forum'] }} diskusi</span>
                        <span>{{ $item['sertifikat'] }} sertifikat</span>
                    </div>

                    <p class="chapter-insight-note">Siswa yang sudah dapat sertifikat: {{ $item['student_reach_percent'] }}%</p>
                </article>
            @empty
                <p class="muted">Belum ada data bab.</p>
            @endforelse
        </div>
    </section>

@endsection
