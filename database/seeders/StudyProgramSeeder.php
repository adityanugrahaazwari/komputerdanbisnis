<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class StudyProgramSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Sample Study Programs
        $prodis = [
            [
                'name' => 'Akuntansi Perpajakan',
                'code' => 'AP',
                'level' => 'D-IV',
                'description' => 'Program studi yang fokus pada keahlian di bidang akuntansi dengan spesialisasi perpajakan untuk memenuhi kebutuhan industri dan pemerintah.',
                'website_url' => 'https://ap.politala.ac.id'
            ],
            [
                'name' => 'Teknik Rekayasa Komputer dan Jaringan',
                'code' => 'TRKJ',
                'level' => 'D-IV',
                'description' => 'Program studi yang membekali mahasiswa dengan kemampuan merancang, mengimplementasikan, dan mengelola infrastruktur jaringan komputer serta sistem komputer.',
                'website_url' => 'https://trkj.politala.ac.id'
            ],
            [
                'name' => 'Akuntansi',
                'code' => 'AK',
                'level' => 'D-III',
                'description' => 'Menghasilkan tenaga ahli madya akuntansi yang kompeten dalam menyusun laporan keuangan, perpajakan, dan pengauditan.',
                'website_url' => 'https://ak.politala.ac.id'
            ],
            [
                'name' => 'Teknologi Informasi',
                'code' => 'TI',
                'level' => 'D-III',
                'description' => 'Fokus pada pengembangan keterampilan praktis dalam pemrograman, basis data, dan pengembangan aplikasi web serta mobile.',
                'website_url' => 'https://ti.politala.ac.id'
            ],
        ];

        // Clear existing data to replace with the new ones
        Schema::disableForeignKeyConstraints();
        StudyProgram::truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($prodis as $prodi) {
            StudyProgram::create([
                'name' => $prodi['name'],
                'slug' => Str::slug($prodi['level'] . '-' . $prodi['name']),
                'code' => $prodi['code'],
                'level' => $prodi['level'],
                'description' => $prodi['description'],
                'website_url' => $prodi['website_url'],
                'is_active' => true
            ]);
        }

        // 2. Create Permissions
        $permissions = [
            ['name' => 'View Study Programs', 'slug' => 'study_programs_view', 'group' => 'Study Program'],
            ['name' => 'Create Study Programs', 'slug' => 'study_programs_create', 'group' => 'Study Program'],
            ['name' => 'Edit Study Programs', 'slug' => 'study_programs_edit', 'group' => 'Study Program'],
            ['name' => 'Delete Study Programs', 'slug' => 'study_programs_delete', 'group' => 'Study Program'],
        ];

        foreach ($permissions as $perm) {
            $group = PermissionGroup::firstOrCreate(
                ['name' => $perm['group']],
                ['slug' => Str::slug($perm['group'])]
            );

            Permission::updateOrCreate(
                ['slug' => $perm['slug']],
                [
                    'name' => $perm['name'],
                    'permission_group_id' => $group->id
                ]
            );
        }

        // 3. Assign to Admin Role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching(Permission::whereIn('slug', array_column($permissions, 'slug'))->pluck('id'));
        }

        // 4. Create Menu under "Manajemen Konten"
        $parent = Menu::where('title', 'Manajemen Konten')->first();
        Menu::updateOrCreate(
            ['url' => '/study-programs'],
            [
                'title' => 'Program Studi',
                'icon' => 'fas fa-graduation-cap',
                'parent_id' => $parent ? $parent->id : null,
                'permission_slug' => 'study_programs_view',
                'order' => 2
            ]
        );
    }
}
