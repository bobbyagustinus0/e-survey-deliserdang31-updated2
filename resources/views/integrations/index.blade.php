@extends('layouts.app')
@section('title', 'Integrasi API')

@section('content')
<style>
    /* Professional Integration Styling */
    .integration-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.03);
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
    }
    .integration-card:hover {
        box-shadow: 0 8px 35px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .integration-card .card-header {
        background: white;
        padding: 1.2rem 1.5rem;
        border-bottom: 2px solid #f1f3f5;
        font-weight: 700;
        font-size: 1rem;
        color: #1a1a2e;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .integration-card .card-header .header-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: white;
    }
    .integration-card .card-header .header-icon.outbound {
        background: linear-gradient(135deg, #0B5D39, #1a8a4a);
    }
    .integration-card .card-header .header-icon.inbound {
        background: linear-gradient(135deg, #1f6fb2, #3a8fd4);
    }
    .integration-card .card-header .badge-status {
        margin-left: auto;
        padding: 0.25rem 0.8rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .integration-card .card-body {
        padding: 1.5rem;
    }

    /* Form Styling */
    .integration-card .form-label {
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #495057;
        margin-bottom: 0.3rem;
    }
    .integration-card .form-control,
    .integration-card .form-select {
        border-radius: 10px;
        border: 1.5px solid #e9ecef;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .integration-card .form-control:focus {
        border-color: #0B5D39;
        box-shadow: 0 0 0 4px rgba(11, 93, 57, 0.08);
    }
    .integration-card .form-control[readonly] {
        background: #f8f9fa;
        cursor: default;
    }

    .btn-integration {
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-integration-primary {
        background: #0B5D39;
        color: white;
        border: none;
    }
    .btn-integration-primary:hover {
        background: #094a2e;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(11, 93, 57, 0.3);
    }
    .btn-integration-outline {
        border: 1.5px solid #e9ecef;
        color: #495057;
        background: white;
    }
    .btn-integration-outline:hover {
        border-color: #0B5D39;
        color: #0B5D39;
        background: #f8faf9;
    }

    /* Token Display */
    .token-display {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-family: 'Courier New', monospace;
        font-size: 0.8rem;
        word-break: break-all;
        border: 1.5px dashed #dee2e6;
        position: relative;
    }
    .token-display .copy-btn {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 0.2rem 0.6rem;
        font-size: 0.7rem;
        transition: all 0.2s;
    }
    .token-display .copy-btn:hover {
        background: #0B5D39;
        color: white;
        border-color: #0B5D39;
    }

    /* Info Box */
    .info-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 0.8rem 1rem;
        border-left: 4px solid #0B5D39;
        margin-top: 1rem;
        font-size: 0.85rem;
        color: #495057;
    }
    .info-box.warning {
        border-left-color: #f59e0b;
        background: #fffbeb;
    }
    .info-box.danger {
        border-left-color: #dc2626;
        background: #fef2f2;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.3rem 0.9rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .status-badge .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    .status-badge.success {
        background: #e8f5ed;
        color: #0B5D39;
    }
    .status-badge.success .dot { background: #0B5D39; }
    .status-badge.danger {
        background: #fde8e5;
        color: #c0392b;
    }
    .status-badge.danger .dot { background: #c0392b; }
    .status-badge.secondary {
        background: #f1f3f5;
        color: #6c757d;
    }
    .status-badge.secondary .dot { background: #6c757d; }

    /* Divider */
    .section-divider {
        border: none;
        border-top: 2px dashed #e9ecef;
        margin: 1.2rem 0;
    }

    /* Documentation Link */
    .doc-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #0B5D39;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    .doc-link:hover {
        color: #094a2e;
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .integration-card .card-body { padding: 1.2rem; }
        .token-display { font-size: 0.7rem; }
        .integration-card .card-header { flex-wrap: wrap; }
    }
</style>

<div class="container-fluid px-4 py-3">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #1a1a2e;">
                <i class="bi bi-plug text-success me-2"></i>Integrasi API
            </h2>
            <p class="text-muted small mt-1">
                Kelola koneksi antara sistem survei dengan website Anda
            </p>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="{{ route('integrasi.dokumentasi') }}" target="_blank" class="btn btn-integration btn-integration-outline btn-sm">
                <i class="bi bi-file-earmark-text me-1"></i> Dokumentasi API
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- ===================== OUTBOUND ===================== --}}
        <div class="col-lg-6">
            <div class="integration-card">
                <div class="card-header">
                    <span class="header-icon outbound"><i class="bi bi-upload"></i></span>
                    <span>Outbound <span class="text-muted fw-normal">— Push Survei</span></span>
                    @if($integration->exists)
                        @php
                            $badge = match($integration->status_koneksi) {
                                'terhubung' => 'success',
                                'gagal' => 'danger',
                                default => 'secondary',
                            };
                            $label = match($integration->status_koneksi) {
                                'terhubung' => 'Terhubung',
                                'gagal' => 'Gagal',
                                default => 'Belum Terhubung',
                            };
                        @endphp
                        <span class="badge-status bg-{{ $badge }}-subtle text-{{ $badge }}">
                            <span class="dot"></span> {{ $label }}
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Isi alamat API website Anda beserta API Key-nya. Kredensial ini digunakan untuk mengirim (push) data survei setiap kali Anda mengaktifkan survei.
                    </p>

                    <form method="POST" action="{{ route('integrasi.update') }}">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-link-45deg me-1"></i> API Base URL</label>
                            <input type="url" name="api_base_url" class="form-control"
                                placeholder="https://website-anda.com/api"
                                value="{{ old('api_base_url', $integration->api_base_url) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-key me-1"></i> API Key</label>
                            <input type="password" name="api_key" class="form-control"
                                placeholder="{{ $integration->exists && $integration->api_key ? '•••••••••••••••• (isi ulang untuk mengganti)' : 'API Key dari sistem website Anda' }}"
                                autocomplete="new-password">
                            <small class="text-muted">Kosongkan untuk mempertahankan API Key yang sudah tersimpan.</small>
                        </div>

                        <button type="submit" class="btn btn-integration btn-integration-primary">
                            <i class="bi bi-save me-2"></i> Simpan Konfigurasi
                        </button>
                    </form>

                    @if($integration->exists)
                        <hr class="section-divider">

                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <form method="POST" action="{{ route('integrasi.test-koneksi') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-integration btn-integration-outline btn-sm">
                                    <i class="bi bi-broadcast me-1"></i> Test Koneksi
                                </button>
                            </form>

                            <span class="status-badge {{ $badge }}">
                                <span class="dot"></span> {{ $label }}
                            </span>

                            @if($integration->last_tested_at)
                                <span class="text-muted small">
                                    <i class="bi bi-clock me-1"></i> {{ $integration->last_tested_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>

                        @if($integration->last_test_message)
                            <div class="info-box {{ $badge === 'danger' ? 'danger' : ($badge === 'success' ? '' : 'warning') }} mt-2">
                                <i class="bi bi-{{ $badge === 'danger' ? 'x-circle' : ($badge === 'success' ? 'check-circle' : 'info-circle') }} me-2"></i>
                                {{ $integration->last_test_message }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        {{-- ===================== INBOUND ===================== --}}
        <div class="col-lg-6">
            <div class="integration-card">
                <div class="card-header">
                    <span class="header-icon inbound"><i class="bi bi-download"></i></span>
                    <span>Inbound <span class="text-muted fw-normal">— Webhook Jawaban</span></span>
                    @if($integration->exists && $integration->webhook_token_hash)
                        <span class="badge-status bg-success-subtle text-success">
                            <span class="dot"></span> Token Aktif
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Token ini dipasang oleh developer website Anda sebagai header 
                        <code class="bg-light px-1 py-0 rounded">X-Webhook-Token</code> saat mengirim jawaban survei ke endpoint kami.
                    </p>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-link-45deg me-1"></i> Webhook Endpoint</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-monospace" readonly 
                                value="{{ url('/api/webhook/survey-jawaban') }}">
                            <button class="btn btn-outline-secondary" type="button" 
                                onclick="navigator.clipboard.writeText('{{ url('/api/webhook/survey-jawaban')}}')"
                                title="Salin URL">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-shield-lock me-1"></i> Webhook Token</label>
                        
                        @if($webhookTokenBaru)
                            <div class="token-display" id="tokenContainer">
                                <span id="webhookTokenBaru">{{ $webhookTokenBaru }}</span>
                                <button class="copy-btn" type="button" 
                                    onclick="copyToken()">
                                    <i class="bi bi-clipboard me-1"></i> Salin
                                </button>
                            </div>
                            <div class="info-box danger mt-2">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Simpan token ini sekarang!</strong> Setelah meninggalkan halaman ini, token tidak akan ditampilkan lagi.
                            </div>
                        @elseif($integration->exists && $integration->webhook_token_hash)
                            <div class="token-display">
                                <span>••••••••••••••••••••••••••••••••••••••••••</span>
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Token sudah pernah digenerate. Generate ulang jika lupa atau hilang (token lama otomatis tidak berlaku).
                            </small>
                        @else
                            <div class="token-display text-muted">
                                <span>Belum ada token</span>
                            </div>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('integrasi.webhook-token.regenerate') }}"
                        onsubmit="return confirm('Yakin generate ulang? Token lama langsung tidak berlaku, developer website Anda harus update tokennya.');"
                        class="d-inline-block">
                        @csrf
                        <button type="submit" class="btn btn-integration btn-integration-outline btn-sm">
                            <i class="bi bi-arrow-repeat me-1"></i> 
                            {{ $integration->exists && $integration->webhook_token_hash ? 'Generate Ulang Token' : 'Generate Token' }}
                        </button>
                    </form>

                    <hr class="section-divider">

                    <a href="{{ route('integrasi.dokumentasi') }}" target="_blank" class="doc-link">
                        <i class="bi bi-file-earmark-text"></i> Lihat dokumentasi lengkap format API (API Contract)
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function copyToken() {
        const token = document.getElementById('webhookTokenBaru');
        if (token) {
            navigator.clipboard.writeText(token.textContent).then(() => {
                const btn = token.parentElement.querySelector('.copy-btn');
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check me-1"></i> Tersalin';
                btn.style.background = '#0B5D39';
                btn.style.color = 'white';
                btn.style.borderColor = '#0B5D39';
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.style.background = 'white';
                    btn.style.color = 'inherit';
                    btn.style.borderColor = '#dee2e6';
                }, 2000);
            });
        }
    }
</script>

@endsection