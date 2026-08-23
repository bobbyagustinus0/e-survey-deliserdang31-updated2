@extends('layouts.app')
@section('title', 'Isi Survey')

@section('content')
<div class="mb-3">
    <a href="{{ route('user-survey.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Survey</a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h5 class="fw-bold mb-1">{{ $template->judul_survei }}</h5>
        <p class="text-muted mb-0">{{ $template->unit_layanan }}</p>
        @if ($template->deskripsi)
            <p class="small mt-2 mb-0">{{ $template->deskripsi }}</p>
        @endif
    </div>
</div>

<form method="POST" action="{{ route('user-survey.store', $template) }}" id="userSurveyForm" novalidate>
    @csrf

    @php
        $kelompokPertanyaan = $template->questions->groupBy(fn ($q) => $q->kategori ?: 'Pernyataan Umum');
        $adaFieldTambahan = $template->identityFields->count() > 0;
        $offset = $adaFieldTambahan ? 1 : 0;
    @endphp

    <div class="survey-progress" id="surveyProgress">
        @if ($adaFieldTambahan)
        <div class="step-dot-wrap active" data-step="0">
            <div class="step-line"></div>
            <div class="step-dot">1</div>
            <div class="step-label">Data Diri</div>
        </div>
        @endif
        @foreach ($kelompokPertanyaan->keys() as $i => $kategori)
        <div class="step-dot-wrap {{ ($i + $offset) === 0 ? 'active' : '' }}" data-step="{{ $i + $offset }}">
            <div class="step-line"></div>
            <div class="step-dot">{{ $i + $offset + 1 }}</div>
            <div class="step-label">{{ $kategori }}</div>
        </div>
        @endforeach
    </div>

    @if ($adaFieldTambahan)
    <div class="survey-step current" data-step="0">
        <div class="card mb-3">
            <div class="card-header">Data Diri Tambahan</div>
            <div class="card-body row g-3">
                @foreach ($template->identityFields as $f)
                <div class="col-md-6">
                    <label class="form-label">{{ $f->label }} @if($f->wajib_diisi)<span class="text-danger">*</span>@endif</label>
                    @if ($f->tipe === 'pilihan')
                        <select name="data_tambahan[{{ $f->field_key }}]" class="form-select" {{ $f->wajib_diisi ? 'required' : '' }}>
                            <option value="">-- Pilih --</option>
                            @foreach ($f->opsi_pilihan ?? [] as $opsi)
                                <option value="{{ $opsi }}">{{ $opsi }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="{{ $f->tipe === 'angka' ? 'number' : ($f->tipe === 'email' ? 'email' : 'text') }}"
                               name="data_tambahan[{{ $f->field_key }}]" class="form-control" {{ $f->wajib_diisi ? 'required' : '' }}>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @foreach ($kelompokPertanyaan as $kategori => $daftarQ)
    <div class="survey-step {{ ($loop->index + $offset) === 0 ? 'current' : '' }}" data-step="{{ $loop->index + $offset }}">
        <div class="step-title">{{ $kategori }}</div>
        <div class="step-subtitle">Berikan penilaian Anda untuk setiap pernyataan berikut.</div>

        @foreach ($daftarQ as $i => $q)
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label fw-semibold">{{ $i + 1 }}. {{ $q->pertanyaan }} @if($q->wajib_diisi)<span class="text-danger">*</span>@endif</label>

                @if ($q->tipe_jawaban === 'skala_ikm')
                    <div class="row g-2 mt-1">
                        @foreach ([1 => 'Tidak Baik', 2 => 'Kurang Baik', 3 => 'Baik', 4 => 'Sangat Baik'] as $val => $label)
                            <div class="col-6 col-md-3">
                                <label class="scale-option d-block">
                                    <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ $val }}" {{ $q->wajib_diisi ? 'required' : '' }}>
                                    <div class="scale-box">{{ $val }} - {{ $label }}</div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                @elseif ($q->tipe_jawaban === 'rating_bintang')
                    @include('partials.star_rating', ['q' => $q])
                @elseif ($q->tipe_jawaban === 'pilihan_ganda')
                    <div class="mt-2">
                        @foreach ($q->opsi_jawaban ?? [] as $opsi)
                            <div class="form-check">
                                <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ $opsi }}" class="form-check-input" {{ $q->wajib_diisi ? 'required' : '' }}>
                                <label class="form-check-label">{{ $opsi }}</label>
                            </div>
                        @endforeach
                    </div>
                @elseif ($q->tipe_jawaban === 'isian_singkat')
                    <input type="text" name="jawaban[{{ $q->id }}]" class="form-control mt-2" {{ $q->wajib_diisi ? 'required' : '' }}>
                @else
                    <textarea name="jawaban[{{ $q->id }}]" rows="3" class="form-control mt-2" {{ $q->wajib_diisi ? 'required' : '' }}></textarea>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

    <div class="survey-nav d-flex justify-content-between gap-2 mb-4">
        <button type="button" class="btn btn-outline-secondary" id="btnPrev" style="visibility:hidden;">
            <i class="bi bi-arrow-left"></i> Sebelumnya
        </button>
        <button type="button" class="btn btn-success" id="btnNext">
            Selanjutnya <i class="bi bi-arrow-right"></i>
        </button>
        <button type="submit" class="btn btn-success d-none" id="btnSubmit">
            <i class="bi bi-send-fill"></i> Kirim Jawaban Survey
        </button>
    </div>
</form>
@endsection

@section('scripts')
<style>
    .survey-progress { display:flex; align-items:flex-start; gap:.25rem; margin-bottom:1.5rem; overflow-x:auto; padding-bottom:.4rem; }
    .survey-progress .step-dot-wrap { flex:1; min-width:80px; text-align:center; position:relative; }
    .survey-progress .step-dot { width:32px; height:32px; border-radius:50%; background:#e2e6ea; color:#6c757d;
        display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.85rem; margin:0 auto .4rem; transition: all .2s; }
    .survey-progress .step-dot-wrap.active .step-dot { background:#0d6e3f; color:#fff; }
    .survey-progress .step-dot-wrap.done .step-dot { background:#2e8b57; color:#fff; }
    .survey-progress .step-label { font-size:.68rem; color:#6c757d; line-height:1.25; }
    .survey-progress .step-dot-wrap.active .step-label { color:#0d6e3f; font-weight:700; }
    .survey-progress .step-line { position:absolute; top:16px; left:-50%; width:100%; height:2px; background:#e2e6ea; z-index:-1; }
    .survey-progress .step-dot-wrap:first-child .step-line { display:none; }
    .survey-progress .step-dot-wrap.done .step-line, .survey-progress .step-dot-wrap.active .step-line { background:#2e8b57; }
    .survey-step { display:none; }
    .survey-step.current { display:block; }
    .step-title { font-weight:700; font-size:1.1rem; color:#17251d; margin-bottom:.2rem; }
    .step-subtitle { color:#6c757d; font-size:.85rem; margin-bottom:1rem; }
</style>
<script>
    (function () {
        const steps = Array.from(document.querySelectorAll('.survey-step'));
        const dots = Array.from(document.querySelectorAll('#surveyProgress .step-dot-wrap'));
        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');
        const btnSubmit = document.getElementById('btnSubmit');
        let current = 0;

        function render() {
            steps.forEach((el, i) => el.classList.toggle('current', i === current));
            dots.forEach((el, i) => {
                el.classList.toggle('active', i === current);
                el.classList.toggle('done', i < current);
            });
            btnPrev.style.visibility = current === 0 ? 'hidden' : 'visible';
            btnNext.classList.toggle('d-none', current === steps.length - 1);
            btnSubmit.classList.toggle('d-none', current !== steps.length - 1);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function validateCurrentStep() {
            const inputs = steps[current].querySelectorAll('[required]');
            for (const input of inputs) {
                if (input.type === 'radio') {
                    const group = steps[current].querySelectorAll(`[name="${input.name}"]`);
                    const checked = Array.from(group).some(r => r.checked);
                    if (!checked) {
                        input.closest('.card')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        alert('Mohon lengkapi semua pernyataan pada langkah ini sebelum melanjutkan.');
                        return false;
                    }
                } else if (!input.value.trim()) {
                    input.reportValidity();
                    input.focus();
                    return false;
                }
            }
            return true;
        }

        btnNext.addEventListener('click', function () {
            if (!validateCurrentStep()) return;
            if (current < steps.length - 1) { current++; render(); }
        });

        btnPrev.addEventListener('click', function () {
            if (current > 0) { current--; render(); }
        });

        document.getElementById('userSurveyForm').addEventListener('submit', function (e) {
            if (!validateCurrentStep()) { e.preventDefault(); return; }
            const btn = this.querySelector('button[type=submit]');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengirim...';
        });

        if (steps.length) render();
    })();
</script>
@endsection
