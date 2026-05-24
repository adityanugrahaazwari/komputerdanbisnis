<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use App\Http\Requests\SocialMediaRequest;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function index()
    {
        $this->authorizePermission('social_media_view');
        $socials = SocialMedia::ordered()->get();
        return view('social_media.index', compact('socials'));
    }

    public function create()
    {
        $this->authorizePermission('social_media_create');
        return view('social_media.create');
    }

    public function store(SocialMediaRequest $request)
    {
        $this->authorizePermission('social_media_create');

        SocialMedia::create($request->all());

        return redirect()->route('social_media.index')->with('success', 'Sosial Media berhasil ditambahkan.');
    }

    public function edit(SocialMedia $socialMedia)
    {
        $this->authorizePermission('social_media_edit');
        return view('social_media.edit', compact('socialMedia'));
    }

    public function update(SocialMediaRequest $request, SocialMedia $socialMedia)
    {
        $this->authorizePermission('social_media_edit');

        $socialMedia->update($request->all());

        return redirect()->route('social_media.index')->with('success', 'Sosial Media berhasil diperbarui.');
    }

    public function destroy(SocialMedia $socialMedia)
    {
        $this->authorizePermission('social_media_delete');
        $socialMedia->delete();
        return redirect()->route('social_media.index')->with('success', 'Sosial Media berhasil dihapus.');
    }
}
