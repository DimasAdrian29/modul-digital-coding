@extends('layouts.admin')

@section('title', 'Soal Latihan')
@section('page_heading', 'Daftar Soal Latihan')

@section('content')
    <section class="panel-card">
        <div class="panel-header">
            <div>
                <h2>Daftar Soal Latihan</h2>
                <p class="muted">Tambah, ubah, atau hapus soal yang akan dikerjakan siswa.</p>
            </div>
            <a href="{{ route('admin.soal.create') }}" class="primary-button">Tambah Soal</a>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Bab</th>
                        <th>Pertanyaan</th>
                        <th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>Jawaban</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($soalList as $soal)
                        <tr>
                            <td>{{ $soal->bab }}</td>
                            <td>{{ Str::limit($soal->pertanyaan, 60) }}</td>
                            <td>{{ Str::limit($soal->pilihan_a, 20) }}</td>
                            <td>{{ Str::limit($soal->pilihan_b, 20) }}</td>
                            <td>{{ Str::limit($soal->pilihan_c, 20) }}</td>
                            <td>{{ Str::limit($soal->pilihan_d, 20) }}</td>
                            <td>{{ $soal->jawaban_benar }}</td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.soal.edit', $soal) }}" class="ghost-button">Edit</a>
                                    <form action="{{ route('admin.soal.destroy', $soal) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="danger-button" onclick="return confirm('Hapus soal ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Belum ada data soal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
