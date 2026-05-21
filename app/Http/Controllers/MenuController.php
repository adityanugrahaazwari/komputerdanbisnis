<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $this->authorizePermission('menus_view');
        $menus = Menu::with('parent')->orderBy('order')->paginate(15);
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        $this->authorizePermission('menus_create');
        $parentMenus = Menu::whereNull('parent_id')->get();
        $permissions = Permission::all();
        return view('menus.create', compact('parentMenus', 'permissions'));
    }

    public function store(Request $request)
    {
        $this->authorizePermission('menus_create');
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'permission_slug' => 'nullable|string|max:255',
            'order' => 'required|integer',
        ]);

        Menu::create([
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'permission_slug' => $request->permission_slug,
            'order' => $request->order,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        $this->authorizePermission('menus_edit');
        $parentMenus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->get();
        $permissions = Permission::all();
        return view('menus.edit', compact('menu', 'parentMenus', 'permissions'));
    }

    public function update(Request $request, Menu $menu)
    {
        $this->authorizePermission('menus_edit');
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'permission_slug' => 'nullable|string|max:255',
            'order' => 'required|integer',
        ]);

        $menu->update([
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'permission_slug' => $request->permission_slug,
            'order' => $request->order,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $this->authorizePermission('menus_delete');
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu deleted successfully.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
