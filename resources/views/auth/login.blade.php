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
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: #eef4f0;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            position: relative;
            overflow: hidden;
        }

        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(60px);
            z-index: 0;
        }

        body::before {
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, rgba(13, 110, 63, .18), transparent 70%);
            top: -180px;
            left: -160px;
        }

        body::after {
            width: 460px;
            height: 460px;
            background: radial-gradient(circle, rgba(217, 164, 65, .16), transparent 70%);
            bottom: -160px;
            right: -140px;
        }

        .auth-shell {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 920px;
            min-height: 580px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #fff;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 30px 70px -20px rgba(5, 46, 28, .35), 0 8px 24px -8px rgba(5, 46, 28, .15);
        }

        .brand-panel {
            position: relative;
            background:
                radial-gradient(circle at 15% 20%, rgba(255, 255, 255, .08), transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(217, 164, 65, .25), transparent 45%),
                linear-gradient(155deg, var(--green-800) 0%, var(--green-900) 55%, var(--green-950) 100%);
            padding: 3rem 2.6rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #fff;
            overflow: hidden;
        }

        .brand-panel .grid-pattern {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .06) 1px, transparent 1px);
            background-size: 34px 34px;
            mask-image: radial-gradient(circle at 30% 30%, black, transparent 70%);
            pointer-events: none;
        }

        .brand-mark {
            display: flex;
            align-items: center;
            gap: .7rem;
            position: relative;
            z-index: 1;
        }

        .brand-mark .mark-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px -6px rgba(217, 164, 65, .6);
            flex-shrink: 0;
        }

        .brand-mark .mark-icon i {
            font-size: 1.3rem;
            color: var(--green-950);
        }

        .brand-mark span {
            font-weight: 700;
            font-size: 1.02rem;
            letter-spacing: .2px;
            line-height: 1.25;
        }

        .brand-copy {
            position: relative;
            z-index: 1;
            margin-top: 2.4rem;
        }

        .brand-copy .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: 1.3px;
            text-transform: uppercase;
            color: var(--gold-light);
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .14);
            padding: .35rem .75rem;
            border-radius: 100px;
            margin-bottom: 1.1rem;
        }

        .brand-copy h1 {
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1.28;
            margin: 0 0 .8rem;
            letter-spacing: -.3px;
        }

        .brand-copy p {
            font-size: .92rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, .72);
            margin: 0;
            max-width: 340px;
        }

        .brand-stats {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 1.6rem;
            margin-top: 2.2rem;
            padding-top: 1.6rem;
            border-top: 1px solid rgba(255, 255, 255, .14);
        }

        .brand-stats div strong {
            display: block;
            font-size: 1.25rem;
            font-weight: 800;
            color: #fff;
        }

        .brand-stats div span {
            font-size: .74rem;
            color: rgba(255, 255, 255, .6);
        }

        .form-panel {
            padding: 3.2rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-panel h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f2b1c;
            margin: 0 0 .3rem;
            letter-spacing: -.2px;
        }

        .form-panel .subtitle {
            color: #6b7a72;
            font-size: .88rem;
            margin-bottom: 1.9rem;
        }

        .field {
            margin-bottom: 1.25rem;
        }

        .field label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: #24382e;
            margin-bottom: .4rem;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
            border: 1.5px solid #e2e8e4;
            border-radius: 12px;
            background: #f8faf9;
            transition: border-color .15s, box-shadow .15s, background .15s;
        }

        .input-wrap:focus-within {
            border-color: var(--green-700);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(13, 110, 63, .1);
        }

        .input-wrap i.leading {
            width: 42px;
            text-align: center;
            color: #8b9a92;
            font-size: 1rem;
        }

        .input-wrap input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            padding: .78rem .5rem .78rem 0;
            font-size: .92rem;
            color: #16241c;
            font-family: inherit;
        }

        .input-wrap input::placeholder {
            color: #a9b6b0;
        }

        .toggle-pass {
            background: none;
            border: none;
            color: #8b9a92;
            padding: 0 14px;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        .toggle-pass:hover {
            color: var(--green-700);
        }

        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.4rem;
        }

        .remember-check {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .85rem;
            color: #4a5a52;
            cursor: pointer;
            user-select: none;
        }

        .remember-check input {
            width: 17px;
            height: 17px;
            accent-color: var(--green-700);
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            border: none;
            background: linear-gradient(135deg, var(--green-700), var(--green-800));
            color: #fff;
            font-weight: 700;
            font-size: .95rem;
            padding: .85rem 1rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            cursor: pointer;
            box-shadow: 0 12px 24px -10px rgba(13, 110, 63, .55);
            transition: transform .12s ease, box-shadow .12s ease, filter .12s ease;
        }

        .btn-submit:hover {
            filter: brightness(1.06);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit i {
            font-size: 1.05rem;
        }

        .alert-box {
            display: flex;
            align-items: flex-start;
            gap: .55rem;
            font-size: .84rem;
            border-radius: 10px;
            padding: .7rem .85rem;
            margin-bottom: 1.1rem;
        }

        .alert-danger-c {
            background: #fdecec;
            color: #a3242a;
            border: 1px solid #f6c9cb;
        }

        .alert-success-c {
            background: #e8f6ee;
            color: #0d6e3f;
            border: 1px solid #bfe6cf;
        }

        .demo-note {
            margin-top: 1.6rem;
            text-align: center;
            font-size: .78rem;
            color: #7c8b83;
            background: #f5f8f6;
            border: 1px dashed #d7e2dc;
            border-radius: 10px;
            padding: .55rem .75rem;
        }

        .demo-note b {
            color: #24382e;
        }

        .pwa-install-btn {
            position: absolute;
            top: 18px;
            right: 18px;
            z-index: 5;
            display: none;
            align-items: center;
            gap: .4rem;
            background: rgba(255, 255, 255, .95);
            color: var(--green-800);
            border: 1px solid #e2e8e4;
            border-radius: 100px;
            padding: .5rem 1rem;
            font-size: .8rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 8px 20px -8px rgba(5, 46, 28, .3);
            transition: transform .12s ease, box-shadow .12s ease;
        }

        .pwa-install-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px -8px rgba(5, 46, 28, .35);
        }

        .pwa-install-btn i {
            font-size: .95rem;
            color: var(--gold);
        }

        @media (max-width: 820px) {
            .pwa-install-btn {
                top: 12px;
                right: 12px;
                padding: .45rem .85rem;
                font-size: .75rem;
            }
        }

        @media (max-width: 820px) {
            .auth-shell {
                grid-template-columns: 1fr;
                max-width: 440px;
            }

            .brand-panel {
                display: none;
            }

            .form-panel {
                padding: 2.6rem 1.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="auth-shell">
        <button id="pwaInstallBtn" class="pwa-install-btn" type="button">
            <i class="bi bi-download"></i> Install App
        </button>

        <!-- Left: brand panel -->
        <div class="brand-panel">
            <div class="grid-pattern"></div>

            <div class="brand-mark">
                <div class="mark-icon"><i class="bi bi-clipboard2-data-fill"></i></div>
                <span>{{ \App\Models\Setting::get('nama_instansi', 'Pemerintah Kabupaten Deli Serdang') }}</span>
            </div>

            <div class="brand-copy">
                <span class="eyebrow"><i class="bi bi-shield-check"></i> Portal Internal</span>
                <h1>{{ \App\Models\Setting::get('nama_aplikasi', 'E-Survey Kepuasan Layanan Digital') }}</h1>
                <p>Masuk untuk mengelola survei kepuasan masyarakat, memantau respon, dan menjaga kualitas layanan digital daerah tetap prima.</p>
            </div>

            <div class="brand-stats">
                <div><strong>100%</strong><span>Terenkripsi</span></div>
                <div><strong>24/7</strong><span>Akses Kapan Saja</span></div>
                <div><strong>Real-time</strong><span>Data Survei</span></div>
            </div>
        </div>

        <!-- Right: form panel -->
        <div class="form-panel">
            <h2>Selamat Datang</h2>
            <p class="subtitle">Masuk ke akun admin untuk melanjutkan.</p>

            @if ($errors->any())
            <div class="alert-box alert-danger-c">
                <i class="bi bi-exclamation-circle-fill mt-1"></i>
                <div>
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            @endif
            @if (session('success'))
            <div class="alert-box alert-success-c">
                <i class="bi bi-check-circle-fill mt-1"></i>
                <div>{{ session('success') }}</div>
            </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="field">
                    <label for="username">Username atau Email</label>
                    <div class="input-wrap">
                        <i class="bi bi-person-fill leading"></i>
                        <input type="text" id="username" name="username" placeholder="Masukkan username atau email" value="{{ old('username') }}" required autofocus>
                    </div>
                </div>

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

                <div class="row-between">
                    <label class="remember-check">
                        <input type="checkbox" name="remember" id="remember">
                        Ingat saya
                    </label>
                </div>

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
                const {
                    outcome
                } = await deferredInstallPrompt.userChoice;
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