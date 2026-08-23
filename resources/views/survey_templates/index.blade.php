@extends('layouts.app')
@section('title', 'Template Survei / Data Survei')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar Template Survei</span>
        <a href="{{ route('survey-templates.create') }}" class="btn btn-sm btn-success"><i class="bi bi-plus-lg"></i> Buat Template Survei</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-datatable align-middle">
                <thead>
                <tr>
                    <th>Kode</th>
                    <th>Judul Survei</th>
                    <th>Unit Layanan</th>
                    <th>Pertanyaan</th>
                    <th>Respon</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($templates as $t)
                    <tr>
                        <td>{{ $t->kode_survei }}</td>
                        <td>{{ $t->judul_survei }}</td>
                        <td>{{ $t->unit_layanan }}</td>
                        <td class="text-center">{{ $t->questions_count }}</td>
                        <td class="text-center">{{ $t->responses_count }}</td>
                        <td>
                            <span class="badge bg-{{ $t->status === 'aktif' ? 'success' : ($t->status === 'draft' ? 'secondary' : 'danger') }}">
                                {{ ucfirst($t->status) }}
                            </span>
                        </td>
                        <td class="text-center text-nowrap">
                            <a href="{{ route('survey-questions.index', $t) }}" class="btn btn-sm btn-outline-dark" title="Kelola Pertanyaan"><i class="bi bi-list-check"></i></a>
                            @if($t->status === 'aktif')
                            @endif
                            <a href="{{ route('survey-templates.edit', $t) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil-square"></i></a>
                            <form action="{{ route('survey-templates.destroy', $t) }}" method="POST" class="d-inline form-delete" data-item-name="template {{ $t->judul_survei }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
