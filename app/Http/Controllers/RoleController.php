<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Daftar menu yang tersedia untuk diatur hak aksesnya
    public const MENUS = [
        'dashboard' => 'Dashboard Admin Utama',

        'isi_survey' => 'Isi Survey',
        'admin_user' => 'Manajemen Admin User',
        'survey_template' => 'Template Survei',

        'survey_data' => 'Data Survei',
        'survey_question' => 'Pertanyaan Survei',
        'survey_response' => 'Respon Survei',
        'backup_restore' => 'Backup & Restore Data',
        'hak_akses' => 'Hak Akses',
        'laporan' => 'Laporan',
        'pengaturan' => 'Pengaturan',
        'integrasi' => 'Integrasi API (Website User)',
    ];

    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('roles.index', ['roles' => $roles, 'menus' => self::MENUS]);
    }

    public function create()
    {
        return view('roles.form', ['menus' => self::MENUS]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_role' => 'required|string|max:100',
            'slug' => 'required|string|max:50|unique:roles,slug|alpha_dash',
        ]);
        $data['menu_access'] = $request->input('menu_access', []);

        Role::create($data);

        return redirect()->route('roles.index')->with('success', 'Role & hak akses berhasil ditambahkan.');
    }

    public function edit(Role $role)
    {
        return view('roles.form', ['role' => $role, 'menus' => self::MENUS]);
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'nama_role' => 'required|string|max:100',
        ]);
        $data['menu_access'] = $role->slug === 'superadmin' ? array_keys(self::MENUS) : $request->input('menu_access', []);

        $role->update($data);

        return redirect()->route('roles.index')->with('success', 'Hak akses role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        if ($role->slug === 'superadmin') {
            return back()->with('error', 'Role Superadmin tidak dapat dihapus.');
        }
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role masih digunakan oleh user, tidak dapat dihapus.');
        }
        $role->delete();
        return back()->with('success', 'Role berhasil dihapus.');
    }
}
