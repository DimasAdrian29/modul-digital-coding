@extends('layouts.admin')

@section('title', 'Daftar Sertifikat')
@section('page_heading', 'Daftar Sertifikat')

@section('content')
    <section class="panel-card">
        <div class="panel-header">
            <div>
                <span class="eyebrow">Sertifikat Siswa</span>
                <h2>Sertifikat yang sudah diterbitkan</h2>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Siswa</th>
                        <th>Materi</th>
                        <th>Nilai</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sertifikatList as $sertifikat)
                        <tr>
                            <td>{{ $sertifikat->nomor_sertifikat }}</td>
                            <td>
                                <strong>{{ $sertifikat->nama_siswa }}</strong><br>
                                <span class="muted">{{ $sertifikat->kelas ?? '-' }} / {{ $sertifikat->jurusan ?? '-' }}</span>
                            </td>
                            <td>{{ $sertifikat->nama_materi }}</td>
                            <td>{{ number_format((float) $sertifikat->nilai_akhir, 2) }}%</td>
                            <td>{{ $sertifikat->tanggal_selesai->translatedFormat('d F Y') }}</td>
                            <td>
                                <a href="{{ route('sertifikat.show', $sertifikat) }}" class="text-link">Lihat</a>
                                <br>
                                <a href="{{ route('sertifikat.download', $sertifikat) }}" class="text-link">Download</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Belum ada sertifikat yang diterbitkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
