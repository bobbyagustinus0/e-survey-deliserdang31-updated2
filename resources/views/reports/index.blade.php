@extends('layouts.app')
@section('title', 'Laporan')

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
                <button class="btn btn-success"><i class="bi bi-funnel"></i> Terapkan</button>
            </div>
        </form>
        <a href="{{ route('laporan.export', request()->query()) }}" class="btn btn-outline-dark btn-sm mt-3"><i class="bi bi-file-earmark-spreadsheet"></i> Export CSV</a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="stat-card bg-grad-green">
            <div class="stat-value">{{ $totalResponden }}</div>
            <div class="stat-label">Total Responden</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card bg-grad-gold">
            <div class="stat-value">{{ $rataIkm }}</div>
            <div class="stat-label">Rata-rata Nilai IKM</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card bg-grad-blue">
            <div class="stat-value">{{ collect($sebaranKategori)->sum() ? round(($sebaranKategori['A (Sangat Baik)'] + $sebaranKategori['B (Baik)']) / max(collect($sebaranKategori)->sum(),1) * 100) : 0 }}%</div>
            <div class="stat-label">Persentase Kategori Baik & Sangat Baik</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Sebaran Kategori Mutu Pelayanan</div>
            <div class="card-body"><canvas id="chartKategori" height="200"></canvas></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Sebaran Jenis Kelamin Responden</div>
            <div class="card-body"><canvas id="chartGender" height="200"></canvas></div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">Perbandingan Nilai IKM Antar Layanan</div>
            <div class="card-body"><canvas id="chartPerbandingan" height="100"></canvas></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($sebaranKategori)) !!},
            datasets: [{
                data: {!! json_encode(array_values($sebaranKategori)) !!},
                backgroundColor: ['#0d6e3f', '#2e8b57', '#c99a2e', '#c0392b'],
            }]
        }
    });

    new Chart(document.getElementById('chartGender'), {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($sebaranGender)) !!},
            datasets: [{
                data: {!! json_encode(array_values($sebaranGender)) !!},
                backgroundColor: ['#1f6fb2', '#e0658f'],
            }]
        }
    });

    const ikmPerTemplate = {!! json_encode($ikmPerTemplate) !!};
    new Chart(document.getElementById('chartPerbandingan'), {
        type: 'bar',
        data: {
            labels: ikmPerTemplate.map(i => i.judul),
            datasets: [{ label: 'Rata-rata IKM', data: ikmPerTemplate.map(i => i.rata_ikm), backgroundColor: '#0d6e3f', borderRadius: 6 }]
        },
        options: { scales: { y: { beginAtZero: true, max: 100 } } }
    });
</script>
@endsection
