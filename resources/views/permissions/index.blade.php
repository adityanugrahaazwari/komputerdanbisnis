@extends('layouts.app')

@section('header', 'Permission Management')

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between mb-4">
        <h3 class="text-lg font-semibold">List of Permissions</h3>
        @can('permissions_create')
            <a href="{{ route('permissions.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Add New Permission</a>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b text-left">Name</th>
                <th class="py-2 px-4 border-b text-left">Slug</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
            <tr>
                <td class="py-2 px-4 border-b text-center">{{ $permission->id }}</td>
                <td class="py-2 px-4 border-b">{{ $permission->name }}</td>
                <td class="py-2 px-4 border-b"><code>{{ $permission->slug }}</code></td>
                <td class="py-2 px-4 border-b text-center">
                    @can('permissions_edit')
                        <a href="{{ route('permissions.edit', $permission->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                    @endcan
                    @can('permissions_delete')
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $permissions->links() }}
    </div>
</div>
@endsection
