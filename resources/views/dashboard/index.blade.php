@extends('layouts.app')
@section('title', 'Dashboard Admin Utama')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-grad-green d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-value">{{ $totalSurvei }}</div>
                <div class="stat-label">Total Template Survei</div>
            </div>
            <i class="bi bi-file-earmark-text-fill stat-icon"></i>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-grad-blue d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-value">{{ $surveiAktif }}</div>
                <div class="stat-label">Survei Aktif</div>
            </div>
            <i class="bi bi-check-circle-fill stat-icon"></i>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-grad-gold d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-value">{{ $totalResponden }}</div>
                <div class="stat-label">Total Responden</div>
            </div>
            <i class="bi bi-people-fill stat-icon"></i>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-grad-purple d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-value">{{ $rataIkm }}</div>
                <div class="stat-label">Rata-rata Nilai IKM</div>
            </div>
            <i class="bi bi-graph-up-arrow stat-icon"></i>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header">Jumlah Respon Survei per Bulan</div>
            <div class="card-body">
                <canvas id="chartResponBulan" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">Rata-rata IKM per Template Survei (Top 5)</div>
            <div class="card-body">
                <canvas id="chartIkmTemplate" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">Template Survei Terbaru</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Judul</th><th>Status</th><th>Dibuat</th></tr></thead>
                    <tbody>
                    @forelse ($surveiTerbaru as $t)
                        <tr>
                            <td>{{ $t->judul_survei }}</td>
                            <td><span class="badge bg-{{ $t->status === 'aktif' ? 'success' : ($t->status === 'draft' ? 'secondary' : 'danger') }}">{{ ucfirst($t->status) }}</span></td>
                            <td>{{ $t->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Belum ada template survei</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">Respon Survei Terbaru</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Responden</th><th>Survei</th><th>Nilai IKM</th></tr></thead>
                    <tbody>
                    @forelse ($responTerbaru as $r)
                        <tr>
                            <td>{{ $r->nama_responden ?: 'Anonim' }}</td>
                            <td>{{ $r->template->judul_survei ?? '-' }}</td>
                            <td>{{ $r->nilai_ikm ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Belum ada respon survei</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const bulanLabels = {!! json_encode(array_keys($responPerBulan->toArray())) !!};
    const bulanData = {!! json_encode(array_values($responPerBulan->toArray())) !!};

    new Chart(document.getElementById('chartResponBulan'), {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Jumlah Respon',
                data: bulanData,
                borderColor: '#0d6e3f',
                backgroundColor: 'rgba(13,110,63,.15)',
                tension: .35,
                fill: true,
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    const ikmTemplate = {!! json_encode($ikmPerTemplate) !!};
    new Chart(document.getElementById('chartIkmTemplate'), {
        type: 'bar',
        data: {
            labels: ikmTemplate.map(i => i.judul.length > 22 ? i.judul.substring(0, 22) + '…' : i.judul),
            datasets: [{
                label: 'Rata-rata IKM',
                data: ikmTemplate.map(i => i.rata_ikm),
                backgroundColor: '#c99a2e',
                borderRadius: 6,
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, max: 100 } } }
    });
</script>
@endsection
