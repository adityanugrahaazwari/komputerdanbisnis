@extends('layouts.app')

@section('header', 'Create Role')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-4xl mx-auto">
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Role Name</label>
            <input type="text" name="name" placeholder="e.g. Editor" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Assign Permissions</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded border">
                @foreach($permissions as $permission)
                <label class="inline-flex items-center">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-checkbox h-5 w-5 text-green-600">
                    <span class="ml-2 text-gray-700 text-sm">{{ $permission->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div class="flex items-center justify-end">
            <a href="{{ route('roles.index') }}" class="mr-4 text-gray-600 hover:underline">Cancel</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Save Role
            </button>
        </div>
    </form>
</div>
@endsection
