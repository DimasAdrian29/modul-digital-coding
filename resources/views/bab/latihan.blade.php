@extends('layouts.app')

@section('title', 'Latihan ' . $babName)

@section('content')
    <section class="page-header student-page-header quiz-page-header">
        <span class="eyebrow">Latihan Bab</span>
        <h1>{{ $babName }}</h1>
        <p>Jawab soal pilihan ganda secara langsung dan lihat hasil nilainya di halaman ini.</p>
        <div class="page-header-actions">
            <a href="{{ route('home') }}" class="secondary-button">Kembali ke Daftar Bab</a>
        </div>
    </section>

    @if ($soalList->isEmpty())
        <div class="empty-state">
            <h3>Belum ada soal</h3>
            <p>Tambahkan soal melalui dashboard admin agar latihan objektif bisa dikerjakan siswa.</p>
        </div>
    @else
        <section
            class="quiz-shell"
            id="quizApp"
            data-bab-name="{{ $babName }}"
            data-attempt-url="{{ route('bab.latihan.store', $babSlug) }}"
            data-complete-url="{{ route('bab.complete', $babSlug) }}"
            data-home-url="{{ route('home') }}"
            data-certificate-show-url="{{ $sertifikat ? route('sertifikat.show', $sertifikat) : '' }}"
            data-certificate-download-url="{{ $sertifikat ? route('sertifikat.download', $sertifikat) : '' }}"
            data-previous-attempt='@json($previousAttempt)'>
            <div class="quiz-progress-card">
                <div class="quiz-progress-orb">
                    <span id="currentQuestion">1</span>
                </div>
                <span class="eyebrow">Progress</span>
                <h3>{{ $soalList->count() }} Tantangan</h3>
                <p>Setiap soal memiliki satu jawaban benar. Pilih jawaban terbaik lalu selesaikan quiz.</p>
                <a href="{{ route('bab.show', $babSlug) }}" class="text-link">Kembali ke ruang bab</a>
            </div>

            <div class="quiz-card">
                @foreach ($soalList as $index => $soal)
                    <article
                        class="question-card {{ $index === 0 ? 'active' : '' }}"
                        data-question
                        data-answer="{{ $soal->jawaban_benar }}">
                        <div class="question-head">
                            <span class="badge">Soal {{ $index + 1 }}</span>
                            <h3>{{ $soal->pertanyaan }}</h3>
                        </div>

                        <div class="option-list">
                            @foreach (['A', 'B', 'C', 'D'] as $opsi)
                                <button
                                    type="button"
                                    class="option-button"
                                    data-option="{{ $opsi }}">
                                    <strong>{{ $opsi }}</strong>
                                    <span>{{ $soal['pilihan_' . strtolower($opsi)] }}</span>
                                </button>
                            @endforeach
                        </div>

                        <div class="question-feedback" data-feedback></div>
                    </article>
                @endforeach

                <div class="quiz-actions">
                    <button type="button" class="secondary-button" id="prevBtn">Sebelumnya</button>
                    <button type="button" class="primary-button" id="nextBtn">Berikutnya</button>
                    <button type="button" class="primary-button hidden" id="finishBtn">Selesai</button>
                </div>

                <div class="result-card hidden" id="resultCard">
                    <span class="eyebrow">Hasil Latihan</span>
                    <h3>Skor Anda: <span id="scoreValue">0</span></h3>
                    <p id="scoreDescription"></p>
                    <p id="completionMessage"></p>
                    <div class="certificate-card hidden" id="certificateCard">
                        <span class="certificate-kicker">Sertifikat Apresiasi</span>
                        <h3>Selamat sudah menyelesaikan latihan</h3>
                        <p id="certificateName">{{ $babName }}</p>
                        <div class="certificate-meta">
                            <span>Skor: <strong id="certificateScore">0 / {{ $soalList->count() }}</strong></span>
                            <span id="certificateStatus">Status latihan tersimpan</span>
                            <span>Tanggal: <strong id="certificateDate"></strong></span>
                        </div>
                        <div class="certificate-actions hidden" id="certificateActions">
                            <a href="{{ $sertifikat ? route('sertifikat.show', $sertifikat) : '#' }}" class="secondary-button" id="viewCertificateBtn">Lihat Sertifikat</a>
                            <a href="{{ $sertifikat ? route('sertifikat.download', $sertifikat) : '#' }}" class="primary-button" id="downloadCertificateBtn">Download PDF</a>
                        </div>
                    </div>
                    <div class="review-list" id="reviewList"></div>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('js/quiz.js') }}"></script>
@endsection
