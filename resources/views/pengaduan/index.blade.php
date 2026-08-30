@extends('layouts.app')
@section('title', 'Pengaduan Masyarakat')

@section('content')
<style>
    :root {
        --primary: #0B5D39;
        --primary-light: #1a8a5a;
        --primary-gradient: linear-gradient(135deg, #0B5D39 0%, #1a8a5a 100%);
        --danger: #dc3545;
        --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        --border-radius: 20px;
        --transition: all 0.3s ease;
    }

    .pengaduan-wrapper {
        min-height: 100vh;
        padding: 1.5rem;
        background:
            radial-gradient(ellipse at 0% 0%, rgba(11, 93, 57, 0.06) 0%, transparent 50%),
            radial-gradient(ellipse at 100% 100%, rgba(185, 134, 46, 0.05) 0%, transparent 50%),
            #f0f2f5;
    }
    [data-theme="dark"] .pengaduan-wrapper {
        background:
            radial-gradient(ellipse at 0% 0%, rgba(46, 204, 113, 0.08) 0%, transparent 50%),
            #12121c;
    }

    .pengaduan-header {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        padding: 1.75rem 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        border-left: 6px solid var(--primary);
        box-shadow: var(--card-shadow);
    }
    [data-theme="dark"] .pengaduan-header {
        background: rgba(30, 30, 46, 0.8);
        border: 1px solid rgba(255,255,255,0.05);
    }
    .pengaduan-header .title {
        font-size: 1.6rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: rgba(11,93,57,0.08);
        color: var(--primary);
        padding: .35rem 1rem;
        border-radius: 50px;
        font-size: .8rem;
        font-weight: 600;
    }

    .card-body-custom {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        padding: 1.5rem;
    }
    [data-theme="dark"] .card-body-custom {
        background: rgba(30, 30, 46, 0.85);
        border: 1px solid rgba(255,255,255,0.05);
    }

    .filter-form .form-control, .filter-form .form-select {
        border-radius: 12px;
    }

    .table-pengaduan thead th {
        border-bottom: 2px solid rgba(11,93,57,0.15);
        color: var(--primary);
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .4px;
        white-space: nowrap;
    }
    .table-pengaduan tbody tr:hover {
        background: rgba(11,93,57,0.04);
    }
    .badge-kategori {
        background: var(--primary-gradient);
        color: #fff;
        padding: .25rem .75rem;
        border-radius: 50px;
        font-size: .72rem;
        font-weight: 600;
    }
    .badge-status {
        background: rgba(244, 185, 60, 0.15);
        color: #9a6b00;
        padding: .25rem .75rem;
        border-radius: 50px;
        font-size: .72rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .isi-preview {
        max-width: 280px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
    }
    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: var(--transition);
        text-decoration: none;
    }
    .btn-action.view { background: rgba(11,93,57,0.1); color: var(--primary); }
    .btn-action.delete { background: rgba(220,53,69,0.1); color: var(--danger); }
    .btn-action:hover { transform: translateY(-2px); }

    .empty-state-table {
        text-align: center;
        padding: 3rem 1rem;
        color: #9aa1a9;
    }
    .empty-state-table i { font-size: 2.5rem; opacity: .5; }
</style>

<div class="pengaduan-wrapper">

    <div class="pengaduan-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="title"><i class="bi bi-megaphone-fill me-2"></i>Pengaduan Masyarakat</div>
            <small class="text-muted">Laporan warga yang masuk lewat form pengaduan di website dinas</small>
        </div>
        <span class="stat-pill">
            <i class="bi bi-inbox"></i> {{ $pengaduan->total() }} Laporan
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
    @endif

    <div class="card-body-custom mb-3">
        <form method="GET" class="row g-2 filter-form">
            <div class="col-md-4">
                <input type="text" name="cari" value="{{ request('cari') }}" class="form-control"
                       placeholder="Cari nama, kontak, lokasi, atau ID laporan...">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $k)
                        <option value="{{ $k }}" {{ request('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="dari" value="{{ request('dari') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="form-control">
            </div>
            <div class="col-md-1">
                <button class="btn btn-success w-100"><i class="bi bi-funnel-fill"></i></button>
            </div>
        </form>
    </div>

    <div class="card-body-custom">
        <div class="table-responsive">
            <table class="table table-pengaduan align-middle">
                <thead>
                    <tr>
                        <th>ID Laporan</th>
                        <th>Pelapor</th>
                        <th>Kontak</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Isi Laporan</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduan as $p)
                        <tr>
                            <td><code>{{ $p->id }}</code></td>
                            <td>{{ $p->nama ?: 'Anonim' }}</td>
                            <td>{{ $p->kontak ?: '-' }}</td>
                            <td>
                                @if($p->kategori)
                                    <span class="badge-kategori">{{ $p->kategori }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $p->lokasi ?: '-' }}</td>
                            <td>
                                <span class="isi-preview" title="{{ $p->isi }}">{{ $p->isi ?: '-' }}</span>
                            </td>
                            <td><span class="badge-status">{{ $p->status ?: 'Baru diterima' }}</span></td>
                            <td style="font-size:.8rem;color:#6c757d;white-space:nowrap;">
                                {{ optional($p->waktu)->format('d-m-Y H:i') ?: '-' }}
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('pengaduan.show', $p) }}" class="btn-action view" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('pengaduan.destroy', $p) }}" method="POST" class="form-delete"
                                          data-item-name="pengaduan {{ $p->nama ?: 'anonim' }}">
                                        @csrf @method('DELETE')
                                        <button class="btn-action delete" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state-table">
                                    <i class="bi bi-inbox"></i>
                                    <h6>Belum Ada Pengaduan</h6>
                                    <small>Laporan warga dari website dinas akan otomatis muncul di sini</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pengaduan->hasPages())
            <div class="mt-3">{{ $pengaduan->links() }}</div>
        @endif
    </div>
</div>

<script>
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const itemName = this.dataset.itemName || 'data ini';
        if (confirm(`Apakah Anda yakin ingin menghapus ${itemName}?`)) {
            this.submit();
        }
    });
});
</script>
@endsection
