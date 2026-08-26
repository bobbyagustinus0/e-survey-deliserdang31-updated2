<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ \App\Models\Setting::get('nama_aplikasi', 'E-Survey Deli Serdang') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- ===== Konfigurasi PWA ===== --}}
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <meta name="theme-color" content="#0d6e3f">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="E-Survey">
    <meta name="mobile-web-app-capable" content="yes">

    <style>
        :root {
            --green-950: #052e1c;
            --green-900: #073b23;
            --green-800: #0a4d2d;
            --green-700: #0d6e3f;
            --green-600: #128a4f;
            --gold: #d9a441;
            --gold-light: #f0c675;
            --gold-dark: #b8892e;
            --purple: #6c3b8a;
            --purple-light: #a87cc4;
            --teal: #1a7a7a;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            position: relative;
            overflow: hidden;
            background: #0a1628;
        }

        /* ===== BACKGROUND SUPER PREMIUM ===== */
        .bg-layer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-layer .gradient-base {
            position: absolute;
            inset: 0;
            background: 
                linear-gradient(135deg, #0a1628 0%, #1a2d4a 25%, #2a4a6a 50%, #1a3a5a 75%, #0d2a4a 100%);
        }

        /* Lingkaran dekoratif besar */
        .bg-layer .circle-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.5;
        }

        .bg-layer .circle-glow:nth-child(1) {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(13, 110, 63, 0.25), transparent 70%);
            top: -200px;
            right: -100px;
            animation: floatGlow 20s ease-in-out infinite;
        }

        .bg-layer .circle-glow:nth-child(2) {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(217, 164, 65, 0.15), transparent 70%);
            bottom: -150px;
            left: -150px;
            animation: floatGlow 25s ease-in-out infinite reverse;
        }

        .bg-layer .circle-glow:nth-child(3) {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(108, 59, 138, 0.20), transparent 70%);
            top: 40%;
            left: 60%;
            animation: floatGlow 18s ease-in-out infinite 3s;
        }

        @keyframes floatGlow {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -20px) scale(1.1); }
            66% { transform: translate(-20px, 30px) scale(0.9); }
        }

        /* Garis grid dekoratif */
        .bg-layer .grid-lines {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(circle at center, black 30%, transparent 70%);
        }

        /* Bintang-bintang kecil */
        .bg-layer .stars {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(2px 2px at 10% 20%, rgba(255,255,255,0.2), transparent),
                radial-gradient(2px 2px at 30% 60%, rgba(255,255,255,0.15), transparent),
                radial-gradient(1px 1px at 50% 10%, rgba(255,255,255,0.3), transparent),
                radial-gradient(1px 1px at 70% 40%, rgba(255,255,255,0.15), transparent),
                radial-gradient(2px 2px at 90% 80%, rgba(255,255,255,0.2), transparent),
                radial-gradient(1px 1px at 20% 80%, rgba(255,255,255,0.15), transparent),
                radial-gradient(1px 1px at 80% 20%, rgba(255,255,255,0.2), transparent),
                radial-gradient(2px 2px at 40% 90%, rgba(255,255,255,0.1), transparent),
                radial-gradient(1px 1px at 60% 30%, rgba(255,255,255,0.2), transparent),
                radial-gradient(1px 1px at 15% 50%, rgba(255,255,255,0.15), transparent);
            background-size: 100% 100%;
        }

        /* ===== BACK BUTTON ===== */
        .back-comment {
            position: fixed;
            top: 24px;
            left: 24px;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.08);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .back-comment:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
        }

        .back-comment i {
            font-size: 16px;
        }

        /* ===== AUTH SHELL ===== */
        .auth-shell {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1000px;
            min-height: 620px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 36px;
            overflow: hidden;
            box-shadow: 
                0 40px 80px -24px rgba(0, 0, 0, 0.6),
                inset 0 1px 0 rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        /* ===== BRAND PANEL ===== */
        .brand-panel {
            position: relative;
            background:
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.04), transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(217, 164, 65, 0.12), transparent 45%),
                linear-gradient(155deg, rgba(10, 38, 71, 0.9) 0%, rgba(5, 46, 28, 0.95) 100%);
            padding: 3.4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #fff;
            overflow: hidden;
        }

        .brand-panel .pattern-overlay {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(circle at 30% 30%, black, transparent 70%);
            pointer-events: none;
        }

        /* Ornamen geometris */
        .brand-panel .geo-ornament {
            position: absolute;
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 50%;
            pointer-events: none;
        }

        .brand-panel .geo-ornament:nth-child(2) {
            width: 300px;
            height: 300px;
            top: -80px;
            right: -80px;
        }

        .brand-panel .geo-ornament:nth-child(3) {
            width: 180px;
            height: 180px;
            bottom: 30px;
            left: -60px;
            border-color: rgba(217, 164, 65, 0.06);
        }

        .brand-panel .geo-ornament:nth-child(4) {
            width: 80px;
            height: 80px;
            top: 40%;
            right: 20px;
            border-color: rgba(255, 255, 255, 0.03);
        }

        /* Brand mark */
        .brand-mark {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            position: relative;
            z-index: 1;
        }

        .brand-mark .mark-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 28px -6px rgba(217, 164, 65, 0.4);
            flex-shrink: 0;
        }

        .brand-mark .mark-icon i {
            font-size: 1.5rem;
            color: var(--green-950);
        }

        .brand-mark .brand-text .name {
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.2px;
            display: block;
            color: rgba(255, 255, 255, 0.95);
        }

        .brand-mark .brand-text .tag {
            font-size: 0.7rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        /* Brand copy */
        .brand-copy {
            position: relative;
            z-index: 1;
            margin-top: 2.6rem;
        }

        .brand-copy .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: var(--gold-light);
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 0.4rem 1rem;
            border-radius: 100px;
            margin-bottom: 1.2rem;
        }

        .brand-copy .eyebrow i {
            font-size: 0.85rem;
        }

        .brand-copy h1 {
            font-size: 2.1rem;
            font-weight: 800;
            line-height: 1.2;
            margin: 0 0 0.8rem;
            letter-spacing: -0.4px;
        }

        .brand-copy h1 .highlight {
            color: var(--gold-light);
            position: relative;
        }

        .brand-copy h1 .highlight::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), transparent);
            border-radius: 2px;
        }

        .brand-copy p {
            font-size: 0.92rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.6);
            margin: 0;
            max-width: 340px;
        }

        /* Brand stats */
        .brand-stats {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 2.2rem;
            margin-top: 2.4rem;
            padding-top: 1.8rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .brand-stats .stat-item strong {
            display: block;
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .brand-stats .stat-item span {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-top: 2px;
        }

        /* ===== FORM PANEL ===== */
        .form-panel {
            padding: 3.4rem 3.2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(8px);
        }

        .form-panel .form-header {
            margin-bottom: 2rem;
        }

        .form-panel .form-header h2 {
            font-size: 1.7rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 0.3rem;
            letter-spacing: -0.3px;
        }

        .form-panel .form-header .subtitle {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.88rem;
            font-weight: 400;
        }

        /* Alert */
        .alert-box {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            font-size: 0.84rem;
            border-radius: 14px;
            padding: 0.8rem 1rem;
            margin-bottom: 1.2rem;
        }

        .alert-box i {
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .alert-danger-c {
            background: rgba(220, 38, 38, 0.12);
            color: #f87171;
            border: 1px solid rgba(220, 38, 38, 0.15);
        }

        .alert-success-c {
            background: rgba(13, 110, 63, 0.12);
            color: #6ee7b7;
            border: 1px solid rgba(13, 110, 63, 0.15);
        }

        /* Form fields */
        .field {
            margin-bottom: 1.25rem;
        }

        .field label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0.4rem;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.04);
            transition: border-color 0.3s, box-shadow 0.3s, background 0.3s;
        }

        .input-wrap:focus-within {
            border-color: var(--gold);
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 0 4px rgba(217, 164, 65, 0.06);
        }

        .input-wrap i.leading {
            width: 48px;
            text-align: center;
            color: rgba(255, 255, 255, 0.3);
            font-size: 1.05rem;
            flex-shrink: 0;
            transition: color 0.3s;
        }

        .input-wrap:focus-within i.leading {
            color: var(--gold);
        }

        .input-wrap input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            padding: 0.85rem 0.5rem 0.85rem 0;
            font-size: 0.92rem;
            color: #ffffff;
            font-family: inherit;
        }

        .input-wrap input::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .input-wrap input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 30px rgba(10, 22, 40, 0.9) inset !important;
            -webkit-text-fill-color: #ffffff !important;
        }

        .toggle-pass {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.3);
            padding: 0 16px;
            cursor: pointer;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            transition: color 0.3s;
        }

        .toggle-pass:hover {
            color: var(--gold);
        }

        /* Row between */
        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.6rem;
        }

        .remember-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            user-select: none;
        }

        .remember-check input {
            width: 18px;
            height: 18px;
            accent-color: var(--gold);
            cursor: pointer;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .forgot-link {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--gold-light);
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: var(--gold);
            text-decoration: underline;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            border: none;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--green-950);
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0.95rem 1.2rem;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            cursor: pointer;
            box-shadow: 0 12px 32px -10px rgba(217, 164, 65, 0.35);
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 44px -10px rgba(217, 164, 65, 0.5);
            filter: brightness(1.05);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit i {
            font-size: 1.1rem;
        }

        /* PWA Install Button */
        .pwa-install-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 5;
            display: none;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(12px);
            color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 100px;
            padding: 0.6rem 1.2rem;
            font-size: 0.8rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .pwa-install-btn:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .pwa-install-btn i {
            font-size: 1rem;
            color: var(--gold);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 820px) {
            .auth-shell {
                grid-template-columns: 1fr;
                max-width: 440px;
                border-radius: 28px;
            }

            .brand-panel {
                display: none;
            }

            .form-panel {
                padding: 2.8rem 1.8rem;
                background: rgba(10, 22, 40, 0.8);
                backdrop-filter: blur(16px);
            }

            .form-panel .form-header h2 {
                font-size: 1.5rem;
            }

            .back-comment {
                top: 16px;
                left: 16px;
                padding: 10px 18px;
                font-size: 12px;
                border-radius: 12px;
            }

            .pwa-install-btn {
                top: 14px;
                right: 14px;
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 420px) {
            body {
                padding: 12px;
            }

            .form-panel {
                padding: 2rem 1.2rem;
            }

            .form-panel .form-header h2 {
                font-size: 1.3rem;
            }

            .input-wrap {
                border-radius: 12px;
            }

            .input-wrap i.leading {
                width: 40px;
                font-size: 0.9rem;
            }

            .input-wrap input {
                padding: 0.7rem 0.4rem 0.7rem 0;
                font-size: 0.85rem;
            }

            .btn-submit {
                padding: 0.8rem 1rem;
                font-size: 0.88rem;
                border-radius: 12px;
            }

            .back-comment {
                top: 12px;
                left: 12px;
                padding: 8px 14px;
                font-size: 11px;
                border-radius: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- ===== BACKGROUND LAYER ===== -->
    <div class="bg-layer">
        <div class="gradient-base"></div>
        <div class="circle-glow"></div>
        <div class="circle-glow"></div>
        <div class="circle-glow"></div>
        <div class="grid-lines"></div>
        <div class="stars"></div>
    </div>

    <!-- Back Button -->
    <a href="{{ route('public.users') }}" class="back-comment">
        <i class="bi bi-arrow-left"></i>
        Komentar Pengguna
    </a>

    <div class="auth-shell">
        <!-- PWA Install Button -->
        <button id="pwaInstallBtn" class="pwa-install-btn" type="button">
            <i class="bi bi-download"></i> Install App
        </button>

        <!-- ===== BRAND PANEL ===== -->
        <div class="brand-panel">
            <div class="pattern-overlay"></div>
            <div class="geo-ornament"></div>
            <div class="geo-ornament"></div>
            <div class="geo-ornament"></div>

            <!-- Brand Mark -->
            <div class="brand-mark">
                <div class="mark-icon">
                    <i class="bi bi-clipboard2-data-fill"></i>
                </div>
                <div class="brand-text">
                    <span class="name">{{ \App\Models\Setting::get('nama_instansi', 'Pemerintah Kabupaten Deli Serdang') }}</span>
                    <span class="tag">Portal Resmi</span>
                </div>
            </div>

            <!-- Brand Copy -->
            <div class="brand-copy">
                <span class="eyebrow">
                    <i class="bi bi-shield-check"></i> Portal Internal
                </span>
                <h1>
                    {{ \App\Models\Setting::get('nama_aplikasi', 'E-Survey Kepuasan Layanan Digital') }}
                    <br>
                    <span class="highlight">Deli Serdang</span>
                </h1>
                <p>Masuk untuk mengelola survei kepuasan masyarakat, memantau respon, dan menjaga kualitas layanan digital daerah tetap prima.</p>
            </div>

            <!-- Brand Stats -->
            <div class="brand-stats">
                <div class="stat-item">
                    <strong>100%</strong>
                    <span>Terenkripsi</span>
                </div>
                <div class="stat-item">
                    <strong>24/7</strong>
                    <span>Akses Kapan Saja</span>
                </div>
                <div class="stat-item">
                    <strong>Real-time</strong>
                    <span>Data Survei</span>
                </div>
            </div>
        </div>

        <!-- ===== FORM PANEL ===== -->
        <div class="form-panel">
            <div class="form-header">
                <h2>Selamat Datang</h2>
                <p class="subtitle">Masuk ke akun admin untuk melanjutkan.</p>
            </div>

            @if ($errors->any())
            <div class="alert-box alert-danger-c">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            @endif

            @if (session('success'))
            <div class="alert-box alert-success-c">
                <i class="bi bi-check-circle-fill"></i>
                <div>{{ session('success') }}</div>
            </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <!-- Username -->
                <div class="field">
                    <label for="username">Username atau Email</label>
                    <div class="input-wrap">
                        <i class="bi bi-person-fill leading"></i>
                        <input type="text" id="username" name="username" placeholder="Masukkan username atau email" value="{{ old('username') }}" required autofocus>
                    </div>
                </div>

                <!-- Password -->
                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock-fill leading"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        <button type="button" class="toggle-pass" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Row between -->
                <div class="row-between">
                    <label class="remember-check">
                        <input type="checkbox" name="remember" id="remember">
                        Ingat saya
                    </label>
                    <a href="#" class="forgot-link">Lupa password?</a>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>

    {{-- ===== Service Worker & Install App (PWA) ===== --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register("{{ asset('sw.js') }}")
                    .catch((err) => console.warn('SW registration gagal:', err));
            });
        }

        let deferredInstallPrompt = null;
        const installBtn = document.getElementById('pwaInstallBtn');

        window.addEventListener('beforeinstallprompt', (event) => {
            event.preventDefault();
            deferredInstallPrompt = event;
            if (installBtn) installBtn.style.display = 'flex';
        });

        if (installBtn) {
            installBtn.addEventListener('click', async () => {
                if (!deferredInstallPrompt) return;
                installBtn.disabled = true;
                deferredInstallPrompt.prompt();
                const { outcome } = await deferredInstallPrompt.userChoice;
                deferredInstallPrompt = null;
                installBtn.disabled = false;
                installBtn.style.display = 'none';
                console.log('PWA install outcome:', outcome);
            });
        }

        window.addEventListener('appinstalled', () => {
            if (installBtn) installBtn.style.display = 'none';
            deferredInstallPrompt = null;
        });

        if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
            if (installBtn) installBtn.style.display = 'none';
        }
    </script>
</body>

</html>