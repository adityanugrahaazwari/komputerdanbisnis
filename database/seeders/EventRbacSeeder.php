<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Menu;

class EventRbacSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Permissions Group
        $group = PermissionGroup::firstOrCreate(
            ['slug' => 'event_management'],
            ['name' => 'Event & Calendar Management']
        );

        // 2. Permissions
        $permissions = [
            ['name' => 'View Events', 'slug' => 'events_view'],
            ['name' => 'Create Event', 'slug' => 'events_create'],
            ['name' => 'Edit Event', 'slug' => 'events_edit'],
            ['name' => 'Delete Event', 'slug' => 'events_delete'],
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
        /*
        $contentMenu = Menu::where('title', 'Manajemen Konten')->where('location', 'admin')->first();
        Menu::updateOrCreate(
            ['url' => '/events'],
            [
                'title' => 'Kalender & Kegiatan',
                'icon' => 'fas fa-calendar-alt',
                'parent_id' => $contentMenu ? $contentMenu->id : null,
                'permission_slug' => 'events_view',
                'order' => 10,
                'is_active' => true,
                'location' => 'admin'
            ]
        );

        // 5. Frontend Menu
        $infoMenu = Menu::where('title', 'Informasi')->where('location', 'frontend')->first();
        if ($infoMenu) {
            Menu::updateOrCreate(
                ['url' => '/kalender-kegiatan'],
                [
                    'title' => 'Kalender Kegiatan',
                    'location' => 'frontend',
                    'parent_id' => $infoMenu->id,
                    'order' => 4,
                    'is_active' => true
                ]
            );
        }
        */
    }
}
