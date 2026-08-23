@extends('layouts.app')
@section('title', isset($role) ? 'Edit Hak Akses Role' : 'Tambah Role')

@section('content')
<div class="card">
    <div class="card-header">{{ isset($role) ? 'Edit Role: ' . $role->nama_role : 'Tambah Role Baru' }}</div>
    <div class="card-body">
        <form method="POST" action="{{ isset($role) ? route('roles.update', $role) : route('roles.store') }}">
            @csrf
            @if(isset($role)) @method('PUT') @endif

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Role</label>
                    <input type="text" name="nama_role" class="form-control" value="{{ old('nama_role', $role->nama_role ?? '') }}" required>
                </div>
                @if(!isset($role))
                <div class="col-md-6">
                    <label class="form-label">Slug (identifier unik, huruf kecil, tanpa spasi)</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="contoh: verifikator" required>
                </div>
                @endif
            </div>

            @if(isset($role) && $role->slug === 'superadmin')
                <div class="alert alert-info">Role Superadmin otomatis memiliki akses ke seluruh menu aplikasi.</div>
            @else
                <label class="form-label fw-semibold">Hak Akses Menu</label>
                <div class="row g-2 mb-3">
                    @foreach ($menus as $key => $label)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" name="menu_access[]" value="{{ $key }}" class="form-check-input" id="menu_{{ $key }}"
                                    @checked(in_array($key, old('menu_access', $role->menu_access ?? [])))>
                                <label class="form-check-label" for="menu_{{ $key }}">{{ $label }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-4">
                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
