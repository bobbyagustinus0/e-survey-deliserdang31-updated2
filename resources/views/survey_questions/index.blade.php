@extends('layouts.app')
@section('title', 'Pertanyaan Survei')

@section('content')
<div class="mb-3">
    <a href="{{ route('survey-templates.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali ke Template Survei</a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h6 class="mb-1">{{ $template->judul_survei }}</h6>
        <p class="text-muted mb-0 small">{{ $template->unit_layanan }} — Kode: {{ $template->kode_survei }}</p>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Field Data Diri Responden</span>
        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahField"><i class="bi bi-plus-lg"></i> Tambah Field</button>
    </div>
    <div class="card-body">
        <p class="text-muted small mb-3">
            <strong>Nama Lengkap</strong> dan <strong>Email</strong> tersedia secara bawaan namun tetap bisa diedit (label, wajib diisi, urutan) atau dihapus jika tidak diperlukan.
            Tambahkan field lain di sini jika Anda butuh info tambahan seperti No. HP, Instansi, dsb.
        </p>

        @if ($identityFields->count())
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead>
                <tr>
                    <th style="width:50px">No</th>
                    <th>Label Field</th>
                    <th style="width:120px">Tipe</th>
                    <th style="width:90px">Wajib</th>
                    <th style="width:110px" class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($identityFields as $f)
                    <tr>
                        <td>{{ $f->urutan }}</td>
                        <td>
                            {{ $f->label }}
                            @if ($f->is_default)
                                <span class="badge bg-secondary-subtle text-secondary-emphasis ms-1">Bawaan</span>
                            @endif
                        </td>
                        <td><span class="badge bg-info-subtle text-info-emphasis">{{ ucfirst($f->tipe) }}</span></td>
                        <td>{{ $f->wajib_diisi ? 'Ya' : 'Tidak' }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditField{{ $f->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('survey-identity-fields.destroy', [$template, $f]) }}" method="POST" class="d-inline form-delete" data-item-name="field {{ $f->label }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-muted small mb-0">Belum ada field tambahan.</p>
        @endif
    </div>
</div>

{{-- Modal Edit Field (di luar table agar valid) --}}
@foreach ($identityFields as $f)
<div class="modal fade" id="modalEditField{{ $f->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('survey-identity-fields.update', [$template, $f]) }}" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header">
                <h6 class="modal-title">Edit Field Data Diri</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Label Field</label>
                    <input type="text" name="label" class="form-control" value="{{ $f->label }}" required placeholder="Misal: No. HP">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe Input</label>
                    <select name="tipe" class="form-select" onchange="toggleOpsiField(this, 'opsiField{{ $f->id }}')" {{ $f->is_default ? 'disabled' : '' }}>
                        <option value="text" @selected($f->tipe === 'text')>Teks Singkat</option>
                        <option value="email" @selected($f->tipe === 'email')>Email</option>
                        <option value="angka" @selected($f->tipe === 'angka')>Angka</option>
                        <option value="pilihan" @selected($f->tipe === 'pilihan')>Pilihan Dropdown (Kustom)</option>
                    </select>
                    @if ($f->is_default)
                        <input type="hidden" name="tipe" value="{{ $f->tipe }}">
                        <div class="form-text">Tipe field bawaan tidak dapat diubah.</div>
                    @endif
                </div>
                <div class="mb-3" id="opsiField{{ $f->id }}" style="display: {{ $f->tipe === 'pilihan' ? 'block' : 'none' }}">
                    <label class="form-label">Opsi Pilihan (satu opsi per baris)</label>
                    <textarea name="opsi_pilihan" class="form-control" rows="3">{{ is_array($f->opsi_pilihan) ? implode("\n", $f->opsi_pilihan) : '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" value="{{ $f->urutan }}" min="1">
                </div>
                <div class="form-check">
                    <input type="checkbox" name="wajib_diisi" value="1" class="form-check-input" id="wajibField{{ $f->id }}" @checked($f->wajib_diisi)>
                    <label class="form-check-label" for="wajibField{{ $f->id }}">Wajib diisi</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Modal Tambah Field -->
<div class="modal fade" id="modalTambahField" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('survey-identity-fields.store', $template) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h6 class="modal-title">Tambah Field Data Diri</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Label Field</label>
                    <input type="text" name="label" class="form-control" required placeholder="Misal: No. HP">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe Input</label>
                    <select name="tipe" class="form-select" onchange="toggleOpsiField(this, 'opsiFieldBaru')">
                        <option value="text">Teks Singkat</option>
                        <option value="email">Email</option>
                        <option value="angka">Angka</option>
                        <option value="pilihan">Pilihan Dropdown (Kustom)</option>
                    </select>
                </div>
                <div class="mb-3" id="opsiFieldBaru" style="display:none">
                    <label class="form-label">Opsi Pilihan (satu opsi per baris)</label>
                    <textarea name="opsi_pilihan" class="form-control" rows="3" placeholder="Opsi 1&#10;Opsi 2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" min="1" placeholder="Otomatis jika dikosongkan">
                </div>
                <div class="form-check">
                    <input type="checkbox" name="wajib_diisi" value="1" class="form-check-input" id="wajibFieldBaru">
                    <label class="form-check-label" for="wajibFieldBaru">Wajib diisi</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleOpsiField(select, targetId) {
        document.getElementById(targetId).style.display = select.value === 'pilihan' ? 'block' : 'none';
    }
</script>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar Pertanyaan</span>
        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-lg"></i> Tambah Pertanyaan</button>
    </div>
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead>
            <tr>
                <th style="width:50px">No</th>
                <th style="width:180px">Kategori/Tahap</th>
                <th>Pertanyaan</th>
                <th style="width:150px">Tipe Jawaban</th>
                <th style="width:90px">Wajib</th>
                <th style="width:130px" class="text-center">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($questions as $q)
                <tr>
                    <td>{{ $q->urutan }}</td>
                    <td>@if($q->kategori)<span class="badge bg-secondary-subtle text-secondary-emphasis">{{ $q->kategori }}</span>@else <span class="text-muted small">-</span>@endif</td>
                    <td>{{ $q->pertanyaan }}</td>
                    <td><span class="badge bg-info-subtle text-info-emphasis">{{ str_replace('_', ' ', ucfirst($q->tipe_jawaban)) }}</span></td>
                    <td>{{ $q->wajib_diisi ? 'Ya' : 'Tidak' }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-primary btn-edit-question"
                                data-bs-toggle="modal" data-bs-target="#modalEdit{{ $q->id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('survey-questions.destroy', [$template, $q]) }}" method="POST" class="d-inline form-delete" data-item-name="pertanyaan ini">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pertanyaan untuk survei ini.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Edit dipindahkan ke luar <table>/<tbody> karena <div> tidak valid sebagai child langsung <tbody> --}}
@foreach ($questions as $q)
<div class="modal fade" id="modalEdit{{ $q->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('survey-questions.update', [$template, $q]) }}" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header">
                <h6 class="modal-title">Edit Pertanyaan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kategori/Tahap (opsional)</label>
                    <input type="text" name="kategori" class="form-control" value="{{ $q->kategori }}" placeholder="Misal: Kualitas Sistem" list="daftarKategori">
                    <div class="form-text">Pertanyaan dengan kategori/tahap yang sama akan ditampilkan dalam satu langkah pada form survei publik.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea name="pertanyaan" class="form-control" rows="2" required>{{ $q->pertanyaan }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe Jawaban</label>
                    <select name="tipe_jawaban" class="form-select" onchange="toggleOpsiJawaban(this, 'opsi{{ $q->id }}')">
                        <option value="skala_ikm" @selected($q->tipe_jawaban === 'skala_ikm')>Skala IKM (1-4)</option>
                        <option value="rating_bintang" @selected($q->tipe_jawaban === 'rating_bintang')>Rating Bintang (Mengecewakan - Memuaskan)</option>
                        <option value="pilihan_ganda" @selected($q->tipe_jawaban === 'pilihan_ganda')>Pilihan Ganda (Kustom)</option>
                        <option value="isian_singkat" @selected($q->tipe_jawaban === 'isian_singkat')>Isian Singkat</option>
                        <option value="esai" @selected($q->tipe_jawaban === 'esai')>Esai</option>
                    </select>
                </div>
                <div class="mb-3" id="opsi{{ $q->id }}" style="display: {{ $q->tipe_jawaban === 'pilihan_ganda' ? 'block' : 'none' }}">
                    <label class="form-label">Opsi Jawaban (satu opsi per baris)</label>
                    <textarea name="opsi_jawaban" class="form-control" rows="3">{{ is_array($q->opsi_jawaban) ? implode("\n", $q->opsi_jawaban) : '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" value="{{ $q->urutan }}" min="1">
                </div>
                <div class="form-check">
                    <input type="checkbox" name="wajib_diisi" value="1" class="form-check-input" id="wajib{{ $q->id }}" @checked($q->wajib_diisi)>
                    <label class="form-check-label" for="wajib{{ $q->id }}">Wajib diisi</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('survey-questions.store', $template) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h6 class="modal-title">Tambah Pertanyaan Survei</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kategori/Tahap (opsional)</label>
                    <input type="text" name="kategori" class="form-control" placeholder="Misal: Kualitas Sistem" list="daftarKategori">
                    <div class="form-text">Pertanyaan dengan kategori/tahap yang sama akan ditampilkan dalam satu langkah pada form survei publik.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea name="pertanyaan" class="form-control" rows="2" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe Jawaban</label>
                    <select name="tipe_jawaban" class="form-select" onchange="toggleOpsiJawaban(this, 'opsiBaru')">
                        <option value="skala_ikm">Skala IKM (1-4)</option>
                        <option value="rating_bintang">Rating Bintang (Mengecewakan - Memuaskan)</option>
                        <option value="pilihan_ganda">Pilihan Ganda (Kustom)</option>
                        <option value="isian_singkat">Isian Singkat</option>
                        <option value="esai">Esai</option>
                    </select>
                </div>
                <div class="mb-3" id="opsiBaru" style="display:none">
                    <label class="form-label">Opsi Jawaban (satu opsi per baris)</label>
                    <textarea name="opsi_jawaban" class="form-control" rows="3" placeholder="Opsi 1&#10;Opsi 2&#10;Opsi 3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" min="1" placeholder="Otomatis jika dikosongkan">
                </div>
                <div class="form-check">
                    <input type="checkbox" name="wajib_diisi" value="1" class="form-check-input" id="wajibBaru" checked>
                    <label class="form-check-label" for="wajibBaru">Wajib diisi</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

<datalist id="daftarKategori">
    @foreach ($questions->pluck('kategori')->filter()->unique() as $kat)
    <option value="{{ $kat }}">
    @endforeach
</datalist>
