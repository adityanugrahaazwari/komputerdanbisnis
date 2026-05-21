@extends('layouts.app')

@section('header', 'Edit Permission: ' . $permission->name)

@section('content')
<div class="bg-white rounded shadow p-6 max-w-lg mx-auto">
    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Permission Name</label>
            <input type="text" name="name" value="{{ $permission->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="flex items-center justify-end">
            <a href="{{ route('permissions.index') }}" class="mr-4 text-gray-600 hover:underline">Cancel</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Permission
            </button>
        </div>
    </form>
</div>
@endsection
