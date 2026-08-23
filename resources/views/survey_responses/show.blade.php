@extends('layouts.app')
@section('title', 'Detail Respon Survei')

@section('content')
<div class="mb-3">
    <a href="{{ route('survey-responses.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Data Responden</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><td class="text-muted">Nama</td><td>{{ $response->nama_responden ?: 'Anonim' }}</td></tr>
                    <tr><td class="text-muted">Email</td><td>{{ $response->email ?: '-' }}</td></tr>
                    @if ($response->template)
                        @foreach ($response->template->identityFields as $f)
                        @continue(in_array($f->field_key, ['nama_responden', 'email']))
                        <tr>
                            <td class="text-muted">{{ $f->label }}</td>
                            <td>{{ data_get($response->data_tambahan, $f->field_key) ?: '-' }}</td>
                        </tr>
                        @endforeach
                    @endif
                    <tr><td class="text-muted">Tanggal Isi</td><td>{{ optional($response->tanggal_isi)->format('d-m-Y H:i') }}</td></tr>
                    <tr><td class="text-muted">IP Address</td><td>{{ $response->ip_address }}</td></tr>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body text-center">
                <div class="text-muted small mb-1">Nilai IKM</div>
                <div class="display-5 fw-bold text-success">{{ $response->nilai_ikm ?? '-' }}</div>
                <span class="badge badge-ikm-{{ strtolower(substr($response->kategoriMutu(),0,1)) }} mt-2">{{ $response->kategoriMutu() }}</span>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">{{ $response->template->judul_survei ?? '-' }}</div>
            <div class="card-body">
                @forelse ($response->answers as $a)
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="fw-semibold small text-muted mb-1">{{ $a->question->pertanyaan ?? '-' }}</div>
                        <div>
                            @if($a->nilai_skala)
                                <span class="badge bg-success">Skala {{ $a->nilai_skala }} / 4</span>
                            @else
                                {{ $a->jawaban }}
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">Tidak ada jawaban tercatat.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
