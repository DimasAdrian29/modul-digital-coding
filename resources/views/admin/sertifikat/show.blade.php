@extends('layouts.admin')

@section('title', 'Sertifikat ' . $sertifikat->nama_siswa)
@section('page_heading', 'Preview Sertifikat')

@section('content')
    <section class="panel-card">
        <div class="panel-header">
            <div>
                <span class="eyebrow">Sertifikat Digital</span>
                <h2>{{ $sertifikat->nama_materi }}</h2>
                <p class="muted">{{ $sertifikat->nomor_sertifikat }} - {{ $sertifikat->nama_siswa }}</p>
            </div>
            <div class="certificate-actions">
                <a href="{{ route('admin.sertifikat.index') }}" class="secondary-button">Kembali ke Daftar</a>
                <a href="{{ route('sertifikat.download', $sertifikat) }}" class="primary-button">Download PDF</a>
            </div>
        </div>

        <div class="admin-certificate-preview">
            @include('sertifikat.partials.card', ['sertifikat' => $sertifikat, 'detail' => $detail])
        </div>
    </section>
@endsection
