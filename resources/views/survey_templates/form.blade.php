@extends('layouts.app')
@section('title', isset($template) ? 'Edit Template Survei' : 'Buat Template Survei')

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
    .form-wrapper {
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

    [data-theme="dark"] .form-wrapper {
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
    .form-content {
        position: relative;
        z-index: 1;
    }

    /* ===== HEADER ===== */
    .form-header {
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

    [data-theme="dark"] .form-header {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .form-header::before {
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

    [data-theme="dark"] .form-header::before {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.08) 0%, transparent 70%);
    }

    .form-header:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .form-header .header-title {
        font-size: 1.75rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    .form-header .header-badge {
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

    /* ===== MAIN CARD ===== */
    .form-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
    }

    [data-theme="dark"] .form-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .form-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .form-card .card-body-custom {
        padding: 2rem;
    }

    /* ===== FORM SECTIONS ===== */
    .form-section {
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid rgba(0, 0, 0, 0.04);
    }

    [data-theme="dark"] .form-section {
        border-bottom-color: rgba(255, 255, 255, 0.04);
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .form-section .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    [data-theme="dark"] .form-section .section-title {
        color: #e0e0e0;
    }

    .form-section .section-title i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .form-section .section-desc {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 1.25rem;
        padding-left: 1.8rem;
    }

    [data-theme="dark"] .form-section .section-desc {
        color: #adb5bd;
    }

    /* ===== FORM CONTROLS ===== */
    .form-label-custom {
        font-weight: 500;
        font-size: 0.85rem;
        color: #495057;
        margin-bottom: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    [data-theme="dark"] .form-label-custom {
        color: #e0e0e0;
    }

    .form-label-custom .required-star {
        color: var(--danger);
        font-size: 0.7rem;
    }

    .form-control-custom {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 2px solid rgba(0, 0, 0, 0.06);
        border-radius: 12px;
        padding: 0.7rem 1rem;
        font-size: 0.9rem;
        transition: var(--transition);
        color: #2c3e50;
        width: 100%;
    }

    [data-theme="dark"] .form-control-custom {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.08);
        color: #e0e0e0;
    }

    .form-control-custom:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(11, 93, 57, 0.1);
        background: rgba(255, 255, 255, 0.8);
        outline: none;
    }

    [data-theme="dark"] .form-control-custom:focus {
        border-color: #2ecc71;
        box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1);
        background: rgba(255, 255, 255, 0.08);
    }

    .form-control-custom::placeholder {
        color: #adb5bd;
        font-size: 0.85rem;
    }

    .form-control-custom:disabled,
    .form-control-custom[readonly] {
        background: rgba(0, 0, 0, 0.02);
        opacity: 0.7;
    }

    select.form-control-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.5rem;
        cursor: pointer;
    }

    textarea.form-control-custom {
        resize: vertical;
        min-height: 80px;
    }

    .form-help-text {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    [data-theme="dark"] .form-help-text {
        color: #adb5bd;
    }

    .form-help-text i {
        font-size: 0.7rem;
        opacity: 0.6;
    }

    /* ===== INPUT GROUP WITH ICON ===== */
    .input-group-custom {
        position: relative;
    }

    .input-group-custom .input-icon {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        display: flex;
        align-items: center;
        padding: 0 1rem;
        color: #6c757d;
        background: transparent;
        border: none;
        z-index: 5;
        font-size: 1rem;
        pointer-events: none;
    }

    .input-group-custom .form-control-custom {
        padding-left: 2.8rem;
    }

    /* ===== STATUS BADGE PREVIEW ===== */
    .status-preview {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    .status-preview .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 2s infinite;
    }

    .status-preview .status-dot.active {
        background: #28a745;
    }

    .status-preview .status-dot.draft {
        background: #ffc107;
    }

    .status-preview .status-dot.inactive {
        background: #dc3545;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.3); }
    }

    /* ===== BUTTONS ===== */
    .btn-save {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.8rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-save:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 30px rgba(11, 93, 57, 0.4);
        color: white;
    }

    .btn-save:active {
        transform: scale(0.98);
    }

    .btn-save i {
        font-size: 1.1rem;
    }

    .btn-cancel {
        background: rgba(108, 117, 125, 0.08);
        color: #6c757d;
        border: 2px solid rgba(108, 117, 125, 0.12);
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: rgba(108, 117, 125, 0.15);
        transform: translateY(-2px);
        color: #6c757d;
        text-decoration: none;
    }

    [data-theme="dark"] .btn-cancel {
        color: #adb5bd;
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-theme="dark"] .btn-cancel:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #adb5bd;
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

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .animate-in {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .animate-in:nth-child(1) { animation-delay: 0.05s; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .form-wrapper {
            padding: 1rem;
        }

        .form-header {
            padding: 1.25rem;
        }

        .form-header .header-title {
            font-size: 1.25rem;
        }

        .form-card .card-body-custom {
            padding: 1.25rem;
        }

        .form-section {
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-control-custom {
            padding: 0.6rem 0.8rem;
            font-size: 0.85rem;
        }

        .btn-save {
            width: 100%;
            justify-content: center;
        }

        .btn-cancel {
            width: 100%;
            justify-content: center;
            margin-top: 0.5rem;
        }

        .header-subtitle {
            font-size: 0.75rem;
            padding: 0.3rem 0.8rem;
        }

        .form-header .header-badge {
            font-size: 0.6rem;
            padding: 0.2rem 0.7rem;
        }
    }

    @media (max-width: 576px) {
        .form-header .header-title {
            font-size: 1rem;
        }

        .form-card .card-body-custom {
            padding: 1rem;
        }

        .form-section .section-title {
            font-size: 0.9rem;
        }

        .form-section .section-desc {
            font-size: 0.75rem;
            padding-left: 1.5rem;
        }

        .form-label-custom {
            font-size: 0.8rem;
        }

        .btn-save {
            font-size: 0.85rem;
            padding: 0.7rem 1.5rem;
        }

        .btn-cancel {
            font-size: 0.85rem;
            padding: 0.7rem 1.5rem;
        }

        .input-group-custom .input-icon {
            padding: 0 0.6rem;
            font-size: 0.85rem;
        }

        .input-group-custom .form-control-custom {
            padding-left: 2.2rem;
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
<div class="form-wrapper">
    <!-- Decorative Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <!-- ===== CONTENT ===== -->
    <div class="form-content">

        <!-- ===== HEADER ===== -->
        <div class="form-header animate-in">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <span class="text-uppercase small fw-bold" style="color:var(--primary); letter-spacing:0.05em; font-size:0.7rem;">
                            <i class="bi bi-pencil-square me-1"></i> 
                            {{ isset($template) ? 'Edit' : 'Buat' }}
                        </span>
                        <h4 class="header-title mt-1 mb-0">
                            <i class="bi {{ isset($template) ? 'bi-pencil-fill' : 'bi-plus-circle-fill' }} me-2"></i>
                            {{ isset($template) ? 'Edit Template Survei' : 'Buat Template Survei Baru' }}
                        </h4>
                    </div>
                    <span class="header-badge">
                        <i class="bi bi-file-earmark-text"></i> 
                        {{ isset($template) ? 'Edit Mode' : 'Create Mode' }}
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="header-subtitle">
                        <i class="bi bi-info-circle"></i> 
                        {{ isset($template) ? 'Perbarui data template survei' : 'Isi form untuk membuat template baru' }}
                    </div>
                    <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== MAIN CARD ===== -->
        <div class="form-card animate-in">
            <div class="card-body-custom">
                <form method="POST" action="{{ isset($template) ? route('survey-templates.update', $template) : route('survey-templates.store') }}" id="templateForm">
                    @csrf
                    @if(isset($template)) @method('PUT') @endif

                    <!-- ===== SECTION 1: INFORMASI TEMPLATE ===== -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-info-circle-fill"></i>
                            Informasi Template Survei
                        </div>
                        <div class="section-desc">
                            <i class="bi bi-info-circle"></i>
                            Informasi dasar tentang template survei yang akan dibuat
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label-custom">
                                    <i class="bi bi-hash"></i> Kode Survei
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-tag"></i></span>
                                    <input type="text" name="kode_survei" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('kode_survei', $template->kode_survei ?? 'SVY-' . str_pad(random_int(1,999), 3, '0', STR_PAD_LEFT)) }}" 
                                           placeholder="Contoh: SVY-001" required>
                                </div>
                                <div class="form-help-text">
                                    <i class="bi bi-info-circle"></i>
                                    Kode unik untuk identifikasi survei
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label-custom">
                                    <i class="bi bi-file-text"></i> Judul Survei
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-pencil"></i></span>
                                    <input type="text" name="judul_survei" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('judul_survei', $template->judul_survei ?? '') }}" 
                                           placeholder="Masukkan judul survei" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">
                                    <i class="bi bi-building"></i> Unit / Nama Layanan Digital
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-buildings"></i></span>
                                    <input type="text" name="unit_layanan" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('unit_layanan', $template->unit_layanan ?? '') }}" 
                                           placeholder="Contoh: Aplikasi SIPANDU, Website PPID, dsb." required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom">
                                    <i class="bi bi-card-text"></i> Deskripsi
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-icon" style="align-items:flex-start;padding-top:0.8rem;">
                                        <i class="bi bi-text-paragraph"></i>
                                    </span>
                                    <textarea name="deskripsi" rows="3" 
                                              class="form-control form-control-custom" 
                                              placeholder="Masukkan deskripsi survei (opsional)">{{ old('deskripsi', $template->deskripsi ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== SECTION 2: PERIODE & STATUS ===== -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-calendar-event"></i>
                            Periode & Status Survei
                        </div>
                        <div class="section-desc">
                            <i class="bi bi-info-circle"></i>
                            Tentukan kapan survei aktif dan statusnya
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label-custom">
                                    <i class="bi bi-calendar-plus"></i> Tanggal Mulai
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-calendar3"></i></span>
                                    <input type="date" name="tanggal_mulai" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('tanggal_mulai', isset($template->tanggal_mulai) ? $template->tanggal_mulai->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">
                                    <i class="bi bi-calendar-minus"></i> Tanggal Selesai
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-calendar3"></i></span>
                                    <input type="date" name="tanggal_selesai" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('tanggal_selesai', isset($template->tanggal_selesai) ? $template->tanggal_selesai->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">
                                    <i class="bi bi-circle-fill"></i> Status
                                    <span class="required-star">*</span>
                                </label>
                                <select name="status" class="form-control form-control-custom" required id="statusSelect">
                                    <option value="draft" @selected(old('status', $template->status ?? 'draft') === 'draft')>📝 Draft</option>
                                    <option value="aktif" @selected(old('status', $template->status ?? '') === 'aktif')>✅ Aktif</option>
                                    <option value="nonaktif" @selected(old('status', $template->status ?? '') === 'nonaktif')>⛔ Nonaktif</option>
                                </select>
                                <div class="form-help-text">
                                    <i class="bi bi-info-circle"></i>
                                    Status menentukan apakah survei dapat diakses publik
                                </div>
                                <!-- Status Preview -->
                                <div class="status-preview" id="statusPreview">
                                    <span class="status-dot draft"></span>
                                    <span>Draft</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== SECTION 3: POPUP SETTINGS ===== -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-window-stack"></i>
                            Pengaturan Pop Up di Website Dinas
                        </div>
                        <div class="section-desc">
                            <i class="bi bi-info-circle"></i>
                            Atur kapan pop up survei ini muncul ke pengunjung website dinas. Tanggal Mulai / Tanggal Selesai di atas menentukan <strong>rentang tanggal tayang</strong>; pengaturan di bawah ini menentukan <strong>waktu &amp; seberapa sering</strong> pop up muncul untuk tiap pengunjung.
                        </div>

                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label-custom">
                                    <i class="bi bi-clock-history"></i> Muncul Setelah (detik)
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-hourglass-split"></i></span>
                                    <input type="number" min="0" max="120" name="popup_tampil_setelah_detik" 
                                           class="form-control form-control-custom"
                                           value="{{ old('popup_tampil_setelah_detik', $template->popup_tampil_setelah_detik ?? 3) }}">
                                </div>
                                <div class="form-help-text">
                                    <i class="bi bi-info-circle"></i>
                                    Jeda sebelum pop up tampil setelah halaman selesai dimuat
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">
                                    <i class="bi bi-repeat"></i> Frekuensi Tampil
                                </label>
                                <select name="popup_frekuensi" class="form-control form-control-custom">
                                    @php $frekuensi = old('popup_frekuensi', $template->popup_frekuensi ?? 'sekali_per_sesi'); @endphp
                                    <option value="setiap_kunjungan" @selected($frekuensi === 'setiap_kunjungan')>🔄 Setiap Kunjungan</option>
                                    <option value="sekali_per_sesi" @selected($frekuensi === 'sekali_per_sesi')>🔄 Sekali per Sesi</option>
                                    <option value="sekali_per_hari" @selected($frekuensi === 'sekali_per_hari')>📅 Sekali per Hari</option>
                                    <option value="sekali_selamanya" @selected($frekuensi === 'sekali_selamanya')>✅ Sekali Saja</option>
                                </select>
                                <div class="form-help-text">
                                    <i class="bi bi-info-circle"></i>
                                    Seberapa sering pop up muncul untuk pengunjung yang sama
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">
                                    <i class="bi bi-sunrise"></i> Jam Mulai Tayang
                                    <span class="text-muted" style="font-weight:400;font-size:0.7rem;">(opsional)</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-clock"></i></span>
                                    <input type="time" name="popup_jam_mulai" 
                                           class="form-control form-control-custom"
                                           value="{{ old('popup_jam_mulai', $template->popup_jam_mulai ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">
                                    <i class="bi bi-sunset"></i> Jam Selesai Tayang
                                    <span class="text-muted" style="font-weight:400;font-size:0.7rem;">(opsional)</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-clock"></i></span>
                                    <input type="time" name="popup_jam_selesai" 
                                           class="form-control form-control-custom"
                                           value="{{ old('popup_jam_selesai', $template->popup_jam_selesai ?? '') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-help-text" style="background:rgba(11,93,57,0.04);padding:0.6rem 1rem;border-radius:8px;">
                                    <i class="bi bi-info-circle" style="color:var(--primary);"></i>
                                    Kosongkan jam mulai/selesai kalau pop up boleh tayang sepanjang hari.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== BUTTONS ===== -->
                    <div class="d-flex flex-wrap gap-3 pt-3">
                        <button type="submit" class="btn-save">
                            <i class="bi {{ isset($template) ? 'bi-pencil-fill' : 'bi-save-fill' }}"></i> 
                            {{ isset($template) ? 'Perbarui Template' : 'Simpan Template' }}
                        </button>
                        <a href="{{ route('survey-templates.index') }}" class="btn-cancel">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <span class="ms-auto text-muted small d-flex align-items-center">
                            <i class="bi bi-shield-check me-1" style="color:var(--primary);"></i>
                            {{ isset($template) ? 'Perubahan akan disimpan' : 'Template baru akan dibuat' }}
                        </span>
                    </div>

                </form>
            </div>
        </div>

        <!-- ===== FOOTER ===== -->
        <div class="text-center mt-4 py-3">
            <small class="text-muted opacity-50">
                <i class="bi bi-database"></i> Data template disimpan aman • 
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
    initStatusPreview();
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

// ===== STATUS PREVIEW =====
function initStatusPreview() {
    const statusSelect = document.getElementById('statusSelect');
    const preview = document.getElementById('statusPreview');
    
    if (!statusSelect || !preview) return;
    
    function updatePreview() {
        const value = statusSelect.value;
        const dot = preview.querySelector('.status-dot');
        const text = preview.querySelector('span:last-child');
        
        // Reset classes
        dot.className = 'status-dot';
        
        if (value === 'aktif') {
            dot.classList.add('active');
            text.textContent = 'Aktif - Survei dapat diakses publik';
            preview.style.background = 'rgba(40,167,69,0.08)';
            preview.style.color = '#28a745';
        } else if (value === 'draft') {
            dot.classList.add('draft');
            text.textContent = 'Draft - Survei belum dipublikasikan';
            preview.style.background = 'rgba(255,193,7,0.08)';
            preview.style.color = '#856404';
        } else {
            dot.classList.add('inactive');
            text.textContent = 'Nonaktif - Survei tidak dapat diakses';
            preview.style.background = 'rgba(220,53,69,0.08)';
            preview.style.color = '#dc3545';
        }
    }
    
    statusSelect.addEventListener('change', updatePreview);
    updatePreview();
}
</script>
@endsection