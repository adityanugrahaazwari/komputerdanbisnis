@extends('layouts.app')

@section('header', 'Edit Sosial Media')

@section('content')
<div class="bg-white rounded shadow p-6">
    <form action="{{ route('social_media.update', $socialMedia->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Platform</label>
                <input type="text" name="platform" class="w-full border rounded px-3 py-2 @error('platform') border-red-500 @enderror" value="{{ old('platform', $socialMedia->platform) }}">
                @error('platform') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">URL</label>
                <input type="url" name="url" class="w-full border rounded px-3 py-2 @error('url') border-red-500 @enderror" value="{{ old('url', $socialMedia->url) }}">
                @error('url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">FontAwesome Icon Class</label>
                <input type="text" name="icon" class="w-full border rounded px-3 py-2 @error('icon') border-red-500 @enderror" value="{{ old('icon', $socialMedia->icon) }}">
                <p class="text-xs text-gray-500 mt-1">Cari di <a href="https://fontawesome.com/icons" target="_blank" class="text-blue-500 underline">FontAwesome</a></p>
                @error('icon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Urutan (Order)</label>
                <input type="number" name="order" class="w-full border rounded px-3 py-2" value="{{ old('order', $socialMedia->order) }}">
            </div>
        </div>

        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ $socialMedia->is_active ? 'checked' : '' }} class="mr-2">
                <span class="text-gray-700 font-bold">Aktif</span>
            </label>
        </div>

        <div class="mt-12 flex justify-end gap-4">
            <a href="{{ route('social_media.index') }}" 
               class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                Batal
            </a>
            <button type="submit" 
                    class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center justify-center group">
                <span>Perbarui Sosmed</span>
                <i class="fas fa-save ml-3 group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>
    </form>
</div>
@endsection
