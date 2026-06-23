@extends('layouts.admin')

@section('title', 'Materi')
@section('page_heading', 'Daftar Materi')

@section('content')
    <section class="panel-card">
        <div class="panel-header">
            <div>
                <h2>Daftar Materi</h2>
                <p class="muted">Tambah, ubah, atau hapus materi yang akan dibaca siswa.</p>
            </div>
            <a href="{{ route('admin.materi.create') }}" class="primary-button">Tambah Materi</a>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Bab</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Video</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($materiList as $materi)
                        <tr>
                            <td>{{ $materi->bab }}</td>
                            <td>{{ $materi->judul }}</td>
                            <td>{{ Str::limit($materi->deskripsi, 80) }}</td>
                            <td>
                                @if (filled($materi->video_url))
                                    <a href="{{ $materi->video_url }}" target="_blank" rel="noopener">YouTube</a>
                                @else
                                    <span class="muted">Belum ada</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.materi.edit', $materi) }}" class="ghost-button">Edit</a>
                                    <form action="{{ route('admin.materi.destroy', $materi) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="danger-button" onclick="return confirm('Hapus materi ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada data materi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
