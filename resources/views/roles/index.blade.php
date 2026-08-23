@extends('layouts.app')
@section('title', 'Hak Akses')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar Role &amp; Hak Akses</span>
        <a href="{{ route('roles.create') }}" class="btn btn-sm btn-success"><i class="bi bi-plus-lg"></i> Tambah Role</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-datatable">
                <thead>
                <tr>
                    <th>Nama Role</th>
                    <th>Slug</th>
                    <th>Jumlah User</th>
                    <th>Menu yang Diizinkan</th>
                    <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->nama_role }}</td>
                        <td><code>{{ $role->slug }}</code></td>
                        <td>{{ $role->users_count }}</td>
                        <td>
                            @if($role->slug === 'superadmin')
                                <span class="badge bg-success">Semua Menu</span>
                            @else
                                @foreach($role->menu_access ?? [] as $menu)
                                    <span class="badge bg-secondary mb-1">{{ $menus[$menu] ?? $menu }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></a>
                            @if($role->slug !== 'superadmin')
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline form-delete" data-item-name="role {{ $role->nama_role }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
