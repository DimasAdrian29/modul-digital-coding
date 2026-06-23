@extends('layouts.admin')

@section('title', 'Diskusi Siswa')
@section('page_heading', 'Diskusi Siswa')

@section('content')
    <section class="panel-card">
        <div class="panel-header">
            <div>
                <h2>Daftar Diskusi Siswa</h2>
                <p class="muted">Lihat pertanyaan siswa, beri jawaban, atau hapus diskusi yang tidak diperlukan.</p>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Bab</th>
                        <th>Nama</th>
                        <th>Judul</th>
                        <th>Isi</th>
                        <th>Status Balasan</th>
                        <th>Dibuat</th>
                        <th>Dibalas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($forumPosts as $forumPost)
                        <tr>
                            <td>{{ $forumPost->bab }}</td>
                            <td>{{ $forumPost->nama }}</td>
                            <td>{{ $forumPost->judul }}</td>
                            <td>{{ Str::limit($forumPost->isi, 100) }}</td>
                            <td>{{ $forumPost->guru_balasan ? 'Sudah dibalas' : 'Belum dibalas' }}</td>
                            <td>{{ $forumPost->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $forumPost->guru_dibalas_pada?->format('d M Y H:i') ?? '-' }}</td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.forum.edit', $forumPost) }}" class="ghost-button">{{ $forumPost->guru_balasan ? 'Lihat / Edit Balasan' : 'Balas' }}</a>
                                    <form action="{{ route('admin.forum.destroy', $forumPost) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="danger-button" onclick="return confirm('Hapus diskusi forum ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Belum ada diskusi forum.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
