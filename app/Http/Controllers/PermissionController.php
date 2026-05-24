<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        $this->authorizePermission('permissions_view');
        $permissions = Permission::with('group')->paginate(15);
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        $this->authorizePermission('permissions_create');
        $groups = PermissionGroup::all();
        return view('permissions.create', compact('groups'));
    }

    public function store(PermissionRequest $request)
    {
        $this->authorizePermission('permissions_create');

        Permission::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '_'),
            'permission_group_id' => $request->permission_group_id,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        $this->authorizePermission('permissions_edit');
        $groups = PermissionGroup::all();
        return view('permissions.edit', compact('permission', 'groups'));
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $this->authorizePermission('permissions_edit');

        $permission->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '_'),
            'permission_group_id' => $request->permission_group_id,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $this->authorizePermission('permissions_delete');
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
