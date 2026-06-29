<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — SIMOM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; }

        .left-panel {
            width: 50%; background-color: #0d1424;
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 40px 52px; position: relative; overflow: hidden;
        }
        .left-panel::before {
            content: ''; position: absolute; inset: 0;
            background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 48px 48px; pointer-events: none;
        }
        .left-panel::after {
            content: ''; position: absolute; bottom: -120px; left: -80px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(59,130,246,0.18) 0%, transparent 70%);
            pointer-events: none;
        }
        .logo-area { display: flex; align-items: center; gap: 12px; position: relative; z-index: 1; }
        .logo-icon { width: 40px; height: 40px; }
        .logo-text { font-size: 15px; font-weight: 700; color: #ffffff; letter-spacing: 0.02em; }
        .hero-content { position: relative; z-index: 1; }
        .hero-headline { font-size: 52px; font-weight: 800; color: #ffffff; line-height: 1.1; letter-spacing: -0.02em; margin-bottom: 28px; }
        .hero-divider { width: 3px; height: 100%; position: absolute; left: 0; top: 0; background: #3b82f6; border-radius: 2px; }
        .hero-desc-wrap { position: relative; padding-left: 20px; }
        .hero-desc { font-size: 15px; font-weight: 400; color: #8fa3bf; line-height: 1.65; max-width: 380px; }
        .left-footer { position: relative; z-index: 1; font-size: 12px; color: #374a60; }

        .right-panel {
            width: 50%; background-color: #f5f6f8;
            display: flex; flex-direction: column; justify-content: center;
            align-items: center; padding: 60px 52px;
        }
        .form-card {
            background: #ffffff; border-radius: 20px; padding: 48px 44px;
            width: 100%; max-width: 420px;
            box-shadow: 0 4px 32px rgba(0,0,0,0.07), 0 1px 4px rgba(0,0,0,0.04);
        }
        .form-title { font-size: 30px; font-weight: 800; color: #0d1424; letter-spacing: -0.02em; margin-bottom: 6px; }
        .form-subtitle { font-size: 14px; color: #6b7a8d; line-height: 1.5; margin-bottom: 32px; }
        .field-label { display: block; font-size: 11px; font-weight: 700; color: #8fa3bf; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 8px; }
        .input-wrap { position: relative; margin-bottom: 18px; }
        .input-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #b0bcc8; width: 16px; height: 16px; }
        .form-input {
            width: 100%; padding: 13px 16px 13px 44px;
            border: 1.5px solid #e5e9ef; border-radius: 10px;
            font-size: 14px; font-family: 'Inter', sans-serif;
            color: #0d1424; background: #fff; outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-input::placeholder { color: #c0cad5; }
        .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }
        .form-input.error { border-color: #ef4444; }
        .error-msg { margin-top: 5px; font-size: 11.5px; color: #ef4444; }
        .btn-primary {
            width: 100%; padding: 14px; background: #0d1424; color: #fff;
            border: none; border-radius: 10px; font-size: 15px; font-weight: 600;
            font-family: 'Inter', sans-serif; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: background 0.15s, transform 0.1s; margin-top: 8px;
        }
        .btn-primary:hover { background: #1a2640; }
        .btn-primary:active { transform: scale(0.99); }
        .login-link { text-align: center; margin-top: 20px; font-size: 13px; color: #6b7a8d; }
        .login-link a { color: #3b82f6; font-weight: 600; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }
        .powered-by { margin-top: 28px; font-size: 10px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: #c0cad5; text-align: center; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .left-panel, .right-panel { width: 100%; }
            .left-panel { padding: 32px 28px; }
            .hero-headline { font-size: 36px; }
            .right-panel { padding: 40px 24px; }
            .form-card { padding: 32px 24px; }
        }
    </style>
</head>
<body>

    {{-- LEFT PANEL --}}
    <div class="left-panel">
        <div class="logo-area">
            <svg class="logo-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="20,4 36,34 4,34" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linejoin="round"/>
                <polygon points="20,12 30,30 10,30" fill="#3b82f6" opacity="0.5"/>
                <line x1="20" y1="4" x2="20" y2="34" stroke="#5b9cf6" stroke-width="1.5" opacity="0.5"/>
            </svg>
            <span class="logo-text">SIMOM</span>
        </div>

        <div class="hero-content">
            <h1 class="hero-headline">Bergabung<br>bersama kami.</h1>
            <div class="hero-desc-wrap">
                <div class="hero-divider"></div>
                <p class="hero-desc">
                    Daftarkan akun Anda untuk mulai mengelola organisasi mahasiswa secara digital, terpusat, dan efisien.
                </p>
            </div>
        </div>

        <div class="left-footer">
            SIMOM v1.0 &copy; 2024 — Sistem Informasi Manajemen Organisasi Mahasiswa
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="form-card">
            <h2 class="form-title">Buat Akun Baru</h2>
            <p class="form-subtitle">Isi data berikut untuk mendaftarkan diri ke sistem SIMOM.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nama --}}
                <label class="field-label">Nama Lengkap</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="8" cy="5" r="3"/>
                        <path d="M2 14c0-3 2.5-5 6-5s6 2 6 5" stroke-linecap="round"/>
                    </svg>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           placeholder="Nama lengkap kamu"
                           class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                           autocomplete="name">
                    @error('name')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIM --}}
<label class="field-label">NIM</label>
<div class="input-wrap">
    <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
        <rect x="2" y="2" width="12" height="12" rx="1.5"/>
        <path d="M5 6h6M5 9h4" stroke-linecap="round"/>
    </svg>
    <input type="text" name="nim" value="{{ old('nim') }}" required
           placeholder="Contoh: 2024001001"
           class="form-input {{ $errors->has('nim') ? 'error' : '' }}">
    @error('nim')
    <p class="error-msg">{{ $message }}</p>
    @enderror
</div>

{{-- No HP --}}
<label class="field-label">No. HP</label>
<div class="input-wrap">
    <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
        <rect x="4" y="1" width="8" height="14" rx="1.5"/>
        <circle cx="8" cy="12" r="0.8" fill="currentColor"/>
    </svg>
    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
           placeholder="Contoh: 08123456789"
           class="form-input {{ $errors->has('no_hp') ? 'error' : '' }}">
    @error('no_hp')
    <p class="error-msg">{{ $message }}</p>
    @enderror
</div>

{{-- Angkatan --}}
<label class="field-label">Angkatan</label>
<div class="input-wrap">
    <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
        <path d="M8 2L2 5l6 3 6-3-6-3z" stroke-linejoin="round"/>
        <path d="M2 8l6 3 6-3M2 11l6 3 6-3" stroke-linecap="round"/>
    </svg>
    <select name="angkatan" required
            class="form-input {{ $errors->has('angkatan') ? 'error' : '' }}"
            style="padding-left: 44px;">
        <option value="">-- Pilih Angkatan --</option>
        @foreach(['2024','2023','2022','2021','2020'] as $thn)
        <option value="{{ $thn }}" {{ old('angkatan') === $thn ? 'selected' : '' }}>
            {{ $thn }}
        </option>
        @endforeach
    </select>
    @error('angkatan')
    <p class="error-msg">{{ $message }}</p>
    @enderror
</div>

{{-- Departemen --}}
<label class="field-label">Departemen</label>
<div class="input-wrap">
    <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
        <path d="M1 14V6l7-4 7 4v8H1z" stroke-linejoin="round"/>
        <rect x="6" y="9" width="4" height="5" rx="0.5"/>
    </svg>
    <select name="departemen_id" required
            class="form-input {{ $errors->has('departemen_id') ? 'error' : '' }}"
            style="padding-left: 44px;">
        <option value="">-- Pilih Departemen --</option>
        @foreach($departemens as $dep)
        <option value="{{ $dep->id }}" {{ old('departemen_id') == $dep->id ? 'selected' : '' }}>
            {{ $dep->nama_departemen }}
        </option>
        @endforeach
    </select>
    @error('departemen_id')
    <p class="error-msg">{{ $message }}</p>
    @enderror
</div>

{{-- Jabatan --}}
<label class="field-label">Jabatan</label>
<div class="input-wrap">
    <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
        <circle cx="8" cy="5" r="3"/>
        <path d="M2 14c0-3 2.5-5 6-5s6 2 6 5" stroke-linecap="round"/>
    </svg>
    <select name="jabatan" required
            class="form-input {{ $errors->has('jabatan') ? 'error' : '' }}"
            style="padding-left: 44px;">
        <option value="">-- Pilih Jabatan --</option>
        @foreach(['Ketua Umum','Sekretaris','Kepala Departemen','Staff'] as $j)
        <option value="{{ $j }}" {{ old('jabatan') === $j ? 'selected' : '' }}>{{ $j }}</option>
        @endforeach
    </select>
    @error('jabatan')
    <p class="error-msg">{{ $message }}</p>
    @enderror
</div>

{{-- Role --}}
<label class="field-label">Role Sistem</label>
<div class="input-wrap">
    <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
        <path d="M8 1l2 4h4l-3 3 1 4-4-2-4 2 1-4L2 5h4z" stroke-linejoin="round"/>
    </svg>
    <select name="role" required
            class="form-input {{ $errors->has('role') ? 'error' : '' }}"
            style="padding-left: 44px;">
        <option value="">-- Pilih Role --</option>
        <option value="anggota"           {{ old('role') === 'anggota'           ? 'selected' : '' }}>Anggota / Staff</option>
        <option value="kepala_departemen" {{ old('role') === 'kepala_departemen' ? 'selected' : '' }}>Kepala Departemen</option>
        <option value="kepala_inventaris" {{ old('role') === 'kepala_inventaris' ? 'selected' : '' }}>Kepala Dep. Inventaris</option>
        <option value="admin"             {{ old('role') === 'admin'             ? 'selected' : '' }}>Admin Utama</option>
    </select>
    @error('role')
    <p class="error-msg">{{ $message }}</p>
    @enderror
</div>

                {{-- Email --}}
                <label class="field-label">Email</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
                        <rect x="1" y="3" width="14" height="10" rx="1.5"/>
                        <path d="M1 4l7 5.5L15 4" stroke-linecap="round"/>
                    </svg>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="nama@student.simom.ac.id"
                           class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                           autocomplete="username">
                    @error('email')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <label class="field-label">Kata Sandi</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
                        <rect x="3" y="7" width="10" height="7" rx="1.5"/>
                        <path d="M5 7V5a3 3 0 016 0v2" stroke-linecap="round"/>
                    </svg>
                    <input type="password" name="password" required
                           placeholder="Minimal 8 karakter"
                           class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                           autocomplete="new-password">
                    @error('password')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <label class="field-label">Konfirmasi Kata Sandi</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
                        <rect x="3" y="7" width="10" height="7" rx="1.5"/>
                        <path d="M5 7V5a3 3 0 016 0v2" stroke-linecap="round"/>
                        <path d="M6 11l1.5 1.5L10 10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input type="password" name="password_confirmation" required
                           placeholder="Ulangi kata sandi"
                           class="form-input {{ $errors->has('password_confirmation') ? 'error' : '' }}"
                           autocomplete="new-password">
                    @error('password_confirmation')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary">
                    Daftar Sekarang
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 8h10M9 4l4 4-4 4"/>
                    </svg>
                </button>
            </form>

            <p class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </p>

            <div class="powered-by">Powered by SIMOM</div>
        </div>
    </div>

</body>
</html>