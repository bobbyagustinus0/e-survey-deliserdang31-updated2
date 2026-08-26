<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} • Profil & Komentar</title>

    <!-- Font & Ikon -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz@14..32&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: 
                linear-gradient(135deg, rgba(10, 38, 71, 0.92) 0%, rgba(31, 74, 122, 0.80) 100%),
                url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
            background-size: cover, auto;
            background-blend-mode: overlay;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
            position: relative;
        }

        /* Efek ornamen lingkaran dekoratif */
        body::before {
            content: '';
            position: fixed;
            top: -200px;
            right: -200px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -150px;
            left: -150px;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            max-width: 880px;
            width: 100%;
            background: #ffffff;
            border-radius: 32px;
            padding: 42px 38px;
            box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.5);
            transition: all 0.3s;
            position: relative;
            z-index: 1;
        }

        /* ===== TOP NAV ===== */
        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 12px 0;
        }

        .back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-weight: 500;
            color: #2563eb;
            font-size: 14px;
            transition: 0.2s;
        }

        .back i {
            font-size: 14px;
            transition: transform 0.2s;
        }

        .back:hover {
            color: #1d4ed8;
        }

        .back:hover i {
            transform: translateX(-4px);
        }

        .login-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            background: #2563eb;
            color: white;
            padding: 12px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25);
        }

        .login-button i {
            font-size: 14px;
        }

        .login-button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.35);
        }

        /* ===== PROFILE ===== */
        .profile {
            background: #f8fafc;
            padding: 38px 28px 30px;
            border-radius: 24px;
            margin-bottom: 34px;
            text-align: center;
            border: 1px solid #eef2f6;
            transition: all 0.3s;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #1a4a8a);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 38px;
            font-weight: 700;
            box-shadow: 0 12px 32px -8px rgba(37, 99, 235, 0.25);
            border: 3px solid white;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 16px 40px -8px rgba(37, 99, 235, 0.35);
        }

        .profile h1 {
            font-size: 28px;
            font-weight: 700;
            color: #0a1e32;
            margin-bottom: 6px;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .profile h1 i {
            font-size: 22px;
            color: #2563eb;
            opacity: 0.4;
        }

        .profile .badge {
            background: #eff6ff;
            padding: 8px 22px;
            border-radius: 60px;
            font-size: 14px;
            color: #2563eb;
            font-weight: 500;
            display: inline-block;
            border: 1px solid #dbeafe;
        }

        .profile .badge i {
            margin-right: 8px;
            font-size: 13px;
        }

        /* ===== SECTION TITLE ===== */
        .section-title {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 22px;
            margin-top: 6px;
        }

        .section-title h2 {
            font-size: 22px;
            font-weight: 600;
            color: #0a1e32;
            letter-spacing: -0.2px;
        }

        .section-title i {
            font-size: 22px;
            color: #2563eb;
            opacity: 0.3;
        }

        .section-title .line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, #e2e8f0, transparent);
        }

        /* ===== KOMENTAR ===== */
        .comment-list {
            display: grid;
            gap: 14px;
        }

        .comment {
            background: #f8fafc;
            padding: 22px 26px;
            border-radius: 20px;
            border: 1px solid #eef2f6;
            transition: all 0.3s;
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .comment:hover {
            background: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.06);
            transform: translateY(-3px);
        }

        .comment-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 18px;
            flex-shrink: 0;
            border: 1px solid #dbeafe;
            transition: all 0.3s;
        }

        .comment:hover .comment-avatar {
            background: #2563eb;
            color: white;
            transform: scale(1.05);
        }

        .comment-body {
            flex: 1;
        }

        .comment-body .meta {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 6px;
        }

        .comment-body .meta strong {
            font-weight: 600;
            color: #0a1e32;
            font-size: 15px;
        }

        .comment-body .meta span {
            font-size: 13px;
            color: #7a8fa5;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .comment-body .meta span i {
            font-size: 12px;
            opacity: 0.6;
        }

        .comment-body p {
            line-height: 1.7;
            color: #1e334b;
            font-size: 15px;
            word-break: break-word;
        }

        /* ===== EMPTY STATE ===== */
        .empty {
            background: #f8fafc;
            padding: 40px 24px;
            border-radius: 20px;
            text-align: center;
            border: 1px dashed #dce2ea;
            color: #7a8fa5;
            font-weight: 400;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .empty i {
            font-size: 36px;
            color: #bcc9d8;
            margin-bottom: 4px;
        }

        .empty span:last-child {
            font-size: 14px;
            opacity: 0.6;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 640px) {
            .container {
                padding: 28px 18px;
                border-radius: 24px;
            }

            .top-nav {
                flex-wrap: wrap;
                gap: 10px;
            }

            .back {
                font-size: 13px;
            }

            .login-button {
                padding: 10px 20px;
                font-size: 13px;
                border-radius: 10px;
            }

            .profile {
                padding: 28px 16px 24px;
                border-radius: 20px;
            }

            .avatar {
                width: 80px;
                height: 80px;
                font-size: 30px;
            }

            .profile h1 {
                font-size: 24px;
            }

            .section-title h2 {
                font-size: 19px;
            }

            .comment {
                padding: 18px 18px;
                border-radius: 18px;
                flex-direction: column;
                gap: 10px;
            }

            .comment-avatar {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .comment-body .meta strong {
                font-size: 14px;
            }

            .comment-body p {
                font-size: 14px;
            }
        }

        @media (max-width: 420px) {
            .container {
                padding: 20px 12px;
                border-radius: 18px;
            }

            .profile h1 {
                font-size: 20px;
            }

            .comment {
                padding: 16px 14px;
            }
        }

        /* ===== ANIMASI ===== */
        .comment {
            animation: slideUp 0.4s ease forwards;
            opacity: 0;
        }

        @keyframes slideUp {
            0% { opacity: 0; transform: translateY(16px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .comment:nth-child(1) { animation-delay: 0.05s; }
        .comment:nth-child(2) { animation-delay: 0.10s; }
        .comment:nth-child(3) { animation-delay: 0.15s; }
        .comment:nth-child(4) { animation-delay: 0.20s; }
        .comment:nth-child(5) { animation-delay: 0.25s; }
    </style>
</head>

<body>

<div class="container">

    <!-- ===== NAVIGASI ===== -->
    <div class="top-nav">
        <a href="{{ route('public.users') }}" class="back">
            <i class="fas fa-arrow-left"></i> Kembali ke pengguna
        </a>
        <a href="{{ route('login') }}" class="login-button">
            <i class="fas fa-lock"></i> Login
        </a>
    </div>

    <!-- ===== PROFILE USER ===== -->
    <div class="profile">
        <div class="avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <h1>
            {{ $user->name }}
            <i class="fas fa-circle-check"></i>
        </h1>
        <div class="badge">
            <i class="fas fa-user"></i> Pengguna E-Survey
        </div>
    </div>

    <!-- ===== KOMENTAR ===== -->
    <div class="section-title">
        <i class="fas fa-comment-dots"></i>
        <h2>Komentar Survei</h2>
        <span class="line"></span>
    </div>

    <div class="comment-list">

    @forelse($user->surveyResponses as $response)

        <div class="comment">

            <div class="comment-avatar">
                <i class="fas fa-user"></i>
            </div>

            <div class="comment-body">

                <div class="meta">
                    <strong>{{ $user->name }}</strong>

                    <span>
                        <i class="fas fa-calendar-day"></i>
                        {{ optional($response->tanggal_isi)->format('d M Y') ?? 'Baru saja' }}
                    </span>
                </div>

                @if($response->template)
                    <div style="margin-bottom: 12px; color: #2563eb; font-weight: 600;">
                        <i class="fas fa-clipboard-list"></i>
                        {{ $response->template->judul_survei }}
                    </div>
                @endif

                @forelse($response->answers as $answer)

                    @if(!empty($answer->jawaban))

                        <div style="margin-bottom: 12px;">

                            @if($answer->question)
                                <div style="
                                    font-size: 13px;
                                    color: #7a8fa5;
                                    margin-bottom: 4px;
                                ">
                                    {{ $answer->question->pertanyaan }}
                                </div>
                            @endif

                            <p>
                                {{ $answer->jawaban }}
                            </p>

                        </div>

                    @endif

                @empty

                    <p>Belum ada jawaban tertulis.</p>

                @endforelse

                @if($response->nilai_ikm !== null)

                    <div style="
                        margin-top: 10px;
                        padding-top: 10px;
                        border-top: 1px solid #e2e8f0;
                        font-size: 14px;
                        color: #64748b;
                    ">
                        Nilai IKM:
                        <strong>{{ $response->nilai_ikm }}</strong>
                    </div>

                @endif

            </div>

        </div>

    @empty

        <div class="empty">
            <i class="fas fa-comment-slash"></i>
            <span>Belum ada komentar dari pengguna ini.</span>
            <span>Pantau terus tanggapan survei.</span>
        </div>

    @endforelse

</div>
       
    </div>

</div>

</body>
</html>