<form action="{{ $action }}" method="POST" class="dashboard-form">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="form-grid">
        <div class="form-group">
            <label for="judul">Judul Materi</label>
            <input type="text" id="judul" name="judul" value="{{ old('judul', $materi->judul ?? '') }}" required>
            @error('judul')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="bab">Bab</label>
            <input type="text" id="bab" name="bab" value="{{ old('bab', $materi->bab ?? '') }}" required>
            @error('bab')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="6" required>{{ old('deskripsi', $materi->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="video_url">Link Video YouTube</label>
        <input type="url" id="video_url" name="video_url" value="{{ old('video_url', $materi->video_url ?? '') }}" placeholder="Boleh dikosongkan">
        @error('video_url')
            <small class="error-text">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.materi.index') }}" class="ghost-button">Batal</a>
        <button type="submit" class="primary-button">Simpan Materi</button>
    </div>
</form>
