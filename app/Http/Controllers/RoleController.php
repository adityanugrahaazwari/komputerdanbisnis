<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorizePermission('roles_view');
        $roles = Role::with('permissions')->paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorizePermission('roles_create');
        $permissions = Permission::with('group')->get()->groupBy(function($item) {
            return $item->group ? $item->group->name : 'Lainnya';
        });
        return view('roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $this->authorizePermission('roles_create');

        $role = Role::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $this->authorizePermission('roles_edit');
        $permissions = Permission::with('group')->get()->groupBy(function($item) {
            return $item->group ? $item->group->name : 'Lainnya';
        });
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $this->authorizePermission('roles_edit');

        $role->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $this->authorizePermission('roles_delete');
        if ($role->slug === 'admin') {
            return back()->with('error', 'Cannot delete admin role.');
        }
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
