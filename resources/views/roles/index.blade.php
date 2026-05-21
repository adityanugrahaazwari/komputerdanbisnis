@extends('layouts.app')

@section('header', 'Role Management')

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between mb-4">
        <h3 class="text-lg font-semibold">List of Roles</h3>
        @can('roles_create')
            <a href="{{ route('roles.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Add New Role</a>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b text-left">Name</th>
                <th class="py-2 px-4 border-b text-left">Slug</th>
                <th class="py-2 px-4 border-b text-left">Permissions</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td class="py-2 px-4 border-b text-center">{{ $role->id }}</td>
                <td class="py-2 px-4 border-b font-bold">{{ $role->name }}</td>
                <td class="py-2 px-4 border-b"><code>{{ $role->slug }}</code></td>
                <td class="py-2 px-4 border-b">
                    @foreach($role->permissions as $perm)
                        <span class="bg-green-100 text-green-800 border border-green-200 rounded px-2 py-1 text-xs inline-block mb-1">{{ $perm->name }}</span>
                    @endforeach
                </td>
                <td class="py-2 px-4 border-b text-center">
                    @can('roles_edit')
                        <a href="{{ route('roles.edit', $role->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                    @endcan
                    @can('roles_delete')
                        @if($role->slug !== 'admin')
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                        @endif
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $roles->links() }}
    </div>
</div>
@endsection
