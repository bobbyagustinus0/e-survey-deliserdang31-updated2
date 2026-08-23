<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->get();
        return view('admin_users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin_users.form', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:aktif,nonaktif',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('admin-users.index')->with('success', 'User admin berhasil ditambahkan.');
    }

    public function edit(User $adminUser)
    {
        $roles = Role::all();
        return view('admin_users.form', ['user' => $adminUser, 'roles' => $roles]);
    }

    public function update(Request $request, User $adminUser)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($adminUser->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($adminUser->id)],
            'no_hp' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:aktif,nonaktif',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $adminUser->update($data);

        return redirect()->route('admin-users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $adminUser)
    {
        if ($adminUser->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        $adminUser->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
