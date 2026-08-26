@extends('layouts.app')
@section('title', isset($role) ? 'Edit Hak Akses Role' : 'Tambah Role')

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
    .role-form-wrapper {
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

    [data-theme="dark"] .role-form-wrapper {
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
    .role-form-content {
        position: relative;
        z-index: 1;
    }

    /* ===== HEADER ===== */
    .role-form-header {
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

    [data-theme="dark"] .role-form-header {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .role-form-header::before {
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

    [data-theme="dark"] .role-form-header::before {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.08) 0%, transparent 70%);
    }

    .role-form-header:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .role-form-header .header-title {
        font-size: 1.75rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    .role-form-header .header-badge {
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
    .role-form-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
    }

    [data-theme="dark"] .role-form-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .role-form-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .role-form-card .card-body-custom {
        padding: 2rem;
    }

    /* ===== FORM SECTIONS ===== */
    .form-section {
        margin-bottom: 2rem;
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

    /* ===== MENU ACCESS GRID ===== */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .menu-check-item {
        position: relative;
        padding: 0.7rem 1rem 0.7rem 2.8rem;
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        border: 2px solid rgba(0, 0, 0, 0.04);
        border-radius: 12px;
        transition: var(--transition);
        cursor: pointer;
        display: flex;
        align-items: center;
        min-height: 48px;
    }

    [data-theme="dark"] .menu-check-item {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.04);
    }

    .menu-check-item:hover {
        border-color: var(--primary);
        background: rgba(11, 93, 57, 0.04);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
    }

    [data-theme="dark"] .menu-check-item:hover {
        border-color: #2ecc71;
        background: rgba(46, 204, 113, 0.04);
    }

    .menu-check-item input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .menu-check-item .check-box {
        position: absolute;
        left: 0.8rem;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        border: 2px solid rgba(0, 0, 0, 0.15);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        background: rgba(255, 255, 255, 0.5);
        flex-shrink: 0;
    }

    [data-theme="dark"] .menu-check-item .check-box {
        border-color: rgba(255, 255, 255, 0.15);
        background: rgba(255, 255, 255, 0.03);
    }

    .menu-check-item .check-box i {
        font-size: 0.6rem;
        color: white;
        opacity: 0;
        transform: scale(0.5);
        transition: var(--transition);
    }

    .menu-check-item input[type="checkbox"]:checked + .check-box {
        background: var(--primary-gradient);
        border-color: var(--primary);
        box-shadow: 0 2px 10px rgba(11, 93, 57, 0.2);
    }

    [data-theme="dark"] .menu-check-item input[type="checkbox"]:checked + .check-box {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
        border-color: #2ecc71;
        box-shadow: 0 2px 10px rgba(46, 204, 113, 0.2);
    }

    .menu-check-item input[type="checkbox"]:checked + .check-box i {
        opacity: 1;
        transform: scale(1);
    }

    .menu-check-item .menu-label {
        font-size: 0.85rem;
        font-weight: 500;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    [data-theme="dark"] .menu-check-item .menu-label {
        color: #e0e0e0;
    }

    .menu-check-item .menu-label .menu-icon {
        font-size: 0.8rem;
        opacity: 0.5;
        color: var(--primary);
    }

    [data-theme="dark"] .menu-check-item .menu-label .menu-icon {
        color: #2ecc71;
    }

    .menu-check-item input[type="checkbox"]:checked ~ .menu-label {
        color: var(--primary);
    }

    [data-theme="dark"] .menu-check-item input[type="checkbox"]:checked ~ .menu-label {
        color: #2ecc71;
    }

    /* ===== ALERT ===== */
    .alert-info-custom {
        background: rgba(11, 93, 57, 0.06);
        border: 2px solid rgba(11, 93, 57, 0.1);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    [data-theme="dark"] .alert-info-custom {
        background: rgba(46, 204, 113, 0.06);
        border-color: rgba(46, 204, 113, 0.1);
    }

    .alert-info-custom .alert-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.15);
    }

    [data-theme="dark"] .alert-info-custom .alert-icon {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
        box-shadow: 0 4px 15px rgba(46, 204, 113, 0.15);
    }

    .alert-info-custom .alert-text {
        flex: 1;
        margin: 0;
        color: #495057;
        font-size: 0.9rem;
    }

    [data-theme="dark"] .alert-info-custom .alert-text {
        color: #adb5bd;
    }

    .alert-info-custom .alert-text strong {
        color: var(--primary);
    }

    [data-theme="dark"] .alert-info-custom .alert-text strong {
        color: #2ecc71;
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

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-in {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .animate-in:nth-child(1) { animation-delay: 0.05s; }

    .menu-check-item {
        animation: slideIn 0.4s ease forwards;
        opacity: 0;
    }

    .menu-check-item:nth-child(1) { animation-delay: 0.05s; }
    .menu-check-item:nth-child(2) { animation-delay: 0.08s; }
    .menu-check-item:nth-child(3) { animation-delay: 0.11s; }
    .menu-check-item:nth-child(4) { animation-delay: 0.14s; }
    .menu-check-item:nth-child(5) { animation-delay: 0.17s; }
    .menu-check-item:nth-child(6) { animation-delay: 0.20s; }
    .menu-check-item:nth-child(7) { animation-delay: 0.23s; }
    .menu-check-item:nth-child(8) { animation-delay: 0.26s; }
    .menu-check-item:nth-child(9) { animation-delay: 0.29s; }
    .menu-check-item:nth-child(10) { animation-delay: 0.32s; }
    .menu-check-item:nth-child(11) { animation-delay: 0.35s; }
    .menu-check-item:nth-child(12) { animation-delay: 0.38s; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .role-form-wrapper {
            padding: 1rem;
        }

        .role-form-header {
            padding: 1.25rem;
        }

        .role-form-header .header-title {
            font-size: 1.25rem;
        }

        .role-form-card .card-body-custom {
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

        .menu-grid {
            grid-template-columns: 1fr 1fr;
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

        .role-form-header .header-badge {
            font-size: 0.6rem;
            padding: 0.2rem 0.7rem;
        }

        .alert-info-custom {
            padding: 1rem;
            flex-direction: column;
            align-items: flex-start;
        }

        .alert-info-custom .alert-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }

        .alert-info-custom .alert-text {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .role-form-header .header-title {
            font-size: 1rem;
        }

        .role-form-card .card-body-custom {
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

        .menu-grid {
            grid-template-columns: 1fr;
        }

        .menu-check-item {
            padding: 0.5rem 0.8rem 0.5rem 2.5rem;
            min-height: 40px;
        }

        .menu-check-item .check-box {
            width: 18px;
            height: 18px;
            left: 0.6rem;
        }

        .menu-check-item .menu-label {
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
<div class="role-form-wrapper">
    <!-- Decorative Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <!-- ===== CONTENT ===== -->
    <div class="role-form-content">

        <!-- ===== HEADER ===== -->
        <div class="role-form-header animate-in">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <span class="text-uppercase small fw-bold" style="color:var(--primary); letter-spacing:0.05em; font-size:0.7rem;">
                            <i class="bi bi-shield-lock me-1"></i> 
                            {{ isset($role) ? 'Edit' : 'Tambah' }}
                        </span>
                        <h4 class="header-title mt-1 mb-0">
                            <i class="bi {{ isset($role) ? 'bi-pencil-fill' : 'bi-plus-circle-fill' }} me-2"></i>
                            {{ isset($role) ? 'Edit Hak Akses Role' : 'Tambah Role Baru' }}
                        </h4>
                    </div>
                    <span class="header-badge">
                        <i class="bi bi-person-gear"></i> 
                        {{ isset($role) ? 'Edit Mode' : 'Create Mode' }}
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="header-subtitle">
                        <i class="bi bi-info-circle"></i> 
                        {{ isset($role) ? 'Perbarui data role dan hak akses' : 'Isi form untuk membuat role baru' }}
                    </div>
                    <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== MAIN CARD ===== -->
        <div class="role-form-card animate-in">
            <div class="card-body-custom">
                <form method="POST" action="{{ isset($role) ? route('roles.update', $role) : route('roles.store') }}" id="roleForm">
                    @csrf
                    @if(isset($role)) @method('PUT') @endif

                    <!-- ===== SECTION 1: INFORMASI ROLE ===== -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-person-badge"></i>
                            Informasi Role
                        </div>
                        <div class="section-desc">
                            <i class="bi bi-info-circle"></i>
                            Informasi dasar tentang role yang akan dibuat atau diedit
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">
                                    <i class="bi bi-tag"></i> Nama Role
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nama_role" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('nama_role', $role->nama_role ?? '') }}" 
                                           placeholder="Contoh: Verifikator" required>
                                </div>
                                <div class="form-help-text">
                                    <i class="bi bi-info-circle"></i>
                                    Nama role yang akan ditampilkan
                                </div>
                            </div>
                            @if(!isset($role))
                            <div class="col-md-6">
                                <label class="form-label-custom">
                                    <i class="bi bi-hash"></i> Slug
                                    <span class="required-star">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-link-45deg"></i></span>
                                    <input type="text" name="slug" 
                                           class="form-control form-control-custom" 
                                           value="{{ old('slug') }}" 
                                           placeholder="contoh: verifikator" required>
                                </div>
                                <div class="form-help-text">
                                    <i class="bi bi-info-circle"></i>
                                    Identifier unik, huruf kecil, tanpa spasi
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- ===== SECTION 2: HAK AKSES ===== -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-menu-app"></i>
                            Hak Akses Menu
                        </div>
                        <div class="section-desc">
                            <i class="bi bi-info-circle"></i>
                            Pilih menu mana saja yang dapat diakses oleh role ini
                        </div>

                        @if(isset($role) && $role->slug === 'superadmin')
                            <div class="alert-info-custom">
                                <div class="alert-icon">
                                    <i class="bi bi-shield-fill-check"></i>
                                </div>
                                <p class="alert-text">
                                    <strong>Superadmin</strong> secara otomatis memiliki akses ke <strong>seluruh menu aplikasi</strong> 
                                    tanpa perlu dipilih secara manual. Hak akses penuh ini memastikan superadmin dapat mengelola semua aspek sistem.
                                </p>
                            </div>
                        @else
                            <div class="menu-grid">
                                @foreach ($menus as $key => $label)
                                    <label class="menu-check-item">
                                        <input type="checkbox" name="menu_access[]" value="{{ $key }}"
                                               id="menu_{{ $key }}"
                                               @checked(in_array($key, old('menu_access', $role->menu_access ?? [])))>
                                        <span class="check-box">
                                            <i class="bi bi-check"></i>
                                        </span>
                                        <span class="menu-label">
                                            <span class="menu-icon">
                                                <i class="bi bi-{{ 
                                                    str_contains($key, 'dashboard') ? 'speedometer2' : 
                                                    (str_contains($key, 'survey') ? 'clipboard2-data' : 
                                                    (str_contains($key, 'template') ? 'file-earmark-text' : 
                                                    (str_contains($key, 'question') ? 'question-circle' : 
                                                    (str_contains($key, 'response') ? 'chat-dots' : 
                                                    (str_contains($key, 'role') ? 'shield-lock' : 
                                                    (str_contains($key, 'user') ? 'people' : 
                                                    (str_contains($key, 'setting') ? 'gear' : 'dot'))))))) 
                                                }}"></i>
                                            </span>
                                            {{ $label }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="form-help-text" style="margin-top:0.75rem;">
                                <i class="bi bi-info-circle"></i>
                                Pilih menu yang ingin diizinkan untuk role ini
                            </div>
                        @endif
                    </div>

                    <!-- ===== BUTTONS ===== -->
                    <div class="d-flex flex-wrap gap-3 pt-3">
                        <button type="submit" class="btn-save">
                            <i class="bi {{ isset($role) ? 'bi-pencil-fill' : 'bi-save-fill' }}"></i> 
                            {{ isset($role) ? 'Perbarui Role' : 'Simpan Role' }}
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn-cancel">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <span class="ms-auto text-muted small d-flex align-items-center">
                            <i class="bi bi-shield-check me-1" style="color:var(--primary);"></i>
                            {{ isset($role) ? 'Perubahan akan disimpan' : 'Role baru akan dibuat' }}
                        </span>
                    </div>

                </form>
            </div>
        </div>

        <!-- ===== FOOTER ===== -->
        <div class="text-center mt-4 py-3">
            <small class="text-muted opacity-50">
                <i class="bi bi-shield-check"></i> Data role tersimpan aman • 
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

// ===== SLUG GENERATOR =====
document.addEventListener('DOMContentLoaded', function() {
    const namaRole = document.querySelector('input[name="nama_role"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    if (namaRole && slugInput) {
        namaRole.addEventListener('keyup', function() {
            if (!slugInput.value || slugInput.dataset.generated === 'true') {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .trim()
                    .replace(/\s+/g, '_');
                slugInput.value = slug;
                slugInput.dataset.generated = 'true';
            }
        });
        
        slugInput.addEventListener('input', function() {
            this.dataset.generated = 'false';
        });
    }
});

// ===== CHECKBOX SELECT ALL / DESELECT ALL =====
// Optional: Add "Select All" functionality if needed
</script>
@endsection