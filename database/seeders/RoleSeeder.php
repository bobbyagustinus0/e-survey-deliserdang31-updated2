<?php

namespace Database\Seeders;

use App\Http\Controllers\RoleController;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $allMenus = array_keys(RoleController::MENUS);

        Role::updateOrCreate(['slug' => 'superadmin'], [
            'nama_role' => 'Superadmin',
            'menu_access' => $allMenus,
        ]);

        Role::updateOrCreate(['slug' => 'admin'], [
            'nama_role' => 'Admin',
            'menu_access' => [
                'dashboard',
                'survey_template',
                'survey_data',
                'survey_question',
                'survey_response',
                'laporan',
                'pengaturan',
            ],
        ]);

        Role::updateOrCreate(['slug' => 'operator'], [
            'nama_role' => 'Operator Survei',
            'menu_access' => ['dashboard', 'survey_question', 'survey_response'],
        ]);

        Role::updateOrCreate(['slug' => 'pimpinan'], [
            'nama_role' => 'Pimpinan',
            'menu_access' => ['dashboard', 'laporan'],
        ]);

        Role::updateOrCreate(['slug' => 'responden'], [
            'nama_role' => 'User / Responden',
            'menu_access' => ['dashboard', 'isi_survey'],
        ]);
    }
}
