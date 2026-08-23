@extends('layouts.app')
@section('title', 'Respon Survei')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small">Template Survei</label>
                <select name="template_id" class="form-select">
                    <option value="">Semua Survei</option>
                    @foreach ($templates as $t)
                        <option value="{{ $t->id }}" @selected(request('template_id') == $t->id)>{{ $t->judul_survei }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Dari Tanggal</label>
                <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Sampai Tanggal</label>
                <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-success"><i class="bi bi-funnel"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">Daftar Respon Survei</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                <tr>
                    <th>Responden</th>
                    <th>Survei</th>
                    <th>Email</th>
                    @foreach ($kolomField as $f)
                        <th>{{ $f->label }}</th>
                    @endforeach
                    <th>Nilai IKM</th>
                    <th>Kategori</th>
                    <th>Tanggal Isi</th>
                    <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($responses as $r)
                    <tr>
                        <td>{{ $r->nama_responden ?: 'Anonim' }}</td>
                        <td>{{ $r->template->judul_survei ?? '-' }}</td>
                        <td>{{ $r->email ?: '-' }}</td>
                        @foreach ($kolomField as $f)
                            <td>{{ data_get($r->data_tambahan, $f->field_key) ?: '-' }}</td>
                        @endforeach
                        <td>{{ $r->nilai_ikm ?? '-' }}</td>
                        <td><span class="badge badge-ikm-{{ strtolower(substr($r->kategoriMutu(),0,1)) }}">{{ $r->kategoriMutu() }}</span></td>
                        <td>{{ optional($r->tanggal_isi)->format('d-m-Y H:i') }}</td>
                        <td class="text-center text-nowrap">
                            <a href="{{ route('survey-responses.show', $r) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <form action="{{ route('survey-responses.destroy', $r) }}" method="POST" class="d-inline form-delete" data-item-name="respon ini">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ 7 + $kolomField->count() }}" class="text-center text-muted py-4">Belum ada respon survei</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $responses->links() }}</div>
    </div>
</div>
@endsection
