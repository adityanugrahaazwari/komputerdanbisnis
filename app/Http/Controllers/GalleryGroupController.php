<?php

namespace App\Http\Controllers;

use App\Models\GalleryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryGroupController extends Controller
{
    public function index()
    {
        $this->authorizePermission('galleries_view');
        $groups = GalleryGroup::latest()->paginate(10);
        return view('gallery_groups.index', compact('groups'));
    }

    public function create()
    {
        $this->authorizePermission('galleries_create');
        return view('gallery_groups.create');
    }

    public function store(Request $request)
    {
        $this->authorizePermission('galleries_create');
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description']);
        $data['slug'] = Str::slug($request->name);

        GalleryGroup::create($data);

        return redirect()->route('gallery-groups.index')->with('success', 'Grup Galeri berhasil ditambahkan.');
    }

    public function edit(GalleryGroup $galleryGroup)
    {
        $this->authorizePermission('galleries_edit');
        return view('gallery_groups.edit', compact('galleryGroup'));
    }

    public function update(Request $request, GalleryGroup $galleryGroup)
    {
        $this->authorizePermission('galleries_edit');
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description', 'is_active']);
        $data['slug'] = Str::slug($request->name);

        $galleryGroup->update($data);

        return redirect()->route('gallery-groups.index')->with('success', 'Grup Galeri berhasil diperbarui.');
    }

    public function destroy(GalleryGroup $galleryGroup)
    {
        $this->authorizePermission('galleries_delete');
        $galleryGroup->delete();
        return redirect()->route('gallery-groups.index')->with('success', 'Grup Galeri berhasil dihapus.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
