<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use App\Models\GalleryGroup;
use App\Traits\UploadsFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    use UploadsFiles;

    public function index()
    {
        $this->authorizePermission('galleries_view');
        $galleries = Gallery::with('group')->ordered()->paginate(12);
        return view('galleries.index', compact('galleries'));
    }

    public function create()
    {
        $this->authorizePermission('galleries_create');
        $groups = GalleryGroup::active()->get();
        return view('galleries.create', compact('groups'));
    }

    public function store(GalleryRequest $request)
    {
        $this->authorizePermission('galleries_create');
        
        $validated = $request->validated();

        $data = $request->only(['gallery_group_id', 'title', 'description', 'order']);
        $data['image'] = $this->uploadFile($request->file('image'), 'gallery');

        Gallery::create($data);

        return redirect()->route('galleries.index')->with('success', 'Image added to gallery.');
    }

    public function edit(Gallery $gallery)
    {
        $this->authorizePermission('galleries_edit');
        $groups = GalleryGroup::active()->get();
        return view('galleries.edit', compact('gallery', 'groups'));
    }

    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $this->authorizePermission('galleries_edit');
        
        $validated = $request->validated();

        $data = $request->only(['gallery_group_id', 'title', 'description', 'order', 'is_active']);

        
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'gallery', $gallery->image);
        }

        $gallery->update($data);

        return redirect()->route('galleries.index')->with('success', 'Gallery item updated.');
    }

    public function destroy(Gallery $gallery)
    {
        $this->authorizePermission('galleries_delete');
        $this->deleteFile($gallery->image);
        $gallery->delete();
        return redirect()->route('galleries.index')->with('success', 'Gallery item deleted.');
    }
}
