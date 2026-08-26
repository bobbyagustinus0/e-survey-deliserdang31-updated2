@extends('layouts.app')
@section('title', 'Isi Survey')

@section('content')
<style>
    /* ===== CSS VARIABLES ===== */
    :root {
        --primary: #0B5D39;
        --primary-light: #1a8a5a;
        --primary-dark: #08452a;
        --primary-gradient: linear-gradient(135deg, #0B5D39 0%, #1a8a5a 100%);
        --secondary: #6c757d;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
        --gold: #B9862E;
        --gold-light: #d4a84a;
        --gold-gradient: linear-gradient(135deg, #B9862E 0%, #d4a84a 100%);
        --purple: #6c3483;
        --purple-light: #8e44ad;
        --purple-gradient: linear-gradient(135deg, #6c3483 0%, #8e44ad 100%);
        --blue: #1a6fa0;
        --blue-light: #3498db;
        --blue-gradient: linear-gradient(135deg, #1a6fa0 0%, #3498db 100%);
        --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        --card-shadow-hover: 0 12px 48px rgba(0, 0, 0, 0.15);
        --border-radius: 20px;
        --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        --font-display: 'Inter', 'Segoe UI', system-ui, sans-serif;
    }

    /* ===== BACKGROUND ===== */
    .survey-wrapper {
        position: relative;
        min-height: 100vh;
        padding: 1.5rem;
        background: 
            radial-gradient(ellipse at 0% 0%, rgba(11, 93, 57, 0.06) 0%, transparent 50%),
            radial-gradient(ellipse at 100% 100%, rgba(185, 134, 46, 0.05) 0%, transparent 50%),
            radial-gradient(ellipse at 100% 0%, rgba(26, 111, 160, 0.04) 0%, transparent 40%),
            radial-gradient(ellipse at 0% 100%, rgba(108, 52, 131, 0.04) 0%, transparent 40%),
            #f0f2f5;
        background-attachment: fixed;
    }

    [data-theme="dark"] .survey-wrapper {
        background: 
            radial-gradient(ellipse at 0% 0%, rgba(46, 204, 113, 0.08) 0%, transparent 50%),
            radial-gradient(ellipse at 100% 100%, rgba(185, 134, 46, 0.06) 0%, transparent 50%),
            radial-gradient(ellipse at 100% 0%, rgba(52, 152, 219, 0.05) 0%, transparent 40%),
            radial-gradient(ellipse at 0% 100%, rgba(142, 68, 173, 0.05) 0%, transparent 40%),
            #12121c;
        background-attachment: fixed;
    }

    /* ===== DECORATIVE SHAPES ===== */
    .bg-shape {
        position: fixed;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
        opacity: 0.3;
        filter: blur(60px);
    }

    .bg-shape.shape-1 {
        width: 400px;
        height: 400px;
        top: -100px;
        right: -100px;
        background: radial-gradient(circle, rgba(11, 93, 57, 0.15), transparent);
    }

    .bg-shape.shape-2 {
        width: 300px;
        height: 300px;
        bottom: -50px;
        left: -50px;
        background: radial-gradient(circle, rgba(185, 134, 46, 0.1), transparent);
    }

    .bg-shape.shape-3 {
        width: 200px;
        height: 200px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: radial-gradient(circle, rgba(26, 111, 160, 0.06), transparent);
        animation: pulseShape 8s ease-in-out infinite;
    }

    [data-theme="dark"] .bg-shape.shape-1 {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.12), transparent);
    }
    [data-theme="dark"] .bg-shape.shape-2 {
        background: radial-gradient(circle, rgba(185, 134, 46, 0.08), transparent);
    }
    [data-theme="dark"] .bg-shape.shape-3 {
        background: radial-gradient(circle, rgba(52, 152, 219, 0.06), transparent);
    }

    @keyframes pulseShape {
        0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.3; }
        50% { transform: translate(-50%, -50%) scale(1.5); opacity: 0.6; }
    }

    /* ===== CONTENT ===== */
    .survey-content {
        position: relative;
        z-index: 1;
    }

    /* ===== HEADER ===== */
    .survey-header {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        padding: 1.75rem 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        border-left: 6px solid var(--primary);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    [data-theme="dark"] .survey-header {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .survey-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(11, 93, 57, 0.06) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    [data-theme="dark"] .survey-header::before {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.08) 0%, transparent 70%);
    }

    .survey-header:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .survey-header .header-title {
        font-size: 1.75rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    .survey-header .header-badge {
        background: var(--primary-gradient);
        color: white;
        padding: 0.3rem 1rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.3);
    }

    .header-subtitle {
        color: #6c757d;
        font-size: 0.85rem;
        background: rgba(108, 117, 125, 0.08);
        padding: 0.4rem 1rem;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        backdrop-filter: blur(10px);
    }

    [data-theme="dark"] .header-subtitle {
        color: #adb5bd;
        background: rgba(255, 255, 255, 0.05);
    }

    /* ===== STATS BADGE ===== */
    .survey-stats {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .stat-badge {
        background: rgba(11, 93, 57, 0.08);
        color: var(--primary);
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: var(--transition);
    }

    [data-theme="dark"] .stat-badge {
        background: rgba(46, 204, 113, 0.1);
        color: #2ecc71;
    }

    .stat-badge:hover {
        transform: scale(1.05);
    }

    .stat-badge i {
        font-size: 0.8rem;
    }

    /* ===== SURVEY CARDS ===== */
    .survey-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        height: 100%;
        position: relative;
    }

    [data-theme="dark"] .survey-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .survey-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
        opacity: 0;
        transition: var(--transition);
    }

    .survey-card:hover::before {
        opacity: 1;
    }

    .survey-card:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-6px) scale(1.01);
    }

    [data-theme="dark"] .survey-card:hover {
        background: rgba(30, 30, 46, 0.85);
    }

    .survey-card .card-body-custom {
        padding: 1.75rem;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    /* ===== CARD ICON ===== */
    .survey-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: rgba(11, 93, 57, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--primary);
        flex-shrink: 0;
        transition: var(--transition);
    }

    [data-theme="dark"] .survey-icon-wrapper {
        background: rgba(46, 204, 113, 0.08);
        color: #2ecc71;
    }

    .survey-card:hover .survey-icon-wrapper {
        background: var(--primary-gradient);
        color: white;
        transform: rotate(-5deg) scale(1.05);
    }

    [data-theme="dark"] .survey-card:hover .survey-icon-wrapper {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
        color: white;
    }

    /* ===== CARD CONTENT ===== */
    .survey-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
        line-height: 1.3;
    }

    [data-theme="dark"] .survey-title {
        color: #e0e0e0;
    }

    .survey-unit {
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    [data-theme="dark"] .survey-unit {
        color: #adb5bd;
    }

    .survey-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        flex-grow: 1;
        line-height: 1.6;
    }

    [data-theme="dark"] .survey-description {
        color: #adb5bd;
    }

    /* ===== CARD BADGES ===== */
    .survey-badge {
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: var(--transition);
    }

    .survey-badge:hover {
        transform: scale(1.05);
    }

    .survey-badge.filled {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.15);
    }

    [data-theme="dark"] .survey-badge.filled {
        background: rgba(40, 167, 69, 0.15);
        border-color: rgba(40, 167, 69, 0.2);
    }

    .survey-badge.active {
        background: rgba(11, 93, 57, 0.08);
        color: var(--primary);
        border: 1px solid rgba(11, 93, 57, 0.1);
    }

    [data-theme="dark"] .survey-badge.active {
        background: rgba(46, 204, 113, 0.1);
        color: #2ecc71;
        border-color: rgba(46, 204, 113, 0.15);
    }

    .survey-badge i {
        font-size: 0.65rem;
    }

    /* ===== CARD FOOTER ===== */
    .survey-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1.25rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(0, 0, 0, 0.04);
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    [data-theme="dark"] .survey-card-footer {
        border-top-color: rgba(255, 255, 255, 0.04);
    }

    .survey-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.75rem;
        color: #6c757d;
    }

    [data-theme="dark"] .survey-meta {
        color: #adb5bd;
    }

    .survey-meta i {
        font-size: 0.7rem;
        opacity: 0.6;
    }

    /* ===== BUTTONS ===== */
    .btn-survey {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.25);
        white-space: nowrap;
    }

    .btn-survey:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 30px rgba(11, 93, 57, 0.35);
        color: white;
    }

    .btn-survey:active {
        transform: scale(0.98);
    }

    .btn-survey i {
        font-size: 0.9rem;
    }

    .btn-survey-completed {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 2px solid rgba(108, 117, 125, 0.15);
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.85rem;
        cursor: default;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    [data-theme="dark"] .btn-survey-completed {
        color: #adb5bd;
        border-color: rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.03);
    }

    /* ===== EMPTY STATE ===== */
    .empty-state-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        padding: 4rem 2rem;
        text-align: center;
    }

    [data-theme="dark"] .empty-state-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(11, 93, 57, 0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2.5rem;
        color: var(--primary);
    }

    [data-theme="dark"] .empty-state-icon {
        background: rgba(46, 204, 113, 0.06);
        color: #2ecc71;
    }

    .empty-state-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    [data-theme="dark"] .empty-state-title {
        color: #e0e0e0;
    }

    .empty-state-desc {
        color: #6c757d;
        font-size: 0.95rem;
    }

    [data-theme="dark"] .empty-state-desc {
        color: #adb5bd;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .animate-in {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .animate-in:nth-child(1) { animation-delay: 0.05s; }
    .animate-in:nth-child(2) { animation-delay: 0.1s; }
    .animate-in:nth-child(3) { animation-delay: 0.15s; }
    .animate-in:nth-child(4) { animation-delay: 0.2s; }

    /* ===== THEME TOGGLE ===== */
    .theme-toggle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid rgba(0, 0, 0, 0.08);
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        cursor: pointer;
        font-size: 1.1rem;
        color: #495057;
    }

    .theme-toggle:hover {
        background: rgba(255, 255, 255, 0.8);
        transform: rotate(30deg);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    [data-theme="dark"] .theme-toggle {
        color: #e0e0e0;
        border-color: rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.05);
    }

    [data-theme="dark"] .theme-toggle:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    /* ===== BADGE PREMIUM ===== */
    .badge-premium {
        padding: 0.35rem 0.9rem;
        font-weight: 500;
        letter-spacing: 0.3px;
        border-radius: 50px;
        transition: var(--transition);
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .badge-premium:hover {
        transform: scale(1.05);
    }

    .badge-premium.bg-success {
        background: var(--primary-gradient) !important;
        color: white !important;
    }

    .badge-premium.bg-warning {
        background: var(--gold-gradient) !important;
        color: white !important;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .survey-wrapper {
            padding: 1rem;
        }

        .survey-header {
            padding: 1.25rem;
        }

        .survey-header .header-title {
            font-size: 1.25rem;
        }

        .survey-card .card-body-custom {
            padding: 1.25rem;
        }

        .survey-icon-wrapper {
            width: 48px;
            height: 48px;
            font-size: 1.2rem;
        }

        .survey-title {
            font-size: 0.95rem;
        }

        .survey-card-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-survey {
            justify-content: center;
            width: 100%;
        }

        .btn-survey-completed {
            justify-content: center;
            width: 100%;
        }

        .survey-meta {
            justify-content: center;
        }

        .header-subtitle {
            font-size: 0.75rem;
            padding: 0.3rem 0.8rem;
        }

        .empty-state-card {
            padding: 2.5rem 1.5rem;
        }

        .empty-state-icon {
            width: 60px;
            height: 60px;
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .survey-header .header-title {
            font-size: 1rem;
        }

        .survey-header .header-badge {
            font-size: 0.6rem;
            padding: 0.2rem 0.7rem;
        }

        .survey-card .card-body-custom {
            padding: 1rem;
        }

        .survey-icon-wrapper {
            width: 40px;
            height: 40px;
            font-size: 1rem;
            border-radius: 12px;
        }

        .survey-title {
            font-size: 0.9rem;
        }

        .survey-description {
            font-size: 0.8rem;
        }

        .survey-badge {
            font-size: 0.65rem;
            padding: 0.2rem 0.6rem;
        }
    }

    /* ===== SCROLLBAR ===== */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c7cd;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a8b0b8;
    }

    [data-theme="dark"] ::-webkit-scrollbar-thumb {
        background: #3a3a4a;
    }

    [data-theme="dark"] ::-webkit-scrollbar-thumb:hover {
        background: #4a4a5a;
    }
</style>

<!-- ===== BACKGROUND ===== -->
<div class="survey-wrapper">
    <!-- Decorative Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <!-- ===== CONTENT ===== -->
    <div class="survey-content">

        <!-- ===== HEADER ===== -->
        <div class="survey-header animate-in">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <span class="text-uppercase small fw-bold" style="color:var(--primary); letter-spacing:0.05em; font-size:0.7rem;">
                            <i class="bi bi-patch-check-fill me-1"></i> Survei Kepuasan Layanan
                        </span>
                        <h4 class="header-title mt-1 mb-0">
                            <i class="bi bi-clipboard2-check me-2"></i> Daftar Survei Aktif
                        </h4>
                    </div>
                    <span class="header-badge">
                        <i class="bi bi-check-circle-fill"></i> {{ count($templates) }} Survei
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="header-subtitle">
                        <i class="bi bi-info-circle"></i> 
                        Silakan pilih survei untuk memberikan penilaian
                    </div>
                    <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== SURVEY LIST ===== -->
        @if($templates->count() > 0)
            <div class="row g-4">
                @foreach($templates as $t)
                    <div class="col-md-6 col-lg-4 animate-in">
                        <div class="survey-card">
                            <div class="card-body-custom">
                                
                                <!-- Card Header -->
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <div class="survey-icon-wrapper">
                                        <i class="bi bi-clipboard2-check-fill"></i>
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <h6 class="survey-title">{{ Str::limit($t->judul_survei, 50) }}</h6>
                                        <div class="survey-unit">
                                            <i class="bi bi-building"></i>
                                            {{ $t->unit_layanan ?: 'Unit Layanan' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="survey-description">
                                    {{ Str::limit($t->deskripsi ?: 'Survei kepuasan layanan untuk meningkatkan kualitas pelayanan.', 120) }}
                                </p>

                                <!-- Badges -->
                                <div class="d-flex gap-2 mb-3 flex-wrap">
                                    @if($t->sudah_diisi > 0)
                                        <span class="survey-badge filled">
                                            <i class="bi bi-check-circle-fill"></i> Sudah diisi
                                        </span>
                                    @else
                                        <span class="survey-badge active">
                                            <i class="bi bi-dot"></i> Aktif
                                        </span>
                                    @endif
                                    @if($t->responden_count ?? 0 > 0)
                                        <span class="survey-badge" style="background:rgba(108,117,125,0.08);color:#6c757d;">
                                            <i class="bi bi-people"></i> {{ $t->responden_count }} responden
                                        </span>
                                    @endif
                                </div>

                                <!-- Card Footer -->
                                <div class="survey-card-footer">
                                    <div class="survey-meta">
                                        @if($t->created_at)
                                            <span>
                                                <i class="bi bi-calendar3"></i> {{ $t->created_at->format('d M Y') }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($t->sudah_diisi > 0)
                                        <span class="btn-survey-completed">
                                            <i class="bi bi-check-circle-fill"></i> Selesai
                                        </span>
                                    @else
                                        <a href="{{ route('user-survey.show', $t) }}" class="btn-survey">
                                            <i class="bi bi-pencil-square"></i> Isi Survei
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- ===== EMPTY STATE ===== -->
            <div class="animate-in">
                <div class="empty-state-card">
                    <div class="empty-state-icon">
                        <i class="bi bi-inboxes"></i>
                    </div>
                    <h5 class="empty-state-title">Belum Ada Survei Aktif</h5>
                    <p class="empty-state-desc">
                        Saat ini belum ada survei yang tersedia untuk diisi.
                        <br>Silakan cek kembali nanti untuk survei terbaru.
                    </p>
                    <div class="mt-4">
                        <span class="badge-premium bg-secondary" style="opacity:0.5;">
                            <i class="bi bi-clock"></i> Diperbarui secara berkala
                        </span>
                    </div>
                </div>
            </div>
        @endif

        <!-- ===== FOOTER ===== -->
        <div class="text-center mt-4 py-3">
            <small class="text-muted opacity-50">
                <i class="bi bi-shield-check"></i> Data survei diperbarui secara otomatis • 
                <span id="updateTime">{{ now()->format('H:i:s') }}</span> WIB
            </small>
        </div>

    </div>
</div>

<script>
// ===== THEME TOGGLE =====
function toggleTheme() {
    const html = document.documentElement;
    const icon = document.getElementById('themeIcon');
    const currentTheme = html.getAttribute('data-theme');
    
    if (currentTheme === 'dark') {
        html.removeAttribute('data-theme');
        icon.className = 'bi bi-moon-fill';
        localStorage.setItem('theme', 'light');
    } else {
        html.setAttribute('data-theme', 'dark');
        icon.className = 'bi bi-sun-fill';
        localStorage.setItem('theme', 'dark');
    }
}

// ===== LOAD SAVED THEME =====
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    const icon = document.getElementById('themeIcon');
    
    if (savedTheme === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
        if (icon) icon.className = 'bi bi-sun-fill';
    } else {
        if (icon) icon.className = 'bi bi-moon-fill';
    }
    
    // Update time
    updateTime();
});

// ===== UPDATE TIME =====
function updateTime() {
    const now = new Date();
    const timeEl = document.getElementById('updateTime');
    if (timeEl) {
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        timeEl.textContent = `${hours}:${minutes}:${seconds}`;
    }
}

setInterval(updateTime, 1000);
</script>
@endsection@extends('layouts.app')
@section('title', 'Isi Survey')

@section('content')
<style>
    /* ===== CSS VARIABLES ===== */
    :root {
        --primary: #0B5D39;
        --primary-light: #1a8a5a;
        --primary-dark: #08452a;
        --primary-gradient: linear-gradient(135deg, #0B5D39 0%, #1a8a5a 100%);
        --secondary: #6c757d;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
        --gold: #B9862E;
        --gold-light: #d4a84a;
        --gold-gradient: linear-gradient(135deg, #B9862E 0%, #d4a84a 100%);
        --purple: #6c3483;
        --purple-light: #8e44ad;
        --purple-gradient: linear-gradient(135deg, #6c3483 0%, #8e44ad 100%);
        --blue: #1a6fa0;
        --blue-light: #3498db;
        --blue-gradient: linear-gradient(135deg, #1a6fa0 0%, #3498db 100%);
        --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        --card-shadow-hover: 0 12px 48px rgba(0, 0, 0, 0.15);
        --border-radius: 20px;
        --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        --font-display: 'Inter', 'Segoe UI', system-ui, sans-serif;
    }

    /* ===== BACKGROUND ===== */
    .survey-wrapper {
        position: relative;
        min-height: 100vh;
        padding: 1.5rem;
        background: 
            radial-gradient(ellipse at 0% 0%, rgba(11, 93, 57, 0.06) 0%, transparent 50%),
            radial-gradient(ellipse at 100% 100%, rgba(185, 134, 46, 0.05) 0%, transparent 50%),
            radial-gradient(ellipse at 100% 0%, rgba(26, 111, 160, 0.04) 0%, transparent 40%),
            radial-gradient(ellipse at 0% 100%, rgba(108, 52, 131, 0.04) 0%, transparent 40%),
            #f0f2f5;
        background-attachment: fixed;
    }

    [data-theme="dark"] .survey-wrapper {
        background: 
            radial-gradient(ellipse at 0% 0%, rgba(46, 204, 113, 0.08) 0%, transparent 50%),
            radial-gradient(ellipse at 100% 100%, rgba(185, 134, 46, 0.06) 0%, transparent 50%),
            radial-gradient(ellipse at 100% 0%, rgba(52, 152, 219, 0.05) 0%, transparent 40%),
            radial-gradient(ellipse at 0% 100%, rgba(142, 68, 173, 0.05) 0%, transparent 40%),
            #12121c;
        background-attachment: fixed;
    }

    /* ===== DECORATIVE SHAPES ===== */
    .bg-shape {
        position: fixed;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
        opacity: 0.3;
        filter: blur(60px);
    }

    .bg-shape.shape-1 {
        width: 400px;
        height: 400px;
        top: -100px;
        right: -100px;
        background: radial-gradient(circle, rgba(11, 93, 57, 0.15), transparent);
    }

    .bg-shape.shape-2 {
        width: 300px;
        height: 300px;
        bottom: -50px;
        left: -50px;
        background: radial-gradient(circle, rgba(185, 134, 46, 0.1), transparent);
    }

    .bg-shape.shape-3 {
        width: 200px;
        height: 200px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: radial-gradient(circle, rgba(26, 111, 160, 0.06), transparent);
        animation: pulseShape 8s ease-in-out infinite;
    }

    [data-theme="dark"] .bg-shape.shape-1 {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.12), transparent);
    }
    [data-theme="dark"] .bg-shape.shape-2 {
        background: radial-gradient(circle, rgba(185, 134, 46, 0.08), transparent);
    }
    [data-theme="dark"] .bg-shape.shape-3 {
        background: radial-gradient(circle, rgba(52, 152, 219, 0.06), transparent);
    }

    @keyframes pulseShape {
        0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.3; }
        50% { transform: translate(-50%, -50%) scale(1.5); opacity: 0.6; }
    }

    /* ===== CONTENT ===== */
    .survey-content {
        position: relative;
        z-index: 1;
    }

    /* ===== HEADER ===== */
    .survey-header {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        padding: 1.75rem 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        border-left: 6px solid var(--primary);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    [data-theme="dark"] .survey-header {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .survey-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(11, 93, 57, 0.06) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    [data-theme="dark"] .survey-header::before {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.08) 0%, transparent 70%);
    }

    .survey-header:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .survey-header .header-title {
        font-size: 1.75rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    .survey-header .header-badge {
        background: var(--primary-gradient);
        color: white;
        padding: 0.3rem 1rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.3);
    }

    .header-subtitle {
        color: #6c757d;
        font-size: 0.85rem;
        background: rgba(108, 117, 125, 0.08);
        padding: 0.4rem 1rem;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        backdrop-filter: blur(10px);
    }

    [data-theme="dark"] .header-subtitle {
        color: #adb5bd;
        background: rgba(255, 255, 255, 0.05);
    }

    /* ===== STATS BADGE ===== */
    .survey-stats {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .stat-badge {
        background: rgba(11, 93, 57, 0.08);
        color: var(--primary);
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: var(--transition);
    }

    [data-theme="dark"] .stat-badge {
        background: rgba(46, 204, 113, 0.1);
        color: #2ecc71;
    }

    .stat-badge:hover {
        transform: scale(1.05);
    }

    .stat-badge i {
        font-size: 0.8rem;
    }

    /* ===== SURVEY CARDS ===== */
    .survey-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        height: 100%;
        position: relative;
    }

    [data-theme="dark"] .survey-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .survey-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
        opacity: 0;
        transition: var(--transition);
    }

    .survey-card:hover::before {
        opacity: 1;
    }

    .survey-card:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-6px) scale(1.01);
    }

    [data-theme="dark"] .survey-card:hover {
        background: rgba(30, 30, 46, 0.85);
    }

    .survey-card .card-body-custom {
        padding: 1.75rem;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    /* ===== CARD ICON ===== */
    .survey-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: rgba(11, 93, 57, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--primary);
        flex-shrink: 0;
        transition: var(--transition);
    }

    [data-theme="dark"] .survey-icon-wrapper {
        background: rgba(46, 204, 113, 0.08);
        color: #2ecc71;
    }

    .survey-card:hover .survey-icon-wrapper {
        background: var(--primary-gradient);
        color: white;
        transform: rotate(-5deg) scale(1.05);
    }

    [data-theme="dark"] .survey-card:hover .survey-icon-wrapper {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
        color: white;
    }

    /* ===== CARD CONTENT ===== */
    .survey-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
        line-height: 1.3;
    }

    [data-theme="dark"] .survey-title {
        color: #e0e0e0;
    }

    .survey-unit {
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    [data-theme="dark"] .survey-unit {
        color: #adb5bd;
    }

    .survey-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        flex-grow: 1;
        line-height: 1.6;
    }

    [data-theme="dark"] .survey-description {
        color: #adb5bd;
    }

    /* ===== CARD BADGES ===== */
    .survey-badge {
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: var(--transition);
    }

    .survey-badge:hover {
        transform: scale(1.05);
    }

    .survey-badge.filled {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.15);
    }

    [data-theme="dark"] .survey-badge.filled {
        background: rgba(40, 167, 69, 0.15);
        border-color: rgba(40, 167, 69, 0.2);
    }

    .survey-badge.active {
        background: rgba(11, 93, 57, 0.08);
        color: var(--primary);
        border: 1px solid rgba(11, 93, 57, 0.1);
    }

    [data-theme="dark"] .survey-badge.active {
        background: rgba(46, 204, 113, 0.1);
        color: #2ecc71;
        border-color: rgba(46, 204, 113, 0.15);
    }

    .survey-badge i {
        font-size: 0.65rem;
    }

    /* ===== CARD FOOTER ===== */
    .survey-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1.25rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(0, 0, 0, 0.04);
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    [data-theme="dark"] .survey-card-footer {
        border-top-color: rgba(255, 255, 255, 0.04);
    }

    .survey-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.75rem;
        color: #6c757d;
    }

    [data-theme="dark"] .survey-meta {
        color: #adb5bd;
    }

    .survey-meta i {
        font-size: 0.7rem;
        opacity: 0.6;
    }

    /* ===== BUTTONS ===== */
    .btn-survey {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.25);
        white-space: nowrap;
    }

    .btn-survey:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 30px rgba(11, 93, 57, 0.35);
        color: white;
    }

    .btn-survey:active {
        transform: scale(0.98);
    }

    .btn-survey i {
        font-size: 0.9rem;
    }

    .btn-survey-completed {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 2px solid rgba(108, 117, 125, 0.15);
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.85rem;
        cursor: default;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    [data-theme="dark"] .btn-survey-completed {
        color: #adb5bd;
        border-color: rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.03);
    }

    /* ===== EMPTY STATE ===== */
    .empty-state-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        padding: 4rem 2rem;
        text-align: center;
    }

    [data-theme="dark"] .empty-state-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(11, 93, 57, 0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2.5rem;
        color: var(--primary);
    }

    [data-theme="dark"] .empty-state-icon {
        background: rgba(46, 204, 113, 0.06);
        color: #2ecc71;
    }

    .empty-state-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    [data-theme="dark"] .empty-state-title {
        color: #e0e0e0;
    }

    .empty-state-desc {
        color: #6c757d;
        font-size: 0.95rem;
    }

    [data-theme="dark"] .empty-state-desc {
        color: #adb5bd;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .animate-in {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .animate-in:nth-child(1) { animation-delay: 0.05s; }
    .animate-in:nth-child(2) { animation-delay: 0.1s; }
    .animate-in:nth-child(3) { animation-delay: 0.15s; }
    .animate-in:nth-child(4) { animation-delay: 0.2s; }

    /* ===== THEME TOGGLE ===== */
    .theme-toggle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid rgba(0, 0, 0, 0.08);
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        cursor: pointer;
        font-size: 1.1rem;
        color: #495057;
    }

    .theme-toggle:hover {
        background: rgba(255, 255, 255, 0.8);
        transform: rotate(30deg);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    [data-theme="dark"] .theme-toggle {
        color: #e0e0e0;
        border-color: rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.05);
    }

    [data-theme="dark"] .theme-toggle:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    /* ===== BADGE PREMIUM ===== */
    .badge-premium {
        padding: 0.35rem 0.9rem;
        font-weight: 500;
        letter-spacing: 0.3px;
        border-radius: 50px;
        transition: var(--transition);
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .badge-premium:hover {
        transform: scale(1.05);
    }

    .badge-premium.bg-success {
        background: var(--primary-gradient) !important;
        color: white !important;
    }

    .badge-premium.bg-warning {
        background: var(--gold-gradient) !important;
        color: white !important;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .survey-wrapper {
            padding: 1rem;
        }

        .survey-header {
            padding: 1.25rem;
        }

        .survey-header .header-title {
            font-size: 1.25rem;
        }

        .survey-card .card-body-custom {
            padding: 1.25rem;
        }

        .survey-icon-wrapper {
            width: 48px;
            height: 48px;
            font-size: 1.2rem;
        }

        .survey-title {
            font-size: 0.95rem;
        }

        .survey-card-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-survey {
            justify-content: center;
            width: 100%;
        }

        .btn-survey-completed {
            justify-content: center;
            width: 100%;
        }

        .survey-meta {
            justify-content: center;
        }

        .header-subtitle {
            font-size: 0.75rem;
            padding: 0.3rem 0.8rem;
        }

        .empty-state-card {
            padding: 2.5rem 1.5rem;
        }

        .empty-state-icon {
            width: 60px;
            height: 60px;
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .survey-header .header-title {
            font-size: 1rem;
        }

        .survey-header .header-badge {
            font-size: 0.6rem;
            padding: 0.2rem 0.7rem;
        }

        .survey-card .card-body-custom {
            padding: 1rem;
        }

        .survey-icon-wrapper {
            width: 40px;
            height: 40px;
            font-size: 1rem;
            border-radius: 12px;
        }

        .survey-title {
            font-size: 0.9rem;
        }

        .survey-description {
            font-size: 0.8rem;
        }

        .survey-badge {
            font-size: 0.65rem;
            padding: 0.2rem 0.6rem;
        }
    }

    /* ===== SCROLLBAR ===== */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c7cd;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a8b0b8;
    }

    [data-theme="dark"] ::-webkit-scrollbar-thumb {
        background: #3a3a4a;
    }

    [data-theme="dark"] ::-webkit-scrollbar-thumb:hover {
        background: #4a4a5a;
    }
</style>

<!-- ===== BACKGROUND ===== -->
<div class="survey-wrapper">
    <!-- Decorative Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <!-- ===== CONTENT ===== -->
    <div class="survey-content">

        <!-- ===== HEADER ===== -->
        <div class="survey-header animate-in">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <span class="text-uppercase small fw-bold" style="color:var(--primary); letter-spacing:0.05em; font-size:0.7rem;">
                            <i class="bi bi-patch-check-fill me-1"></i> Survei Kepuasan Layanan
                        </span>
                        <h4 class="header-title mt-1 mb-0">
                            <i class="bi bi-clipboard2-check me-2"></i> Daftar Survei Aktif
                        </h4>
                    </div>
                    <span class="header-badge">
                        <i class="bi bi-check-circle-fill"></i> {{ count($templates) }} Survei
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="header-subtitle">
                        <i class="bi bi-info-circle"></i> 
                        Silakan pilih survei untuk memberikan penilaian
                    </div>
                    <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== SURVEY LIST ===== -->
        @if($templates->count() > 0)
            <div class="row g-4">
                @foreach($templates as $t)
                    <div class="col-md-6 col-lg-4 animate-in">
                        <div class="survey-card">
                            <div class="card-body-custom">
                                
                                <!-- Card Header -->
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <div class="survey-icon-wrapper">
                                        <i class="bi bi-clipboard2-check-fill"></i>
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <h6 class="survey-title">{{ Str::limit($t->judul_survei, 50) }}</h6>
                                        <div class="survey-unit">
                                            <i class="bi bi-building"></i>
                                            {{ $t->unit_layanan ?: 'Unit Layanan' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="survey-description">
                                    {{ Str::limit($t->deskripsi ?: 'Survei kepuasan layanan untuk meningkatkan kualitas pelayanan.', 120) }}
                                </p>

                                <!-- Badges -->
                                <div class="d-flex gap-2 mb-3 flex-wrap">
                                    @if($t->sudah_diisi > 0)
                                        <span class="survey-badge filled">
                                            <i class="bi bi-check-circle-fill"></i> Sudah diisi
                                        </span>
                                    @else
                                        <span class="survey-badge active">
                                            <i class="bi bi-dot"></i> Aktif
                                        </span>
                                    @endif
                                    @if($t->responden_count ?? 0 > 0)
                                        <span class="survey-badge" style="background:rgba(108,117,125,0.08);color:#6c757d;">
                                            <i class="bi bi-people"></i> {{ $t->responden_count }} responden
                                        </span>
                                    @endif
                                </div>

                                <!-- Card Footer -->
                                <div class="survey-card-footer">
                                    <div class="survey-meta">
                                        @if($t->created_at)
                                            <span>
                                                <i class="bi bi-calendar3"></i> {{ $t->created_at->format('d M Y') }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($t->sudah_diisi > 0)
                                        <span class="btn-survey-completed">
                                            <i class="bi bi-check-circle-fill"></i> Selesai
                                        </span>
                                    @else
                                        <a href="{{ route('user-survey.show', $t) }}" class="btn-survey">
                                            <i class="bi bi-pencil-square"></i> Isi Survei
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- ===== EMPTY STATE ===== -->
            <div class="animate-in">
                <div class="empty-state-card">
                    <div class="empty-state-icon">
                        <i class="bi bi-inboxes"></i>
                    </div>
                    <h5 class="empty-state-title">Belum Ada Survei Aktif</h5>
                    <p class="empty-state-desc">
                        Saat ini belum ada survei yang tersedia untuk diisi.
                        <br>Silakan cek kembali nanti untuk survei terbaru.
                    </p>
                    <div class="mt-4">
                        <span class="badge-premium bg-secondary" style="opacity:0.5;">
                            <i class="bi bi-clock"></i> Diperbarui secara berkala
                        </span>
                    </div>
                </div>
            </div>
        @endif

        <!-- ===== FOOTER ===== -->
        <div class="text-center mt-4 py-3">
            <small class="text-muted opacity-50">
                <i class="bi bi-shield-check"></i> Data survei diperbarui secara otomatis • 
                <span id="updateTime">{{ now()->format('H:i:s') }}</span> WIB
            </small>
        </div>

    </div>
</div>

<script>
// ===== THEME TOGGLE =====
function toggleTheme() {
    const html = document.documentElement;
    const icon = document.getElementById('themeIcon');
    const currentTheme = html.getAttribute('data-theme');
    
    if (currentTheme === 'dark') {
        html.removeAttribute('data-theme');
        icon.className = 'bi bi-moon-fill';
        localStorage.setItem('theme', 'light');
    } else {
        html.setAttribute('data-theme', 'dark');
        icon.className = 'bi bi-sun-fill';
        localStorage.setItem('theme', 'dark');
    }
}

// ===== LOAD SAVED THEME =====
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    const icon = document.getElementById('themeIcon');
    
    if (savedTheme === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
        if (icon) icon.className = 'bi bi-sun-fill';
    } else {
        if (icon) icon.className = 'bi bi-moon-fill';
    }
    
    // Update time
    updateTime();
});

// ===== UPDATE TIME =====
function updateTime() {
    const now = new Date();
    const timeEl = document.getElementById('updateTime');
    if (timeEl) {
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        timeEl.textContent = `${hours}:${minutes}:${seconds}`;
    }
}

setInterval(updateTime, 1000);
</script>
@endsection