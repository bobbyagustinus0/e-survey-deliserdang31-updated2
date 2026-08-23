<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $superadmin = Role::where('slug', 'superadmin')->first();

        User::updateOrCreate(['username' => 'superadmin'], [
            'role_id' => $superadmin->id,
            'name' => 'Administrator Utama',
            'email' => 'superadmin@deliserdangkab.go.id',
            'password' => Hash::make('password123'),
            'status' => 'aktif',
        ]);

        $admin = Role::where('slug', 'admin')->first();
        User::updateOrCreate(['username' => 'admin'], [
            'role_id' => $admin->id,
            'name' => 'Admin Dinas Kominfo',
            'email' => 'admin@deliserdangkab.go.id',
            'password' => Hash::make('password123'),
            'status' => 'aktif',
        ]);

        $responden = Role::where('slug', 'responden')->first();
        User::updateOrCreate(['username' => 'user'], [
            'role_id' => $responden->id,
            'name' => 'Contoh User Responden',
            'email' => 'user@deliserdangkab.go.id',
            'password' => Hash::make('password123'),
            'status' => 'aktif',
        ]);
    }
}
