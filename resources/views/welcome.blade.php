<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Survey Deli Serdang</title>
    <link rel="icon" type="image/png" href="{{ asset('icons/icon-192x192.png') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            overflow: hidden;
            background: #000;
            height: 100vh;
            width: 100vw;
            font-family: 'Georgia', serif;
        }

        .video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
        }

        .video-container video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }

        /* ===== OVERLAY DARK ===== */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            background: rgba(0, 0, 0, 0.3);
            pointer-events: none;
        }

        /* ===== TITLE ANIMATION ===== */
        .title-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 3;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .title-text {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: clamp(2.5rem, 8vw, 6rem);
            font-weight: 700;
            color: #ffffff;
            text-shadow: 
                0 0 40px rgba(11, 93, 57, 0.6),
                0 0 80px rgba(11, 93, 57, 0.3),
                0 4px 30px rgba(0, 0, 0, 0.5);
            text-align: center;
            letter-spacing: 2px;
            animation: fadeInScale 2s ease forwards;
            opacity: 0;
            transform: scale(0.8);
            padding: 0 1rem;
        }

        .title-text .highlight {
            display: block;
            font-size: clamp(3rem, 10vw, 7rem);
            background: linear-gradient(135deg, #B9862E, #E7A94C, #B9862E);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
            animation: shimmerGold 3s ease-in-out infinite;
            background-size: 200% 200%;
        }

        .title-text .sub {
            display: block;
            font-size: clamp(0.8rem, 2vw, 1.5rem);
            font-weight: 300;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 0.5rem;
            font-family: 'Arial', sans-serif;
            animation: fadeInUp 2s ease forwards 1s;
            opacity: 0;
            -webkit-text-fill-color: rgba(255, 255, 255, 0.7);
        }

        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shimmerGold {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        /* ===== DECORATIVE LINE ===== */
        .decorative-line {
            position: fixed;
            bottom: 8%;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #B9862E, transparent);
            border-radius: 2px;
            animation: pulseLine 3s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes pulseLine {
            0%, 100% {
                width: 60px;
                opacity: 0.5;
            }
            50% {
                width: 120px;
                opacity: 1;
            }
        }

        /* ===== LOGIN BUTTON (minimal) ===== */
        .btn-login-minimal {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 4;
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.7rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            pointer-events: auto;
        }

        .btn-login-minimal:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            color: #fff;
            transform: scale(1.05);
        }

        .btn-login-minimal i {
            font-size: 0.8rem;
        }

        /* ===== LOGIN MODAL ===== */
        .login-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .login-modal.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .login-modal-content {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 2.5rem;
            max-width: 380px;
            width: 90%;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.4s ease;
            position: relative;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .login-modal-content .close-modal {
            position: absolute;
            top: 0.8rem;
            right: 0.8rem;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.5);
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-modal-content .close-modal:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(90deg);
            color: #fff;
        }

        .login-modal-content .modal-title {
            font-family: 'Georgia', serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
            color: #fff;
            text-align: center;
        }

        .login-modal-content .modal-title .gold {
            color: #B9862E;
        }

        .login-modal-content .modal-subtitle {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .login-modal-content .form-group {
            margin-bottom: 1rem;
        }

        .login-modal-content .form-group label {
            font-weight: 600;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            display: block;
            margin-bottom: 0.3rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .login-modal-content .form-group input {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-family: 'Arial', sans-serif;
        }

        .login-modal-content .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .login-modal-content .form-group input:focus {
            border-color: #B9862E;
            box-shadow: 0 0 0 4px rgba(185, 134, 46, 0.1);
            outline: none;
            background: rgba(255, 255, 255, 0.08);
        }

        .login-modal-content .btn-login {
            width: 100%;
            padding: 0.8rem;
            border-radius: 12px;
            background: linear-gradient(135deg, #B9862E, #E7A94C);
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px -8px rgba(185, 134, 46, 0.4);
            margin-top: 0.5rem;
        }

        .login-modal-content .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px -8px rgba(185, 134, 46, 0.5);
        }

        .login-modal-content .login-error {
            color: #e74c3c;
            font-size: 0.8rem;
            margin-top: 0.5rem;
            display: none;
            text-align: center;
        }

        .login-modal-content .login-error.show {
            display: block;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .title-text {
                font-size: clamp(2rem, 6vw, 3.5rem);
            }
            .title-text .highlight {
                font-size: clamp(2.5rem, 8vw, 4.5rem);
            }
            .title-text .sub {
                font-size: clamp(0.6rem, 1.5vw, 1rem);
                letter-spacing: 3px;
            }
            .btn-login-minimal {
                bottom: 1rem;
                right: 1rem;
                padding: 0.4rem 0.8rem;
                font-size: 0.6rem;
            }
            .login-modal-content {
                padding: 1.5rem;
            }
            .decorative-line {
                bottom: 5%;
            }
        }

        @media (max-width: 480px) {
            .title-text {
                font-size: 1.5rem;
            }
            .title-text .highlight {
                font-size: 2rem;
            }
            .title-text .sub {
                font-size: 0.5rem;
                letter-spacing: 2px;
            }
            .btn-login-minimal {
                bottom: 0.8rem;
                right: 0.8rem;
                padding: 0.3rem 0.6rem;
                font-size: 0.5rem;
            }
            .login-modal-content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- ===== VIDEO BACKGROUND ===== -->
    <a href="{{ route('public.users') }}" class="video-container">

    <video autoplay muted loop playsinline id="bgVideo">
        <source src="https://assets.mixkit.co/videos/preview/mixkit-abstract-wave-pattern-3696-large.mp4" type="video/mp4">
        <source src="https://assets.mixkit.co/videos/preview/mixkit-white-abstract-background-1902-large.mp4" type="video/mp4">
    </video>

</a>

    <!-- ===== OVERLAY ===== -->
    <div class="overlay"></div>

    <!-- ===== TITLE ===== -->
    <div class="title-wrapper">
        <div class="title-text">
            <span class="highlight">Survei Kamu</span>
            <span style="display:block;font-size:clamp(1.8rem,5vw,3.5rem);color:#ffffff;text-shadow:0 0 40px rgba(0,0,0,0.3);">
                Kepuasan Kami
            </span>
            <span class="sub">Kabupaten Deli Serdang</span>
        </div>
    </div>

    <!-- ===== DECORATIVE LINE ===== -->
    <div class="decorative-line"></div>

    

    <!-- ===== BOOTSTRAP ICONS ===== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <script>
       

        // ===== VIDEO LOADING FALLBACK =====
        document.getElementById('bgVideo').addEventListener('error', function() {
            this.src = 'https://assets.mixkit.co/videos/preview/mixkit-white-abstract-background-1902-large.mp4';
            this.load();
        });

        // ===== SPINNER STYLE =====
        const style = document.createElement('style');
        style.textContent = `@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }`;
        document.head.appendChild(style);
    </script>
</body>
</html>