@extends('layouts.app')
@section('title', 'Backup & Restore Data')

@section('content')
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Backup Data Survei</div>
            <div class="card-body">
                <p class="text-muted small">Membuat salinan (backup) seluruh database aplikasi termasuk data survei, pertanyaan, respon, dan pengguna dalam format <code>.sql</code>.</p>
                <form action="{{ route('backup.run') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="bi bi-hdd-fill"></i> Jalankan Backup Sekarang</button>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Restore Data</div>
            <div class="card-body">
                <p class="text-muted small">Unggah file <code>.sql</code> hasil backup untuk mengembalikan (restore) data. <b class="text-danger">Proses ini akan menimpa data yang ada saat ini.</b></p>
                <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="file_restore" class="form-control" accept=".sql,.txt" required>
                    </div>
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Yakin ingin restore? Data saat ini akan ditimpa.')">
                        <i class="bi bi-arrow-counterclockwise"></i> Restore Data
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Daftar File Backup</div>
            <div class="card-body p-0">
                <table class="table mb-0 align-middle">
                    <thead><tr><th>Nama File</th><th>Ukuran</th><th>Tanggal</th><th class="text-center">Aksi</th></tr></thead>
                    <tbody>
                    @forelse ($files as $f)
                        <tr>
                            <td class="text-break">{{ $f['nama'] }}</td>
                            <td>{{ $f['ukuran'] }}</td>
                            <td>{{ $f['tanggal'] }}</td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('backup.download', $f['nama']) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i></a>
                                <form action="{{ route('backup.destroy', $f['nama']) }}" method="POST" class="d-inline form-delete" data-item-name="file {{ $f['nama'] }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Belum ada file backup</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Riwayat Aktivitas Backup / Restore</div>
            <div class="card-body p-0">
                <table class="table mb-0 align-middle">
                    <thead><tr><th>Jenis</th><th>File</th><th>Oleh</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td><span class="badge bg-{{ $log->jenis === 'backup' ? 'success' : 'warning' }}">{{ ucfirst($log->jenis) }}</span></td>
                            <td class="text-break small">{{ $log->nama_file }}</td>
                            <td>{{ $log->user->name ?? '-' }}</td>
                            <td><span class="badge bg-{{ $log->status === 'sukses' ? 'success' : 'danger' }}">{{ ucfirst($log->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Belum ada riwayat</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info mt-3">
    <i class="bi bi-info-circle-fill"></i>
    Fitur ini menjalankan perintah <code>mysqldump</code> / <code>mysql</code> pada sistem operasi anda.
    Pastikan folder <b>bin</b> MySQL (XAMPP) sudah ditambahkan ke environment <b>PATH</b> komputer anda, atau jalankan Laravel Herd yang biasanya sudah menyertakan MySQL/PATH secara otomatis.
</div>
@endsection