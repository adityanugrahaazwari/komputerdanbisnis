<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $this->authorizePermission('galleries_view');
        $galleries = Gallery::with('group')->orderBy('order')->paginate(12);
        return view('galleries.index', compact('galleries'));
    }

    public function create()
    {
        $this->authorizePermission('galleries_create');
        $groups = GalleryGroup::where('is_active', true)->get();
        return view('galleries.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $this->authorizePermission('galleries_create');
        $request->validate([
            'gallery_group_id' => 'nullable|exists:gallery_groups,id',
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimetypes:image/jpeg,image/png,image/gif|max:5120',
            'order' => 'nullable|integer',
            'description' => 'nullable|string'
        ]);

        $data = $request->only(['gallery_group_id', 'title', 'description', 'order']);
        $file = $request->file('image');
        $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
        $data['image'] = $file->storeAs('gallery', $filename, 'public');

        Gallery::create($data);

        return redirect()->route('galleries.index')->with('success', 'Image added to gallery.');
    }

    public function edit(Gallery $gallery)
    {
        $this->authorizePermission('galleries_edit');
        $groups = GalleryGroup::where('is_active', true)->get();
        return view('galleries.edit', compact('gallery', 'groups'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $this->authorizePermission('galleries_edit');
        $request->validate([
            'gallery_group_id' => 'nullable|exists:gallery_groups,id',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimetypes:image/jpeg,image/png,image/gif|max:5120',
            'order' => 'nullable|integer',
            'description' => 'nullable|string'
        ]);

        $data = $request->only(['gallery_group_id', 'title', 'description', 'order', 'is_active']);

        
        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $file = $request->file('image');
            $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['image'] = $file->storeAs('gallery', $filename, 'public');
        }

        $gallery->update($data);

        return redirect()->route('galleries.index')->with('success', 'Gallery item updated.');
    }

    public function destroy(Gallery $gallery)
    {
        $this->authorizePermission('galleries_delete');
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();
        return redirect()->route('galleries.index')->with('success', 'Gallery item deleted.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
