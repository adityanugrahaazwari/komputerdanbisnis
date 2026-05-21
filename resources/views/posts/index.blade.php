@extends('layouts.app')

@section('header', 'Post Management')

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between mb-4">
        <h3 class="text-lg font-semibold">List of Posts</h3>
        @can('posts_create')
            <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Add New Post</a>
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
                <th class="py-2 px-4 border-b text-left">Title</th>
                <th class="py-2 px-4 border-b text-left">Author</th>
                <th class="py-2 px-4 border-b text-left">Status</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td class="py-2 px-4 border-b text-center">{{ $post->id }}</td>
                <td class="py-2 px-4 border-b">{{ $post->title }}</td>
                <td class="py-2 px-4 border-b">{{ $post->user->name }}</td>
                <td class="py-2 px-4 border-b">
                    @php
                        $statusClasses = [
                            'draft' => 'bg-gray-200 text-gray-800',
                            'pending' => 'bg-yellow-200 text-yellow-800',
                            'published' => 'bg-green-200 text-green-800',
                            'rejected' => 'bg-red-200 text-red-800',
                        ];
                        $statusLabels = [
                            'draft' => 'Draft',
                            'pending' => 'Pending Review',
                            'published' => 'Published',
                            'rejected' => 'Rejected',
                        ];
                    @endphp
                    <span class="{{ $statusClasses[$post->status] ?? 'bg-gray-200' }} rounded px-2 py-1 text-xs">
                        {{ $statusLabels[$post->status] ?? ucfirst($post->status) }}
                    </span>
                </td>
                <td class="py-2 px-4 border-b text-center">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-green-500 hover:underline mr-2">View</a>
                    @can('posts_edit')
                        @if(auth()->user()->can('posts_publish') || $post->user_id === auth()->id())
                            <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                        @endif
                    @endcan
                    @can('posts_delete')
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
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
        {{ $posts->links() }}
    </div>
</div>
@endsection
