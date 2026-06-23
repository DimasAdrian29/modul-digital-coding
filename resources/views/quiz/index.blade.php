@extends('layouts.app')

@section('title', 'Latihan Soal Interaktif')

@section('content')
    <section class="page-header">
        <span class="eyebrow">Quiz Interaktif</span>
        <h1>Uji pemahaman informatika dengan latihan soal interaktif.</h1>
        <p>Pilih jawaban terbaik, lalu lihat hasil skor secara otomatis di akhir sesi.</p>
    </section>

    @if ($soalList->isEmpty())
        <div class="empty-state">
            <h3>Belum ada soal</h3>
            <p>Tambahkan soal dari dashboard admin untuk mengaktifkan fitur quiz.</p>
        </div>
    @else
        <section class="quiz-shell" id="quizApp">
            <div class="quiz-progress-card">
                <span class="eyebrow">Progress</span>
                <h3><span id="currentQuestion">1</span> / {{ $soalList->count() }}</h3>
                <p>Jawab semua soal, lalu tekan tombol selesai untuk melihat nilai.</p>
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
                    <span class="eyebrow">Hasil Quiz</span>
                    <h3>Skor Anda: <span id="scoreValue">0</span></h3>
                    <p id="scoreDescription"></p>
                    <div class="review-list" id="reviewList"></div>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('js/quiz.js') }}"></script>
@endsection
