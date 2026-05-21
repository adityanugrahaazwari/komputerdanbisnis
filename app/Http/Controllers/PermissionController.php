<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        $this->authorizePermission('permissions_view');
        $permissions = Permission::paginate(15);
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        $this->authorizePermission('permissions_create');
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $this->authorizePermission('permissions_create');
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'group' => 'nullable|string|max:255'
        ]);

        Permission::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '_'),
            'group' => $request->group,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        $this->authorizePermission('permissions_edit');
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $this->authorizePermission('permissions_edit');
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'group' => 'nullable|string|max:255'
        ]);

        $permission->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '_'),
            'group' => $request->group,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $this->authorizePermission('permissions_delete');
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
