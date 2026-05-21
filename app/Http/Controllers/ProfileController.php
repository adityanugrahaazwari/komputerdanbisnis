<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $this->authorizePermission('profiles_view');
        $profiles = Profile::all();
        return view('profiles.index', compact('profiles'));
    }

    public function edit(Profile $profile)
    {
        $this->authorizePermission('profiles_edit');
        return view('profiles.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $this->authorizePermission('profiles_edit');
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120' // 5MB for structure images
        ]);

        $data = $request->only(['title', 'content']);

        if ($request->hasFile('image')) {
            if ($profile->image) {
                Storage::disk('public')->delete($profile->image);
            }
            $data['image'] = $request->file('image')->store('profiles', 'public');
        }

        $profile->update($data);

        return redirect()->route('profiles.index')->with('success', $profile->title . ' updated successfully.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
