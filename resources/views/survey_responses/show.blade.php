@extends('layouts.app')
@section('title', 'Detail Respon Survei')

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
    .detail-wrapper {
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

    [data-theme="dark"] .detail-wrapper {
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
    .detail-content {
        position: relative;
        z-index: 1;
    }

    /* ===== BACK BUTTON ===== */
    .btn-back {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 2px solid rgba(0, 0, 0, 0.06);
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        font-size: 0.85rem;
        color: #495057;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    [data-theme="dark"] .btn-back {
        background: rgba(30, 30, 46, 0.6);
        border-color: rgba(255, 255, 255, 0.05);
        color: #adb5bd;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.9);
        transform: translateX(-4px);
        box-shadow: var(--card-shadow);
        color: var(--primary);
        text-decoration: none;
    }

    [data-theme="dark"] .btn-back:hover {
        background: rgba(30, 30, 46, 0.9);
        color: #2ecc71;
    }

    /* ===== HEADER ===== */
    .detail-header {
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

    [data-theme="dark"] .detail-header {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .detail-header::before {
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

    [data-theme="dark"] .detail-header::before {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.08) 0%, transparent 70%);
    }

    .detail-header:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .detail-header .header-title {
        font-size: 1.75rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    .detail-header .header-badge {
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

    /* ===== CARDS ===== */
    .detail-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        height: 100%;
    }

    [data-theme="dark"] .detail-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .detail-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .detail-card .card-header-custom {
        padding: 1rem 1.5rem;
        background: rgba(0, 0, 0, 0.02);
        border-bottom: 2px solid rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    [data-theme="dark"] .detail-card .card-header-custom {
        background: rgba(255, 255, 255, 0.02);
        border-bottom-color: rgba(255, 255, 255, 0.04);
    }

    .detail-card .card-header-custom .card-title {
        font-weight: 600;
        font-size: 1rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
    }

    [data-theme="dark"] .detail-card .card-header-custom .card-title {
        color: #e0e0e0;
    }

    .detail-card .card-header-custom .card-title i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .detail-card .card-body-custom {
        padding: 1.5rem;
    }

    /* ===== RESPONDEN INFO ===== */
    .responden-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.2);
    }

    [data-theme="dark"] .responden-avatar {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
    }

    .responden-info {
        flex: 1;
        min-width: 0;
    }

    .responden-info .responden-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
        line-height: 1.3;
    }

    [data-theme="dark"] .responden-info .responden-name {
        color: #e0e0e0;
    }

    .responden-info .responden-email {
        color: #6c757d;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    [data-theme="dark"] .responden-info .responden-email {
        color: #adb5bd;
    }

    .responden-info .responden-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem 1rem;
        margin-top: 0.3rem;
        font-size: 0.75rem;
        color: #6c757d;
    }

    [data-theme="dark"] .responden-info .responden-meta {
        color: #8a8a9a;
    }

    .responden-info .responden-meta i {
        font-size: 0.7rem;
        opacity: 0.6;
    }

    /* ===== TABEL RESPONDEN ===== */
    .table-detail {
        font-size: 0.85rem;
        margin-bottom: 0;
    }

    .table-detail tr {
        transition: var(--transition);
    }

    .table-detail tr:hover {
        background: rgba(11, 93, 57, 0.03);
    }

    [data-theme="dark"] .table-detail tr:hover {
        background: rgba(46, 204, 113, 0.03);
    }

    .table-detail td {
        padding: 0.6rem 0.8rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        vertical-align: middle;
    }

    [data-theme="dark"] .table-detail td {
        border-bottom-color: rgba(255, 255, 255, 0.03);
        color: #e0e0e0;
    }

    .table-detail .label-cell {
        color: #6c757d;
        font-weight: 500;
        width: 35%;
    }

    [data-theme="dark"] .table-detail .label-cell {
        color: #8a8a9a;
    }

    .table-detail .value-cell {
        color: #2c3e50;
        font-weight: 500;
    }

    [data-theme="dark"] .table-detail .value-cell {
        color: #e0e0e0;
    }

    /* ===== IKM SCORE ===== */
    .ikm-score-card {
        text-align: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(11, 93, 57, 0.04) 0%, rgba(26, 111, 160, 0.04) 100%);
        border-radius: 16px;
        border: 2px solid rgba(11, 93, 57, 0.06);
        transition: var(--transition);
    }

    [data-theme="dark"] .ikm-score-card {
        background: linear-gradient(135deg, rgba(46, 204, 113, 0.04) 0%, rgba(52, 152, 219, 0.04) 100%);
        border-color: rgba(46, 204, 113, 0.06);
    }

    .ikm-score-card:hover {
        transform: scale(1.02);
        border-color: var(--primary);
    }

    .ikm-score-card .ikm-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        font-weight: 500;
    }

    [data-theme="dark"] .ikm-score-card .ikm-label {
        color: #8a8a9a;
    }

    .ikm-score-card .ikm-value {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0.25rem 0;
    }

    .ikm-score-card .ikm-category {
        display: inline-block;
        padding: 0.3rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        margin-top: 0.3rem;
    }

    .ikm-score-card .ikm-category.A {
        background: rgba(40, 167, 69, 0.12);
        color: #28a745;
    }

    .ikm-score-card .ikm-category.B {
        background: rgba(185, 134, 46, 0.12);
        color: #B9862E;
    }

    .ikm-score-card .ikm-category.C {
        background: rgba(255, 193, 7, 0.12);
        color: #856404;
    }

    .ikm-score-card .ikm-category.D {
        background: rgba(220, 53, 69, 0.12);
        color: #dc3545;
    }

    /* ===== ANSWERS ===== */
    .answer-item {
        padding: 1rem 1.25rem;
        border-radius: 12px;
        background: rgba(0, 0, 0, 0.02);
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: var(--transition);
        margin-bottom: 0.75rem;
    }

    [data-theme="dark"] .answer-item {
        background: rgba(255, 255, 255, 0.02);
        border-color: rgba(255, 255, 255, 0.04);
    }

    .answer-item:hover {
        border-color: var(--primary);
        transform: translateX(4px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    }

    [data-theme="dark"] .answer-item:hover {
        border-color: #2ecc71;
    }

    .answer-item .answer-question {
        font-weight: 600;
        font-size: 0.9rem;
        color: #2c3e50;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }

    [data-theme="dark"] .answer-item .answer-question {
        color: #e0e0e0;
    }

    .answer-item .answer-question .q-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: rgba(11, 93, 57, 0.08);
        color: var(--primary);
        font-size: 0.7rem;
        font-weight: 700;
        flex-shrink: 0;
        margin-top: 0.1rem;
    }

    [data-theme="dark"] .answer-item .answer-question .q-number {
        background: rgba(46, 204, 113, 0.08);
        color: #2ecc71;
    }

    .answer-item .answer-value {
        margin-top: 0.4rem;
        padding-left: 2rem;
    }

    .answer-item .answer-value .badge-answer {
        padding: 0.3rem 0.9rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .answer-item .answer-value .badge-answer.scale {
        background: var(--primary-gradient);
        color: white;
    }

    [data-theme="dark"] .answer-item .answer-value .badge-answer.scale {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
    }

    .answer-item .answer-value .badge-answer.text {
        background: rgba(108, 117, 125, 0.08);
        color: #6c757d;
    }

    [data-theme="dark"] .answer-item .answer-value .badge-answer.text {
        background: rgba(255, 255, 255, 0.05);
        color: #adb5bd;
    }

    .answer-item .answer-value .badge-answer.star {
        background: rgba(241, 196, 15, 0.12);
        color: #f1c40f;
    }

    .answer-item .answer-value .badge-answer.star i {
        color: #f1c40f;
        margin-right: 0.2rem;
    }

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

    .animate-in {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .animate-in:nth-child(1) { animation-delay: 0.05s; }
    .animate-in:nth-child(2) { animation-delay: 0.1s; }
    .animate-in:nth-child(3) { animation-delay: 0.15s; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .detail-wrapper {
            padding: 1rem;
        }

        .detail-header {
            padding: 1.25rem;
        }

        .detail-header .header-title {
            font-size: 1.25rem;
        }

        .detail-card .card-body-custom {
            padding: 1.25rem;
        }

        .detail-card .card-header-custom {
            padding: 0.8rem 1.25rem;
        }

        .responden-avatar {
            width: 56px;
            height: 56px;
            font-size: 1.5rem;
        }

        .responden-info .responden-name {
            font-size: 1rem;
        }

        .ikm-score-card .ikm-value {
            font-size: 2.8rem;
        }

        .answer-item {
            padding: 0.8rem 1rem;
        }

        .header-subtitle {
            font-size: 0.75rem;
            padding: 0.3rem 0.8rem;
        }

        .detail-header .header-badge {
            font-size: 0.6rem;
            padding: 0.2rem 0.7rem;
        }

        .table-detail td {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
        }

        .table-detail .label-cell {
            width: 40%;
        }
    }

    @media (max-width: 576px) {
        .detail-header .header-title {
            font-size: 1rem;
        }

        .detail-card .card-body-custom {
            padding: 1rem;
        }

        .responden-avatar {
            width: 48px;
            height: 48px;
            font-size: 1.2rem;
        }

        .responden-info .responden-name {
            font-size: 0.9rem;
        }

        .responden-info .responden-meta {
            font-size: 0.65rem;
            gap: 0.3rem 0.6rem;
        }

        .ikm-score-card .ikm-value {
            font-size: 2.2rem;
        }

        .ikm-score-card .ikm-category {
            font-size: 0.75rem;
            padding: 0.2rem 1rem;
        }

        .answer-item .answer-question {
            font-size: 0.8rem;
        }

        .answer-item .answer-value {
            padding-left: 1.5rem;
        }

        .answer-item .answer-value .badge-answer {
            font-size: 0.7rem;
            padding: 0.2rem 0.7rem;
        }

        .btn-back {
            font-size: 0.75rem;
            padding: 0.4rem 1rem;
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
<div class="detail-wrapper">
    <!-- Decorative Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <!-- ===== CONTENT ===== -->
    <div class="detail-content">

        <!-- ===== HEADER ===== -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('survey-responses.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>
            <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode">
                <i class="bi bi-moon-fill" id="themeIcon"></i>
            </button>
        </div>

        <!-- ===== HEADER CARD ===== -->
        <div class="detail-header animate-in">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <span class="text-uppercase small fw-bold" style="color:var(--primary); letter-spacing:0.05em; font-size:0.7rem;">
                            <i class="bi bi-file-earmark-text me-1"></i> Detail Respon
                        </span>
                        <h4 class="header-title mt-1 mb-0">
                            <i class="bi bi-clipboard2-data me-2"></i> 
                            {{ $response->template->judul_survei ?? 'Detail Respon Survei' }}
                        </h4>
                    </div>
                    <span class="header-badge">
                        <i class="bi bi-check-circle-fill"></i> 
                        #{{ $response->id }}
                    </span>
                </div>
                <div class="header-subtitle">
                    <i class="bi bi-clock"></i> 
                    {{ optional($response->tanggal_isi)->format('d F Y H:i') ?: 'Tanggal tidak tersedia' }}
                </div>
            </div>
        </div>

        <!-- ===== CONTENT ROW ===== -->
        <div class="row g-4">

            <!-- ===== LEFT COLUMN ===== -->
            <div class="col-lg-4">
                
                <!-- Responden Card -->
                <div class="detail-card animate-in">
                    <div class="card-header-custom">
                        <span class="card-title">
                            <i class="bi bi-person-badge"></i>
                            Data Responden
                        </span>
                        <span class="badge-premium" style="background:rgba(11,93,57,0.08);color:var(--primary);font-size:0.65rem;padding:0.2rem 0.6rem;border-radius:50px;">
                            <i class="bi bi-shield-check"></i> Terverifikasi
                        </span>
                    </div>
                    <div class="card-body-custom">
                        <!-- Avatar & Name -->
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="responden-avatar">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="responden-info">
                                <h6 class="responden-name">{{ $response->nama_responden ?: 'Anonim' }}</h6>
                                <div class="responden-email">
                                    <i class="bi bi-envelope"></i>
                                    {{ $response->email ?: '-' }}
                                </div>
                            </div>
                        </div>

                        <!-- Detail Table -->
                        <table class="table table-detail">
                            <tbody>
                                @if ($response->template)
                                    @foreach ($response->template->identityFields as $f)
                                        @continue(in_array($f->field_key, ['nama_responden', 'email']))
                                        <tr>
                                            <td class="label-cell">
                                                <i class="bi bi-dot" style="color:var(--primary);font-size:0.5rem;"></i>
                                                {{ $f->label }}
                                            </td>
                                            <td class="value-cell">
                                                {{ data_get($response->data_tambahan, $f->field_key) ?: '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr>
                                    <td class="label-cell">
                                        <i class="bi bi-calendar3" style="color:var(--primary);font-size:0.8rem;"></i>
                                        Tanggal Isi
                                    </td>
                                    <td class="value-cell">{{ optional($response->tanggal_isi)->format('d-m-Y H:i') ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">
                                        <i class="bi bi-hdd-network" style="color:var(--primary);font-size:0.8rem;"></i>
                                        IP Address
                                    </td>
                                    <td class="value-cell">
                                        <code style="background:rgba(0,0,0,0.04);padding:0.1rem 0.5rem;border-radius:4px;font-size:0.75rem;">
                                            {{ $response->ip_address ?: '-' }}
                                        </code>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- IKM Score Card -->
                <div class="detail-card mt-4 animate-in">
                    <div class="card-body-custom">
                        <div class="ikm-score-card">
                            <div class="ikm-label">
                                <i class="bi bi-star-fill" style="color:var(--gold);"></i>
                                Nilai Indeks Kepuasan Masyarakat
                            </div>
                            <div class="ikm-value">
                                {{ $response->nilai_ikm ?? '-' }}
                            </div>
                            <div class="ikm-category {{ strtolower(substr($response->kategoriMutu() ?? 'C', 0, 1)) }}">
                                <i class="bi {{ 
                                    strtolower(substr($response->kategoriMutu() ?? 'C', 0, 1)) == 'a' ? 'bi-emoji-smile-fill' : 
                                    (strtolower(substr($response->kategoriMutu() ?? 'C', 0, 1)) == 'b' ? 'bi-emoji-neutral-fill' : 
                                    'bi-emoji-frown-fill') 
                                }}"></i>
                                {{ $response->kategoriMutu() ?: 'Belum dikategorikan' }}
                            </div>
                            <div class="mt-2" style="font-size:0.7rem;color:#6c757d;">
                                <i class="bi bi-info-circle"></i>
                                Berdasarkan Kepmenpan No. 14 Tahun 2017
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ===== RIGHT COLUMN ===== -->
            <div class="col-lg-8">
                <div class="detail-card animate-in">
                    <div class="card-header-custom">
                        <span class="card-title">
                            <i class="bi bi-list-check"></i>
                            Jawaban Survei
                        </span>
                        <span class="badge-premium" style="background:rgba(40,167,69,0.08);color:#28a745;font-size:0.65rem;padding:0.2rem 0.6rem;border-radius:50px;">
                            <i class="bi bi-check-circle"></i> {{ $response->answers->count() }} Jawaban
                        </span>
                    </div>
                    <div class="card-body-custom">
                        @forelse ($response->answers as $index => $a)
                            <div class="answer-item">
                                <div class="answer-question">
                                    <span class="q-number">{{ $index + 1 }}</span>
                                    <span>{{ $a->question->pertanyaan ?? 'Pertanyaan tidak tersedia' }}</span>
                                </div>
                                <div class="answer-value">
                                    @php
                                        $tipeJawabanIni = $a->question->tipe_jawaban ?? null;
                                        $labelBintangIni = null;
                                        if ($tipeJawabanIni === 'rating_bintang' && $a->nilai_skala) {
                                            $daftarLabelIni = (is_array($a->question->opsi_jawaban ?? null) && count($a->question->opsi_jawaban) >= 2)
                                                ? $a->question->opsi_jawaban
                                                : ['Tidak Sesuai', 'Kurang Sesuai', 'Agak Sesuai', 'Sesuai', 'Sangat Sesuai'];
                                            $labelBintangIni = $daftarLabelIni[$a->nilai_skala - 1] ?? null;
                                        }
                                    @endphp
                                    @if($tipeJawabanIni === 'rating_bintang' && $a->nilai_skala)
                                        <span class="badge-answer star">
                                            <i class="bi bi-star-fill"></i>
                                            {{ $labelBintangIni ?? $a->nilai_skala }} ({{ $a->nilai_skala }}/{{ is_array($a->question->opsi_jawaban ?? null) && count($a->question->opsi_jawaban) >= 2 ? count($a->question->opsi_jawaban) : 5 }})
                                        </span>
                                    @elseif($a->nilai_skala)
                                        <span class="badge-answer scale">
                                            <i class="bi bi-bar-chart-fill"></i>
                                            Skala {{ $a->nilai_skala }} / 4
                                        </span>
                                    @else
                                        <span class="badge-answer text">
                                            <i class="bi bi-chat"></i>
                                            {{ $a->jawaban ?: 'Tidak ada jawaban' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4" style="color:#6c757d;">
                                <i class="bi bi-inbox" style="font-size:2.5rem;display:block;margin-bottom:0.5rem;opacity:0.3;"></i>
                                <h6 style="font-weight:600;color:#495057;">Tidak Ada Jawaban</h6>
                                <small class="text-muted">Belum ada jawaban yang tercatat untuk survei ini.</small>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        <!-- ===== FOOTER ===== -->
        <div class="text-center mt-4 py-3">
            <small class="text-muted opacity-50">
                <i class="bi bi-shield-check"></i> Data respon tersimpan aman • 
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
