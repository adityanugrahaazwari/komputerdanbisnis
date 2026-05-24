<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;

class TestimonialRbacSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Permission Group
        $group = PermissionGroup::firstOrCreate(
            ['name' => 'Testimonials'],
            ['slug' => 'testimonials']
        );

        // 2. Create Permissions
        $perms = [
            ['name' => 'View Testimonials', 'slug' => 'testimonials_view'],
            ['name' => 'Create Testimonial', 'slug' => 'testimonials_create'],
            ['name' => 'Edit Testimonial', 'slug' => 'testimonials_edit'],
            ['name' => 'Delete Testimonial', 'slug' => 'testimonials_delete'],
        ];

        $allPermIds = [];
        foreach ($perms as $perm) {
            $permission = Permission::updateOrCreate(
                ['slug' => $perm['slug']],
                [
                    'name' => $perm['name'],
                    'permission_group_id' => $group->id
                ]
            );
            $allPermIds[] = $permission->id;
        }

        // 3. Assign to Admin Role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching($allPermIds);
        }

        // 4. Add to Sidebar Menu (Manajemen Konten)
        $contentMenu = Menu::where('title', 'Manajemen Konten')->first();
        if ($contentMenu) {
            Menu::updateOrCreate(
                ['url' => '/testimonials'],
                [
                    'title' => 'Testimoni',
                    'icon' => 'fas fa-quote-right',
                    'parent_id' => $contentMenu->id,
                    'permission_slug' => 'testimonials_view',
                    'order' => 8,
                    'is_active' => true
                ]
            );
        }
    }
}
