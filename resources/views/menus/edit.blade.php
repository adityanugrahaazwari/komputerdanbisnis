@extends('layouts.app')

@section('header', 'Edit Menu: ' . $menu->title)

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl mx-auto">
    <form action="{{ route('menus.update', $menu->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input type="text" name="title" value="{{ $menu->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Icon (FontAwesome)</label>
                <input type="text" name="icon" value="{{ $menu->icon }}" placeholder="fas fa-link" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">URL / Route</label>
            <input type="text" name="url" value="{{ $menu->url }}" placeholder="/example" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Parent Menu</label>
                <select name="parent_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">None (Root)</option>
                    @foreach($parentMenus as $parent)
                        <option value="{{ $parent->id }}" {{ $menu->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Required Permission</label>
                <select name="permission_slug" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">None (Public)</option>
                    @foreach($permissions as $perm)
                        <option value="{{ $perm->slug }}" {{ $menu->permission_slug == $perm->slug ? 'selected' : '' }}>{{ $perm->name }} ({{ $perm->slug }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Order</label>
            <input type="number" name="order" value="{{ $menu->order }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ $menu->is_active ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2 text-gray-700 font-bold">Is Active</span>
            </label>
        </div>

        <div class="flex items-center justify-end">
            <a href="{{ route('menus.index') }}" class="mr-4 text-gray-600 hover:underline">Cancel</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Menu
            </button>
        </div>
    </form>
</div>
@endsection
