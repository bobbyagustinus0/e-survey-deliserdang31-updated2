@extends('layouts.app')
@section('title', 'Pertanyaan Survei')

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
    .question-wrapper {
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

    [data-theme="dark"] .question-wrapper {
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
    .question-content {
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

    /* ===== HEADER CARD ===== */
    .survey-info-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    [data-theme="dark"] .survey-info-card {
        background: rgba(30, 30, 46, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .survey-info-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .survey-info-card .info-body {
        padding: 1.25rem 1.75rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .survey-info-card .info-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.2);
    }

    [data-theme="dark"] .survey-info-card .info-icon {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
    }

    .survey-info-card .info-detail {
        flex: 1;
        min-width: 0;
    }

    .survey-info-card .info-detail .info-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
        line-height: 1.3;
    }

    [data-theme="dark"] .survey-info-card .info-detail .info-title {
        color: #e0e0e0;
    }

    .survey-info-card .info-detail .info-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem 1rem;
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 0.15rem;
    }

    [data-theme="dark"] .survey-info-card .info-detail .info-meta {
        color: #8a8a9a;
    }

    .survey-info-card .info-detail .info-meta i {
        font-size: 0.7rem;
        opacity: 0.6;
    }

    .survey-info-card .info-badge {
        background: rgba(11, 93, 57, 0.08);
        color: var(--primary);
        padding: 0.3rem 1rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        border: 1px solid rgba(11, 93, 57, 0.1);
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    [data-theme="dark"] .survey-info-card .info-badge {
        background: rgba(46, 204, 113, 0.08);
        color: #2ecc71;
        border-color: rgba(46, 204, 113, 0.1);
    }

    /* ===== MAIN CARDS ===== */
    .question-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    [data-theme="dark"] .question-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .question-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .question-card .card-header-custom {
        padding: 1rem 1.75rem;
        background: rgba(0, 0, 0, 0.02);
        border-bottom: 2px solid rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    [data-theme="dark"] .question-card .card-header-custom {
        background: rgba(255, 255, 255, 0.02);
        border-bottom-color: rgba(255, 255, 255, 0.04);
    }

    .question-card .card-header-custom .card-title {
        font-weight: 600;
        font-size: 1rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
    }

    [data-theme="dark"] .question-card .card-header-custom .card-title {
        color: #e0e0e0;
    }

    .question-card .card-header-custom .card-title i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .btn-add {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.4rem 1.1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.15);
    }

    .btn-add:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 25px rgba(11, 93, 57, 0.25);
        color: white;
    }

    [data-theme="dark"] .btn-add {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
    }

    .question-card .card-body-custom {
        padding: 1.5rem 1.75rem;
    }

    /* ===== INFO NOTE ===== */
    .info-note {
        background: rgba(11, 93, 57, 0.04);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.25rem;
        border-left: 4px solid var(--primary);
        font-size: 0.85rem;
        color: #495057;
    }

    [data-theme="dark"] .info-note {
        background: rgba(46, 204, 113, 0.04);
        border-left-color: #2ecc71;
        color: #adb5bd;
    }

    .info-note i {
        color: var(--primary);
        margin-right: 0.3rem;
    }

    [data-theme="dark"] .info-note i {
        color: #2ecc71;
    }

    .info-note strong {
        color: var(--primary);
    }

    [data-theme="dark"] .info-note strong {
        color: #2ecc71;
    }

    /* ===== TABLES ===== */
    .table-premium {
        font-size: 0.85rem;
        margin-bottom: 0;
        width: 100%;
    }

    .table-premium thead th {
        background: rgba(0, 0, 0, 0.02);
        border-bottom: 2px solid rgba(0, 0, 0, 0.06);
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        font-size: 0.65rem;
        letter-spacing: 0.8px;
        padding: 0.7rem 1rem;
        position: sticky;
        top: 0;
        z-index: 10;
        white-space: nowrap;
    }

    [data-theme="dark"] .table-premium thead th {
        background: rgba(255, 255, 255, 0.02);
        color: #adb5bd;
        border-bottom-color: rgba(255, 255, 255, 0.05);
    }

    .table-premium tbody tr {
        transition: var(--transition);
        border-left: 3px solid transparent;
        cursor: default;
        background: transparent;
    }

    .table-premium tbody tr:hover {
        background: rgba(11, 93, 57, 0.04);
        border-left-color: var(--primary);
        transform: scale(1.01);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    }

    [data-theme="dark"] .table-premium tbody tr:hover {
        background: rgba(46, 204, 113, 0.05);
    }

    .table-premium tbody td {
        padding: 0.7rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        background: transparent;
        color: #2c3e50;
    }

    [data-theme="dark"] .table-premium tbody td {
        border-bottom-color: rgba(255, 255, 255, 0.03);
        color: #e0e0e0;
    }

    .table-premium tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== BADGES ===== */
    .badge-premium {
        padding: 0.25rem 0.8rem;
        font-weight: 500;
        letter-spacing: 0.3px;
        border-radius: 50px;
        transition: var(--transition);
        font-size: 0.7rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .badge-premium:hover {
        transform: scale(1.05);
    }

    .badge-premium.type {
        background: rgba(26, 111, 160, 0.08);
        color: var(--blue);
        border: 1px solid rgba(26, 111, 160, 0.1);
    }

    .badge-premium.category {
        background: rgba(185, 134, 46, 0.08);
        color: var(--gold);
        border: 1px solid rgba(185, 134, 46, 0.1);
    }

    .badge-premium.default {
        background: rgba(108, 117, 125, 0.08);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.1);
    }

    .badge-premium.required-yes {
        background: rgba(40, 167, 69, 0.08);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.1);
    }

    .badge-premium.required-no {
        background: rgba(108, 117, 125, 0.08);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.1);
    }

    /* ===== ACTION BUTTONS ===== */
    .action-group {
        display: flex;
        gap: 0.3rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        border: 2px solid rgba(0, 0, 0, 0.06);
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        color: #6c757d;
        font-size: 0.8rem;
        text-decoration: none;
        cursor: pointer;
    }

    [data-theme="dark"] .btn-action {
        border-color: rgba(255, 255, 255, 0.05);
        background: rgba(255, 255, 255, 0.03);
        color: #8a8a9a;
    }

    .btn-action:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        text-decoration: none;
    }

    .btn-action.edit:hover {
        border-color: var(--primary);
        background: rgba(11, 93, 57, 0.05);
        color: var(--primary);
    }

    [data-theme="dark"] .btn-action.edit:hover {
        border-color: #2ecc71;
        background: rgba(46, 204, 113, 0.05);
        color: #2ecc71;
    }

    .btn-action.delete:hover {
        border-color: var(--danger);
        background: rgba(220, 53, 69, 0.05);
        color: var(--danger);
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

    /* ===== EMPTY STATE ===== */
    .empty-state-table {
        padding: 2.5rem 1.5rem;
        text-align: center;
        color: #6c757d;
    }

    .empty-state-table i {
        font-size: 2.5rem;
        opacity: 0.2;
        margin-bottom: 0.75rem;
        display: block;
    }

    .empty-state-table h6 {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.25rem;
    }

    [data-theme="dark"] .empty-state-table h6 {
        color: #adb5bd;
    }

    /* ===== MODAL ===== */
    .modal-content {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow-hover);
    }

    [data-theme="dark"] .modal-content {
        background: rgba(30, 30, 46, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .modal-header {
        border-bottom: 2px solid rgba(0, 0, 0, 0.04);
        padding: 1.25rem 1.5rem;
    }

    [data-theme="dark"] .modal-header {
        border-bottom-color: rgba(255, 255, 255, 0.04);
    }

    .modal-header .modal-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    [data-theme="dark"] .modal-header .modal-title {
        color: #e0e0e0;
    }

    .modal-header .modal-title i {
        color: var(--primary);
    }

    .modal-footer {
        border-top: 2px solid rgba(0, 0, 0, 0.04);
        padding: 1.25rem 1.5rem;
    }

    [data-theme="dark"] .modal-footer {
        border-top-color: rgba(255, 255, 255, 0.04);
    }

    .modal .form-label {
        font-weight: 500;
        font-size: 0.85rem;
        color: #495057;
    }

    [data-theme="dark"] .modal .form-label {
        color: #e0e0e0;
    }

    .modal .form-control,
    .modal .form-select {
        background: rgba(255, 255, 255, 0.6);
        border: 2px solid rgba(0, 0, 0, 0.06);
        border-radius: 12px;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        transition: var(--transition);
        color: #2c3e50;
    }

    [data-theme="dark"] .modal .form-control,
    [data-theme="dark"] .modal .form-select {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.08);
        color: #e0e0e0;
    }

    .modal .form-control:focus,
    .modal .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(11, 93, 57, 0.1);
        background: rgba(255, 255, 255, 0.8);
        outline: none;
    }

    [data-theme="dark"] .modal .form-control:focus,
    [data-theme="dark"] .modal .form-select:focus {
        border-color: #2ecc71;
        box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1);
        background: rgba(255, 255, 255, 0.08);
    }

    .modal .form-text {
        font-size: 0.75rem;
        color: #6c757d;
    }

    [data-theme="dark"] .modal .form-text {
        color: #8a8a9a;
    }

    .modal .btn-modal-close {
        background: rgba(108, 117, 125, 0.08);
        color: #6c757d;
        border: 2px solid rgba(108, 117, 125, 0.12);
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        transition: var(--transition);
    }

    .modal .btn-modal-close:hover {
        background: rgba(108, 117, 125, 0.15);
        transform: translateY(-2px);
    }

    .modal .btn-modal-save {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.2);
    }

    .modal .btn-modal-save:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 25px rgba(11, 93, 57, 0.3);
        color: white;
    }

    [data-theme="dark"] .modal .btn-modal-save {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .question-wrapper {
            padding: 1rem;
        }

        .survey-info-card .info-body {
            padding: 1rem 1.25rem;
        }

        .survey-info-card .info-icon {
            width: 44px;
            height: 44px;
            font-size: 1.2rem;
        }

        .survey-info-card .info-detail .info-title {
            font-size: 0.95rem;
        }

        .question-card .card-header-custom {
            padding: 0.8rem 1.25rem;
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
        }

        .question-card .card-body-custom {
            padding: 1rem 1.25rem;
        }

        .table-premium {
            font-size: 0.75rem;
        }

        .table-premium thead th,
        .table-premium tbody td {
            padding: 0.5rem 0.6rem;
        }

        .btn-action {
            width: 28px;
            height: 28px;
            font-size: 0.7rem;
            border-radius: 8px;
        }

        .info-note {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }

        .btn-add {
            font-size: 0.7rem;
            padding: 0.35rem 0.9rem;
        }

        .btn-back {
            font-size: 0.75rem;
            padding: 0.4rem 1rem;
        }

        .theme-toggle {
            width: 34px;
            height: 34px;
            font-size: 0.95rem;
        }
    }

    @media (max-width: 576px) {
        .survey-info-card .info-body {
            flex-direction: column;
            align-items: flex-start;
            padding: 0.8rem 1rem;
        }

        .survey-info-card .info-icon {
            width: 38px;
            height: 38px;
            font-size: 1rem;
            border-radius: 10px;
        }

        .survey-info-card .info-detail .info-title {
            font-size: 0.85rem;
        }

        .survey-info-card .info-detail .info-meta {
            font-size: 0.7rem;
        }

        .question-card .card-body-custom {
            padding: 0.8rem 1rem;
        }

        .table-premium {
            font-size: 0.65rem;
        }

        .table-premium thead th,
        .table-premium tbody td {
            padding: 0.3rem 0.4rem;
        }

        .btn-action {
            width: 24px;
            height: 24px;
            font-size: 0.6rem;
            border-radius: 6px;
        }

        .badge-premium {
            font-size: 0.55rem;
            padding: 0.15rem 0.5rem;
        }

        .btn-add {
            font-size: 0.6rem;
            padding: 0.25rem 0.7rem;
        }

        .info-note {
            font-size: 0.7rem;
            padding: 0.4rem 0.6rem;
        }

        .modal .modal-header,
        .modal .modal-footer {
            padding: 0.8rem 1rem;
        }

        .modal .modal-body {
            padding: 0.8rem 1rem;
        }

        .modal .modal-title {
            font-size: 0.95rem;
        }

        .modal .form-control,
        .modal .form-select {
            font-size: 0.8rem;
            padding: 0.5rem 0.8rem;
        }
    }

    /* ===== SCROLLBAR ===== */
    .table-responsive::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: transparent;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c7cd;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a8b0b8;
    }

    [data-theme="dark"] .table-responsive::-webkit-scrollbar-thumb {
        background: #3a3a4a;
    }

    [data-theme="dark"] .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #4a4a5a;
    }
</style>

<!-- ===== BACKGROUND ===== -->
<div class="question-wrapper">
    <!-- Decorative Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <!-- ===== CONTENT ===== -->
    <div class="question-content">

        <!-- ===== TOP BAR ===== -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('survey-templates.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Template Survei
            </a>
            <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode">
                <i class="bi bi-moon-fill" id="themeIcon"></i>
            </button>
        </div>

        <!-- ===== SURVEY INFO ===== -->
        <div class="survey-info-card animate-in">
            <div class="info-body">
                <div class="info-icon">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <div class="info-detail">
                    <h6 class="info-title">{{ $template->judul_survei }}</h6>
                    <div class="info-meta">
                        <span><i class="bi bi-building"></i> {{ $template->unit_layanan }}</span>
                        <span><i class="bi bi-hash"></i> Kode: {{ $template->kode_survei }}</span>
                        <span><i class="bi bi-question-circle"></i> {{ $questions->count() }} Pertanyaan</span>
                        <span><i class="bi bi-person"></i> {{ $identityFields->count() }} Field Data Diri</span>
                    </div>
                </div>
                <div class="info-badge">
                    <i class="bi {{ $template->status === 'aktif' ? 'bi-check-circle-fill' : 'bi-clock-fill' }}"></i>
                    {{ ucfirst($template->status) }}
                </div>
            </div>
        </div>

        <!-- ===== IDENTITY FIELDS CARD ===== -->
        <div class="question-card animate-in">
            <div class="card-header-custom">
                <span class="card-title">
                    <i class="bi bi-person-badge"></i>
                    Field Data Diri Responden
                </span>
                <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahField">
                    <i class="bi bi-plus-lg"></i> Tambah Field
                </button>
            </div>
            <div class="card-body-custom">
                <div class="info-note">
                    <i class="bi bi-info-circle-fill"></i>
                    <strong>Nama Lengkap</strong> dan <strong>Email</strong> tersedia secara bawaan namun tetap bisa diedit (label, wajib diisi, urutan) atau dihapus jika tidak diperlukan.
                    Tambahkan field lain di sini jika Anda butuh info tambahan seperti No. HP, Instansi, dsb.
                </div>

                @if ($identityFields->count())
                <div class="table-responsive">
                    <table class="table table-premium">
                        <thead>
                            <tr>
                                <th style="width:50px"><i class="bi bi-hash"></i> No</th>
                                <th><i class="bi bi-tag"></i> Label Field</th>
                                <th style="width:120px"><i class="bi bi-type"></i> Tipe</th>
                                <th style="width:90px"><i class="bi bi-check-circle"></i> Wajib</th>
                                <th style="width:110px" class="text-center"><i class="bi bi-tools"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($identityFields as $f)
                            <tr>
                                <td class="text-center fw-bold">{{ $f->urutan }}</td>
                                <td>
                                    {{ $f->label }}
                                    @if ($f->is_default)
                                        <span class="badge-premium default">
                                            <i class="bi bi-shield-fill-check"></i> Bawaan
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-premium type">
                                        <i class="bi bi-{{ $f->tipe === 'pilihan' ? 'list-ul' : ($f->tipe === 'email' ? 'envelope' : ($f->tipe === 'angka' ? '123' : 'text-paragraph')) }}"></i>
                                        {{ ucfirst($f->tipe) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-premium {{ $f->wajib_diisi ? 'required-yes' : 'required-no' }}">
                                        <i class="bi {{ $f->wajib_diisi ? 'bi-check-circle-fill' : 'bi-circle' }}"></i>
                                        {{ $f->wajib_diisi ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <button class="btn-action edit" data-bs-toggle="modal" data-bs-target="#modalEditField{{ $f->id }}" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('survey-identity-fields.destroy', [$template, $f]) }}" method="POST" class="d-inline form-delete" data-item-name="field {{ $f->label }}">
                                            @csrf @method('DELETE')
                                            <button class="btn-action delete" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state-table">
                    <i class="bi bi-person-plus"></i>
                    <h6>Belum Ada Field Tambahan</h6>
                    <small class="text-muted">Klik tombol "Tambah Field" untuk menambahkan field data diri</small>
                </div>
                @endif
            </div>
        </div>

        <!-- ===== QUESTIONS CARD ===== -->
        <div class="question-card animate-in">
            <div class="card-header-custom">
                <span class="card-title">
                    <i class="bi bi-list-check"></i>
                    Daftar Pertanyaan
                </span>
                <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg"></i> Tambah Pertanyaan
                </button>
            </div>
            <div class="card-body-custom p-0">
                <div class="table-responsive">
                    <table class="table table-premium">
                        <thead>
                            <tr>
                                <th style="width:50px"><i class="bi bi-hash"></i> No</th>
                                <th style="width:150px"><i class="bi bi-tags"></i> Kategori</th>
                                <th><i class="bi bi-question-lg"></i> Pertanyaan</th>
                                <th style="width:140px"><i class="bi bi-ui-radios"></i> Tipe Jawaban</th>
                                <th style="width:90px"><i class="bi bi-check-circle"></i> Wajib</th>
                                <th style="width:110px" class="text-center"><i class="bi bi-tools"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($questions as $q)
                            <tr>
                                <td class="text-center fw-bold">{{ $q->urutan }}</td>
                                <td>
                                    @if($q->kategori)
                                        <span class="badge-premium category">
                                            <i class="bi bi-tag-fill"></i> {{ $q->kategori }}
                                        </span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($q->pertanyaan, 60) }}</td>
                                <td>
                                    <span class="badge-premium type">
                                        <i class="bi bi-{{ $q->tipe_jawaban === 'skala_ikm' ? 'bar-chart' : ($q->tipe_jawaban === 'rating_bintang' ? 'star' : ($q->tipe_jawaban === 'pilihan_ganda' ? 'list-ul' : ($q->tipe_jawaban === 'isian_singkat' ? 'input-cursor' : 'text-paragraph'))) }}"></i>
                                        {{ str_replace('_', ' ', ucfirst($q->tipe_jawaban)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-premium {{ $q->wajib_diisi ? 'required-yes' : 'required-no' }}">
                                        <i class="bi {{ $q->wajib_diisi ? 'bi-check-circle-fill' : 'bi-circle' }}"></i>
                                        {{ $q->wajib_diisi ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <button class="btn-action edit btn-edit-question" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $q->id }}" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('survey-questions.destroy', [$template, $q]) }}" method="POST" class="d-inline form-delete" data-item-name="pertanyaan ini">
                                            @csrf @method('DELETE')
                                            <button class="btn-action delete" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state-table">
                                        <i class="bi bi-question-diamond"></i>
                                        <h6>Belum Ada Pertanyaan</h6>
                                        <small class="text-muted">Klik tombol "Tambah Pertanyaan" untuk menambahkan pertanyaan survei</small>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ===== FOOTER ===== -->
        <div class="text-center mt-4 py-3">
            <small class="text-muted opacity-50">
                <i class="bi bi-shield-check"></i> Data pertanyaan tersimpan aman • 
                <span id="updateTime">{{ now()->format('H:i:s') }}</span> WIB
            </small>
        </div>

    </div>
</div>

<!-- ===== MODAL EDIT FIELD ===== -->
@foreach ($identityFields as $f)
<div class="modal fade" id="modalEditField{{ $f->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('survey-identity-fields.update', [$template, $f]) }}" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="bi bi-pencil-square"></i> Edit Field Data Diri
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Label Field</label>
                    <input type="text" name="label" class="form-control" value="{{ $f->label }}" required placeholder="Misal: No. HP">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe Input</label>
                    <select name="tipe" class="form-select" onchange="toggleOpsiField(this, 'opsiField{{ $f->id }}')" {{ $f->is_default ? 'disabled' : '' }}>
                        <option value="text" @selected($f->tipe === 'text')>📝 Teks Singkat</option>
                        <option value="email" @selected($f->tipe === 'email')>✉️ Email</option>
                        <option value="angka" @selected($f->tipe === 'angka')>🔢 Angka</option>
                        <option value="pilihan" @selected($f->tipe === 'pilihan')>📋 Pilihan Dropdown</option>
                    </select>
                    @if ($f->is_default)
                        <input type="hidden" name="tipe" value="{{ $f->tipe }}">
                        <div class="form-text">Tipe field bawaan tidak dapat diubah.</div>
                    @endif
                </div>
                <div class="mb-3" id="opsiField{{ $f->id }}" style="display: {{ $f->tipe === 'pilihan' ? 'block' : 'none' }}">
                    <label class="form-label">Opsi Pilihan (satu opsi per baris)</label>
                    <textarea name="opsi_pilihan" class="form-control" rows="3">{{ is_array($f->opsi_pilihan) ? implode("\n", $f->opsi_pilihan) : '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" value="{{ $f->urutan }}" min="1">
                </div>
                <div class="form-check">
                    <input type="checkbox" name="wajib_diisi" value="1" class="form-check-input" id="wajibField{{ $f->id }}" @checked($f->wajib_diisi)>
                    <label class="form-check-label" for="wajibField{{ $f->id }}">Wajib diisi</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-close" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-save">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- ===== MODAL TAMBAH FIELD ===== -->
<div class="modal fade" id="modalTambahField" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('survey-identity-fields.store', $template) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="bi bi-plus-circle"></i> Tambah Field Data Diri
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Label Field</label>
                    <input type="text" name="label" class="form-control" required placeholder="Misal: No. HP">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe Input</label>
                    <select name="tipe" class="form-select" onchange="toggleOpsiField(this, 'opsiFieldBaru')">
                        <option value="text">📝 Teks Singkat</option>
                        <option value="email">✉️ Email</option>
                        <option value="angka">🔢 Angka</option>
                        <option value="pilihan">📋 Pilihan Dropdown</option>
                    </select>
                </div>
                <div class="mb-3" id="opsiFieldBaru" style="display:none">
                    <label class="form-label">Opsi Pilihan (satu opsi per baris)</label>
                    <textarea name="opsi_pilihan" class="form-control" rows="3" placeholder="Opsi 1&#10;Opsi 2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" min="1" placeholder="Otomatis jika dikosongkan">
                </div>
                <div class="form-check">
                    <input type="checkbox" name="wajib_diisi" value="1" class="form-check-input" id="wajibFieldBaru">
                    <label class="form-check-label" for="wajibFieldBaru">Wajib diisi</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-close" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== MODAL EDIT QUESTION ===== -->
@foreach ($questions as $q)
<div class="modal fade" id="modalEdit{{ $q->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('survey-questions.update', [$template, $q]) }}" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="bi bi-pencil-square"></i> Edit Pertanyaan
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kategori/Tahap <span class="text-muted">(opsional)</span></label>
                    <input type="text" name="kategori" class="form-control" value="{{ $q->kategori }}" placeholder="Misal: Kualitas Sistem" list="daftarKategori">
                    <div class="form-text">Pertanyaan dengan kategori/tahap yang sama akan ditampilkan dalam satu langkah pada form survei publik.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea name="pertanyaan" class="form-control" rows="2" required>{{ $q->pertanyaan }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe Jawaban</label>
                    <select name="tipe_jawaban" class="form-select" onchange="toggleOpsiJawaban(this, 'opsi{{ $q->id }}')">
                        <option value="skala_ikm" @selected($q->tipe_jawaban === 'skala_ikm')>📊 Skala IKM (1-4)</option>
                        <option value="rating_bintang" @selected($q->tipe_jawaban === 'rating_bintang')>⭐ Rating Bintang</option>
                        <option value="pilihan_ganda" @selected($q->tipe_jawaban === 'pilihan_ganda')>📋 Pilihan Ganda</option>
                        <option value="isian_singkat" @selected($q->tipe_jawaban === 'isian_singkat')>📝 Isian Singkat</option>
                        <option value="esai" @selected($q->tipe_jawaban === 'esai')>📄 Esai</option>
                    </select>
                </div>
                <div class="mb-3" id="opsi{{ $q->id }}" style="display: {{ $q->tipe_jawaban === 'pilihan_ganda' ? 'block' : 'none' }}">
                    <label class="form-label">Opsi Jawaban (satu opsi per baris)</label>
                    <textarea name="opsi_jawaban" class="form-control" rows="3">{{ is_array($q->opsi_jawaban) ? implode("\n", $q->opsi_jawaban) : '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" value="{{ $q->urutan }}" min="1">
                </div>
                <div class="form-check">
                    <input type="checkbox" name="wajib_diisi" value="1" class="form-check-input" id="wajib{{ $q->id }}" @checked($q->wajib_diisi)>
                    <label class="form-check-label" for="wajib{{ $q->id }}">Wajib diisi</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-close" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-save">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- ===== MODAL TAMBAH QUESTION ===== -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('survey-questions.store', $template) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="bi bi-plus-circle"></i> Tambah Pertanyaan Survei
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kategori/Tahap <span class="text-muted">(opsional)</span></label>
                    <input type="text" name="kategori" class="form-control" placeholder="Misal: Kualitas Sistem" list="daftarKategori">
                    <div class="form-text">Pertanyaan dengan kategori/tahap yang sama akan ditampilkan dalam satu langkah pada form survei publik.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea name="pertanyaan" class="form-control" rows="2" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe Jawaban</label>
                    <select name="tipe_jawaban" class="form-select" onchange="toggleOpsiJawaban(this, 'opsiBaru')">
                        <option value="skala_ikm">📊 Skala IKM (1-4)</option>
                        <option value="rating_bintang">⭐ Rating Bintang</option>
                        <option value="pilihan_ganda">📋 Pilihan Ganda</option>
                        <option value="isian_singkat">📝 Isian Singkat</option>
                        <option value="esai">📄 Esai</option>
                    </select>
                </div>
                <div class="mb-3" id="opsiBaru" style="display:none">
                    <label class="form-label">Opsi Jawaban (satu opsi per baris)</label>
                    <textarea name="opsi_jawaban" class="form-control" rows="3" placeholder="Opsi 1&#10;Opsi 2&#10;Opsi 3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" min="1" placeholder="Otomatis jika dikosongkan">
                </div>
                <div class="form-check">
                    <input type="checkbox" name="wajib_diisi" value="1" class="form-check-input" id="wajibBaru" checked>
                    <label class="form-check-label" for="wajibBaru">Wajib diisi</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-close" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== DATALIST KATEGORI ===== -->
<datalist id="daftarKategori">
    @foreach ($questions->pluck('kategori')->filter()->unique() as $kat)
    <option value="{{ $kat }}">
    @endforeach
</datalist>

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

// ===== DELETE CONFIRMATION =====
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const itemName = this.dataset.itemName || 'item ini';
        if (confirm(`Apakah Anda yakin ingin menghapus ${itemName}?`)) {
            this.submit();
        }
    });
});

// ===== TOGGLE OPSI FIELD =====
function toggleOpsiField(select, targetId) {
    const target = document.getElementById(targetId);
    if (target) {
        target.style.display = select.value === 'pilihan' ? 'block' : 'none';
    }
}

// ===== TOGGLE OPSI JAWABAN =====
function toggleOpsiJawaban(select, targetId) {
    const target = document.getElementById(targetId);
    if (target) {
        target.style.display = select.value === 'pilihan_ganda' ? 'block' : 'none';
    }
}
</script>
@endsection