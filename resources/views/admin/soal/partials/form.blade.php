<form action="{{ $action }}" method="POST" class="dashboard-form">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="form-group">
        <label for="bab">Bab</label>
        <select id="bab" name="bab" required>
            <option value="">Pilih bab</option>
            @foreach ($babOptions as $bab)
                <option value="{{ $bab }}" @selected(old('bab', $soal->bab ?? '') === $bab)>{{ $bab }}</option>
            @endforeach
        </select>
        @error('bab')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="pertanyaan">Pertanyaan</label>
        <textarea id="pertanyaan" name="pertanyaan" rows="4" required>{{ old('pertanyaan', $soal->pertanyaan ?? '') }}</textarea>
        @error('pertanyaan')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-grid">
        @foreach (['a' => 'Pilihan A', 'b' => 'Pilihan B', 'c' => 'Pilihan C', 'd' => 'Pilihan D'] as $key => $label)
            <div class="form-group">
                <label for="pilihan_{{ $key }}">{{ $label }}</label>
                <input
                    type="text"
                    id="pilihan_{{ $key }}"
                    name="pilihan_{{ $key }}"
                    value="{{ old('pilihan_' . $key, $soal->{'pilihan_' . $key} ?? '') }}"
                    required>
                @error('pilihan_' . $key)
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>
        @endforeach
    </div>

    <div class="form-group">
        <label for="jawaban_benar">Jawaban Benar</label>
        <select id="jawaban_benar" name="jawaban_benar" required>
            <option value="">Pilih jawaban</option>
            @foreach (['A', 'B', 'C', 'D'] as $jawaban)
                <option value="{{ $jawaban }}" @selected(old('jawaban_benar', $soal->jawaban_benar ?? '') === $jawaban)>{{ $jawaban }}</option>
            @endforeach
        </select>
        @error('jawaban_benar')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.soal.index') }}" class="ghost-button">Batal</a>
        <button type="submit" class="primary-button">Simpan Soal</button>
    </div>
</form>
