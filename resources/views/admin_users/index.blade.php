@extends('layouts.app')
@section('title', 'Manajemen Admin User')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar Admin / User</span>
        <a href="{{ route('admin-users.create') }}" class="btn btn-sm btn-success"><i class="bi bi-plus-lg"></i> Tambah User</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-datatable align-middle">
                <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge bg-secondary">{{ $user->role->nama_role ?? '-' }}</span></td>
                        <td>
                            <span class="badge bg-{{ $user->status === 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin-users.edit', $user) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></a>
                            <form action="{{ route('admin-users.destroy', $user) }}" method="POST" class="d-inline form-delete" data-item-name="user {{ $user->name }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
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
