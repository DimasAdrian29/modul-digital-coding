@extends('layouts.admin')

@section('title', 'Tambah Materi')
@section('page_heading', 'Tambah Materi')

@section('content')
    <section class="panel-card form-panel">
        <div class="panel-header">
            <div>
                <h2>Form Materi Baru</h2>
                <p class="muted">Masukkan judul, deskripsi, bab, dan link video YouTube.</p>
            </div>
        </div>

        @include('admin.materi.partials.form', [
            'action' => route('admin.materi.store'),
            'method' => 'POST',
            'materi' => null,
        ])
    </section>
@endsection
