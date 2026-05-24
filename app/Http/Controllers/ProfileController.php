<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\ProfileRequest;
use App\Traits\UploadsFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use UploadsFiles;

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

    public function update(ProfileRequest $request, Profile $profile)
    {
        $this->authorizePermission('profiles_edit');
        
        $data = $request->only(['title', 'content']);
        $data['content'] = clean($request->content);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'profiles', $profile->image);
        }

        $profile->update($data);

        return redirect()->route('profiles.index')->with('success', $profile->title . ' updated successfully.');
    }
}
