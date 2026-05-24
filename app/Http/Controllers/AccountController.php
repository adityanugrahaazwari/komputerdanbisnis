<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('account.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(AccountRequest $request)
    {
        $user = $request->user();
        
        $validated = $request->validated();

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the change password form.
     */
    public function password()
    {
        return view('account.password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(AccountRequest $request)
    {
        $validated = $request->validated();

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
