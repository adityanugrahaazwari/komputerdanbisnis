<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function index()
    {
        $this->authorizePermission('social_media_view');
        $socials = SocialMedia::orderBy('order')->get();
        return view('social_media.index', compact('socials'));
    }

    public function create()
    {
        $this->authorizePermission('social_media_create');
        return view('social_media.create');
    }

    public function store(Request $request)
    {
        $this->authorizePermission('social_media_create');
        $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|url',
            'icon' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);

        SocialMedia::create($request->all());

        return redirect()->route('social_media.index')->with('success', 'Sosial Media berhasil ditambahkan.');
    }

    public function edit(SocialMedia $socialMedia)
    {
        $this->authorizePermission('social_media_edit');
        return view('social_media.edit', compact('socialMedia'));
    }

    public function update(Request $request, SocialMedia $socialMedia)
    {
        $this->authorizePermission('social_media_edit');
        $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|url',
            'icon' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $socialMedia->update($request->all());

        return redirect()->route('social_media.index')->with('success', 'Sosial Media berhasil diperbarui.');
    }

    public function destroy(SocialMedia $socialMedia)
    {
        $this->authorizePermission('social_media_delete');
        $socialMedia->delete();
        return redirect()->route('social_media.index')->with('success', 'Sosial Media berhasil dihapus.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
