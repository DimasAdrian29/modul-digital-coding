<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.register');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (! Auth::attempt($validated, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password tidak sesuai.'])
                ->withInput($request->except('password'));
        }

        $request->session()->regenerate();

        return $this->redirectByRole(Auth::user()->role);
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'account_type' => ['required', Rule::in(['siswa', 'guru'])],
            'name' => ['required', 'string', 'max:100'],
            'nis_nisn' => ['required_if:account_type,siswa', 'nullable', 'string', 'max:50', 'regex:/^\\d+$/'],
            'kelas' => ['required_if:account_type,siswa', 'nullable', 'string', 'max:50'],
            'jurusan' => ['required_if:account_type,siswa', 'nullable', 'string', 'max:100'],
            'nip_nuptk' => ['required_if:account_type,guru', 'nullable', 'string', 'max:50', 'regex:/^\\d+$/'],
            'jabatan' => ['required_if:account_type,guru', 'nullable', 'string', 'max:100'],
            'mata_pelajaran' => ['required_if:account_type,guru', 'nullable', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'account_type.required' => 'Pilih jenis akun terlebih dahulu.',
            'account_type.in' => 'Jenis akun tidak valid.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'nis_nisn.required_if' => 'NIS/NISN wajib diisi untuk siswa.',
            'nis_nisn.regex' => 'NIS/NISN hanya boleh diisi angka.',
            'kelas.required_if' => 'Kelas wajib diisi untuk siswa.',
            'jurusan.required_if' => 'Jurusan wajib diisi untuk siswa.',
            'nip_nuptk.required_if' => 'NIP/NUPTK wajib diisi untuk guru.',
            'nip_nuptk.regex' => 'NIP/NUPTK hanya boleh diisi angka.',
            'jabatan.required_if' => 'Jabatan wajib diisi untuk guru.',
            'mata_pelajaran.required_if' => 'Mata pelajaran atau bidang keahlian wajib diisi untuk guru.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['account_type'],
            'nis_nisn' => $validated['account_type'] === 'siswa' ? $validated['nis_nisn'] : null,
            'kelas' => $validated['account_type'] === 'siswa' ? $validated['kelas'] : null,
            'jurusan' => $validated['account_type'] === 'siswa' ? $validated['jurusan'] : null,
            'nip_nuptk' => $validated['account_type'] === 'guru' ? $validated['nip_nuptk'] : null,
            'jabatan' => $validated['account_type'] === 'guru' ? $validated['jabatan'] : null,
            'mata_pelajaran' => $validated['account_type'] === 'guru' ? $validated['mata_pelajaran'] : null,
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login dengan email dan password Anda.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->forget([
        ]);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda berhasil logout.');
    }

    private function redirectByRole(string $role): RedirectResponse
    {
        return redirect()->route(in_array($role, ['guru', 'admin'], true) ? 'admin.dashboard' : 'home');
    }
}
