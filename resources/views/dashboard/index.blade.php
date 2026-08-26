@extends('layouts.app')
@section('title', 'Dashboard Admin Utama')

@section('content')
<style>
    /* ===== CSS VARIABLES (mandiri, tidak perlu ubah app.css) ===== */
    :root {
        --primary: #0B5D39;
        --primary-light: #1a8a5a;
        --primary-gradient: linear-gradient(135deg, #0B5D39 0%, #1a8a5a 100%);
        --gold: #B9862E;
        --gold-light: #d4a84a;
        --gold-gradient: linear-gradient(135deg, #B9862E 0%, #d4a84a 100%);
        --purple-gradient: linear-gradient(135deg, #6c3483 0%, #8e44ad 100%);
        --blue-gradient: linear-gradient(135deg, #1a6fa0 0%, #3498db 100%);
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        --card-shadow-hover: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all .25s ease;
    }

    body { background: #f4f6f5; }
    [data-theme="dark"] body { background: #14161a; }

    .content-wrapper { position: relative; }

    /* ===== HEADER ===== */
    .dashboard-header {
        background: #fff;
        padding: 1.5rem 1.75rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.75rem;
        border-left: 5px solid var(--primary);
        box-shadow: var(--card-shadow);
    }
    [data-theme="dark"] .dashboard-header {
        background: #1e2025;
        border-color: rgba(255,255,255,.05);
        border-left: 5px solid var(--primary-light);
    }

    .dashboard-header .header-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1b1f1c;
        letter-spacing: -.3px;
    }
    [data-theme="dark"] .dashboard-header .header-title { color: #f0f0f0; }

    .header-badge {
        background: var(--primary-gradient);
        color: #fff;
        padding: .28rem .85rem;
        border-radius: 50px;
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .4px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: .3rem;
    }

    /* ===== JAM LIVE (dipertahankan, tanpa blink/pulse) ===== */
    .header-clock {
        display: inline-flex;
        align-items: center;
        gap: .6rem;
        background: rgba(11, 93, 57, .06);
        padding: .4rem 1.1rem;
        border-radius: 50px;
        font-size: .85rem;
    }
    [data-theme="dark"] .header-clock { background: rgba(255,255,255,.06); color: #b5bcc2; }
    .header-clock .clock-date { color: #6c757d; }
    [data-theme="dark"] .header-clock .clock-date { color: #9aa0a6; }
    .header-clock .clock-time {
        font-weight: 700;
        color: var(--primary);
        font-variant-numeric: tabular-nums;
    }
    [data-theme="dark"] .header-clock .clock-time { color: #4fd394; }
    .header-clock .clock-separator { opacity: .3; }

    /* ===== TOGGLE DARK MODE (dipertahankan) ===== */
    .theme-toggle {
        width: 38px; height: 38px; border-radius: 50%;
        border: 1px solid rgba(0,0,0,.08);
        background: #fff;
        display: flex; align-items: center; justify-content: center;
        transition: var(--transition);
        cursor: pointer;
        font-size: 1rem;
        color: #495057;
    }
    .theme-toggle:hover { background: #f5f5f5; }
    [data-theme="dark"] .theme-toggle {
        color: #e0e0e0; border-color: rgba(255,255,255,.1); background: #24262b;
    }
    [data-theme="dark"] .theme-toggle:hover { background: #2c2f35; }

    /* ===== STAT CARDS ===== */
    .stat-card {
        padding: 1.5rem;
        border-radius: var(--border-radius);
        color: #fff;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        min-height: 122px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: var(--card-shadow);
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: var(--card-shadow-hover); }
    .stat-card .stat-top { display: flex; justify-content: space-between; align-items: flex-start; }
    .stat-card .stat-icon-badge {
        width: 38px; height: 38px; border-radius: 10px;
        background: rgba(255,255,255,.18);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.05rem;
    }
    .stat-card .stat-value { font-size: 2.2rem; font-weight: 800; line-height: 1; letter-spacing: -.5px; }
    .stat-card .stat-label { font-size: .82rem; font-weight: 500; opacity: .92; margin-top: .3rem; }

    .stat-green  { background: var(--primary-gradient); }
    .stat-blue   { background: var(--blue-gradient); }
    .stat-gold   { background: var(--gold-gradient); }
    .stat-purple { background: var(--purple-gradient); }

    /* ===== CARD PANEL ===== */
    .card-modern {
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        height: 100%;
        transition: var(--transition);
    }
    [data-theme="dark"] .card-modern { background: #1e2025; }
    .card-modern:hover { box-shadow: var(--card-shadow-hover); }

    .card-modern .card-header-custom {
        padding: 1.1rem 1.4rem;
        border-bottom: 1px solid rgba(0,0,0,.06);
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: .5rem;
    }
    [data-theme="dark"] .card-modern .card-header-custom { border-bottom-color: rgba(255,255,255,.06); }
    .card-modern .card-title {
        font-weight: 600; font-size: .95rem; color: #2c3e50;
        display: flex; align-items: center; gap: .5rem; margin: 0;
    }
    [data-theme="dark"] .card-modern .card-title { color: #e6e6e6; }
    .card-modern .card-title i { color: var(--primary); }
    .card-modern .card-body-custom { padding: 1.4rem; }
    .card-modern .meta { font-size: .74rem; color: #8a8f98; font-weight: 500; }

    /* ===== TABEL ===== */
    .table-premium { font-size: .87rem; margin-bottom: 0; }
    .table-premium thead th {
        border-bottom: 1px solid rgba(0,0,0,.08);
        font-weight: 700; color: #6b7280;
        text-transform: uppercase; font-size: .68rem; letter-spacing: .6px;
        padding: .8rem 1.2rem;
    }
    [data-theme="dark"] .table-premium thead th { color: #9aa0a6; border-bottom-color: rgba(255,255,255,.06); }
    .table-premium tbody tr { transition: var(--transition); }
    .table-premium tbody tr:hover { background: rgba(11, 93, 57, .04); }
    [data-theme="dark"] .table-premium tbody tr:hover { background: rgba(79, 211, 148, .06); }
    .table-premium tbody td {
        padding: .8rem 1.2rem; vertical-align: middle;
        border-bottom: 1px solid rgba(0,0,0,.04);
    }
    [data-theme="dark"] .table-premium tbody td { border-bottom-color: rgba(255,255,255,.04); color: #dcdcdc; }

    /* ===== BADGE / PILL — lembut, bukan blok solid ===== */
    .badge-premium {
        padding: .3rem .8rem; font-weight: 600; letter-spacing: .2px;
        border-radius: 50px; font-size: .74rem;
        display: inline-flex; align-items: center; gap: .3rem;
    }
    .badge-premium.bg-success { background: #E9F3EC !important; color: #08452a !important; }
    .badge-premium.bg-warning { background: #FBF0DD !important; color: #8a6220 !important; }
    .badge-premium.bg-danger  { background: #FBEAE9 !important; color: #a3241c !important; }
    .badge-premium.bg-secondary { background: #EFEDE4 !important; color: #5b6660 !important; }
    .badge-premium.bg-primary { background: #E7F0FB !important; color: #1a4f7a !important; }
    .badge-premium.bg-info    { background: #E7F0FB !important; color: #1a4f7a !important; }

    /* ===== CHART ===== */
    .chart-wrapper { position: relative; height: 230px; }
    .chart-wrapper canvas { max-height: 230px; width: 100% !important; }

    /* ===== EMPTY STATE ===== */
    .empty-state { padding: 2.25rem 1rem; text-align: center; color: #8a8f98; }
    .empty-state i { font-size: 1.9rem; opacity: .35; margin-bottom: .5rem; display: block; }
    .empty-state h6 { font-weight: 600; color: #495057; margin-bottom: .2rem; }
    [data-theme="dark"] .empty-state h6 { color: #b5bcc2; }

    /* ===== Animasi masuk — satu kali, halus, tidak berulang ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeInUp .45s ease both; }
    .animate-in:nth-child(1) { animation-delay: .03s; }
    .animate-in:nth-child(2) { animation-delay: .07s; }
    .animate-in:nth-child(3) { animation-delay: .11s; }
    .animate-in:nth-child(4) { animation-delay: .15s; }
    @media (prefers-reduced-motion: reduce) { .animate-in { animation: none; } }

    @media (max-width: 768px) {
        .dashboard-header { padding: 1.1rem 1.25rem; }
        .dashboard-header .header-title { font-size: 1.2rem; }
        .header-clock { font-size: .75rem; padding: .3rem .8rem; }
        .stat-card { padding: 1.15rem; min-height: 100px; }
        .stat-card .stat-value { font-size: 1.7rem; }
        .chart-wrapper { height: 170px; }
        .chart-wrapper canvas { max-height: 170px; }
    }
</style>

<div class="content-wrapper">

    <!-- ===== HEADER ===== -->
    <div class="dashboard-header animate-in">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div>
                    <span class="text-uppercase small fw-bold" style="color:var(--primary); letter-spacing:.05em; font-size:.7rem;">
                        <i class="bi bi-grid-3x3-gap-fill me-1"></i> Overview
                    </span>
                    <h4 class="header-title mt-1 mb-0">Dashboard Admin</h4>
                </div>
                <span class="header-badge"><i class="bi bi-shield-check"></i> Admin</span>
            </div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="header-clock" id="headerClock">
                    <i class="bi bi-clock-history" style="color:var(--primary);"></i>
                    <span class="clock-date" id="clockDate">{{ now()->format('l, d F Y') }}</span>
                    <span class="clock-separator">|</span>
                    <span class="clock-time" id="clockTime">{{ now()->format('H:i:s') }}</span>
                </div>
                <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark Mode">
                    <i class="bi bi-moon-fill" id="themeIcon"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- ===== STAT CARDS ===== -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6 animate-in">
            <div class="stat-card stat-green">
                <div class="stat-top">
                    <div class="stat-icon-badge"><i class="bi bi-file-earmark-text-fill"></i></div>
                </div>
                <div>
                    <div class="stat-value" id="statTotal">{{ $totalSurvei }}</div>
                    <div class="stat-label">Total Template Survei</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 animate-in">
            <div class="stat-card stat-blue">
                <div class="stat-top">
                    <div class="stat-icon-badge"><i class="bi bi-check-circle-fill"></i></div>
                </div>
                <div>
                    <div class="stat-value" id="statAktif">{{ $surveiAktif }}</div>
                    <div class="stat-label">Survei Aktif</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 animate-in">
            <div class="stat-card stat-gold">
                <div class="stat-top">
                    <div class="stat-icon-badge"><i class="bi bi-people-fill"></i></div>
                </div>
                <div>
                    <div class="stat-value" id="statResponden">{{ $totalResponden }}</div>
                    <div class="stat-label">Total Responden</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 animate-in">
            <div class="stat-card stat-purple">
                <div class="stat-top">
                    <div class="stat-icon-badge"><i class="bi bi-graph-up-arrow"></i></div>
                </div>
                <div>
                    <div class="stat-value" id="statIkm">{{ $rataIkm }}</div>
                    <div class="stat-label">Rata-rata Nilai IKM</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== CHARTS ===== -->
    <div class="row g-3 mb-4">
        <div class="col-lg-7 animate-in">
            <div class="card-modern">
                <div class="card-header-custom">
                    <span class="card-title"><i class="bi bi-bar-chart-line-fill"></i> Jumlah Respon Survei per Bulan</span>
                    <span class="meta">12 bulan terakhir</span>
                </div>
                <div class="card-body-custom">
                    <div class="chart-wrapper"><canvas id="chartResponBulan"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 animate-in">
            <div class="card-modern">
                <div class="card-header-custom">
                    <span class="card-title"><i class="bi bi-trophy-fill"></i> Rata-rata IKM per Template</span>
                    <span class="meta">Top 5</span>
                </div>
                <div class="card-body-custom">
                    <div class="chart-wrapper"><canvas id="chartIkmTemplate"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== TABLES ===== -->
    <div class="row g-3">
        <div class="col-lg-6 animate-in">
            <div class="card-modern">
                <div class="card-header-custom">
                    <span class="card-title"><i class="bi bi-clock-history"></i> Template Survei Terbaru</span>
                    <span class="badge-premium bg-primary"><i class="bi bi-list"></i> {{ count($surveiTerbaru) }} Terbaru</span>
                </div>
                <div class="card-body-custom p-0">
                    <div class="table-responsive">
                        <table class="table table-premium">
                            <thead>
                                <tr><th>Judul</th><th>Status</th><th>Dibuat</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($surveiTerbaru as $t)
                                <tr>
                                    <td class="fw-medium">{{ Str::limit($t->judul_survei, 45) }}</td>
                                    <td>
                                        <span class="badge-premium bg-{{ $t->status === 'aktif' ? 'success' : ($t->status === 'draft' ? 'secondary' : 'danger') }}">
                                            {{ ucfirst($t->status) }}
                                        </span>
                                    </td>
                                    <td class="text-muted">{{ $t->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox"></i>
                                            <h6>Belum Ada Template Survei</h6>
                                            <small class="text-muted">Template survei akan muncul di sini setelah dibuat</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 animate-in">
            <div class="card-modern">
                <div class="card-header-custom">
                    <span class="card-title"><i class="bi bi-chat-dots-fill"></i> Respon Survei Terbaru</span>
                    <span class="badge-premium bg-info"><i class="bi bi-chat"></i> {{ count($responTerbaru) }} Respon</span>
                </div>
                <div class="card-body-custom p-0">
                    <div class="table-responsive">
                        <table class="table table-premium">
                            <thead>
                                <tr><th>Responden</th><th>Survei</th><th>IKM</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($responTerbaru as $r)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $r->nama_responden ?: 'Anonim' }}</span>
                                    </td>
                                    <td>{{ Str::limit($r->template->judul_survei ?? '-', 30) }}</td>
                                    <td>
                                        @if($r->nilai_ikm)
                                            <span class="badge-premium bg-{{ $r->nilai_ikm >= 80 ? 'success' : ($r->nilai_ikm >= 60 ? 'warning' : 'danger') }}">
                                                {{ $r->nilai_ikm }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox"></i>
                                            <h6>Belum Ada Respon Survei</h6>
                                            <small class="text-muted">Respon akan muncul di sini setelah ada yang mengisi survei</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4 py-3">
        <small class="text-muted" style="opacity:.6;">
            <i class="bi bi-database"></i> Data diperbarui otomatis • <span id="updateTime">{{ now()->format('H:i:s') }}</span> WIB
        </small>
    </div>

</div>
@endsection

@section('scripts')
<script>
// ===== JAM LIVE =====
function updateClock() {
    const now = new Date();
    const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const dateString = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
    const hh = String(now.getHours()).padStart(2,'0');
    const mm = String(now.getMinutes()).padStart(2,'0');
    const ss = String(now.getSeconds()).padStart(2,'0');

    const dateEl = document.getElementById('clockDate');
    const timeEl = document.getElementById('clockTime');
    const updateEl = document.getElementById('updateTime');
    if (dateEl) dateEl.textContent = dateString;
    if (timeEl) timeEl.textContent = `${hh}:${mm}:${ss}`;
    if (updateEl) updateEl.textContent = `${hh}:${mm}:${ss}`;
}
setInterval(updateClock, 1000);
updateClock();

// ===== DARK MODE =====
function toggleTheme() {
    const html = document.documentElement;
    const icon = document.getElementById('themeIcon');
    if (html.getAttribute('data-theme') === 'dark') {
        html.removeAttribute('data-theme');
        icon.className = 'bi bi-moon-fill';
        localStorage.setItem('theme', 'light');
    } else {
        html.setAttribute('data-theme', 'dark');
        icon.className = 'bi bi-sun-fill';
        localStorage.setItem('theme', 'dark');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const savedTheme = localStorage.getItem('theme');
    const icon = document.getElementById('themeIcon');
    if (savedTheme === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
        icon.className = 'bi bi-sun-fill';
    }
    animateCounters();
    initCharts();
});

// ===== COUNTER ANIMASI (dipertahankan) =====
function animateCounters() {
    const counters = [
        { el: document.getElementById('statTotal'), val: {{ $totalSurvei }} },
        { el: document.getElementById('statAktif'), val: {{ $surveiAktif }} },
        { el: document.getElementById('statResponden'), val: {{ $totalResponden }} },
        { el: document.getElementById('statIkm'), val: {{ $rataIkm }} }
    ];
    counters.forEach(({ el, val }) => {
        if (!el) return;
        const isFloat = val % 1 !== 0;
        let current = 0;
        const steps = 30, duration = 700, stepTime = duration / steps;
        const increment = val / steps;
        const timer = setInterval(() => {
            current += increment;
            if (current >= val) {
                el.textContent = isFloat ? val.toFixed(1) : Math.round(val);
                clearInterval(timer);
            } else {
                el.textContent = isFloat ? current.toFixed(1) : Math.round(current);
            }
        }, stepTime);
    });
}

// ===== CHARTS =====
function initCharts() {
    const bulanLabels = {!! json_encode(array_keys($responPerBulan->toArray())) !!};
    const bulanData = {!! json_encode(array_values($responPerBulan->toArray())) !!};
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const textColor = isDark ? '#adb5bd' : '#6b7280';

    const ctx1 = document.getElementById('chartResponBulan');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: bulanLabels,
                datasets: [{
                    label: 'Jumlah Respon',
                    data: bulanData,
                    borderColor: '#0B5D39',
                    backgroundColor: 'rgba(11,93,57,0.1)',
                    borderWidth: 2.5,
                    tension: .35,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: '#0B5D39',
                    pointHoverRadius: 5,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: textColor, font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { color: textColor, font: { size: 11 } } }
                }
            }
        });
    }

    const ikmTemplate = {!! json_encode($ikmPerTemplate) !!};
    const ctx2 = document.getElementById('chartIkmTemplate');
    if (ctx2) {
        const colors = ['#0B5D39', '#1a8a5a', '#B9862E', '#1a6fa0', '#6c3483'];
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ikmTemplate.map(i => i.judul.length > 20 ? i.judul.substring(0, 20) + '…' : i.judul),
                datasets: [{
                    label: 'Rata-rata IKM',
                    data: ikmTemplate.map(i => i.rata_ikm),
                    backgroundColor: ikmTemplate.map((_, idx) => colors[idx % colors.length]),
                    borderRadius: 6,
                    maxBarThickness: 34,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, max: 100, grid: { color: gridColor }, ticks: { color: textColor, font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { color: textColor, font: { size: 10 } } }
                }
            }
        });
    }
}
</script>
@endsection