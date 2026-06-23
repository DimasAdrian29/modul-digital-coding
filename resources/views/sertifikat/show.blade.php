<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat {{ $sertifikat->nama_materi }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        @include('sertifikat.partials.fixed-style')
    </style>
</head>
<body class="certificate-preview-body-page">
    <main class="certificate-fullscreen">
        <header class="certificate-topbar">
            <div>
                <span class="certificate-mini-label">Sertifikat Digital</span>
                <h1>{{ $sertifikat->nama_materi }}</h1>
                <p>{{ $sertifikat->nomor_sertifikat }}</p>
            </div>
            <div class="certificate-toolbar-actions">
                <a href="{{ route('home') }}" class="certificate-ghost-button">Kembali</a>
                <a href="{{ route('sertifikat.download', $sertifikat) }}" class="certificate-download-button">Download PDF</a>
            </div>
        </header>

        <section class="certificate-pages">
            @include('sertifikat.partials.card', ['sertifikat' => $sertifikat, 'detail' => $detail])
        </section>
    </main>
</body>
</html>
