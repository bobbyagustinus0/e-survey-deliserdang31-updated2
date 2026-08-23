@extends('layouts.app')
@section('title', 'Integrasi API')

@section('content')

<div class="row g-4">

    {{-- ===================== OUTBOUND: kita -> website User ===================== --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-upload"></i> Outbound &mdash; Push Survei ke Website Anda
            </div>
            <div class="card-body">
                <p class="text-muted small">
                    Isi alamat API website Anda beserta API Key-nya. Kredensial ini milik sistem Anda sendiri,
                    dipakai kami untuk mengirim (push) data survei setiap kali Anda mengaktifkan survei.
                </p>

                <form method="POST" action="{{ route('integrasi.update') }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">API Base URL</label>
                        <input type="url" name="api_base_url" class="form-control"
                            placeholder="https://website-anda.com/api"
                            value="{{ old('api_base_url', $integration->api_base_url) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">API Key</label>
                        <input type="password" name="api_key" class="form-control"
                            placeholder="{{ $integration->exists && $integration->api_key ? '•••••••••••••••• (sudah tersimpan, isi ulang untuk mengganti)' : 'API Key dari sistem website Anda' }}"
                            autocomplete="new-password">
                        <small class="text-muted">Dikosongkan artinya API Key lama tetap dipakai (kalau sudah pernah diisi).</small>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </form>

                @if($integration->exists)
                <hr>
                <form method="POST" action="{{ route('integrasi.test-koneksi') }}" class="d-flex align-items-center gap-2 flex-wrap">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-broadcast"></i> Test Koneksi
                    </button>

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
                    <span class="badge bg-{{ $badge }}">{{ $label }}</span>

                    @if($integration->last_tested_at)
                    <span class="text-muted small">Terakhir dites {{ $integration->last_tested_at->diffForHumans() }}</span>
                    @endif
                </form>

                @if($integration->last_test_message)
                <div class="alert alert-{{ $badge }} mt-3 mb-0 small">{{ $integration->last_test_message }}</div>
                @endif
                @endif
            </div>
        </div>
    </div>

    {{-- ===================== INBOUND: website User -> kita ===================== --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-download"></i> Inbound &mdash; Webhook Jawaban Survei
            </div>
            <div class="card-body">
                <p class="text-muted small">
                    Token di bawah ini dipasang oleh developer website Anda sebagai header
                    <code>X-Webhook-Token</code> saat mengirim jawaban survei ke endpoint kami.
                    Ini membuktikan bahwa jawaban yang masuk memang berasal dari website Anda yang sah.
                </p>

                <div class="mb-3">
                    <label class="form-label">Webhook Endpoint (URL Tujuan)</label>
                    <div class="input-group">
                        <input type="text" class="form-control" readonly value="{{ url('/api/webhook/survey-jawaban') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Webhook Token</label>
                    @if($webhookTokenBaru)
                    <div class="input-group">
                        <input type="text" class="form-control font-monospace" id="webhookTokenBaru" readonly value="{{ $webhookTokenBaru }}">
                        <button class="btn btn-outline-secondary" type="button" onclick="navigator.clipboard.writeText(document.getElementById('webhookTokenBaru').value)">
                            <i class="bi bi-clipboard"></i> Salin
                        </button>
                    </div>
                    <small class="text-danger">Simpan token ini sekarang. Setelah meninggalkan halaman ini, token tidak akan ditampilkan lagi.</small>
                    @elseif($integration->exists && $integration->webhook_token_hash)
                    <input type="text" class="form-control font-monospace" readonly value="•••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••">
                    <small class="text-muted">Token sudah pernah digenerate. Kalau lupa/hilang, generate ulang di bawah (token lama otomatis tidak berlaku lagi).</small>
                    @else
                    <input type="text" class="form-control" readonly value="Belum ada token">
                    @endif
                </div>

                <form method="POST" action="{{ route('integrasi.webhook-token.regenerate') }}"
                    onsubmit="return confirm('Yakin generate ulang? Token lama langsung tidak berlaku, developer website Anda harus update tokennya.');">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-arrow-repeat"></i> {{ $integration->exists && $integration->webhook_token_hash ? 'Generate Ulang Token' : 'Generate Token' }}
                    </button>
                </form>

                <hr>
                <a href="{{ route('integrasi.dokumentasi') }}" target="_blank" class="small">
                    <i class="bi bi-file-earmark-text"></i> Lihat dokumentasi lengkap format API (API Contract)
                </a>
            </div>
        </div>
    </div>

</div>

@endsection