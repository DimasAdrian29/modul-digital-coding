<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Modul Digital Informatika</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="login-body">
    <main class="login-shell">
        <section class="login-visual">
            <img src="{{ asset('images/tut-wuri-handayani.svg') }}" alt="Logo Tut Wuri Handayani" class="login-logo">
            <span class="eyebrow">Modul Digital Informatika</span>
            <h1>Satu pintu masuk untuk semua akun.</h1>
            <p>Siswa masuk ke dashboard belajar, sedangkan guru masuk ke panel pengelolaan modul.</p>
        </section>

        <section class="login-card">
            <div class="login-card-head">
                <span class="eyebrow">Login</span>
                <h2>Masuk ke akun Anda</h2>
            </div>

            @if (session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert danger">
                    <strong>Login belum berhasil.</strong>
                    <p>Periksa kembali email dan password yang Anda isi.</p>
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <label class="checkbox-field">
                    <input type="checkbox" name="remember" value="1">
                    <span>Ingat saya</span>
                </label>

                <button type="submit" class="primary-button full-button">Masuk</button>

                <p class="auth-switch">
                    Belum punya akun?
                    <a href="{{ route('register') }}">Daftar sekarang</a>
                </p>
            </form>
        </section>
    </main>
</body>
</html>
