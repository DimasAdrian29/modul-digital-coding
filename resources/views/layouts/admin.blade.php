<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Guru')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('images/tut-wuri-handayani.svg') }}" alt="Logo Tut Wuri Handayani" class="sidebar-logo">
                <div>
                    <p>Dashboard Guru</p>
                    <span>Atur materi, soal, dan diskusi</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.materi.index') }}" class="{{ request()->routeIs('admin.materi.*') ? 'active' : '' }}">Materi</a>
                <a href="{{ route('admin.soal.index') }}" class="{{ request()->routeIs('admin.soal.*') ? 'active' : '' }}">Soal Latihan</a>
                <a href="{{ route('admin.forum.index') }}" class="{{ request()->routeIs('admin.forum.*') ? 'active' : '' }}">Diskusi Siswa</a>
                <a href="{{ route('admin.sertifikat.index') }}" class="{{ request()->routeIs('admin.sertifikat.*') ? 'active' : '' }}">Sertifikat</a>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Buka Situs Siswa</a>
            </nav>
        </aside>

        <div class="admin-content">
            <header class="admin-topbar">
                <div>
                    <p class="page-kicker">Halaman Guru</p>
                    <h1>@yield('page_heading', 'Dashboard Guru')</h1>
                    <span class="admin-user-label">{{ auth()->user()?->name }} - {{ ucfirst(auth()->user()?->role) }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline-form">
                    @csrf
                    <button type="submit" class="danger-button">Logout</button>
                </form>
            </header>

            @if (session('error'))
                <div class="alert danger">{{ session('error') }}</div>
            @endif

            @if (session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    @yield('scripts')
</body>
</html>
