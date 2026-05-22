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
            <label class="block text-gray-700 font-bold mb-2">Category</label>
            <select name="category_id" class="w-full border rounded px-3 py-2 @error('category_id') border-red-500 @enderror">
                <option value="">No Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Content</label>
            <textarea name="content" rows="10" class="w-full border rounded px-3 py-2 @error('content') border-red-500 @enderror" required>{{ old('content') }}</textarea>
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4 p-4 bg-gray-50 rounded border border-gray-200">
            <h4 class="font-bold mb-2 text-gray-600 uppercase text-xs">SEO Metadata</h4>
            <div class="mb-3">
                <label class="block text-gray-700 text-sm mb-1">Meta Description (Max 160 chars)</label>
                <input type="text" name="meta_description" class="w-full border rounded px-3 py-2 text-sm @error('meta_description') border-red-500 @enderror" value="{{ old('meta_description') }}" maxlength="160">
                @error('meta_description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-gray-700 text-sm mb-1">Meta Keywords (Comma separated)</label>
                <input type="text" name="meta_keywords" class="w-full border rounded px-3 py-2 text-sm @error('meta_keywords') border-red-500 @enderror" value="{{ old('meta_keywords') }}">
                @error('meta_keywords') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
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

        <div class="mt-12 flex justify-end gap-4">
            <a href="{{ route('posts.index') }}" class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                Batal
            </a>
            <button type="submit" class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center justify-center group">
                <i class="fas fa-save mr-3 group-hover:rotate-12 transition-transform"></i>
                Simpan Post
            </button>
        </div>
    </form>
</div>
@endsection
