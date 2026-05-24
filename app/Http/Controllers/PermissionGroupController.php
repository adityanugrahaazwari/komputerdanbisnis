<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;
use App\Http\Requests\PermissionGroupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionGroupController extends Controller
{
    public function index()
    {
        $this->authorizePermission('permission_groups_view');
        $groups = PermissionGroup::withCount('permissions')->paginate(15);
        return view('permission_groups.index', compact('groups'));
    }

    public function create()
    {
        $this->authorizePermission('permission_groups_create');
        return view('permission_groups.create');
    }

    public function store(PermissionGroupRequest $request)
    {
        $this->authorizePermission('permission_groups_create');

        PermissionGroup::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('permission-groups.index')->with('success', 'Permission group created successfully.');
    }

    public function edit(PermissionGroup $permissionGroup)
    {
        $this->authorizePermission('permission_groups_edit');
        return view('permission_groups.edit', compact('permissionGroup'));
    }

    public function update(PermissionGroupRequest $request, PermissionGroup $permissionGroup)
    {
        $this->authorizePermission('permission_groups_edit');

        $permissionGroup->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('permission-groups.index')->with('success', 'Permission group updated successfully.');
    }

    public function destroy(PermissionGroup $permissionGroup)
    {
        $this->authorizePermission('permission_groups_delete');
        
        if ($permissionGroup->permissions()->exists()) {
            return back()->with('error', 'Cannot delete group that has permissions assigned.');
        }

        $permissionGroup->delete();
        return redirect()->route('permission-groups.index')->with('success', 'Permission group deleted successfully.');
    }
}
