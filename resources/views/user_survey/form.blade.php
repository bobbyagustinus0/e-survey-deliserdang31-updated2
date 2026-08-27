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
    }

    [data-theme="dark"] .btn-back:hover {
        background: rgba(30, 30, 46, 0.9);
        color: #2ecc71;
    }

    /* ===== HERO CARD ===== */
    .survey-hero {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        margin-top: 1rem;
    }

    [data-theme="dark"] .survey-hero {
        background: rgba(30, 30, 46, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .survey-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: var(--primary-gradient);
    }

    .survey-hero .hero-body {
        padding: 1.75rem 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .survey-hero .hero-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 8px 25px rgba(11, 93, 57, 0.25);
    }

    [data-theme="dark"] .survey-hero .hero-icon {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
    }

    .survey-hero .hero-info {
        flex: 1;
    }

    .survey-hero .hero-unit {
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    [data-theme="dark"] .survey-hero .hero-unit {
        color: #2ecc71;
    }

    .survey-hero .hero-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0.15rem 0 0.25rem;
        line-height: 1.3;
    }

    [data-theme="dark"] .survey-hero .hero-title {
        color: #e0e0e0;
    }

    .survey-hero .hero-desc {
        color: #6c757d;
        font-size: 0.9rem;
        margin: 0;
        line-height: 1.5;
    }

    [data-theme="dark"] .survey-hero .hero-desc {
        color: #adb5bd;
    }

    .survey-hero .hero-badge {
        background: rgba(11, 93, 57, 0.08);
        color: var(--primary);
        padding: 0.3rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        border: 1px solid rgba(11, 93, 57, 0.1);
    }

    [data-theme="dark"] .survey-hero .hero-badge {
        background: rgba(46, 204, 113, 0.08);
        color: #2ecc71;
        border-color: rgba(46, 204, 113, 0.1);
    }

    /* ===== PROGRESS BAR STYLING ===== */
    .survey-progress {
        display: flex;
        align-items: flex-start;
        gap: 0;
        margin-bottom: 2rem;
        padding: 0.5rem 0;
        overflow-x: auto;
        position: relative;
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1rem 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    [data-theme="dark"] .survey-progress {
        background: rgba(30, 30, 46, 0.4);
        border-color: rgba(255, 255, 255, 0.03);
    }

    .survey-progress .step-dot-wrap {
        flex: 1;
        min-width: 70px;
        text-align: center;
        position: relative;
        cursor: pointer;
        transition: var(--transition);
        padding: 0.25rem 0;
    }

    .survey-progress .step-dot-wrap:hover {
        transform: translateY(-2px);
    }

    .survey-progress .step-dot {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e2e6ea;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        margin: 0 auto 0.4rem;
        transition: var(--transition);
        position: relative;
        z-index: 2;
        border: 3px solid transparent;
    }

    [data-theme="dark"] .survey-progress .step-dot {
        background: #2a2a3a;
        color: #8a8a9a;
    }

    .survey-progress .step-dot-wrap.active .step-dot {
        background: var(--primary-gradient);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 20px rgba(11, 93, 57, 0.3);
        transform: scale(1.1);
    }

    [data-theme="dark"] .survey-progress .step-dot-wrap.active .step-dot {
        box-shadow: 0 4px 20px rgba(46, 204, 113, 0.3);
    }

    .survey-progress .step-dot-wrap.done .step-dot {
        background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
    }

    .survey-progress .step-label {
        font-size: 0.65rem;
        color: #6c757d;
        line-height: 1.2;
        font-weight: 500;
        transition: var(--transition);
        max-width: 80px;
        margin: 0 auto;
    }

    [data-theme="dark"] .survey-progress .step-label {
        color: #8a8a9a;
    }

    .survey-progress .step-dot-wrap.active .step-label {
        color: var(--primary);
        font-weight: 700;
    }

    [data-theme="dark"] .survey-progress .step-dot-wrap.active .step-label {
        color: #2ecc71;
    }

    .survey-progress .step-dot-wrap.done .step-label {
        color: #28a745;
    }

    .survey-progress .step-line {
        position: absolute;
        top: 20px;
        left: -50%;
        width: 100%;
        height: 3px;
        background: #e2e6ea;
        z-index: 0;
        transition: var(--transition);
    }

    [data-theme="dark"] .survey-progress .step-line {
        background: #2a2a3a;
    }

    .survey-progress .step-dot-wrap:first-child .step-line {
        display: none;
    }

    .survey-progress .step-dot-wrap.done .step-line,
    .survey-progress .step-dot-wrap.active .step-line {
        background: var(--primary-gradient);
        background-size: 200% 100%;
        animation: shimmerLine 2s ease-in-out infinite;
    }

    [data-theme="dark"] .survey-progress .step-dot-wrap.done .step-line,
    [data-theme="dark"] .survey-progress .step-dot-wrap.active .step-line {
        background: linear-gradient(90deg, #2ecc71, #55d98d);
    }

    @keyframes shimmerLine {
        0%, 100% { background-position: 0% 0%; }
        50% { background-position: 100% 0%; }
    }

    /* ===== STEP CONTAINER ===== */
    .survey-step {
        display: none;
        animation: fadeSlideUp 0.5s ease;
    }

    .survey-step.current {
        display: block;
    }

    @keyframes fadeSlideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .step-header {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .step-header .step-number {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--primary);
        background: rgba(11, 93, 57, 0.08);
        padding: 0.2rem 0.8rem;
        border-radius: 50px;
        margin-bottom: 0.3rem;
    }

    [data-theme="dark"] .step-header .step-number {
        background: rgba(46, 204, 113, 0.08);
        color: #2ecc71;
    }

    .step-header .step-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    [data-theme="dark"] .step-header .step-title {
        color: #e0e0e0;
    }

    .step-header .step-title i {
        color: var(--primary);
        font-size: 1.2rem;
    }

    [data-theme="dark"] .step-header .step-title i {
        color: #2ecc71;
    }

    .step-header .step-subtitle {
        color: #6c757d;
        font-size: 0.9rem;
        margin: 0.2rem 0 0;
        padding-left: 2rem;
    }

    [data-theme="dark"] .step-header .step-subtitle {
        color: #adb5bd;
    }

    /* ===== QUESTION CARDS ===== */
    .question-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        margin-bottom: 1.25rem;
        overflow: hidden;
        position: relative;
    }

    [data-theme="dark"] .question-card {
        background: rgba(30, 30, 46, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .question-card:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .question-card .question-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(11, 93, 57, 0.08);
        color: var(--primary);
        font-weight: 700;
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    [data-theme="dark"] .question-card .question-number {
        background: rgba(46, 204, 113, 0.08);
        color: #2ecc71;
    }

    .question-card .question-body {
        padding: 1.5rem 1.75rem;
    }

    .question-card .question-text {
        font-weight: 600;
        font-size: 0.95rem;
        color: #2c3e50;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    [data-theme="dark"] .question-card .question-text {
        color: #e0e0e0;
    }

    .question-card .question-required {
        color: var(--danger);
        font-size: 0.7rem;
        font-weight: 700;
        margin-left: 0.2rem;
    }

    /* ===== SCALE OPTIONS ===== */
    .scale-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 0.75rem;
        margin-top: 0.75rem;
    }

    .scale-option {
        position: relative;
        cursor: pointer;
        transition: var(--transition);
    }

    .scale-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .scale-option .scale-box {
        padding: 0.75rem 0.5rem;
        text-align: center;
        border: 2px solid rgba(0, 0, 0, 0.06);
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #495057;
        transition: var(--transition);
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        cursor: pointer;
        position: relative;
    }

    [data-theme="dark"] .scale-option .scale-box {
        border-color: rgba(255, 255, 255, 0.05);
        color: #adb5bd;
        background: rgba(255, 255, 255, 0.03);
    }

    .scale-option input[type="radio"]:checked + .scale-box {
        border-color: var(--primary);
        background: rgba(11, 93, 57, 0.05);
        color: var(--primary);
        box-shadow: 0 0 0 4px rgba(11, 93, 57, 0.05);
        transform: scale(1.02);
    }

    [data-theme="dark"] .scale-option input[type="radio"]:checked + .scale-box {
        border-color: #2ecc71;
        background: rgba(46, 204, 113, 0.05);
        color: #2ecc71;
        box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.05);
    }

    .scale-option:hover .scale-box {
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: var(--card-shadow);
    }

    [data-theme="dark"] .scale-option:hover .scale-box {
        border-color: #2ecc71;
    }

    /* ===== STAR RATING ===== */
    .star-rating {
        display: flex;
        gap: 0.5rem;
        flex-direction: row-reverse;
        justify-content: flex-end;
        margin-top: 0.5rem;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        font-size: 2rem;
        color: #e2e6ea;
        cursor: pointer;
        transition: var(--transition);
        padding: 0.1rem;
    }

    [data-theme="dark"] .star-rating label {
        color: #2a2a3a;
    }

    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input[type="radio"]:checked ~ label {
        color: #f1c40f;
        transform: scale(1.1);
    }

    .star-rating input[type="radio"]:checked ~ label {
        animation: starPop 0.3s ease;
    }

    @keyframes starPop {
        0% { transform: scale(0.8); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }

    /* ===== STAR RATING (CUSTOM LABELS) ===== */
    .star-rating-labeled {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        margin-top: 0.75rem;
    }

    .star-rating-card {
        position: relative;
        cursor: pointer;
        flex: 1 1 100px;
        min-width: 90px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.4rem;
        padding: 0.9rem 0.5rem;
        text-align: center;
        border: 2px solid rgba(0, 0, 0, 0.06);
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        transition: var(--transition);
    }

    [data-theme="dark"] .star-rating-card {
        border-color: rgba(255, 255, 255, 0.05);
        background: rgba(255, 255, 255, 0.03);
    }

    .star-rating-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .star-rating-card .star-rating-icon {
        font-size: 1.5rem;
        color: #f1c40f;
        line-height: 1;
    }

    .star-rating-card .star-rating-text {
        font-size: 0.8rem;
        font-weight: 600;
        color: #495057;
    }

    [data-theme="dark"] .star-rating-card .star-rating-text {
        color: #adb5bd;
    }

    .star-rating-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-shadow);
        border-color: var(--gold);
    }

    .star-rating-card.is-selected,
    .star-rating-card:has(input[type="radio"]:checked) {
        border-color: var(--gold);
        background: linear-gradient(135deg, rgba(185, 134, 46, 0.14), rgba(185, 134, 46, 0.04));
        box-shadow: 0 0 0 4px rgba(185, 134, 46, 0.08);
        transform: translateY(-2px) scale(1.02);
    }

    .star-rating-card.is-selected .star-rating-text,
    .star-rating-card:has(input[type="radio"]:checked) .star-rating-text {
        color: var(--gold);
    }

    .star-rating-card.is-selected .star-rating-icon,
    .star-rating-card:has(input[type="radio"]:checked) .star-rating-icon {
        animation: starPop 0.3s ease;
    }

    @media (max-width: 576px) {
        .star-rating-card {
            flex: 1 1 72px;
            min-width: 72px;
            padding: 0.7rem 0.35rem;
        }
        .star-rating-card .star-rating-icon {
            font-size: 1.25rem;
        }
        .star-rating-card .star-rating-text {
            font-size: 0.72rem;
        }
    }

    /* ===== NAVIGATION BUTTONS ===== */
    .survey-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 1rem 1.5rem;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 1rem;
    }

    [data-theme="dark"] .survey-nav {
        background: rgba(30, 30, 46, 0.4);
        border-color: rgba(255, 255, 255, 0.03);
    }

    .survey-nav .nav-info {
        font-size: 0.8rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    [data-theme="dark"] .survey-nav .nav-info {
        color: #8a8a9a;
    }

    .survey-nav .nav-info .progress-text {
        font-weight: 600;
        color: var(--primary);
    }

    [data-theme="dark"] .survey-nav .nav-info .progress-text {
        color: #2ecc71;
    }

    .btn-nav {
        padding: 0.65rem 1.75rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }

    .btn-nav-prev {
        background: rgba(108, 117, 125, 0.08);
        color: #6c757d;
        border: 2px solid rgba(108, 117, 125, 0.12);
    }

    .btn-nav-prev:hover:not(:disabled) {
        background: rgba(108, 117, 125, 0.15);
        transform: translateX(-4px);
    }

    .btn-nav-prev:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .btn-nav-next {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 20px rgba(11, 93, 57, 0.25);
    }

    .btn-nav-next:hover:not(:disabled) {
        transform: translateX(4px) scale(1.02);
        box-shadow: 0 8px 30px rgba(11, 93, 57, 0.35);
        color: white;
    }

    .btn-nav-next:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-nav-submit {
        background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
        color: white;
        box-shadow: 0 4px 20px rgba(40, 167, 69, 0.25);
    }

    .btn-nav-submit:hover:not(:disabled) {
        transform: scale(1.02) translateY(-2px);
        box-shadow: 0 8px 30px rgba(40, 167, 69, 0.35);
        color: white;
    }

    .btn-nav-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    [data-theme="dark"] .btn-nav-next {
        background: linear-gradient(135deg, #2ecc71 0%, #55d98d 100%);
        box-shadow: 0 4px 20px rgba(46, 204, 113, 0.25);
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
        .survey-wrapper {
            padding: 1rem;
        }

        .survey-hero .hero-body {
            padding: 1.25rem;
            flex-direction: column;
            align-items: flex-start;
        }

        .survey-hero .hero-icon {
            width: 48px;
            height: 48px;
            font-size: 1.3rem;
            border-radius: 14px;
        }

        .survey-hero .hero-title {
            font-size: 1.1rem;
        }

        .survey-progress {
            padding: 0.75rem 1rem;
            gap: 0;
            overflow-x: auto;
        }

        .survey-progress .step-dot-wrap {
            min-width: 60px;
        }

        .survey-progress .step-dot {
            width: 32px;
            height: 32px;
            font-size: 0.75rem;
        }

        .survey-progress .step-label {
            font-size: 0.6rem;
            max-width: 60px;
        }

        .question-card .question-body {
            padding: 1.25rem;
        }

        .scale-options {
            grid-template-columns: 1fr 1fr;
        }

        .survey-nav {
            flex-direction: column;
            align-items: stretch;
            padding: 1rem;
            gap: 0.75rem;
        }

        .survey-nav .nav-info {
            justify-content: center;
            font-size: 0.75rem;
        }

        .btn-nav {
            justify-content: center;
            padding: 0.6rem 1.25rem;
            font-size: 0.8rem;
        }

        .step-header .step-title {
            font-size: 1.1rem;
        }

        .step-header .step-subtitle {
            font-size: 0.8rem;
            padding-left: 0;
        }

        .star-rating label {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .survey-hero .hero-title {
            font-size: 1rem;
        }

        .survey-hero .hero-desc {
            font-size: 0.8rem;
        }

        .survey-progress .step-dot-wrap {
            min-width: 50px;
        }

        .survey-progress .step-dot {
            width: 28px;
            height: 28px;
            font-size: 0.65rem;
        }

        .survey-progress .step-label {
            font-size: 0.5rem;
            max-width: 45px;
        }

        .question-card .question-text {
            font-size: 0.85rem;
        }

        .scale-options {
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .scale-option .scale-box {
            font-size: 0.75rem;
            padding: 0.5rem 0.25rem;
        }

        .star-rating label {
            font-size: 1.2rem;
        }

        .btn-nav {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
        }
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

        <!-- ===== BACK BUTTON ===== -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('user-survey.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Survei
            </a>
            <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode">
                <i class="bi bi-moon-fill" id="themeIcon"></i>
            </button>
        </div>

        <!-- ===== HERO CARD ===== -->
        <div class="survey-hero">
            <div class="hero-body">
                <div class="hero-icon">
                    <i class="bi bi-clipboard2-check-fill"></i>
                </div>
                <div class="hero-info">
                    <div class="hero-unit">
                        <i class="bi bi-building"></i> {{ $template->unit_layanan }}
                    </div>
                    <h5 class="hero-title">{{ $template->judul_survei }}</h5>
                    @if ($template->deskripsi)
                        <p class="hero-desc">{{ $template->deskripsi }}</p>
                    @endif
                </div>
                <div class="hero-badge">
                    <i class="bi bi-clock"></i> {{ $template->questions->count() }} Pertanyaan
                </div>
            </div>
        </div>

        <!-- ===== FORM ===== -->
        <form method="POST" action="{{ route('user-survey.store', $template) }}" id="userSurveyForm" novalidate>
            @csrf

            @php
                $kelompokPertanyaan = $template->questions->groupBy(fn ($q) => $q->kategori ?: 'Pernyataan Umum');
                $adaFieldTambahan = $template->identityFields->count() > 0;
                $offset = $adaFieldTambahan ? 1 : 0;
            @endphp

            <!-- ===== PROGRESS BAR ===== -->
            <div class="survey-progress" id="surveyProgress">
                @if ($adaFieldTambahan)
                <div class="step-dot-wrap active" data-step="0">
                    <div class="step-line"></div>
                    <div class="step-dot"><i class="bi bi-person"></i></div>
                    <div class="step-label">Data Diri</div>
                </div>
                @endif
                @foreach ($kelompokPertanyaan->keys() as $i => $kategori)
                <div class="step-dot-wrap {{ ($i + $offset) === 0 ? 'active' : '' }}" data-step="{{ $i + $offset }}">
                    <div class="step-line"></div>
                    <div class="step-dot">{{ $i + $offset + 1 }}</div>
                    <div class="step-label">{{ Str::limit($kategori, 15) }}</div>
                </div>
                @endforeach
            </div>

            <!-- ===== DATA DIRI STEP ===== -->
            @if ($adaFieldTambahan)
            <div class="survey-step current" data-step="0">
                <div class="step-header">
                    <div class="step-number">Langkah 1</div>
                    <h5 class="step-title"><i class="bi bi-person-badge"></i> Data Diri Tambahan</h5>
                    <p class="step-subtitle">Mohon isi data diri Anda untuk keperluan verifikasi.</p>
                </div>

                <div class="question-card">
                    <div class="question-body">
                        <div class="row g-3">
                            @foreach ($template->identityFields as $f)
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:0.85rem;">
                                    <i class="bi bi-check-circle" style="color:var(--primary);font-size:0.7rem;"></i>
                                    {{ $f->label }}
                                    @if($f->wajib_diisi)
                                        <span class="question-required">*</span>
                                    @endif
                                </label>
                                @if ($f->tipe === 'pilihan')
                                    <select name="data_tambahan[{{ $f->field_key }}]" 
                                            class="form-control-custom" 
                                            {{ $f->wajib_diisi ? 'required' : '' }}
                                            style="width:100%;padding:0.6rem 1rem;border-radius:12px;border:2px solid rgba(0,0,0,0.06);background:rgba(255,255,255,0.6);transition:var(--transition);">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($f->opsi_pilihan ?? [] as $opsi)
                                            <option value="{{ $opsi }}">{{ $opsi }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="{{ $f->tipe === 'angka' ? 'number' : ($f->tipe === 'email' ? 'email' : 'text') }}"
                                           name="data_tambahan[{{ $f->field_key }}]" 
                                           class="form-control-custom" 
                                           {{ $f->wajib_diisi ? 'required' : '' }}
                                           placeholder="Masukkan {{ $f->label }}"
                                           style="width:100%;padding:0.6rem 1rem;border-radius:12px;border:2px solid rgba(0,0,0,0.06);background:rgba(255,255,255,0.6);transition:var(--transition);">
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- ===== QUESTION STEPS ===== -->
            @foreach ($kelompokPertanyaan as $kategori => $daftarQ)
            <div class="survey-step {{ ($loop->index + $offset) === 0 ? 'current' : '' }}" 
                 data-step="{{ $loop->index + $offset }}">
                
                <div class="step-header">
                    <div class="step-number">Langkah {{ $loop->index + $offset + 1 }}</div>
                    <h5 class="step-title"><i class="bi bi-question-circle"></i> {{ $kategori }}</h5>
                    <p class="step-subtitle">Berikan penilaian Anda untuk setiap pernyataan berikut.</p>
                </div>

                @foreach ($daftarQ as $i => $q)
                <div class="question-card">
                    <div class="question-body">
                        <div class="question-text">
                            <span class="question-number">{{ $i + 1 }}</span>
                            <span>{{ $q->pertanyaan }}</span>
                            @if($q->wajib_diisi)
                                <span class="question-required">*</span>
                            @endif
                        </div>

                        @if ($q->tipe_jawaban === 'skala_ikm')
                            <div class="scale-options">
                                @foreach ([1 => 'Tidak Baik', 2 => 'Kurang Baik', 3 => 'Baik', 4 => 'Sangat Baik'] as $val => $label)
                                    <label class="scale-option">
                                        <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ $val }}" {{ $q->wajib_diisi ? 'required' : '' }}>
                                        <div class="scale-box">{{ $val }} - {{ $label }}</div>
                                    </label>
                                @endforeach
                            </div>

                        @elseif ($q->tipe_jawaban === 'rating_bintang')
                            @php
                                $labelBintang = (is_array($q->opsi_jawaban) && count($q->opsi_jawaban) >= 2)
                                    ? $q->opsi_jawaban
                                    : ['Tidak Sesuai', 'Kurang Sesuai', 'Agak Sesuai', 'Sesuai', 'Sangat Sesuai'];
                            @endphp
                            <div class="star-rating-labeled">
                                @foreach ($labelBintang as $idxBintang => $teksBintang)
                                    @php $nilaiBintang = $idxBintang + 1; @endphp
                                    <label class="star-rating-card" for="star_{{ $q->id }}_{{ $nilaiBintang }}">
                                        <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ $nilaiBintang }}" id="star_{{ $q->id }}_{{ $nilaiBintang }}" {{ $q->wajib_diisi ? 'required' : '' }}>
                                        <span class="star-rating-icon"><i class="bi bi-star-fill"></i></span>
                                        <span class="star-rating-text">{{ $teksBintang }}</span>
                                    </label>
                                @endforeach
                            </div>

                        @elseif ($q->tipe_jawaban === 'pilihan_ganda')
                            <div class="mt-2 d-flex flex-wrap gap-2">
                                @foreach ($q->opsi_jawaban ?? [] as $opsi)
                                    <label class="scale-option" style="flex:0 1 auto;">
                                        <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ $opsi }}" {{ $q->wajib_diisi ? 'required' : '' }}>
                                        <div class="scale-box" style="padding:0.5rem 1.2rem;">
                                            {{ $opsi }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                        @elseif ($q->tipe_jawaban === 'isian_singkat')
                            <input type="text" name="jawaban[{{ $q->id }}]" 
                                   class="form-control-custom" 
                                   {{ $q->wajib_diisi ? 'required' : '' }}
                                   placeholder="Tulis jawaban Anda..."
                                   style="width:100%;padding:0.6rem 1rem;border-radius:12px;border:2px solid rgba(0,0,0,0.06);background:rgba(255,255,255,0.6);transition:var(--transition);margin-top:0.5rem;">

                        @else
                            <textarea name="jawaban[{{ $q->id }}]" rows="3" 
                                      class="form-control-custom" 
                                      {{ $q->wajib_diisi ? 'required' : '' }}
                                      placeholder="Tulis jawaban Anda di sini..."
                                      style="width:100%;padding:0.6rem 1rem;border-radius:12px;border:2px solid rgba(0,0,0,0.06);background:rgba(255,255,255,0.6);transition:var(--transition);margin-top:0.5rem;"></textarea>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach

            <!-- ===== NAVIGATION ===== -->
            <div class="survey-nav">
                <div class="nav-info">
                    <i class="bi bi-info-circle"></i>
                    <span>Langkah <span class="progress-text" id="stepCounter">1</span> dari <span class="progress-text" id="totalSteps">{{ count($kelompokPertanyaan) + ($adaFieldTambahan ? 1 : 0) }}</span></span>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn-nav btn-nav-prev" id="btnPrev" disabled>
                        <i class="bi bi-arrow-left"></i> Sebelumnya
                    </button>
                    <button type="button" class="btn-nav btn-nav-next" id="btnNext">
                        Selanjutnya <i class="bi bi-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn-nav btn-nav-submit d-none" id="btnSubmit">
                        <i class="bi bi-send-fill"></i> Kirim Jawaban
                    </button>
                </div>
            </div>

        </form>

        <!-- ===== FOOTER ===== -->
        <div class="text-center mt-4 py-3">
            <small class="text-muted opacity-50">
                <i class="bi bi-shield-check"></i> Jawaban Anda akan dijaga kerahasiaannya • 
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
    initSurveyNavigation();
    initStarRatingLabeled();
});

// ===== STAR RATING (CUSTOM LABELS) =====
function initStarRatingLabeled() {
    document.querySelectorAll('.star-rating-labeled').forEach(function (group) {
        const cards = Array.from(group.querySelectorAll('.star-rating-card'));

        cards.forEach(function (card) {
            const input = card.querySelector('input[type="radio"]');
            if (!input) return;

            if (input.checked) {
                card.classList.add('is-selected');
            }

            input.addEventListener('change', function () {
                cards.forEach(function (c) { c.classList.remove('is-selected'); });
                if (input.checked) {
                    card.classList.add('is-selected');
                }
            });
        });
    });
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

// ===== SURVEY NAVIGATION =====
function initSurveyNavigation() {
    const steps = Array.from(document.querySelectorAll('.survey-step'));
    const dots = Array.from(document.querySelectorAll('#surveyProgress .step-dot-wrap'));
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const btnSubmit = document.getElementById('btnSubmit');
    const stepCounter = document.getElementById('stepCounter');
    const totalSteps = document.getElementById('totalSteps');
    let current = 0;

    function render() {
        steps.forEach((el, i) => {
            el.classList.toggle('current', i === current);
        });
        
        dots.forEach((el, i) => {
            el.classList.toggle('active', i === current);
            el.classList.toggle('done', i < current);
        });

        btnPrev.disabled = current === 0;
        btnPrev.style.visibility = current === 0 ? 'hidden' : 'visible';
        btnNext.classList.toggle('d-none', current === steps.length - 1);
        btnSubmit.classList.toggle('d-none', current !== steps.length - 1);

        if (stepCounter) {
            stepCounter.textContent = current + 1;
        }
        if (totalSteps) {
            totalSteps.textContent = steps.length;
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateCurrentStep() {
        const inputs = steps[current].querySelectorAll('[required]');
        for (const input of inputs) {
            if (input.type === 'radio') {
                const name = input.getAttribute('name');
                if (name) {
                    const group = steps[current].querySelectorAll(`[name="${name}"]`);
                    const checked = Array.from(group).some(r => r.checked);
                    if (!checked) {
                        const card = input.closest('.question-card') || input.closest('.card');
                        if (card) {
                            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            card.style.border = '2px solid #dc3545';
                            setTimeout(() => card.style.border = '', 2000);
                        }
                        alert('Mohon lengkapi semua pernyataan pada langkah ini sebelum melanjutkan.');
                        return false;
                    }
                }
            } else if (input.tagName === 'SELECT' && !input.value) {
                input.focus();
                input.style.borderColor = '#dc3545';
                setTimeout(() => input.style.borderColor = '', 2000);
                return false;
            } else if (!input.value.trim()) {
                input.focus();
                input.style.borderColor = '#dc3545';
                setTimeout(() => input.style.borderColor = '', 2000);
                return false;
            }
        }
        return true;
    }

    btnNext.addEventListener('click', function() {
        if (!validateCurrentStep()) return;
        if (current < steps.length - 1) {
            current++;
            render();
        }
    });

    btnPrev.addEventListener('click', function() {
        if (current > 0) {
            current--;
            render();
        }
    });

    // Click on progress dots to navigate (only to completed steps)
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            if (index <= current) {
                current = index;
                render();
            } else {
                // Try to validate and navigate
                if (validateCurrentStep()) {
                    current = index;
                    render();
                }
            }
        });
    });

    document.getElementById('userSurveyForm').addEventListener('submit', function(e) {
        if (!validateCurrentStep()) {
            e.preventDefault();
            return;
        }
        const btn = this.querySelector('button[type=submit]');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Mengirim...';
    });

    render();
}
</script>
@endsection
