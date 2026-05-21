<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StudyProgramSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Sample Study Programs
        $prodis = [
            [
                'name' => 'Manajemen Informatika',
                'code' => 'MI',
                'level' => 'D3',
                'description' => 'Program studi yang fokus pada pengembangan perangkat lunak dan manajemen basis data untuk kebutuhan bisnis.'
            ],
            [
                'name' => 'Teknologi Rekayasa Perangkat Lunak',
                'code' => 'TRPL',
                'level' => 'D4',
                'description' => 'Program studi yang menekankan pada rekayasa perangkat lunak skala besar dan kualitas perangkat lunak.'
            ],
            [
                'name' => 'Akuntansi Komputer',
                'code' => 'AK',
                'level' => 'D3',
                'description' => 'Integrasi antara ilmu akuntansi dan teknologi informasi untuk menghasilkan laporan keuangan yang akurat dan cepat.'
            ],
        ];

        foreach ($prodis as $prodi) {
            StudyProgram::updateOrCreate(
                ['code' => $prodi['code']],
                [
                    'name' => $prodi['name'],
                    'slug' => Str::slug($prodi['name']),
                    'level' => $prodi['level'],
                    'description' => $prodi['description'],
                    'is_active' => true
                ]
            );
        }

        // 2. Create Permissions
        $permissions = [
            ['name' => 'View Study Programs', 'slug' => 'study_programs_view', 'group' => 'Study Program'],
            ['name' => 'Create Study Programs', 'slug' => 'study_programs_create', 'group' => 'Study Program'],
            ['name' => 'Edit Study Programs', 'slug' => 'study_programs_edit', 'group' => 'Study Program'],
            ['name' => 'Delete Study Programs', 'slug' => 'study_programs_delete', 'group' => 'Study Program'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['slug' => $perm['slug']], $perm);
        }

        // 3. Assign to Admin Role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching(Permission::whereIn('slug', array_column($permissions, 'slug'))->pluck('id'));
        }

        // 4. Create Menu
        Menu::updateOrCreate(
            ['url' => '/study-programs'],
            [
                'title' => 'Program Studi',
                'icon' => 'fas fa-graduation-cap',
                'permission_slug' => 'study_programs_view',
                'order' => 5
            ]
        );
    }
}
