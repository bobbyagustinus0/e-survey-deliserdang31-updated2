@extends('layouts.app')
@section('title', 'Isi Survey')

@section('content')
<div class="card">
    <div class="card-header">Daftar Survey Aktif</div>
    <div class="card-body">
        <p class="text-muted small">Silakan pilih survei di bawah ini untuk memberikan penilaian kepuasan anda terhadap layanan digital Kabupaten Deli Serdang.</p>

        <div class="row g-3">
            @forelse ($templates as $t)
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-semibold">{{ $t->judul_survei }}</h6>
                            <p class="text-muted small mb-2">{{ $t->unit_layanan }}</p>
                            <p class="small flex-grow-1">{{ Str::limit($t->deskripsi, 100) }}</p>
                            @if ($t->sudah_diisi > 0)
                                <span class="badge bg-success align-self-start mb-2"><i class="bi bi-check-circle"></i> Sudah pernah anda isi</span>
                            @endif
                            <a href="{{ route('user-survey.show', $t) }}" class="btn btn-success mt-auto">
                                <i class="bi bi-pencil-square"></i> Isi Survey
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted text-center py-4">Belum ada survei yang aktif saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
