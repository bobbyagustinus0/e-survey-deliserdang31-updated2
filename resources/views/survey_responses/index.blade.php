@extends('layouts.app')
@section('title', 'Respon Survei')

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
    .response-wrapper {
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

    [data-theme="dark"] .response-wrapper {
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
    .response-content {
        position: relative;
        z-index: 1;
    }

    /* ===== HEADER ===== */
    .response-header {
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

    [data-theme="dark"] .response-header {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .response-header::before {
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

    [data-theme="dark"] .response-header::before {
        background: radial-gradient(circle, rgba(46, 204, 113, 0.08) 0%, transparent 70%);
    }

    .response-header:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .response-header .header-title {
        font-size: 1.75rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    .response-header .header-badge {
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
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.3rem;
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

    .btn-reset-filter {
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
        width: 100%;
        justify-content: center;
        min-height: 44px;
    }

    .btn-reset-filter:hover {
        background: rgba(108, 117, 125, 0.15);
        transform: translateY(-2px);
        color: #6c757d;
        text-decoration: none;
    }

    [data-theme="dark"] .btn-reset-filter {
        color: #adb5bd;
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-theme="dark"] .btn-reset-filter:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #adb5bd;
    }

    /* ===== MAIN TABLE CARD ===== */
    .table-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
    }

    [data-theme="dark"] .table-card {
        background: rgba(30, 30, 46, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .table-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .table-card .card-header-custom {
        padding: 1.25rem 1.75rem;
        background: rgba(0, 0, 0, 0.02);
        border-bottom: 2px solid rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    [data-theme="dark"] .table-card .card-header-custom {
        background: rgba(255, 255, 255, 0.02);
        border-bottom-color: rgba(255, 255, 255, 0.04);
    }

    .table-card .card-header-custom .card-title {
        font-weight: 600;
        font-size: 1rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
    }

    [data-theme="dark"] .table-card .card-header-custom .card-title {
        color: #e0e0e0;
    }

    .table-card .card-header-custom .card-title i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .table-card .card-body-custom {
        padding: 0;
        overflow: hidden;
    }

    /* ===== TABLE ===== */
    .table-premium {
        font-size: 0.82rem;
        margin-bottom: 0;
        width: 100%;
    }

    .table-premium thead th {
        background: rgba(0, 0, 0, 0.02);
        border-bottom: 2px solid rgba(0, 0, 0, 0.06);
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        font-size: 0.6rem;
        letter-spacing: 0.8px;
        padding: 0.8rem 1rem;
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

    .table-premium .responden-name {
        font-weight: 600;
        color: #2c3e50;
    }

    [data-theme="dark"] .table-premium .responden-name {
        color: #e0e0e0;
    }

    .table-premium .responden-anon {
        color: #6c757d;
        font-style: italic;
    }

    [data-theme="dark"] .table-premium .responden-anon {
        color: #8a8a9a;
    }

    .table-premium .survey-title {
        max-width: 150px;
        display: inline-block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .table-premium .email-cell {
        color: var(--blue);
        font-size: 0.75rem;
    }

    [data-theme="dark"] .table-premium .email-cell {
        color: #3498db;
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

    .badge-ikm-a {
        background: rgba(40, 167, 69, 0.12);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.15);
    }

    .badge-ikm-b {
        background: rgba(185, 134, 46, 0.12);
        color: #B9862E;
        border: 1px solid rgba(185, 134, 46, 0.15);
    }

    .badge-ikm-c {
        background: rgba(255, 193, 7, 0.12);
        color: #856404;
        border: 1px solid rgba(255, 193, 7, 0.15);
    }

    .badge-ikm-d {
        background: rgba(220, 53, 69, 0.12);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.15);
    }

    .badge-ikm-e {
        background: rgba(108, 117, 125, 0.12);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.15);
    }

    .badge-ikm-a i,
    .badge-ikm-b i,
    .badge-ikm-c i,
    .badge-ikm-d i,
    .badge-ikm-e i {
        font-size: 0.6rem;
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

    .btn-action.view:hover {
        border-color: var(--blue);
        background: rgba(26, 111, 160, 0.05);
        color: var(--blue);
    }

    .btn-action.delete:hover {
        border-color: var(--danger);
        background: rgba(220, 53, 69, 0.05);
        color: var(--danger);
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

    /* ===== PAGINATION ===== */
    .pagination-wrapper {
        padding: 1rem 1.75rem;
        border-top: 1px solid rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    [data-theme="dark"] .pagination-wrapper {
        border-top-color: rgba(255, 255, 255, 0.04);
    }

    .pagination-wrapper .pagination-info {
        font-size: 0.8rem;
        color: #6c757d;
        margin-right: 1rem;
    }

    [data-theme="dark"] .pagination-wrapper .pagination-info {
        color: #8a8a9a;
    }

    .pagination-wrapper .pagination {
        margin: 0;
    }

    .pagination-wrapper .pagination .page-link {
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid rgba(0, 0, 0, 0.06);
        color: #495057;
        border-radius: 8px;
        padding: 0.3rem 0.7rem;
        font-size: 0.8rem;
        transition: var(--transition);
        margin: 0 0.1rem;
    }

    [data-theme="dark"] .pagination-wrapper .pagination .page-link {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.05);
        color: #adb5bd;
    }

    .pagination-wrapper .pagination .page-link:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: var(--primary);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(11, 93, 57, 0.2);
    }

    [data-theme="dark"] .pagination-wrapper .pagination .page-link:hover {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
        border-color: #2ecc71;
        box-shadow: 0 4px 15px rgba(46, 204, 113, 0.2);
    }

    .pagination-wrapper .pagination .active .page-link {
        background: var(--primary-gradient);
        color: white;
        border-color: var(--primary);
    }

    [data-theme="dark"] .pagination-wrapper .pagination .active .page-link {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
        border-color: #2ecc71;
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
    @media (max-width: 992px) {
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
    }

    @media (max-width: 768px) {
        .response-wrapper {
            padding: 1rem;
        }

        .response-header {
            padding: 1.25rem;
        }

        .response-header .header-title {
            font-size: 1.25rem;
        }

        .response-header .header-badge {
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

        .filter-card .card-body-custom {
            padding: 1rem 1.25rem;
        }

        .table-card .card-header-custom {
            padding: 0.8rem 1.25rem;
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
        }

        .table-card .card-header-custom .card-title {
            font-size: 0.9rem;
        }

        .table-premium {
            font-size: 0.7rem;
        }

        .table-premium thead th,
        .table-premium tbody td {
            padding: 0.4rem 0.5rem;
        }

        .btn-filter,
        .btn-reset-filter {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            min-height: 38px;
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

        .pagination-wrapper {
            padding: 0.75rem 1.25rem;
            flex-direction: column;
        }

        .pagination-wrapper .pagination-info {
            margin-right: 0;
            margin-bottom: 0.5rem;
            font-size: 0.7rem;
        }

        .badge-premium {
            font-size: 0.6rem;
            padding: 0.2rem 0.6rem;
        }

        .badge-ikm-a,
        .badge-ikm-b,
        .badge-ikm-c,
        .badge-ikm-d,
        .badge-ikm-e {
            font-size: 0.6rem;
            padding: 0.15rem 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .response-header .header-title {
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

        .filter-card .card-body-custom {
            padding: 0.8rem 1rem;
        }

        .table-card .card-header-custom {
            padding: 0.6rem 1rem;
        }

        .table-premium {
            font-size: 0.65rem;
        }

        .table-premium thead th,
        .table-premium tbody td {
            padding: 0.3rem 0.4rem;
        }

        .table-premium .survey-title {
            max-width: 80px;
        }

        .btn-filter,
        .btn-reset-filter {
            font-size: 0.7rem;
            padding: 0.4rem 0.8rem;
            min-height: 34px;
        }

        .btn-action {
            width: 24px;
            height: 24px;
            font-size: 0.6rem;
            border-radius: 6px;
        }

        .pagination-wrapper .pagination .page-link {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
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
<div class="response-wrapper">
    <!-- Decorative Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <!-- ===== CONTENT ===== -->
    <div class="response-content">

        <!-- ===== HEADER ===== -->
        <div class="response-header animate-in">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <span class="text-uppercase small fw-bold" style="color:var(--primary); letter-spacing:0.05em; font-size:0.7rem;">
                            <i class="bi bi-clipboard2-data me-1"></i> Manajemen
                        </span>
                        <h4 class="header-title mt-1 mb-0">
                            <i class="bi bi-file-bar-graph me-2"></i> Respon Survei
                        </h4>
                    </div>
                    <span class="header-badge">
                        <i class="bi bi-database"></i> {{ $responses->total() }} Respon
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="header-subtitle">
                        <i class="bi bi-info-circle"></i> 
                        Kelola semua respon survei
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
                    <i class="bi bi-file-bar-graph-fill"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $responses->total() }}</div>
                    <div class="stat-label">Total Respon</div>
                </div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-icon-box blue">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $responses->whereNotNull('nama_responden')->count() }}</div>
                    <div class="stat-label">Teridentifikasi</div>
                </div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-icon-box gold">
                    <i class="bi bi-incognito"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $responses->whereNull('nama_responden')->count() }}</div>
                    <div class="stat-label">Anonim</div>
                </div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-icon-box purple">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">
                        @php
                            $avgIkm = $responses->avg('nilai_ikm');
                        @endphp
                        {{ $avgIkm ? number_format($avgIkm, 1) : '-' }}
                    </div>
                    <div class="stat-label">Rata-rata IKM</div>
                </div>
            </div>
        </div>

        <!-- ===== FILTER CARD ===== -->
        <div class="filter-card animate-in">
            <div class="card-body-custom">
                <div class="filter-title">
                    <i class="bi bi-funnel-fill"></i>
                    Filter Data Respon
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
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                            @if(request('template_id') || request('dari') || request('sampai'))
                                <a href="{{ route('survey-responses.index') }}" class="btn-reset-filter">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- ===== TABLE CARD ===== -->
        <div class="table-card animate-in">
            <div class="card-header-custom">
                <span class="card-title">
                    <i class="bi bi-list-ul"></i>
                    Daftar Respon Survei
                </span>
                <span class="badge-premium" style="background:rgba(11,93,57,0.08);color:var(--primary);font-size:0.7rem;">
                    <i class="bi bi-clock-history"></i> 
                    {{ $responses->total() }} Data
                </span>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="table table-premium">
                        <thead>
                            <tr>
                                <th style="min-width:120px;"><i class="bi bi-person me-1"></i>Responden</th>
                                <th style="min-width:150px;"><i class="bi bi-file-text me-1"></i>Survei</th>
                                <th style="min-width:130px;"><i class="bi bi-envelope me-1"></i>Email</th>
                                @foreach ($kolomField as $f)
                                    <th style="min-width:100px;">
                                        <i class="bi bi-tag me-1"></i>{{ $f->label }}
                                    </th>
                                @endforeach
                                <th style="min-width:80px;text-align:center;"><i class="bi bi-star me-1"></i>IKM</th>
                                <th style="min-width:100px;"><i class="bi bi-trophy me-1"></i>Kategori</th>
                                <th style="min-width:130px;"><i class="bi bi-calendar3 me-1"></i>Tanggal Isi</th>
                                <th style="min-width:90px;text-align:center;"><i class="bi bi-tools me-1"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($responses as $r)
                                <tr>
                                    <td>
                                        <span class="responden-name">
                                            {{ $r->nama_responden ?: 'Anonim' }}
                                        </span>
                                        @if(!$r->nama_responden)
                                            <span class="badge-premium" style="background:rgba(108,117,125,0.08);color:#6c757d;font-size:0.55rem;padding:0.1rem 0.4rem;border-radius:50px;margin-left:0.2rem;">
                                                <i class="bi bi-incognito"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="survey-title" title="{{ $r->template->judul_survei ?? '-' }}">
                                            {{ $r->template->judul_survei ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="email-cell">{{ $r->email ?: '-' }}</td>
                                    @foreach ($kolomField as $f)
                                        <td>{{ data_get($r->data_tambahan, $f->field_key) ?: '-' }}</td>
                                    @endforeach
                                    <td class="text-center fw-bold">
                                        {{ $r->nilai_ikm ?? '-' }}
                                    </td>
                                    <td>
                                        @php
                                            $kategori = $r->kategoriMutu();
                                            $huruf = strtolower(substr($kategori, 0, 1));
                                            $icon = match($huruf) {
                                                'a' => 'bi-emoji-smile-fill',
                                                'b' => 'bi-emoji-neutral-fill',
                                                'c' => 'bi-emoji-frown-fill',
                                                default => 'bi-dash-circle'
                                            };
                                        @endphp
                                        <span class="badge-premium badge-ikm-{{ $huruf ?: 'e' }}">
                                            <i class="{{ $icon }}"></i>
                                            {{ $kategori ?: 'Belum' }}
                                        </span>
                                    </td>
                                    <td style="font-size:0.75rem;color:#6c757d;">
                                        {{ optional($r->tanggal_isi)->format('d-m-Y H:i') ?: '-' }}
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <a href="{{ route('survey-responses.show', $r) }}" 
                                               class="btn-action view" 
                                               title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="{{ route('survey-responses.destroy', $r) }}" 
                                                  method="POST" 
                                                  class="d-inline form-delete" 
                                                  data-item-name="respon {{ $r->nama_responden ?: 'anonim' }}">
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
                                    <td colspan="{{ 7 + $kolomField->count() }}">
                                        <div class="empty-state-table">
                                            <i class="bi bi-inbox"></i>
                                            <h6>Belum Ada Respon Survei</h6>
                                            <small class="text-muted">Belum ada responden yang mengisi survei</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($responses->hasPages())
                    <div class="pagination-wrapper">
                        <span class="pagination-info">
                            <i class="bi bi-info-circle"></i>
                            Menampilkan {{ $responses->firstItem() ?? 0 }} - {{ $responses->lastItem() ?? 0 }} 
                            dari {{ $responses->total() }} data
                        </span>
                        {{ $responses->links() }}
                    </div>
                @endif
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