<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIMOM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
        }
 
        /* ===== LEFT PANEL ===== */
        .left-panel {
            width: 50%;
            background-color: #0c4f6a;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 52px;
            position: relative;
            overflow: hidden;
        }
 
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }
 
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -120px;
            left: -80px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59,130,246,0.18) 0%, transparent 70%);
            pointer-events: none;
        }
 
        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }
 
        .logo-icon { width: 40px; height: 40px; }
 
        .logo-text {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.02em;
        }
 
        .hero-content {
            position: relative;
            z-index: 1;
        }
 
        .hero-headline {
            font-size: 52px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin-bottom: 28px;
        }
 
        .hero-divider {
            width: 3px;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            background: #3b82f6;
            border-radius: 2px;
        }
 
        .hero-desc-wrap {
            position: relative;
            padding-left: 20px;
        }
 
        .hero-desc {
            font-size: 15px;
            font-weight: 400;
            color: #8fa3bf;
            line-height: 1.65;
            max-width: 380px;
        }
 
        .left-footer {
            position: relative;
            z-index: 1;
            font-size: 12px;
            color: #374a60;
        }
 
        /* ===== RIGHT PANEL ===== */
        .right-panel {
            width: 50%;
            background-color: #f5f6f8;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 52px;
        }
 
        .form-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 48px 44px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 4px 32px rgba(0,0,0,0.07), 0 1px 4px rgba(0,0,0,0.04);
        }
 
        .form-title {
            font-size: 30px;
            font-weight: 800;
            color: #0d1424;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }
 
        .form-subtitle {
            font-size: 14px;
            color: #6b7a8d;
            line-height: 1.5;
            margin-bottom: 36px;
        }
 
        .field-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #8fa3bf;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
 
        .input-wrap {
            position: relative;
            margin-bottom: 20px;
        }
 
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0bcc8;
            width: 16px;
            height: 16px;
        }
 
        .form-input {
            width: 100%;
            padding: 13px 16px 13px 44px;
            border: 1.5px solid #e5e9ef;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #0d1424;
            background: #fff;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
 
        .form-input::placeholder { color: #c0cad5; }
 
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
        }
 
        .form-input.error { border-color: #ef4444; }
 
        .error-msg {
            margin-top: 5px;
            font-size: 11.5px;
            color: #ef4444;
        }
 
        .btn-primary {
            width: 100%;
            padding: 14px;
            background: #0d1424;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.15s, transform 0.1s;
            margin-top: 8px;
        }
 
        .btn-primary:hover { background: #1a2640; }
        .btn-primary:active { transform: scale(0.99); }
 
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
        }
 
        .divider-line { flex: 1; height: 1px; background: #e8ecf0; }
 
        .divider-text {
            font-size: 11px;
            font-weight: 600;
            color: #b0bcc8;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
 
        .btn-guest:hover { background: #eef0f3; border-color: #d0d7df; }
 
        .guest-note strong { color: #6b7a8d; }
 
        .powered-by {
            margin-top: 32px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #c0cad5;
            text-align: center;
        }
 
        .alert-success {
            margin-bottom: 20px;
            padding: 12px 16px;
            background: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 10px;
            font-size: 13px;
            color: #16a34a;
        }
 
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
            <img src="{{ asset('images/logo.jpeg') }}" alt="SIMOM Logo" class="logo-icon">
            <span class="logo-text">SIMOM</span>
        </div>
 
        <div class="hero-content">
            <h1 class="hero-headline">Sistem kerja<br>terpadu.</h1>
            <div class="hero-desc-wrap">
                <div class="hero-divider"></div>
                <p class="hero-desc">
                    Sistem informasi terintegrasi untuk manajemen organisasi mahasiswa.
                    Pantau logistik, divisi, dan anggaran secara terpusat.
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
            <h2 class="form-title">Masuk ke Sistem</h2>
            <p class="form-subtitle">Silakan masukkan kredensial Anda untuk<br>melanjutkan ke dashboard.</p>
 
            {{-- Session Status --}}
            @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
            @endif
 
            <form method="POST" action="{{ route('login') }}">
                @csrf
 
                {{-- Email --}}
                <label class="field-label">Email</label>
                <div class="input-wrap">
                    <svg class="input-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="8" cy="5" r="3"/>
                        <path d="M2 14c0-3 2.5-5 6-5s6 2 6 5" stroke-linecap="round"/>
                    </svg>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="nama@student.simom.ac.id"
                           class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                           autocomplete="email">
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
                           placeholder="••••••••"
                           class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                           autocomplete="current-password">
                    @error('password')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
 
                <button type="submit" class="btn-primary">
                    Masuk Sekarang
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 8h10M9 4l4 4-4 4"/>
                    </svg>
                </button>
            </form>

            <p style="text-align: center; margin-top: 16px; font-size: 13px; color: #6b7a8d;">
             Belum punya akun?
            <a href="{{ route('register') }}" style="color: #3b82f6; font-weight: 600; text-decoration: none;">
                Daftar Sekarang
            </a>
            </p>
 
            <div class="powered-by">Powered by SIMOM</div>
        </div>
    </div>
 
</body>
</html>
