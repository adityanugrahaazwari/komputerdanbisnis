<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Permission;
use App\Http\Requests\MenuRequest;

class MenuController extends Controller
{
    public function index()
    {
        $this->authorizePermission('menus_view');
        $menus = Menu::with('parent')->ordered()->paginate(15);
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        $this->authorizePermission('menus_create');
        $parentMenus = Menu::whereNull('parent_id')->get();
        $permissions = Permission::all();
        return view('menus.create', compact('parentMenus', 'permissions'));
    }

    public function store(MenuRequest $request)
    {
        $this->authorizePermission('menus_create');

        Menu::create([
            'title' => $request->title,
            'url' => $request->url,
            'location' => $request->location,
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
        $parentMenus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->where('location', $menu->location)->get();
        $permissions = Permission::all();
        return view('menus.edit', compact('menu', 'parentMenus', 'permissions'));
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $this->authorizePermission('menus_edit');

        $menu->update([
            'title' => $request->title,
            'url' => $request->url,
            'location' => $request->location,
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
}
