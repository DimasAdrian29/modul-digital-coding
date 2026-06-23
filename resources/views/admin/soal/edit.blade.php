@extends('layouts.admin')

@section('title', 'Edit Soal')
@section('page_heading', 'Edit Soal')

@section('content')
    <section class="panel-card form-panel">
        <div class="panel-header">
            <div>
                <h2>Perbarui Soal</h2>
                <p class="muted">Edit pertanyaan dan pilihan jawaban sesuai kebutuhan.</p>
            </div>
        </div>

        @include('admin.soal.partials.form', [
            'action' => route('admin.soal.update', $soal),
            'method' => 'PUT',
            'soal' => $soal,
            'babOptions' => $babOptions,
        ])
    </section>
@endsection
