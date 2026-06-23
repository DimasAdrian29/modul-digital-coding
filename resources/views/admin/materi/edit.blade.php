@extends('layouts.admin')

@section('title', 'Edit Materi')
@section('page_heading', 'Edit Materi')

@section('content')
    <section class="panel-card form-panel">
        <div class="panel-header">
            <div>
                <h2>Perbarui Materi</h2>
                <p class="muted">Ubah konten materi dan simpan pembaruan.</p>
            </div>
        </div>

        @include('admin.materi.partials.form', [
            'action' => route('admin.materi.update', $materi),
            'method' => 'PUT',
            'materi' => $materi,
        ])
    </section>
@endsection
