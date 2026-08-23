@extends('layouts.app')
@section('title', isset($user) ? 'Edit User' : 'Tambah User')

@section('content')
<div class="card">
    <div class="card-header">{{ isset($user) ? 'Edit Data User' : 'Tambah User Baru' }}</div>
    <div class="card-body">
        <form method="POST" action="{{ isset($user) ? route('admin-users.update', $user) : route('admin-users.store') }}">
            @csrf
            @if(isset($user)) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username', $user->username ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <select name="role_id" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id ?? '') == $role->id)>{{ $role->nama_role }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="aktif" @selected(old('status', $user->status ?? 'aktif') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status', $user->status ?? '') === 'nonaktif')>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}</label>
                    <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" {{ isset($user) ? '' : 'required' }}>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('admin-users.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
