@extends('layouts.app')
@section('title', 'Detail Pengaduan')

@section('content')
<style>
    :root {
        --primary: #0B5D39;
        --primary-gradient: linear-gradient(135deg, #0B5D39 0%, #1a8a5a 100%);
        --border-radius: 20px;
        --card-shadow: 0 8px 32px rgba(0,0,0,0.08);
    }
    .detail-wrapper { min-height: 100vh; padding: 1.5rem; background: #f0f2f5; }
    [data-theme="dark"] .detail-wrapper { background: #12121c; }
    .detail-card {
        background: rgba(255,255,255,0.9);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        padding: 2rem;
        max-width: 800px;
        margin: 0 auto;
    }
    [data-theme="dark"] .detail-card {
        background: rgba(30,30,46,0.9);
        border: 1px solid rgba(255,255,255,0.05);
    }
    .detail-title {
        font-size: 1.4rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
    }
    .detail-row { display: flex; padding: .6rem 0; border-bottom: 1px dashed rgba(0,0,0,0.08); }
    .detail-row .label { width: 200px; font-weight: 600; color: #6c757d; font-size: .85rem; }
    .detail-row .value { flex: 1; }
    .badge-kategori {
        background: var(--primary-gradient);
        color: #fff;
        padding: .25rem .75rem;
        border-radius: 50px;
        font-size: .72rem;
        font-weight: 600;
    }
</style>

<div class="detail-wrapper">
    <div class="detail-card">
        <a href="{{ route('pengaduan.index') }}" class="btn btn-sm btn-outline-secondary mb-3 rounded-pill">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <div class="detail-title"><i class="bi bi-megaphone-fill me-2"></i>Detail Pengaduan</div>

        <div class="detail-row">
            <div class="label">No. Tiket</div>
            <div class="value"><code>{{ data_get($pengaduan->data_tambahan, 'nomor_tiket', '-') }}</code></div>
        </div>
        <div class="detail-row">
            <div class="label">Nama Pelapor</div>
            <div class="value">{{ $pengaduan->nama_responden ?: 'Anonim' }}</div>
        </div>
        <div class="detail-row">
            <div class="label">Kontak / No. HP</div>
            <div class="value">{{ $pengaduan->no_hp ?: '-' }}</div>
        </div>
        <div class="detail-row">
            <div class="label">Kategori</div>
            <div class="value">
                @if($k = data_get($pengaduan->data_tambahan, 'kategori'))
                    <span class="badge-kategori">{{ $k }}</span>
                @else - @endif
            </div>
        </div>
        <div class="detail-row">
            <div class="label">Lokasi Kejadian</div>
            <div class="value">{{ data_get($pengaduan->data_tambahan, 'lokasi', '-') }}</div>
        </div>
        @foreach($pengaduan->answers as $a)
            <div class="detail-row">
                <div class="label">{{ $a->question->pertanyaan ?? 'Jawaban' }}</div>
                <div class="value">{{ $a->jawaban }}</div>
            </div>
        @endforeach
        <div class="detail-row">
            <div class="label">Waktu Masuk</div>
            <div class="value">{{ optional($pengaduan->tanggal_isi)->format('d-m-Y H:i') ?: '-' }} WIB</div>
        </div>
        <div class="detail-row">
            <div class="label">Sumber</div>
            <div class="value">{{ data_get($pengaduan->data_tambahan, 'sumber', '-') }}</div>
        </div>

        <form action="{{ route('pengaduan.destroy', $pengaduan) }}" method="POST" class="mt-4 form-delete"
              data-item-name="pengaduan ini">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger rounded-pill"><i class="bi bi-trash me-1"></i>Hapus Pengaduan</button>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (confirm(`Apakah Anda yakin ingin menghapus ${this.dataset.itemName}?`)) {
            this.submit();
        }
    });
});
</script>
@endsection
