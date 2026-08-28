@extends('layouts.app')

@section('title', 'Pengaduan Masyarakat')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Pengaduan Masyarakat</h4>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                @foreach ($statusList as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
        </div>
        <div class="col-auto">
            <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengaduan as $item)
                        <tr>
                            <td>{{ $item->waktu->format('d M Y H:i') }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kontak }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>
                                @php
                                    $badge = match ($item->status) {
                                        'Selesai' => 'success',
                                        'Diproses' => 'warning',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $item->status }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('pengaduan.show', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada laporan pengaduan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $pengaduan->links() }}
    </div>

</div>
@endsection
