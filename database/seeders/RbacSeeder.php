<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Menu;
use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RbacSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Granular Permissions
        $permissions = [
            ['name' => 'View Dashboard', 'slug' => 'view_dashboard', 'group' => 'Dashboard'],
            
            // User Permissions
            ['name' => 'View Users', 'slug' => 'users_view', 'group' => 'User Management'],
            ['name' => 'Create User', 'slug' => 'users_create', 'group' => 'User Management'],
            ['name' => 'Edit User', 'slug' => 'users_edit', 'group' => 'User Management'],
            ['name' => 'Delete User', 'slug' => 'users_delete', 'group' => 'User Management'],
            
            // Role Permissions
            ['name' => 'View Roles', 'slug' => 'roles_view', 'group' => 'Access Control'],
            ['name' => 'Create Role', 'slug' => 'roles_create', 'group' => 'Access Control'],
            ['name' => 'Edit Role', 'slug' => 'roles_edit', 'group' => 'Access Control'],
            ['name' => 'Delete Role', 'slug' => 'roles_delete', 'group' => 'Access Control'],
            
            // Permission Permissions
            ['name' => 'View Permissions', 'slug' => 'permissions_view', 'group' => 'Access Control'],
            ['name' => 'Create Permission', 'slug' => 'permissions_create', 'group' => 'Access Control'],
            ['name' => 'Edit Permission', 'slug' => 'permissions_edit', 'group' => 'Access Control'],
            ['name' => 'Delete Permission', 'slug' => 'permissions_delete', 'group' => 'Access Control'],
            
            // Menu Permissions
            ['name' => 'View Menus', 'slug' => 'menus_view', 'group' => 'Navigation'],
            ['name' => 'Create Menu', 'slug' => 'menus_create', 'group' => 'Navigation'],
            ['name' => 'Edit Menu', 'slug' => 'menus_edit', 'group' => 'Navigation'],
            ['name' => 'Delete Menu', 'slug' => 'menus_delete', 'group' => 'Navigation'],
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

        // 2. Create Roles
        $adminRole = Role::updateOrCreate(['slug' => 'admin'], ['name' => 'Administrator', 'description' => 'Has all access']);
        $operatorRole = Role::updateOrCreate(['slug' => 'operator'], ['name' => 'Operator', 'description' => 'Limited access']);

        // 3. Assign Permissions to Roles
        $adminRole->permissions()->sync(Permission::pluck('id'));
        
        $operatorPerms = Permission::whereIn('slug', ['view_dashboard', 'users_view', 'roles_view'])->pluck('id');
        $operatorRole->permissions()->sync($operatorPerms);

        // 4. Create Users
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password')]
        );
        $adminUser->roles()->sync([$adminRole->id]);

        $opUser = User::updateOrCreate(
            ['email' => 'operator@example.com'],
            ['name' => 'Operator User', 'password' => Hash::make('password')]
        );
        $opUser->roles()->sync([$operatorRole->id]);

        // 5. Create Root Menus (Categories)
        Menu::updateOrCreate(
            ['url' => '/dashboard'],
            ['title' => 'Dashboard', 'icon' => 'fas fa-home', 'permission_slug' => 'view_dashboard', 'order' => 1]
        );

        Menu::updateOrCreate(
            ['title' => 'Manajemen Konten'],
            ['url' => null, 'icon' => 'fas fa-edit', 'permission_slug' => null, 'order' => 2]
        );

        Menu::updateOrCreate(
            ['title' => 'Profil Lembaga'],
            ['url' => null, 'icon' => 'fas fa-university', 'permission_slug' => null, 'order' => 3]
        );

        $systemMenu = Menu::updateOrCreate(
            ['title' => 'Pengaturan Sistem'],
            ['url' => null, 'icon' => 'fas fa-cogs', 'permission_slug' => null, 'order' => 4]
        );

        // Sub Menus for Pengaturan Sistem
        Menu::updateOrCreate(
            ['url' => '/users'],
            ['title' => 'Manajemen User', 'icon' => 'fas fa-users', 'parent_id' => $systemMenu->id, 'permission_slug' => 'users_view', 'order' => 1]
        );

        Menu::updateOrCreate(
            ['url' => '/roles'],
            ['title' => 'Role & Hak Akses', 'icon' => 'fas fa-user-shield', 'parent_id' => $systemMenu->id, 'permission_slug' => 'roles_view', 'order' => 2]
        );

        Menu::updateOrCreate(
            ['url' => '/permissions'],
            ['title' => 'Daftar Izin (Permissions)', 'icon' => 'fas fa-key', 'parent_id' => $systemMenu->id, 'permission_slug' => 'permissions_view', 'order' => 3]
        );

        Menu::updateOrCreate(
            ['url' => '/menus'],
            ['title' => 'Manajemen Menu', 'icon' => 'fas fa-list', 'parent_id' => $systemMenu->id, 'permission_slug' => 'menus_view', 'order' => 5]
        );
    }
}
