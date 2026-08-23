@extends('layouts.app')
@section('title', isset($template) ? 'Edit Template Survei' : 'Buat Template Survei')

@section('content')
<div class="card">
    <div class="card-header">{{ isset($template) ? 'Edit Template Survei' : 'Buat Template Survei Baru' }}</div>
    <div class="card-body">
        <form method="POST" action="{{ isset($template) ? route('survey-templates.update', $template) : route('survey-templates.store') }}">
            @csrf
            @if(isset($template)) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Kode Survei</label>
                    <input type="text" name="kode_survei" class="form-control" value="{{ old('kode_survei', $template->kode_survei ?? 'SVY-' . str_pad(random_int(1,999), 3, '0', STR_PAD_LEFT)) }}" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Judul Survei</label>
                    <input type="text" name="judul_survei" class="form-control" value="{{ old('judul_survei', $template->judul_survei ?? '') }}" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Unit / Nama Layanan Digital</label>
                    <input type="text" name="unit_layanan" class="form-control" value="{{ old('unit_layanan', $template->unit_layanan ?? '') }}" required placeholder="Contoh: Aplikasi SIPANDU, Website PPID, dsb.">
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-control">{{ old('deskripsi', $template->deskripsi ?? '') }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', isset($template->tanggal_mulai) ? $template->tanggal_mulai->format('Y-m-d') : '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', isset($template->tanggal_selesai) ? $template->tanggal_selesai->format('Y-m-d') : '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="draft" @selected(old('status', $template->status ?? 'draft') === 'draft')>Draft</option>
                        <option value="aktif" @selected(old('status', $template->status ?? '') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status', $template->status ?? '') === 'nonaktif')>Nonaktif</option>
                    </select>
                </div>
            </div>

            <hr class="my-4">

            <h6 class="mb-3"><i class="bi bi-window-stack"></i> Pengaturan Pop Up di Website Dinas</h6>
            <p class="text-muted small mb-3">
                Atur kapan pop up survei ini muncul ke pengunjung website dinas. Tanggal Mulai / Tanggal
                Selesai di atas menentukan <strong>rentang tanggal tayang</strong>; pengaturan di bawah ini
                menentukan <strong>waktu &amp; seberapa sering</strong> pop up muncul untuk tiap pengunjung.
            </p>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Muncul Setelah (detik)</label>
                    <input type="number" min="0" max="120" name="popup_tampil_setelah_detik" class="form-control"
                        value="{{ old('popup_tampil_setelah_detik', $template->popup_tampil_setelah_detik ?? 3) }}">
                    <div class="form-text">Jeda sebelum pop up tampil setelah halaman selesai dimuat.</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Frekuensi Tampil</label>
                    <select name="popup_frekuensi" class="form-select">
                        @php $frekuensi = old('popup_frekuensi', $template->popup_frekuensi ?? 'sekali_per_sesi'); @endphp
                        <option value="setiap_kunjungan" @selected($frekuensi === 'setiap_kunjungan')>Setiap Kunjungan</option>
                        <option value="sekali_per_sesi" @selected($frekuensi === 'sekali_per_sesi')>Sekali per Sesi (tab masih terbuka)</option>
                        <option value="sekali_per_hari" @selected($frekuensi === 'sekali_per_hari')>Sekali per Hari</option>
                        <option value="sekali_selamanya" @selected($frekuensi === 'sekali_selamanya')>Sekali Saja (sampai submit/tutup)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jam Mulai Tayang <span class="text-muted">(opsional)</span></label>
                    <input type="time" name="popup_jam_mulai" class="form-control"
                        value="{{ old('popup_jam_mulai', $template->popup_jam_mulai ?? '') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jam Selesai Tayang <span class="text-muted">(opsional)</span></label>
                    <input type="time" name="popup_jam_selesai" class="form-control"
                        value="{{ old('popup_jam_selesai', $template->popup_jam_selesai ?? '') }}">
                </div>
                <div class="col-12">
                    <div class="form-text">Kosongkan jam mulai/selesai kalau pop up boleh tayang sepanjang hari.</div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('survey-templates.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
