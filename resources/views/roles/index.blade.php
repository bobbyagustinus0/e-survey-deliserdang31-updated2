@extends('layouts.app')
@section('title', 'Hak Akses')

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
    .role-wrapper {
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

    [data-theme="dark"] .role-wrapper {
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
    .role-content {
        position: relative;
        z-index: 1;
    }

    /* ===== HEADER ===== */
    .role-header {
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

    [data-theme="dark"] .role-header {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .role-header::before {
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

    [data-theme="dark"] .role-header::before {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.08) 0%, transparent 70%);
    }

    .role-header:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .role-header .header-title {
        font-size: 1.75rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    .role-header .header-badge {
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
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
    [data-theme="dark"] .stat-mini-card .stat-icon-box.blue {
        background: rgba(52, 152, 219, 0.1);
        color: #3498db;
    }
    [data-theme="dark"] .stat-mini-card .stat-icon-box.gold {
        background: rgba(185, 134, 46, 0.1);
        color: #d4a84a;
    }
    [data-theme="dark"] .stat-mini-card .stat-icon-box.purple {
        background: rgba(142, 68, 173, 0.1);
        color: #8e44ad;
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
        font-size: 0.65rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    [data-theme="dark"] .stat-mini-card .stat-info .stat-label {
        color: #8a8a9a;
    }

    /* ===== MAIN CARD ===== */
    .role-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
    }

    [data-theme="dark"] .role-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .role-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .role-card .card-header-custom {
        padding: 1.25rem 1.75rem;
        background: rgba(0, 0, 0, 0.02);
        border-bottom: 2px solid rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    [data-theme="dark"] .role-card .card-header-custom {
        background: rgba(255, 255, 255, 0.02);
        border-bottom-color: rgba(255, 255, 255, 0.04);
    }

    .role-card .card-header-custom .card-title {
        font-weight: 600;
        font-size: 1rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
    }

    [data-theme="dark"] .role-card .card-header-custom .card-title {
        color: #e0e0e0;
    }

    .role-card .card-header-custom .card-title i {
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
        text-decoration: none;
    }

    .btn-create:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 30px rgba(11, 93, 57, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-create:active {
        transform: scale(0.98);
    }

    [data-theme="dark"] .btn-create {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
        box-shadow: 0 4px 15px rgba(46, 204, 113, 0.2);
    }

    .role-card .card-body-custom {
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
        padding: 0.8rem 1.2rem;
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

    /* ===== ROLE NAME ===== */
    .role-name {
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    [data-theme="dark"] .role-name {
        color: #e0e0e0;
    }

    .role-name .role-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .role-name .role-icon.superadmin {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .role-name .role-icon.admin {
        background: rgba(26, 111, 160, 0.1);
        color: var(--blue);
    }

    .role-name .role-icon.user {
        background: rgba(185, 134, 46, 0.1);
        color: var(--gold);
    }

    .role-name .role-icon.default {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }

    /* ===== SLUG ===== */
    .role-slug {
        font-family: 'Courier New', monospace;
        font-weight: 600;
        font-size: 0.75rem;
        color: var(--primary);
        background: rgba(11, 93, 57, 0.06);
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        display: inline-block;
        letter-spacing: 0.3px;
    }

    [data-theme="dark"] .role-slug {
        background: rgba(46, 204, 113, 0.06);
        color: #2ecc71;
    }

    /* ===== USER COUNT ===== */
    .user-count {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-weight: 600;
        color: #2c3e50;
    }

    [data-theme="dark"] .user-count {
        color: #e0e0e0;
    }

    .user-count .count-number {
        background: rgba(11, 93, 57, 0.06);
        padding: 0.1rem 0.5rem;
        border-radius: 50px;
        font-size: 0.85rem;
        min-width: 24px;
        text-align: center;
    }

    [data-theme="dark"] .user-count .count-number {
        background: rgba(46, 204, 113, 0.06);
    }

    /* ===== MENU ACCESS ===== */
    .menu-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.2rem 0.7rem;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 500;
        margin: 0.15rem;
        background: rgba(108, 117, 125, 0.08);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.08);
        transition: var(--transition);
    }

    .menu-badge:hover {
        transform: scale(1.05);
        background: rgba(108, 117, 125, 0.12);
    }

    [data-theme="dark"] .menu-badge {
        background: rgba(255, 255, 255, 0.03);
        color: #adb5bd;
        border-color: rgba(255, 255, 255, 0.03);
    }

    [data-theme="dark"] .menu-badge:hover {
        background: rgba(255, 255, 255, 0.06);
    }

    .menu-badge i {
        font-size: 0.5rem;
        opacity: 0.6;
    }

    .menu-all-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.2rem 0.9rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        background: rgba(40, 167, 69, 0.12);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.15);
    }

    .menu-all-badge i {
        font-size: 0.65rem;
    }

    [data-theme="dark"] .menu-all-badge {
        background: rgba(46, 204, 113, 0.1);
        color: #2ecc71;
        border-color: rgba(46, 204, 113, 0.1);
    }

    /* ===== ACTION BUTTONS ===== */
    .action-group {
        display: flex;
        gap: 0.3rem;
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

    .btn-action.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .btn-action.disabled:hover {
        transform: none;
        box-shadow: none;
        border-color: rgba(0, 0, 0, 0.06);
        background: rgba(255, 255, 255, 0.5);
        color: #6c757d;
    }

    [data-theme="dark"] .btn-action.disabled:hover {
        border-color: rgba(255, 255, 255, 0.05);
        background: rgba(255, 255, 255, 0.03);
        color: #8a8a9a;
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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .table-premium {
            font-size: 0.75rem;
        }

        .table-premium thead th,
        .table-premium tbody td {
            padding: 0.5rem 0.6rem;
        }

        .btn-action {
            width: 30px;
            height: 30px;
            font-size: 0.75rem;
        }

        .role-name .role-icon {
            width: 28px;
            height: 28px;
            font-size: 0.7rem;
        }
    }

    @media (max-width: 768px) {
        .role-wrapper {
            padding: 1rem;
        }

        .role-header {
            padding: 1.25rem;
        }

        .role-header .header-title {
            font-size: 1.25rem;
        }

        .role-header .header-badge {
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
            font-size: 0.55rem;
        }

        .role-card .card-header-custom {
            padding: 0.8rem 1.25rem;
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
        }

        .role-card .card-header-custom .card-title {
            font-size: 0.9rem;
        }

        .btn-create {
            width: 100%;
            justify-content: center;
            font-size: 0.7rem;
            padding: 0.4rem 1rem;
        }

        .table-premium {
            font-size: 0.7rem;
        }

        .table-premium thead th,
        .table-premium tbody td {
            padding: 0.4rem 0.5rem;
        }

        .role-name {
            font-size: 0.8rem;
        }

        .role-name .role-icon {
            width: 24px;
            height: 24px;
            font-size: 0.6rem;
            border-radius: 6px;
        }

        .role-slug {
            font-size: 0.65rem;
            padding: 0.15rem 0.4rem;
        }

        .menu-badge {
            font-size: 0.55rem;
            padding: 0.15rem 0.5rem;
        }

        .menu-all-badge {
            font-size: 0.6rem;
            padding: 0.15rem 0.6rem;
        }

        .btn-action {
            width: 26px;
            height: 26px;
            font-size: 0.65rem;
            border-radius: 6px;
        }
    }

    @media (max-width: 576px) {
        .role-header .header-title {
            font-size: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .stat-mini-card {
            padding: 0.5rem 0.75rem;
            gap: 0.6rem;
        }

        .stat-mini-card .stat-icon-box {
            width: 30px;
            height: 30px;
            font-size: 0.85rem;
            border-radius: 8px;
        }

        .stat-mini-card .stat-info .stat-number {
            font-size: 0.95rem;
        }

        .stat-mini-card .stat-info .stat-label {
            font-size: 0.5rem;
        }

        .table-premium {
            font-size: 0.65rem;
        }

        .table-premium thead th,
        .table-premium tbody td {
            padding: 0.3rem 0.4rem;
        }

        .role-name {
            font-size: 0.7rem;
        }

        .role-name .role-icon {
            width: 20px;
            height: 20px;
            font-size: 0.5rem;
            border-radius: 4px;
        }

        .role-slug {
            font-size: 0.55rem;
            padding: 0.1rem 0.3rem;
        }

        .user-count .count-number {
            font-size: 0.7rem;
            padding: 0.05rem 0.3rem;
            min-width: 18px;
        }

        .menu-badge {
            font-size: 0.5rem;
            padding: 0.1rem 0.4rem;
        }

        .menu-all-badge {
            font-size: 0.55rem;
            padding: 0.1rem 0.5rem;
        }

        .btn-action {
            width: 22px;
            height: 22px;
            font-size: 0.55rem;
            border-radius: 4px;
        }

        .empty-state-table {
            padding: 2rem 1rem;
        }

        .empty-state-table i {
            font-size: 2.5rem;
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
<div class="role-wrapper">
    <!-- Decorative Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <!-- ===== CONTENT ===== -->
    <div class="role-content">

        <!-- ===== HEADER ===== -->
        <div class="role-header animate-in">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <span class="text-uppercase small fw-bold" style="color:var(--primary); letter-spacing:0.05em; font-size:0.7rem;">
                            <i class="bi bi-shield-lock me-1"></i> Keamanan
                        </span>
                        <h4 class="header-title mt-1 mb-0">
                            <i class="bi bi-person-lock me-2"></i> Hak Akses
                        </h4>
                    </div>
                    <span class="header-badge">
                        <i class="bi bi-database"></i> {{ $roles->count() }} Role
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="header-subtitle">
                        <i class="bi bi-info-circle"></i> 
                        Kelola role dan hak akses pengguna
                    </div>
                    <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== STATS ===== -->
        <div class="stats-grid animate-in">
            <div class="stat-mini-card">
                <div class="stat-icon-box green">
                    <i class="bi bi-shield-fill-check"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $roles->count() }}</div>
                    <div class="stat-label">Total Role</div>
                </div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-icon-box blue">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $roles->sum('users_count') }}</div>
                    <div class="stat-label">Total User</div>
                </div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-icon-box gold">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $roles->where('slug', 'superadmin')->count() }}</div>
                    <div class="stat-label">Super Admin</div>
                </div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-icon-box purple">
                    <i class="bi bi-menu-app"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ count($menus ?? []) }}</div>
                    <div class="stat-label">Total Menu</div>
                </div>
            </div>
        </div>

        <!-- ===== TABLE CARD ===== -->
        <div class="role-card animate-in">
            <div class="card-header-custom">
                <span class="card-title">
                    <i class="bi bi-list-ul"></i>
                    Daftar Role &amp; Hak Akses
                </span>
                <a href="{{ route('roles.create') }}" class="btn-create">
                    <i class="bi bi-plus-lg"></i> Tambah Role
                </a>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="table table-premium">
                        <thead>
                            <tr>
                                <th style="min-width:140px;"><i class="bi bi-person-badge me-1"></i>Nama Role</th>
                                <th style="min-width:100px;"><i class="bi bi-tag me-1"></i>Slug</th>
                                <th style="min-width:90px;text-align:center;"><i class="bi bi-people me-1"></i>User</th>
                                <th style="min-width:200px;"><i class="bi bi-menu-button-wide me-1"></i>Menu yang Diizinkan</th>
                                <th style="min-width:100px;text-align:center;"><i class="bi bi-tools me-1"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                            <tr>
                                <td>
                                    <span class="role-name">
                                        <span class="role-icon {{ 
                                            $role->slug === 'superadmin' ? 'superadmin' : 
                                            ($role->slug === 'admin' ? 'admin' : 
                                            ($role->slug === 'user' ? 'user' : 'default')) 
                                        }}">
                                            <i class="bi {{ 
                                                $role->slug === 'superadmin' ? 'bi-shield-fill-check' : 
                                                ($role->slug === 'admin' ? 'bi-person-gear' : 
                                                ($role->slug === 'user' ? 'bi-person' : 'bi-person-badge')) 
                                            }}"></i>
                                        </span>
                                        {{ $role->nama_role }}
                                    </span>
                                </td>
                                <td>
                                    <span class="role-slug">{{ $role->slug }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="user-count">
                                        <span class="count-number">{{ $role->users_count }}</span>
                                    </span>
                                </td>
                                <td>
                                    @if($role->slug === 'superadmin')
                                        <span class="menu-all-badge">
                                            <i class="bi bi-check-circle-fill"></i> Semua Menu
                                        </span>
                                    @else
                                        @php
                                            $menuAccess = $role->menu_access ?? [];
                                        @endphp
                                        @if(count($menuAccess) > 0)
                                            @foreach($menuAccess as $menu)
                                                <span class="menu-badge">
                                                    <i class="bi bi-dot"></i>
                                                    {{ $menus[$menu] ?? $menu }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="menu-badge" style="opacity:0.5;">
                                                <i class="bi bi-dash-circle"></i> Tidak ada menu
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('roles.edit', $role) }}" class="btn-action edit" title="Edit Role">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if($role->slug !== 'superadmin')
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline form-delete" data-item-name="role {{ $role->nama_role }}">
                                                @csrf @method('DELETE')
                                                <button class="btn-action delete" title="Hapus Role">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="btn-action disabled" title="Superadmin tidak dapat dihapus">
                                                <i class="bi bi-lock-fill"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state-table">
                                        <i class="bi bi-shield-slash"></i>
                                        <h6>Belum Ada Role</h6>
                                        <small class="text-muted">Klik tombol "Tambah Role" untuk membuat role baru</small>
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
                <i class="bi bi-shield-check"></i> Data hak akses tersimpan aman • 
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
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const itemName = this.dataset.itemName || 'item ini';
        if (confirm(`Apakah Anda yakin ingin menghapus ${itemName}?`)) {
            this.submit();
        }
    });
});
</script>
@endsection