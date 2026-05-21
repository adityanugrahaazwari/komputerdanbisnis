<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RbacSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Granular Permissions
        $permissions = [
            ['name' => 'View Dashboard', 'slug' => 'view_dashboard'],
            
            // User Permissions
            ['name' => 'View Users', 'slug' => 'users_view'],
            ['name' => 'Create User', 'slug' => 'users_create'],
            ['name' => 'Edit User', 'slug' => 'users_edit'],
            ['name' => 'Delete User', 'slug' => 'users_delete'],
            
            // Role Permissions
            ['name' => 'View Roles', 'slug' => 'roles_view'],
            ['name' => 'Create Role', 'slug' => 'roles_create'],
            ['name' => 'Edit Role', 'slug' => 'roles_edit'],
            ['name' => 'Delete Role', 'slug' => 'roles_delete'],
            
            // Permission Permissions
            ['name' => 'View Permissions', 'slug' => 'permissions_view'],
            ['name' => 'Create Permission', 'slug' => 'permissions_create'],
            ['name' => 'Edit Permission', 'slug' => 'permissions_edit'],
            ['name' => 'Delete Permission', 'slug' => 'permissions_delete'],
            
            // Menu Permissions
            ['name' => 'View Menus', 'slug' => 'menus_view'],
            ['name' => 'Create Menu', 'slug' => 'menus_create'],
            ['name' => 'Edit Menu', 'slug' => 'menus_edit'],
            ['name' => 'Delete Menu', 'slug' => 'menus_delete'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['slug' => $perm['slug']], $perm);
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

        $opUser2 = User::updateOrCreate(
            ['email' => 'operator2@example.com'],
            ['name' => 'Operator 2', 'password' => Hash::make('password')]
        );
        $opUser2->roles()->sync([$operatorRole->id]);

        // 5. Create Menus
        // Dashboard Menu
        Menu::updateOrCreate(
            ['url' => '/dashboard'],
            ['title' => 'Dashboard', 'icon' => 'fas fa-home', 'permission_slug' => 'view_dashboard', 'order' => 1]
        );

        // Settings Parent Menu (Dropdown)
        $settingsMenu = Menu::updateOrCreate(
            ['title' => 'RBAC Management'],
            ['url' => null, 'icon' => 'fas fa-user-shield', 'permission_slug' => null, 'order' => 2]
        );

        // Sub Menus
        Menu::updateOrCreate(
            ['url' => '/users'],
            ['title' => 'User Management', 'icon' => 'fas fa-users', 'parent_id' => $settingsMenu->id, 'permission_slug' => 'users_view', 'order' => 1]
        );

        Menu::updateOrCreate(
            ['url' => '/roles'],
            ['title' => 'Role Management', 'icon' => 'fas fa-shield-alt', 'parent_id' => $settingsMenu->id, 'permission_slug' => 'roles_view', 'order' => 2]
        );

        Menu::updateOrCreate(
            ['url' => '/permissions'],
            ['title' => 'Permission Management', 'icon' => 'fas fa-key', 'parent_id' => $settingsMenu->id, 'permission_slug' => 'permissions_view', 'order' => 3]
        );

        Menu::updateOrCreate(
            ['url' => '/menus'],
            ['title' => 'Menu Management', 'icon' => 'fas fa-list', 'parent_id' => $settingsMenu->id, 'permission_slug' => 'menus_view', 'order' => 4]
        );
    }
}
