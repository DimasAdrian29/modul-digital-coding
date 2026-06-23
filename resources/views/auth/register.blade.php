<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register | Modul Digital Informatika</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="login-body">
    <main class="login-shell register-shell">
        <section class="login-visual">
            <img src="{{ asset('images/tut-wuri-handayani.svg') }}" alt="Logo Tut Wuri Handayani" class="login-logo">
            <span class="eyebrow">Registrasi</span>
            <h1>Buat akun sesuai peran Anda.</h1>
            <p>Pilih Siswa untuk belajar materi dan latihan, atau Guru untuk mengelola konten pembelajaran.</p>
        </section>

        <section class="login-card">
            <div class="login-card-head">
                <span class="eyebrow">Buat Akun</span>
                <h2>Lengkapi data registrasi</h2>
            </div>

            @if ($errors->any())
                <div class="alert danger">
                    <strong>Registrasi belum berhasil.</strong>
                    <p>Periksa kembali data yang Anda isi.</p>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST" class="login-form" id="registerForm">
                @csrf

                <div class="role-picker" role="radiogroup" aria-label="Pilihan jenis akun">
                    <label class="role-option {{ old('account_type', 'siswa') === 'siswa' ? 'active' : '' }}">
                        <input type="radio" name="account_type" value="siswa" {{ old('account_type', 'siswa') === 'siswa' ? 'checked' : '' }}>
                        <span>Siswa</span>
                    </label>
                    <label class="role-option {{ old('account_type') === 'guru' ? 'active' : '' }}">
                        <input type="radio" name="account_type" value="guru" {{ old('account_type') === 'guru' ? 'checked' : '' }}>
                        <span>Guru</span>
                    </label>
                </div>
                @error('account_type')
                    <span class="field-error">{{ $message }}</span>
                @enderror

                <div class="form-group">
                    <label for="name">Nama lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="account-fields" data-account-fields="siswa">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nis_nisn">NIS/NISN</label>
                            <input type="text" id="nis_nisn" name="nis_nisn" value="{{ old('nis_nisn') }}" placeholder="Masukkan NIS/NISN">
                            @error('nis_nisn')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <input type="text" id="kelas" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: XI">
                            @error('kelas')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="jurusan">Jurusan</label>
                            <input type="text" id="jurusan" name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: RPL">
                            @error('jurusan')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="account-fields hidden" data-account-fields="guru">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nip_nuptk">NIP/NUPTK</label>
                            <input type="text" id="nip_nuptk" name="nip_nuptk" value="{{ old('nip_nuptk') }}" placeholder="Masukkan NIP/NUPTK">
                            @error('nip_nuptk')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Guru Mapel">
                            @error('jabatan')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="mata_pelajaran">Mata pelajaran / bidang keahlian</label>
                            <input type="text" id="mata_pelajaran" name="mata_pelajaran" value="{{ old('mata_pelajaran') }}" placeholder="Contoh: Pemrograman Dasar">
                            @error('mata_pelajaran')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>
                </div>

                <button type="submit" class="primary-button full-button">Daftar</button>

                <p class="auth-switch">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">Login</a>
                </p>
            </form>
        </section>
    </main>

    <script>
        const roleOptions = [...document.querySelectorAll('.role-option')];
        const accountFields = [...document.querySelectorAll('[data-account-fields]')];

        const syncAccountType = () => {
            const selected = document.querySelector('input[name="account_type"]:checked')?.value ?? 'siswa';

            roleOptions.forEach((option) => {
                option.classList.toggle('active', option.querySelector('input')?.value === selected);
            });

            accountFields.forEach((fieldGroup) => {
                const isActive = fieldGroup.dataset.accountFields === selected;
                fieldGroup.classList.toggle('hidden', ! isActive);
                fieldGroup.querySelectorAll('input').forEach((input) => {
                    input.required = isActive;
                });
            });
        };

        roleOptions.forEach((option) => {
            option.addEventListener('change', syncAccountType);
            option.addEventListener('click', syncAccountType);
        });

        syncAccountType();
    </script>
</body>
</html>
