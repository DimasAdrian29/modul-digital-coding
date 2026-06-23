@extends('layouts.admin')

@section('title', 'Tambah Soal')
@section('page_heading', 'Tambah Soal')

@section('content')
    <section class="panel-card form-panel">
        <div class="panel-header">
            <div>
                <h2>Form Soal Baru</h2>
                <p class="muted">Pilih bab lalu masukkan beberapa soal sekaligus.</p>
            </div>
            <button type="button" class="ghost-button" id="addQuestionBtn">Tambah Baris Soal</button>
        </div>

        <form action="{{ route('admin.soal.store') }}" method="POST" class="dashboard-form" id="bulkQuestionForm">
            @csrf

            <div class="question-form-list" id="questionFormList">
                @php
                    $oldQuestions = old('questions', [
                        [
                            'bab' => '',
                            'pertanyaan' => '',
                            'pilihan_a' => '',
                            'pilihan_b' => '',
                            'pilihan_c' => '',
                            'pilihan_d' => '',
                            'jawaban_benar' => '',
                        ],
                    ]);
                @endphp

                @foreach ($oldQuestions as $index => $question)
                    <div class="bulk-question-card" data-question-row>
                        <div class="bulk-question-head">
                            <h3>Soal <span data-question-number>{{ $index + 1 }}</span></h3>
                            <button type="button" class="danger-button" data-remove-question>Hapus</button>
                        </div>

                        <div class="form-group">
                            <label for="questions_{{ $index }}_bab" data-field-label="bab">Bab</label>
                            <select id="questions_{{ $index }}_bab" name="questions[{{ $index }}][bab]" data-field="bab" required>
                                <option value="">Pilih bab</option>
                                @foreach ($babOptions as $bab)
                                    <option value="{{ $bab }}" @selected(($question['bab'] ?? '') === $bab)>{{ $bab }}</option>
                                @endforeach
                            </select>
                            @error("questions.$index.bab")
                                <small class="error-text">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="questions_{{ $index }}_pertanyaan" data-field-label="pertanyaan">Pertanyaan</label>
                            <textarea id="questions_{{ $index }}_pertanyaan" name="questions[{{ $index }}][pertanyaan]" data-field="pertanyaan" rows="4" required>{{ $question['pertanyaan'] ?? '' }}</textarea>
                            @error("questions.$index.pertanyaan")
                                <small class="error-text">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-grid">
                            @foreach (['a' => 'Pilihan A', 'b' => 'Pilihan B', 'c' => 'Pilihan C', 'd' => 'Pilihan D'] as $key => $label)
                                <div class="form-group">
                                    <label for="questions_{{ $index }}_pilihan_{{ $key }}" data-field-label="pilihan_{{ $key }}">{{ $label }}</label>
                                    <input
                                        type="text"
                                        id="questions_{{ $index }}_pilihan_{{ $key }}"
                                        name="questions[{{ $index }}][pilihan_{{ $key }}]"
                                        data-field="pilihan_{{ $key }}"
                                        value="{{ $question['pilihan_' . $key] ?? '' }}"
                                        required>
                                    @error("questions.$index.pilihan_$key")
                                        <small class="error-text">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="questions_{{ $index }}_jawaban_benar" data-field-label="jawaban_benar">Jawaban Benar</label>
                            <select id="questions_{{ $index }}_jawaban_benar" name="questions[{{ $index }}][jawaban_benar]" data-field="jawaban_benar" required>
                                <option value="">Pilih jawaban</option>
                                @foreach (['A', 'B', 'C', 'D'] as $jawaban)
                                    <option value="{{ $jawaban }}" @selected(($question['jawaban_benar'] ?? '') === $jawaban)>{{ $jawaban }}</option>
                                @endforeach
                            </select>
                            @error("questions.$index.jawaban_benar")
                                <small class="error-text">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.soal.index') }}" class="ghost-button">Batal</a>
                <button type="submit" class="primary-button">Simpan Semua Soal</button>
            </div>
        </form>
    </section>
@endsection

@section('scripts')
    <template id="questionRowTemplate">
        <div class="bulk-question-card" data-question-row>
            <div class="bulk-question-head">
                <h3>Soal <span data-question-number></span></h3>
                <button type="button" class="danger-button" data-remove-question>Hapus</button>
            </div>

            <div class="form-group">
                <label data-field-label="bab">Bab</label>
                <select data-field="bab" required>
                    <option value="">Pilih bab</option>
                    @foreach ($babOptions as $bab)
                        <option value="{{ $bab }}">{{ $bab }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label data-field-label="pertanyaan">Pertanyaan</label>
                <textarea data-field="pertanyaan" rows="4" required></textarea>
            </div>

            <div class="form-grid">
                @foreach (['a' => 'Pilihan A', 'b' => 'Pilihan B', 'c' => 'Pilihan C', 'd' => 'Pilihan D'] as $key => $label)
                    <div class="form-group">
                        <label data-field-label="pilihan_{{ $key }}">{{ $label }}</label>
                        <input type="text" data-field="pilihan_{{ $key }}" required>
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <label data-field-label="jawaban_benar">Jawaban Benar</label>
                <select data-field="jawaban_benar" required>
                    <option value="">Pilih jawaban</option>
                    @foreach (['A', 'B', 'C', 'D'] as $jawaban)
                        <option value="{{ $jawaban }}">{{ $jawaban }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </template>
    <script src="{{ asset('js/admin-soal.js') }}"></script>
@endsection
