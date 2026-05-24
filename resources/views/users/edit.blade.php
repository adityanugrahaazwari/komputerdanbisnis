@extends('layouts.app')

@section('header', 'Edit User: ' . $user->name)

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl mx-auto">
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password (Leave blank to keep current)</label>
            <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Assign Roles</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($roles as $role)
                <label class="inline-flex items-center">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ in_array($role->id, $userRoles) ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="ml-2 text-gray-700">{{ $role->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div class="mt-12 flex justify-end gap-4">
            <a href="{{ route('users.index') }}" 
               class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                Batal
            </a>
            <button type="submit" 
                    class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center justify-center group">
                <span>Perbarui User</span>
                <i class="fas fa-save ml-3 group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>
    </form>
</div>
@endsection
