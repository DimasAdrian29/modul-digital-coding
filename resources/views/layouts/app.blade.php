<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Modul Digital Informatika')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="student-body">
    <div class="site-shell">
        <header class="topbar">
            <div class="brand">
                <img src="{{ asset('images/tut-wuri-handayani.svg') }}" alt="Logo Tut Wuri Handayani" class="topbar-logo">
                <div>
                    <p class="brand-title">Modul Digital Informatika</p>
                    <span class="brand-subtitle">Belajar informatika lebih terarah dan interaktif</span>
                </div>
            </div>

            <nav class="nav-links">
                @if (in_array(auth()->user()?->role, ['guru', 'admin'], true))
                    <a href="{{ route('admin.dashboard') }}">Dashboard Guru</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="inline-form">
                    @csrf
                    <button type="submit" class="nav-button">Logout</button>
                </form>
            </nav>
        </header>

        <main>
            @if (session('error'))
                <div class="alert danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
