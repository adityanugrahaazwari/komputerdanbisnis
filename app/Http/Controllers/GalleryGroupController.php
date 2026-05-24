<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryGroupRequest;
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

    public function store(GalleryGroupRequest $request)
    {
        $this->authorizePermission('galleries_create');
        
        $validated = $request->validated();

        $data = $request->only(['name', 'description']);
        $data['slug'] = Str::slug($validated['name']);

        GalleryGroup::create($data);

        return redirect()->route('gallery-groups.index')->with('success', 'Grup Galeri berhasil ditambahkan.');
    }

    public function edit(GalleryGroup $galleryGroup)
    {
        $this->authorizePermission('galleries_edit');
        return view('gallery_groups.edit', compact('galleryGroup'));
    }

    public function update(GalleryGroupRequest $request, GalleryGroup $galleryGroup)
    {
        $this->authorizePermission('galleries_edit');
        
        $validated = $request->validated();

        $data = $request->only(['name', 'description', 'is_active']);
        $data['slug'] = Str::slug($validated['name']);

        $galleryGroup->update($data);

        return redirect()->route('gallery-groups.index')->with('success', 'Grup Galeri berhasil diperbarui.');
    }

    public function destroy(GalleryGroup $galleryGroup)
    {
        $this->authorizePermission('galleries_delete');
        $galleryGroup->delete();
        return redirect()->route('gallery-groups.index')->with('success', 'Grup Galeri berhasil dihapus.');
    }
}
