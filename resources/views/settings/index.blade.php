@extends('layouts.app')
@section('title', 'Pengaturan')

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
    .settings-wrapper {
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

    [data-theme="dark"] .settings-wrapper {
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

    [data-theme="dark"] .bg-shape.shape-1 {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.12), transparent);
    }
    [data-theme="dark"] .bg-shape.shape-2 {
        background: radial-gradient(circle, rgba(185, 134, 46, 0.08), transparent);
    }

    /* ===== CONTENT ===== */
    .settings-content {
        position: relative;
        z-index: 1;
    }

    /* ===== HEADER ===== */
    .settings-header {
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

    [data-theme="dark"] .settings-header {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .settings-header::before {
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

    [data-theme="dark"] .settings-header::before {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.08) 0%, transparent 70%);
    }

    .settings-header:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .settings-header .header-title {
        font-size: 1.75rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .settings-header .header-badge {
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

    .settings-header .header-subtitle {
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

    [data-theme="dark"] .settings-header .header-subtitle {
        color: #adb5bd;
        background: rgba(255, 255, 255, 0.05);
    }

    /* ===== MAIN CARD ===== */
    .settings-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
    }

    [data-theme="dark"] .settings-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .settings-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .settings-card .card-body-custom {
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

    /* ===== SPECIAL INPUT GROUPS ===== */
    .input-group-custom {
        position: relative;
    }

    .input-group-custom .input-group-text-custom {
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
    }

    .input-group-custom .form-control-custom {
        padding-left: 2.8rem;
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

    .btn-reset {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 2px solid rgba(108, 117, 125, 0.15);
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-reset:hover {
        background: rgba(108, 117, 125, 0.15);
        transform: translateY(-2px);
    }

    [data-theme="dark"] .btn-reset {
        color: #adb5bd;
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-theme="dark"] .btn-reset:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    /* ===== FLOATING LABEL EFFECT ===== */
    .form-floating-custom {
        position: relative;
    }

    .form-floating-custom .form-control-custom {
        padding-top: 1.2rem;
        padding-bottom: 0.4rem;
    }

    .form-floating-custom .form-label-custom {
        position: absolute;
        top: 0.7rem;
        left: 1rem;
        font-size: 0.7rem;
        opacity: 0.6;
        transition: var(--transition);
        pointer-events: none;
        margin-bottom: 0;
        font-weight: 400;
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
        .settings-wrapper {
            padding: 1rem;
        }

        .settings-header {
            padding: 1.25rem;
        }

        .settings-header .header-title {
            font-size: 1.25rem;
        }

        .settings-card .card-body-custom {
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

        .btn-reset {
            width: 100%;
            justify-content: center;
            margin-top: 0.5rem;
        }

        .settings-header .header-subtitle {
            font-size: 0.75rem;
            padding: 0.3rem 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .settings-header .header-title {
            font-size: 1rem;
        }

        .settings-header .header-badge {
            font-size: 0.6rem;
            padding: 0.2rem 0.7rem;
        }

        .settings-card .card-body-custom {
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

        .btn-reset {
            font-size: 0.85rem;
            padding: 0.7rem 1.5rem;
        }
    }

    /* ===== TOGGLE DARK MODE ===== */
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
<div class="settings-wrapper">
    <!-- Decorative Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <!-- ===== CONTENT ===== -->
    <div class="settings-content">

        <!-- ===== HEADER ===== -->
        <div class="settings-header animate-in">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <span class="text-uppercase small fw-bold" style="color:var(--primary); letter-spacing:0.05em; font-size:0.7rem;">
                            <i class="bi bi-sliders2 me-1"></i> Konfigurasi
                        </span>
                        <h4 class="header-title mt-1 mb-0">
                            <i class="bi bi-gear-fill"></i> Pengaturan Aplikasi
                        </h4>
                    </div>
                    <span class="header-badge">
                        <i class="bi bi-shield-lock-fill"></i> Admin
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="header-subtitle">
                        <i class="bi bi-info-circle"></i> 
                        Kelola konfigurasi sistem
                    </div>
                    <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== MAIN CARD ===== -->
        <div class="settings-card animate-in">
            <div class="card-body-custom">
                <form method="POST" action="{{ route('pengaturan.update') }}" id="settingsForm">
                    @csrf @method('PUT')

                    <!-- ===== SECTION 1: INFORMASI UMUM ===== -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-building"></i>
                            Informasi Umum
                        </div>
                        <div class="section-desc">
                            <i class="bi bi-info-circle"></i>
                            Informasi dasar yang akan ditampilkan di seluruh aplikasi
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">
                                    <i class="bi bi-tag"></i> Nama Aplikasi
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-group-text-custom">
                                        <i class="bi bi-app-indicator"></i>
                                    </span>
                                    <input type="text" name="nama_aplikasi" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('nama_aplikasi', $settings['nama_aplikasi']) }}" 
                                           placeholder="Masukkan nama aplikasi" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">
                                    <i class="bi bi-building"></i> Nama Instansi
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-group-text-custom">
                                        <i class="bi bi-buildings"></i>
                                    </span>
                                    <input type="text" name="nama_instansi" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('nama_instansi', $settings['nama_instansi']) }}" 
                                           placeholder="Masukkan nama instansi" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">
                                    <i class="bi bi-geo-alt"></i> Alamat Instansi
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-group-text-custom">
                                        <i class="bi bi-pin-map"></i>
                                    </span>
                                    <input type="text" name="alamat_instansi" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('alamat_instansi', $settings['alamat_instansi']) }}" 
                                           placeholder="Masukkan alamat lengkap instansi">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">
                                    <i class="bi bi-envelope"></i> Email Kontak
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-group-text-custom">
                                        <i class="bi bi-at"></i>
                                    </span>
                                    <input type="email" name="email_kontak" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('email_kontak', $settings['email_kontak']) }}" 
                                           placeholder="Masukkan email kontak">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">
                                    <i class="bi bi-telephone"></i> Telepon Kontak
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-group-text-custom">
                                        <i class="bi bi-phone"></i>
                                    </span>
                                    <input type="text" name="telepon_kontak" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('telepon_kontak', $settings['telepon_kontak']) }}" 
                                           placeholder="Masukkan nomor telepon kontak">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== SECTION 2: IKM ===== -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-bar-chart-fill"></i>
                            Batas Nilai Indeks Kepuasan Masyarakat (IKM)
                        </div>
                        <div class="section-desc">
                            <i class="bi bi-info-circle"></i>
                            Sesuai standar Kepmenpan No. 14 Tahun 2017. Nilai IKM berskala 0-100.
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label-custom">
                                    <span class="badge-premium bg-success" style="font-size:0.7rem;">
                                        <i class="bi bi-star-fill"></i> A - Sangat Baik
                                    </span>
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-group-text-custom">
                                        <i class="bi bi-arrow-up-circle"></i>
                                    </span>
                                    <input type="number" step="0.01" name="batas_ikm_a" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('batas_ikm_a', $settings['batas_ikm_a']) }}" 
                                           placeholder="Contoh: 80" required>
                                </div>
                                <div class="form-help-text">
                                    <i class="bi bi-info-circle"></i>
                                    Minimal nilai untuk kategori Sangat Baik
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">
                                    <span class="badge-premium bg-warning" style="font-size:0.7rem;">
                                        <i class="bi bi-check-circle"></i> B - Baik
                                    </span>
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-group-text-custom">
                                        <i class="bi bi-arrow-right-circle"></i>
                                    </span>
                                    <input type="number" step="0.01" name="batas_ikm_b" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('batas_ikm_b', $settings['batas_ikm_b']) }}" 
                                           placeholder="Contoh: 60" required>
                                </div>
                                <div class="form-help-text">
                                    <i class="bi bi-info-circle"></i>
                                    Minimal nilai untuk kategori Baik
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">
                                    <span class="badge-premium bg-danger" style="font-size:0.7rem;">
                                        <i class="bi bi-exclamation-triangle"></i> C - Kurang Baik
                                    </span>
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-group-text-custom">
                                        <i class="bi bi-arrow-down-circle"></i>
                                    </span>
                                    <input type="number" step="0.01" name="batas_ikm_c" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('batas_ikm_c', $settings['batas_ikm_c']) }}" 
                                           placeholder="Contoh: 40" required>
                                </div>
                                <div class="form-help-text">
                                    <i class="bi bi-info-circle"></i>
                                    Minimal nilai untuk kategori Kurang Baik
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== SECTION 3: LANDING PAGE & CHATBOT ===== -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-chat-dots-fill"></i>
                            Halaman Depan (Landing Page) &amp; Chatbot Publik
                        </div>
                        <div class="section-desc">
                            <i class="bi bi-info-circle"></i>
                            Pengaturan interaksi dengan pengunjung di halaman depan
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">
                                    <i class="bi bi-clock-history"></i> Popup Ajakan Isi Survei
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-group-text-custom">
                                        <i class="bi bi-hourglass-split"></i>
                                    </span>
                                    <input type="number" step="0.5" min="0" name="popup_delay_menit" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('popup_delay_menit', $settings['popup_delay_menit']) }}" 
                                           placeholder="Contoh: 5" required>
                                </div>
                                <div class="form-help-text">
                                    <i class="bi bi-info-circle"></i>
                                    Waktu tunggu di halaman depan sebelum popup ajakan isi survei muncul otomatis (dalam menit)
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">
                                    <i class="bi bi-robot"></i> Chatbot Kasih Link Survei
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-group-text-custom">
                                        <i class="bi bi-clock"></i>
                                    </span>
                                    <input type="number" step="0.5" min="0" name="chatbot_link_delay_menit" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('chatbot_link_delay_menit', $settings['chatbot_link_delay_menit']) }}" 
                                           placeholder="Contoh: 3" required>
                                </div>
                                <div class="form-help-text">
                                    <i class="bi bi-info-circle"></i>
                                    Setelah ngobrol sekian menit dengan chatbot, otomatis dikasih link isi survei (dalam menit)
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== BUTTONS ===== -->
                    <div class="d-flex flex-wrap gap-3 pt-3">
                        <button type="submit" class="btn-save">
                            <i class="bi bi-save-fill"></i> Simpan Pengaturan
                        </button>
                        <button type="reset" class="btn-reset" onclick="resetForm()">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </button>
                        <span class="ms-auto text-muted small d-flex align-items-center">
                            <i class="bi bi-shield-check me-1" style="color:var(--primary);"></i>
                            Semua perubahan akan disimpan
                        </span>
                    </div>

                </form>
            </div>
        </div>

        <!-- ===== FOOTER ===== -->
        <div class="text-center mt-4 py-3">
            <small class="text-muted opacity-50">
                <i class="bi bi-database"></i> Pengaturan disimpan secara aman • 
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
});

// ===== RESET FORM =====
function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset semua perubahan?')) {
        document.getElementById('settingsForm').reset();
        // Reload initial values from server
        location.reload();
    }
}

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
updateTime();
</script>
@endsection