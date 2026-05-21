@extends('layouts.app')

@section('header', 'Menu Management')

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between mb-4">
        <h3 class="text-lg font-semibold">List of Menus</h3>
        @can('menus_create')
            <a href="{{ route('menus.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Add New Menu</a>
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
                <th class="py-2 px-4 border-b text-left">Order</th>
                <th class="py-2 px-4 border-b text-left">Title</th>
                <th class="py-2 px-4 border-b text-left">Parent</th>
                <th class="py-2 px-4 border-b text-left">URL</th>
                <th class="py-2 px-4 border-b text-left">Permission</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
            <tr>
                <td class="py-2 px-4 border-b">{{ $menu->order }}</td>
                <td class="py-2 px-4 border-b">
                    <i class="{{ $menu->icon }} mr-2"></i> {{ $menu->title }}
                </td>
                <td class="py-2 px-4 border-b text-gray-500 text-sm">
                    {{ $menu->parent ? $menu->parent->title : '-' }}
                </td>
                <td class="py-2 px-4 border-b text-sm"><code>{{ $menu->url ?: '#' }}</code></td>
                <td class="py-2 px-4 border-b text-sm text-blue-600">{{ $menu->permission_slug ?: 'Public' }}</td>
                <td class="py-2 px-4 border-b text-center">
                    @if($menu->is_active)
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Active</span>
                    @else
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Inactive</span>
                    @endif
                </td>
                <td class="py-2 px-4 border-b text-center">
                    @can('menus_edit')
                        <a href="{{ route('menus.edit', $menu->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                    @endcan
                    @can('menus_delete')
                        <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
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
        {{ $menus->links() }}
    </div>
</div>
@endsection
