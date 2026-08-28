@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Detail Pengaduan</h4>
        <a href="{{ route('pengaduan.index') }}" class="btn btn-sm btn-outline-secondary">
            &larr; Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Waktu</dt>
                <dd class="col-sm-9">{{ $item->waktu->format('d M Y H:i') }}</dd>

                <dt class="col-sm-3">Nama</dt>
                <dd class="col-sm-9">{{ $item->nama }}</dd>

                <dt class="col-sm-3">Kontak</dt>
                <dd class="col-sm-9">{{ $item->kontak }}</dd>

                <dt class="col-sm-3">Kategori</dt>
                <dd class="col-sm-9">{{ $item->kategori }}</dd>

                <dt class="col-sm-3">Lokasi</dt>
                <dd class="col-sm-9">{{ $item->lokasi }}</dd>

                <dt class="col-sm-3">Isi Laporan</dt>
                <dd class="col-sm-9">{{ $item->isi }}</dd>
            </dl>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('pengaduan.updateStatus', $item->id) }}" class="row g-2 align-items-end">
                @csrf
                @method('PUT')

                <div class="col-auto">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach ($statusList as $status)
                            <option value="{{ $status }}" @selected($item->status === $status)>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Simpan Status</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
