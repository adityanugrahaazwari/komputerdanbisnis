@extends('layouts.app')

@section('header', 'Create Post')

@section('content')
<div class="bg-white rounded shadow p-6">
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Title</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Content</label>
            <textarea name="content" rows="10" class="w-full border rounded px-3 py-2 @error('content') border-red-500 @enderror" required>{{ old('content') }}</textarea>
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Image</label>
            <input type="file" name="image" class="w-full border rounded px-3 py-2 @error('image') border-red-500 @enderror">
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2 @error('status') border-red-500 @enderror">
                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Simpan)</option>
                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending (Ajukan Review)</option>
                @can('posts_publish')
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published (Terbitkan)</option>
                    <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>Rejected (Tolak)</option>
                @endcan
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Notes (Catatan Pengajuan/Review)</label>
            <textarea name="notes" rows="3" class="w-full border rounded px-3 py-2 @error('notes') border-red-500 @enderror" placeholder="Berikan catatan singkat jika diperlukan">{{ old('notes') }}</textarea>
            @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Create Post</button>
            <a href="{{ route('posts.index') }}" class="text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection
