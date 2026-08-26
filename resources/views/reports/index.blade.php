@extends('layouts.app')
@section('title', 'Laporan')

@section('content')
<style>
    /* ===== CSS VARIABLES ===== */
    :root {
        --primary: #0B5D39;
        --primary-light: #1a8a5a;
        --primary-dark: #094a2e;
        --primary-gradient: linear-gradient(135deg, #0B5D39 0%, #1a8a5a 100%);
        --secondary: #6c757d;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
        --gold: #b8860b;
        --gold-light: #d4a84a;
        --gold-gradient: linear-gradient(135deg, #b8860b 0%, #d4a84a 100%);
        --purple: #7c3aed;
        --purple-light: #a78bfa;
        --purple-gradient: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
        --blue: #1f6fb2;
        --blue-light: #3498db;
        --blue-gradient: linear-gradient(135deg, #1f6fb2 0%, #3498db 100%);
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        --card-shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.08);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --font-display: 'Inter', 'Segoe UI', system-ui, sans-serif;
    }

    /* ===== BACKGROUND ===== */
    .report-wrapper {
        position: relative;
        min-height: 100vh;
        padding: 1.5rem;
        background: 
            radial-gradient(ellipse at 0% 0%, rgba(11, 93, 57, 0.06) 0%, transparent 50%),
            radial-gradient(ellipse at 100% 100%, rgba(185, 134, 46, 0.05) 0%, transparent 50%),
            radial-gradient(ellipse at 100% 0%, rgba(26, 111, 160, 0.04) 0%, transparent 40%),
            radial-gradient(ellipse at 0% 100%, rgba(108, 52, 131, 0.04) 0%, transparent 40%),
            #f8f9fc;
        background-attachment: fixed;
    }

    [data-theme="dark"] .report-wrapper {
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
        background: radial-gradient(circle, rgba(11, 93, 57, 0.12), transparent);
    }

    .bg-shape.shape-2 {
        width: 300px;
        height: 300px;
        bottom: -50px;
        left: -50px;
        background: radial-gradient(circle, rgba(185, 134, 46, 0.08), transparent);
    }

    .bg-shape.shape-3 {
        width: 200px;
        height: 200px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: radial-gradient(circle, rgba(26, 111, 160, 0.05), transparent);
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
    .report-content {
        position: relative;
        z-index: 1;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ===== HEADER ===== */
    .report-header {
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

    [data-theme="dark"] .report-header {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .report-header::before {
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

    [data-theme="dark"] .report-header::before {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.08) 0%, transparent 70%);
    }

    .report-header:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .report-header .header-title {
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

    .report-header .header-title i {
        -webkit-text-fill-color: initial;
        color: var(--primary);
        font-size: 1.8rem;
    }

    [data-theme="dark"] .report-header .header-title i {
        color: #2ecc71;
    }

    .report-header .header-badge {
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

    /* ===== FILTER CARD ===== */
    .filter-card {
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

    [data-theme="dark"] .filter-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .filter-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .filter-card .card-body-custom {
        padding: 1.5rem 1.75rem;
    }

    .filter-card .filter-title {
        font-weight: 600;
        font-size: 0.9rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    [data-theme="dark"] .filter-card .filter-title {
        color: #e0e0e0;
    }

    .filter-card .filter-title i {
        color: var(--primary);
        font-size: 1rem;
    }

    .form-label-filter {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 0.3rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    [data-theme="dark"] .form-label-filter {
        color: #8a8a9a;
    }

    .form-control-filter {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 2px solid rgba(0, 0, 0, 0.06);
        border-radius: 12px;
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
        transition: var(--transition);
        color: #2c3e50;
        width: 100%;
    }

    [data-theme="dark"] .form-control-filter {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.08);
        color: #e0e0e0;
    }

    .form-control-filter:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(11, 93, 57, 0.1);
        background: rgba(255, 255, 255, 0.8);
        outline: none;
    }

    [data-theme="dark"] .form-control-filter:focus {
        border-color: #2ecc71;
        box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1);
        background: rgba(255, 255, 255, 0.08);
    }

    select.form-control-filter {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.5rem;
        cursor: pointer;
    }

    .btn-filter {
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
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.2);
        width: 100%;
        justify-content: center;
        height: 100%;
        min-height: 44px;
    }

    .btn-filter:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 30px rgba(11, 93, 57, 0.3);
        color: white;
    }

    .btn-filter:active {
        transform: scale(0.98);
    }

    [data-theme="dark"] .btn-filter {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
        box-shadow: 0 4px 15px rgba(46, 204, 113, 0.2);
    }

    .btn-export {
        background: rgba(108, 117, 125, 0.08);
        color: #6c757d;
        border: 2px solid rgba(108, 117, 125, 0.12);
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.85rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-export:hover {
        background: rgba(108, 117, 125, 0.15);
        transform: translateY(-2px);
        color: #6c757d;
        text-decoration: none;
    }

    [data-theme="dark"] .btn-export {
        color: #adb5bd;
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-theme="dark"] .btn-export:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #adb5bd;
    }

    .btn-export i {
        font-size: 1rem;
    }

    /* ===== STATS CARDS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card-premium {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        padding: 1.25rem 1.5rem;
        transition: var(--transition);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
    }

    [data-theme="dark"] .stat-card-premium {
        background: rgba(30, 30, 46, 0.6);
        border-color: rgba(255, 255, 255, 0.05);
    }

    .stat-card-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        opacity: 0.6;
    }

    .stat-card-premium.green::before {
        background: var(--primary-gradient);
    }

    .stat-card-premium.gold::before {
        background: var(--gold-gradient);
    }

    .stat-card-premium.blue::before {
        background: var(--blue-gradient);
    }

    .stat-card-premium.purple::before {
        background: var(--purple-gradient);
    }

    .stat-card-premium:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
    }

    .stat-card-premium .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .stat-card-premium .stat-value {
        font-size: 2.2rem;
        font-weight: 800;
        color: #2c3e50;
        line-height: 1.2;
        letter-spacing: -0.5px;
    }

    [data-theme="dark"] .stat-card-premium .stat-value {
        color: #e0e0e0;
    }

    .stat-card-premium .stat-icon {
        font-size: 2rem;
        opacity: 0.15;
        transition: var(--transition);
    }

    .stat-card-premium:hover .stat-icon {
        opacity: 0.25;
        transform: scale(1.1) rotate(-5deg);
    }

    .stat-card-premium .stat-icon.green {
        color: var(--primary);
    }
    .stat-card-premium .stat-icon.gold {
        color: var(--gold);
    }
    .stat-card-premium .stat-icon.blue {
        color: var(--blue);
    }
    .stat-card-premium .stat-icon.purple {
        color: var(--purple);
    }

    .stat-card-premium .stat-label {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 500;
        margin-top: 0.1rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    [data-theme="dark"] .stat-card-premium .stat-label {
        color: #8a8a9a;
    }

    .stat-card-premium .stat-label i {
        font-size: 0.7rem;
        opacity: 0.6;
    }

    .stat-card-premium .stat-trend {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.2rem 0.6rem;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
        margin-top: 0.3rem;
    }

    .stat-card-premium .stat-trend.up {
        background: rgba(40, 167, 69, 0.08);
        color: #28a745;
    }

    .stat-card-premium .stat-trend.down {
        background: rgba(220, 53, 69, 0.08);
        color: #dc3545;
    }

    /* ===== CHART CARDS ===== */
    .chart-card {
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

    [data-theme="dark"] .chart-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .chart-card:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .chart-card .card-header-custom {
        padding: 1rem 1.5rem;
        background: rgba(0, 0, 0, 0.02);
        border-bottom: 2px solid rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    [data-theme="dark"] .chart-card .card-header-custom {
        background: rgba(255, 255, 255, 0.02);
        border-bottom-color: rgba(255, 255, 255, 0.04);
    }

    .chart-card .card-header-custom .card-title {
        font-weight: 600;
        font-size: 0.95rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
    }

    [data-theme="dark"] .chart-card .card-header-custom .card-title {
        color: #e0e0e0;
    }

    .chart-card .card-header-custom .card-title i {
        font-size: 1rem;
    }

    .chart-card .card-header-custom .badge-count {
        background: rgba(0, 0, 0, 0.04);
        padding: 0.2rem 0.8rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        color: #6c757d;
    }

    [data-theme="dark"] .chart-card .card-header-custom .badge-count {
        background: rgba(255, 255, 255, 0.04);
        color: #8a8a9a;
    }

    .chart-card .card-body-custom {
        padding: 1.5rem;
    }

    .chart-wrapper {
        position: relative;
        min-height: 220px;
    }

    .chart-wrapper canvas {
        max-height: 220px;
        width: 100% !important;
    }

    .chart-wrapper.tall canvas {
        max-height: 140px;
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
    .animate-in:nth-child(4) { animation-delay: 0.2s; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .report-wrapper {
            padding: 1rem;
        }

        .report-header {
            padding: 1.25rem;
        }

        .report-header .header-title {
            font-size: 1.25rem;
        }

        .report-header .header-badge {
            font-size: 0.6rem;
            padding: 0.2rem 0.7rem;
        }

        .header-subtitle {
            font-size: 0.75rem;
            padding: 0.3rem 0.8rem;
        }

        .filter-card .card-body-custom {
            padding: 1rem 1.25rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .stat-card-premium {
            padding: 1rem 1.25rem;
        }

        .stat-card-premium .stat-value {
            font-size: 1.8rem;
        }

        .stat-card-premium .stat-icon {
            font-size: 1.5rem;
        }

        .stat-card-premium .stat-label {
            font-size: 0.65rem;
        }

        .chart-card .card-body-custom {
            padding: 1rem;
        }

        .chart-wrapper {
            min-height: 180px;
        }

        .chart-wrapper canvas {
            max-height: 180px;
        }

        .btn-filter {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            min-height: 38px;
        }

        .btn-export {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
        }
    }

    @media (max-width: 576px) {
        .report-header .header-title {
            font-size: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .stat-card-premium {
            padding: 0.75rem 1rem;
        }

        .stat-card-premium .stat-value {
            font-size: 1.4rem;
        }

        .stat-card-premium .stat-icon {
            font-size: 1.2rem;
        }

        .stat-card-premium .stat-label {
            font-size: 0.6rem;
        }

        .stat-card-premium .stat-trend {
            font-size: 0.6rem;
            padding: 0.1rem 0.4rem;
        }

        .filter-card .card-body-custom {
            padding: 0.8rem 1rem;
        }

        .filter-card .filter-title {
            font-size: 0.8rem;
        }

        .chart-card .card-header-custom {
            padding: 0.6rem 1rem;
        }

        .chart-card .card-header-custom .card-title {
            font-size: 0.8rem;
        }

        .chart-card .card-body-custom {
            padding: 0.8rem;
        }

        .chart-wrapper {
            min-height: 150px;
        }

        .chart-wrapper canvas {
            max-height: 150px;
        }

        .btn-filter {
            font-size: 0.7rem;
            padding: 0.4rem 0.8rem;
            min-height: 34px;
        }

        .btn-export {
            font-size: 0.7rem;
            padding: 0.4rem 0.8rem;
        }

        .form-label-filter {
            font-size: 0.65rem;
        }

        .form-control-filter {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
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
<div class="report-wrapper">
    <!-- Decorative Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <!-- ===== CONTENT ===== -->
    <div class="report-content">

        <!-- ===== HEADER ===== -->
        <div class="report-header animate-in">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <span class="text-uppercase small fw-bold" style="color:var(--primary); letter-spacing:0.05em; font-size:0.7rem;">
                            <i class="bi bi-graph-up-arrow me-1"></i> Analisis
                        </span>
                        <h4 class="header-title mt-1 mb-0">
                            <i class="bi bi-bar-chart-fill"></i> Laporan Survei
                        </h4>
                    </div>
                    <span class="header-badge">
                        <i class="bi bi-database"></i> {{ number_format($totalResponden) }} Responden
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="header-subtitle">
                        <i class="bi bi-info-circle"></i> 
                        Analisis data survei kepuasan layanan
                    </div>
                    <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== FILTER CARD ===== -->
        <div class="filter-card animate-in">
            <div class="card-body-custom">
                <div class="filter-title">
                    <i class="bi bi-funnel-fill"></i>
                    Filter Laporan
                </div>
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label-filter">
                            <i class="bi bi-file-text"></i> Template Survei
                        </label>
                        <select name="template_id" class="form-control-filter">
                            <option value="">📋 Semua Survei</option>
                            @foreach ($templates as $t)
                                <option value="{{ $t->id }}" @selected(request('template_id') == $t->id)>
                                    {{ $t->judul_survei }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label-filter">
                            <i class="bi bi-calendar-plus"></i> Dari Tanggal
                        </label>
                        <input type="date" name="dari" class="form-control-filter" value="{{ request('dari') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label-filter">
                            <i class="bi bi-calendar-minus"></i> Sampai Tanggal
                        </label>
                        <input type="date" name="sampai" class="form-control-filter" value="{{ request('sampai') }}">
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button class="btn-filter" type="submit">
                                <i class="bi bi-funnel"></i> Terapkan
                            </button>
                            @if(request('template_id') || request('dari') || request('sampai'))
                                <a href="{{ route('laporan.index') }}" class="btn-export" style="padding:0.6rem 1rem;">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
                <div class="mt-3">
                    <a href="{{ route('laporan.export', request()->query()) }}" class="btn-export">
                        <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
                    </a>
                </div>
            </div>
        </div>

        <!-- ===== STATS ===== -->
        <div class="stats-grid animate-in">
            <div class="stat-card-premium green">
                <div class="stat-top">
                    <div>
                        <div class="stat-value">{{ number_format($totalResponden) }}</div>
                        <div class="stat-label">
                            <i class="bi bi-people"></i> Total Responden
                        </div>
                        <div class="stat-trend up">
                            <i class="bi bi-arrow-up"></i> +12%
                        </div>
                    </div>
                    <div class="stat-icon green">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
            <div class="stat-card-premium gold">
                <div class="stat-top">
                    <div>
                        <div class="stat-value">{{ number_format($rataIkm, 2) }}</div>
                        <div class="stat-label">
                            <i class="bi bi-star"></i> Rata-rata Nilai IKM
                        </div>
                        <div class="stat-trend up">
                            <i class="bi bi-arrow-up"></i> +3.2 poin
                        </div>
                    </div>
                    <div class="stat-icon gold">
                        <i class="bi bi-star-fill"></i>
                    </div>
                </div>
            </div>
            <div class="stat-card-premium blue">
                <div class="stat-top">
                    <div>
                        @php
                            $totalKategori = collect($sebaranKategori)->sum();
                            $baikSangatBaik = ($sebaranKategori['A (Sangat Baik)'] ?? 0) + ($sebaranKategori['B (Baik)'] ?? 0);
                            $persentase = $totalKategori > 0 ? round(($baikSangatBaik / $totalKategori) * 100) : 0;
                        @endphp
                        <div class="stat-value">{{ $persentase }}%</div>
                        <div class="stat-label">
                            <i class="bi bi-check-circle"></i> Kategori Baik & Sangat Baik
                        </div>
                        <div class="stat-trend up">
                            <i class="bi bi-arrow-up"></i> +5.4%
                        </div>
                    </div>
                    <div class="stat-icon blue">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
            <div class="stat-card-premium purple">
                <div class="stat-top">
                    <div>
                        <div class="stat-value">{{ $templates->where('status', 'aktif')->count() }}</div>
                        <div class="stat-label">
                            <i class="bi bi-clipboard"></i> Survei Aktif
                        </div>
                        <div class="stat-trend up">
                            <i class="bi bi-arrow-up"></i> +3
                        </div>
                    </div>
                    <div class="stat-icon purple">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== CHARTS ===== -->
        <div class="row g-3">
            <!-- Kategori Chart -->
            <div class="col-lg-6 animate-in">
                <div class="chart-card">
                    <div class="card-header-custom">
                        <span class="card-title">
                            <i class="bi bi-pie-chart-fill" style="color:var(--primary);"></i>
                            Sebaran Kategori Mutu Pelayanan
                        </span>
                        <span class="badge-count">{{ collect($sebaranKategori)->sum() }} total</span>
                    </div>
                    <div class="card-body-custom">
                        <div class="chart-wrapper">
                            <canvas id="chartKategori"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gender Chart -->
            <div class="col-lg-6 animate-in">
                <div class="chart-card">
                    <div class="card-header-custom">
                        <span class="card-title">
                            <i class="bi bi-gender-ambiguous" style="color:var(--blue);"></i>
                            Sebaran Jenis Kelamin Responden
                        </span>
                        <span class="badge-count">{{ collect($sebaranGender)->sum() }} total</span>
                    </div>
                    <div class="card-body-custom">
                        <div class="chart-wrapper">
                            <canvas id="chartGender"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perbandingan Chart -->
            <div class="col-12 animate-in">
                <div class="chart-card">
                    <div class="card-header-custom">
                        <span class="card-title">
                            <i class="bi bi-bar-chart-fill" style="color:var(--gold);"></i>
                            Perbandingan Nilai IKM Antar Layanan
                        </span>
                        <span class="badge-count">{{ count($ikmPerTemplate) }} layanan</span>
                    </div>
                    <div class="card-body-custom">
                        <div class="chart-wrapper tall">
                            <canvas id="chartPerbandingan"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== FOOTER ===== -->
        <div class="text-center mt-4 py-3">
            <small class="text-muted opacity-50">
                <i class="bi bi-shield-check"></i> Data laporan diperbarui secara otomatis • 
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
    initCharts();
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

// ===== CHARTS =====
function initCharts() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const textColor = isDark ? '#adb5bd' : '#495057';
    const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
    const borderColor = isDark ? 'rgba(255,255,255,0.1)' : '#ffffff';

    // Chart 1: Kategori
    const ctxKategori = document.getElementById('chartKategori');
    if (ctxKategori) {
        new Chart(ctxKategori, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($sebaranKategori)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($sebaranKategori)) !!},
                    backgroundColor: ['#0B5D39', '#2e8b57', '#d4a843', '#c0392b'],
                    borderWidth: 3,
                    borderColor: borderColor,
                    hoverOffset: 12,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 12, weight: '500' },
                            color: textColor
                        }
                    },
                    tooltip: {
                        backgroundColor: isDark ? 'rgba(30,30,46,0.95)' : 'rgba(0,0,0,0.85)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });
    }

    // Chart 2: Gender
    const ctxGender = document.getElementById('chartGender');
    if (ctxGender) {
        new Chart(ctxGender, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($sebaranGender)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($sebaranGender)) !!},
                    backgroundColor: ['#1f6fb2', '#e0658f'],
                    borderWidth: 3,
                    borderColor: borderColor,
                    hoverOffset: 12,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 12, weight: '500' },
                            color: textColor
                        }
                    },
                    tooltip: {
                        backgroundColor: isDark ? 'rgba(30,30,46,0.95)' : 'rgba(0,0,0,0.85)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // Chart 3: Perbandingan
    const ikmPerTemplate = {!! json_encode($ikmPerTemplate) !!};
    const ctxPerbandingan = document.getElementById('chartPerbandingan');
    if (ctxPerbandingan) {
        const colors = ['#0B5D39', '#2e8b57', '#3da06a', '#4db87c', '#5fcf8e'];
        new Chart(ctxPerbandingan, {
            type: 'bar',
            data: {
                labels: ikmPerTemplate.map(i => i.judul),
                datasets: [{
                    label: 'Rata-rata IKM',
                    data: ikmPerTemplate.map(i => parseFloat(i.rata_ikm) || 0),
                    backgroundColor: ikmPerTemplate.map((_, idx) => colors[idx % colors.length]),
                    borderRadius: 8,
                    borderSkipped: false,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: isDark ? 'rgba(30,30,46,0.95)' : 'rgba(0,0,0,0.85)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return 'Nilai IKM: ' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: gridColor,
                            drawBorder: false,
                        },
                        ticks: {
                            font: { size: 11 },
                            color: textColor,
                            callback: function(value) {
                                return value + '';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 11 },
                            color: textColor,
                            maxRotation: 45,
                            minRotation: 30
                        }
                    }
                }
            }
        });
    }
}

// ===== REINIT CHARTS ON THEME CHANGE =====
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.attributeName === 'data-theme') {
            // Destroy and recreate charts
            Chart.instances.forEach(instance => instance.destroy());
            initCharts();
        }
    });
});

observer.observe(document.documentElement, { attributes: true });
</script>
@endsection