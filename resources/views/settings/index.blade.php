@extends('layouts.app')
@section('title', 'Pengaturan')

@section('content')
<div class="card">
    <div class="card-header">Pengaturan Aplikasi</div>
    <div class="card-body">
        <form method="POST" action="{{ route('pengaturan.update') }}">
            @csrf @method('PUT')

            <h6 class="text-muted mb-3">Informasi Umum</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama Aplikasi</label>
                    <input type="text" name="nama_aplikasi" class="form-control" value="{{ old('nama_aplikasi', $settings['nama_aplikasi']) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Instansi</label>
                    <input type="text" name="nama_instansi" class="form-control" value="{{ old('nama_instansi', $settings['nama_instansi']) }}" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Alamat Instansi</label>
                    <input type="text" name="alamat_instansi" class="form-control" value="{{ old('alamat_instansi', $settings['alamat_instansi']) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Kontak</label>
                    <input type="email" name="email_kontak" class="form-control" value="{{ old('email_kontak', $settings['email_kontak']) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telepon Kontak</label>
                    <input type="text" name="telepon_kontak" class="form-control" value="{{ old('telepon_kontak', $settings['telepon_kontak']) }}">
                </div>
            </div>

            <h6 class="text-muted mb-3">Batas Nilai Indeks Kepuasan Masyarakat (IKM)</h6>
            <p class="small text-muted">Sesuai standar Kepmenpan No. 14 Tahun 2017. Nilai IKM berskala 0-100.</p>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Batas Bawah Kategori A (Sangat Baik)</label>
                    <input type="number" step="0.01" name="batas_ikm_a" class="form-control" value="{{ old('batas_ikm_a', $settings['batas_ikm_a']) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Batas Bawah Kategori B (Baik)</label>
                    <input type="number" step="0.01" name="batas_ikm_b" class="form-control" value="{{ old('batas_ikm_b', $settings['batas_ikm_b']) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Batas Bawah Kategori C (Kurang Baik)</label>
                    <input type="number" step="0.01" name="batas_ikm_c" class="form-control" value="{{ old('batas_ikm_c', $settings['batas_ikm_c']) }}" required>
                </div>
            </div>

            <h6 class="text-muted mb-3">Halaman Depan (Landing Page) & Chatbot Publik</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Popup Ajakan Isi Survei Muncul Setelah (menit)</label>
                    <input type="number" step="0.5" min="0" name="popup_delay_menit" class="form-control" value="{{ old('popup_delay_menit', $settings['popup_delay_menit']) }}" required>
                    <small class="text-muted">Waktu tunggu di halaman depan sebelum popup ajakan isi survei muncul otomatis.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Chatbot Kasih Link Survei Setelah (menit ngobrol)</label>
                    <input type="number" step="0.5" min="0" name="chatbot_link_delay_menit" class="form-control" value="{{ old('chatbot_link_delay_menit', $settings['chatbot_link_delay_menit']) }}" required>
                    <small class="text-muted">Setelah ngobrol sekian menit dengan chatbot, otomatis dikasih link isi survei.</small>
                </div>
            </div>

            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection
