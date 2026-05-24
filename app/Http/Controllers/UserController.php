<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $this->authorizePermission('users_view');
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizePermission('users_create');
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $this->authorizePermission('users_create');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->authorizePermission('users_edit');
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorizePermission('users_edit');

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->roles()->sync($request->roles ?? []);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->authorizePermission('users_delete');
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
