@extends('layouts.app')
@section('title', 'Template Survei / Data Survei')

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
    .template-wrapper {
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

    [data-theme="dark"] .template-wrapper {
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
    .template-content {
        position: relative;
        z-index: 1;
    }

    /* ===== HEADER ===== */
    .template-header {
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

    [data-theme="dark"] .template-header {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .template-header::before {
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

    [data-theme="dark"] .template-header::before {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.08) 0%, transparent 70%);
    }

    .template-header:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .template-header .header-title {
        font-size: 1.75rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    .template-header .header-badge {
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

    /* ===== STATS CARDS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-mini-card {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    }

    [data-theme="dark"] .stat-mini-card {
        background: rgba(30, 30, 46, 0.6);
        border-color: rgba(255, 255, 255, 0.05);
    }

    .stat-mini-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-shadow-hover);
    }

    .stat-mini-card .stat-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .stat-mini-card .stat-icon-box.green {
        background: rgba(11, 93, 57, 0.1);
        color: var(--primary);
    }

    .stat-mini-card .stat-icon-box.blue {
        background: rgba(26, 111, 160, 0.1);
        color: var(--blue);
    }

    .stat-mini-card .stat-icon-box.gold {
        background: rgba(185, 134, 46, 0.1);
        color: var(--gold);
    }

    .stat-mini-card .stat-icon-box.purple {
        background: rgba(108, 52, 131, 0.1);
        color: var(--purple);
    }

    [data-theme="dark"] .stat-mini-card .stat-icon-box.green {
        background: rgba(46, 204, 113, 0.1);
        color: #2ecc71;
    }

    .stat-mini-card .stat-info .stat-number {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        line-height: 1.2;
    }

    [data-theme="dark"] .stat-mini-card .stat-info .stat-number {
        color: #e0e0e0;
    }

    .stat-mini-card .stat-info .stat-label {
        font-size: 0.7rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    [data-theme="dark"] .stat-mini-card .stat-info .stat-label {
        color: #8a8a9a;
    }

    /* ===== MAIN CARD ===== */
    .template-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
    }

    [data-theme="dark"] .template-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .template-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .template-card .card-header-custom {
        padding: 1.25rem 1.75rem;
        background: rgba(0, 0, 0, 0.02);
        border-bottom: 2px solid rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    [data-theme="dark"] .template-card .card-header-custom {
        background: rgba(255, 255, 255, 0.02);
        border-bottom-color: rgba(255, 255, 255, 0.04);
    }

    .template-card .card-header-custom .card-title {
        font-weight: 600;
        font-size: 1rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
    }

    [data-theme="dark"] .template-card .card-header-custom .card-title {
        color: #e0e0e0;
    }

    .template-card .card-header-custom .card-title i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .btn-create {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.2);
    }

    .btn-create:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 30px rgba(11, 93, 57, 0.3);
        color: white;
    }

    .btn-create:active {
        transform: scale(0.98);
    }

    [data-theme="dark"] .btn-create {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
        box-shadow: 0 4px 15px rgba(46, 204, 113, 0.2);
    }

    .template-card .card-body-custom {
        padding: 0;
        overflow: hidden;
    }

    /* ===== TABLE ===== */
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
        padding: 0.9rem 1.2rem;
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
        padding: 0.9rem 1.2rem;
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

    /* ===== TABLE BADGES ===== */
    .badge-premium {
        padding: 0.3rem 0.9rem;
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

    .badge-premium.bg-success {
        background: var(--primary-gradient) !important;
        color: white !important;
    }

    .badge-premium.bg-warning {
        background: var(--gold-gradient) !important;
        color: white !important;
    }

    .badge-premium.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%) !important;
        color: white !important;
    }

    .badge-premium.bg-secondary {
        background: #6c757d !important;
        color: white !important;
    }

    .badge-premium .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 2s infinite;
    }

    .badge-premium .status-dot.active {
        background: #28a745;
    }

    .badge-premium .status-dot.inactive {
        background: #dc3545;
    }

    .badge-premium .status-dot.draft {
        background: #ffc107;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.3); }
    }

    /* ===== ACTION BUTTONS ===== */
    .action-group {
        display: flex;
        gap: 0.4rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-action {
        width: 34px;
        height: 34px;
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
        font-size: 0.85rem;
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

    .btn-action.questions:hover {
        border-color: var(--primary);
        background: rgba(11, 93, 57, 0.05);
        color: var(--primary);
    }

    [data-theme="dark"] .btn-action.questions:hover {
        border-color: #2ecc71;
        background: rgba(46, 204, 113, 0.05);
        color: #2ecc71;
    }

    .btn-action.edit:hover {
        border-color: var(--blue);
        background: rgba(26, 111, 160, 0.05);
        color: var(--blue);
    }

    .btn-action.delete:hover {
        border-color: var(--danger);
        background: rgba(220, 53, 69, 0.05);
        color: var(--danger);
    }

    .btn-action.preview:hover {
        border-color: var(--gold);
        background: rgba(185, 134, 46, 0.05);
        color: var(--gold);
    }

    /* ===== KODE SURVEI ===== */
    .survey-code {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--primary);
        background: rgba(11, 93, 57, 0.06);
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        display: inline-block;
        letter-spacing: 0.5px;
    }

    [data-theme="dark"] .survey-code {
        background: rgba(46, 204, 113, 0.06);
        color: #2ecc71;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state-table {
        padding: 3rem 1.5rem;
        text-align: center;
        color: #6c757d;
    }

    .empty-state-table i {
        font-size: 3rem;
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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .template-wrapper {
            padding: 1rem;
        }

        .template-header {
            padding: 1.25rem;
        }

        .template-header .header-title {
            font-size: 1.25rem;
        }

        .template-header .header-badge {
            font-size: 0.6rem;
            padding: 0.2rem 0.7rem;
        }

        .header-subtitle {
            font-size: 0.75rem;
            padding: 0.3rem 0.8rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .stat-mini-card {
            padding: 0.75rem 1rem;
        }

        .stat-mini-card .stat-icon-box {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }

        .stat-mini-card .stat-info .stat-number {
            font-size: 1.1rem;
        }

        .stat-mini-card .stat-info .stat-label {
            font-size: 0.6rem;
        }

        .template-card .card-header-custom {
            padding: 1rem 1.25rem;
        }

        .template-card .card-header-custom .card-title {
            font-size: 0.9rem;
        }

        .table-premium thead th,
        .table-premium tbody td {
            padding: 0.6rem 0.8rem;
            font-size: 0.75rem;
        }

        .btn-create {
            font-size: 0.7rem;
            padding: 0.4rem 1rem;
        }

        .btn-action {
            width: 30px;
            height: 30px;
            font-size: 0.75rem;
            border-radius: 8px;
        }

        .survey-code {
            font-size: 0.7rem;
        }

        .badge-premium {
            font-size: 0.6rem;
            padding: 0.2rem 0.6rem;
        }
    }

    @media (max-width: 576px) {
        .template-header .header-title {
            font-size: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .stat-mini-card {
            padding: 0.6rem 0.8rem;
            gap: 0.6rem;
        }

        .stat-mini-card .stat-icon-box {
            width: 32px;
            height: 32px;
            font-size: 0.85rem;
            border-radius: 8px;
        }

        .stat-mini-card .stat-info .stat-number {
            font-size: 0.95rem;
        }

        .table-premium {
            font-size: 0.7rem;
        }

        .table-premium thead th,
        .table-premium tbody td {
            padding: 0.4rem 0.5rem;
        }

        .action-group {
            gap: 0.2rem;
        }

        .btn-action {
            width: 26px;
            height: 26px;
            font-size: 0.65rem;
            border-radius: 6px;
        }

        .survey-code {
            font-size: 0.6rem;
            padding: 0.1rem 0.4rem;
        }

        .template-card .card-header-custom {
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
        }

        .btn-create {
            justify-content: center;
            width: 100%;
        }

        .table-responsive {
            border-radius: 0 0 var(--border-radius) var(--border-radius);
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
<div class="template-wrapper">
    <!-- Decorative Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <!-- ===== CONTENT ===== -->
    <div class="template-content">

        <!-- ===== HEADER ===== -->
        <div class="template-header">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <span class="text-uppercase small fw-bold" style="color:var(--primary); letter-spacing:0.05em; font-size:0.7rem;">
                            <i class="bi bi-layout-text-window me-1"></i> Manajemen
                        </span>
                        <h4 class="header-title mt-1 mb-0">
                            <i class="bi bi-file-earmark-text me-2"></i> Template Survei
                        </h4>
                    </div>
                    <span class="header-badge">
                        <i class="bi bi-database"></i> {{ $templates->count() }} Template
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="header-subtitle">
                        <i class="bi bi-info-circle"></i> 
                        Kelola semua template survei
                    </div>
                    <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== STATS ===== -->
        <div class="stats-grid">
            <div class="stat-mini-card">
                <div class="stat-icon-box green">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $templates->count() }}</div>
                    <div class="stat-label">Total Template</div>
                </div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-icon-box blue">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $templates->where('status', 'aktif')->count() }}</div>
                    <div class="stat-label">Aktif</div>
                </div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-icon-box gold">
                    <i class="bi bi-pencil-fill"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $templates->where('status', 'draft')->count() }}</div>
                    <div class="stat-label">Draft</div>
                </div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-icon-box purple">
                    <i class="bi bi-bar-chart-fill"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $templates->sum('responses_count') }}</div>
                    <div class="stat-label">Total Respon</div>
                </div>
            </div>
        </div>

        <!-- ===== TABLE CARD ===== -->
        <div class="template-card">
            <div class="card-header-custom">
                <span class="card-title">
                    <i class="bi bi-list-ul"></i>
                    Daftar Template Survei
                </span>
                <a href="{{ route('survey-templates.create') }}" class="btn-create">
                    <i class="bi bi-plus-lg"></i> Buat Template Survei
                </a>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="table table-premium">
                        <thead>
                            <tr>
                                <th style="min-width:90px;"><i class="bi bi-hash me-1"></i>Kode</th>
                                <th style="min-width:150px;"><i class="bi bi-file-text me-1"></i>Judul Survei</th>
                                <th style="min-width:120px;"><i class="bi bi-building me-1"></i>Unit Layanan</th>
                                <th style="min-width:70px;text-align:center;"><i class="bi bi-question-circle me-1"></i>Pertanyaan</th>
                                <th style="min-width:70px;text-align:center;"><i class="bi bi-people me-1"></i>Respon</th>
                                <th style="min-width:100px;"><i class="bi bi-circle-fill me-1"></i>Status</th>
                                <th style="min-width:140px;text-align:center;"><i class="bi bi-tools me-1"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($templates as $t)
                            <tr>
                                <td>
                                    <span class="survey-code">{{ $t->kode_survei }}</span>
                                </td>
                                <td class="fw-medium">{{ Str::limit($t->judul_survei, 40) }}</td>
                                <td>{{ Str::limit($t->unit_layanan, 25) }}</td>
                                <td class="text-center">
                                    <span class="badge-premium" style="background:rgba(11,93,57,0.08);color:var(--primary);">
                                        {{ $t->questions_count }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge-premium" style="background:rgba(26,111,160,0.08);color:var(--blue);">
                                        {{ $t->responses_count }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-premium bg-{{ $t->status === 'aktif' ? 'success' : ($t->status === 'draft' ? 'secondary' : 'danger') }}">
                                        @if($t->status === 'aktif')
                                            <span class="status-dot active"></span>
                                        @elseif($t->status === 'draft')
                                            <span class="status-dot draft"></span>
                                        @else
                                            <span class="status-dot inactive"></span>
                                        @endif
                                        {{ ucfirst($t->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('survey-questions.index', $t) }}" 
                                           class="btn-action questions" 
                                           title="Kelola Pertanyaan">
                                            <i class="bi bi-list-check"></i>
                                        </a>
                                        <a href="{{ route('survey-templates.edit', $t) }}" 
                                           class="btn-action edit" 
                                           title="Edit Template">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('survey-templates.destroy', $t) }}" 
                                              method="POST" 
                                              class="d-inline form-delete" 
                                              data-item-name="template {{ $t->judul_survei }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-action delete" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state-table">
                                        <i class="bi bi-inbox"></i>
                                        <h6>Belum Ada Template Survei</h6>
                                        <small class="text-muted">Klik tombol "Buat Template Survei" untuk membuat template baru</small>
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
                <i class="bi bi-shield-check"></i> Data template survei tersimpan aman • 
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

// ===== DELETE CONFIRMATION =====
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-delete').forEach(function (form) {

        form.addEventListener('submit', function (e) {

            const itemName = form.dataset.itemName || 'template ini';

            const confirmed = window.confirm(
                'Apakah Anda yakin ingin menghapus ' + itemName + '?\n\n' +
                'Data yang sudah dihapus tidak dapat dikembalikan.'
            );

            if (!confirmed) {
                e.preventDefault();
                return false;
            }

            // Jika OK, form diteruskan ke Laravel
            return true;
        });

    });

});
</script>
@endsection