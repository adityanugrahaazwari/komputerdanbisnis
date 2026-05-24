<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;
use Illuminate\Support\Str;

class LecturerRbacSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Permissions Group
        $group = PermissionGroup::firstOrCreate(
            ['slug' => 'lecturer_management'],
            ['name' => 'Lecturer & Staff Management']
        );

        // 2. Permissions
        $permissions = [
            ['name' => 'View Lecturers', 'slug' => 'lecturers_view'],
            ['name' => 'Create Lecturer', 'slug' => 'lecturers_create'],
            ['name' => 'Edit Lecturer', 'slug' => 'lecturers_edit'],
            ['name' => 'Delete Lecturer', 'slug' => 'lecturers_delete'],
        ];

        foreach ($permissions as $perm) {
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
            $adminRole->permissions()->syncWithoutDetaching(
                Permission::where('permission_group_id', $group->id)->pluck('id')
            );
        }

        // 4. Admin Menu
        $profileMenu = Menu::where('title', 'Profil Lembaga')->where('location', 'admin')->first();
        Menu::updateOrCreate(
            ['url' => '/lecturers'],
            [
                'title' => 'Direktori Dosen & Staf',
                'icon' => 'fas fa-chalkboard-teacher',
                'parent_id' => $profileMenu ? $profileMenu->id : null,
                'permission_slug' => 'lecturers_view',
                'order' => 5,
                'is_active' => true,
                'location' => 'admin'
            ]
        );

        // 5. Frontend Menu
        $academicMenu = Menu::where('title', 'Akademik')->where('location', 'frontend')->first();
        if ($academicMenu) {
            Menu::updateOrCreate(
                ['url' => '/direktori-dosen'],
                [
                    'title' => 'Dosen & Staf',
                    'location' => 'frontend',
                    'parent_id' => $academicMenu->id,
                    'order' => 3,
                    'is_active' => true
                ]
            );
        }
    }
}
