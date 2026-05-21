@extends('layouts.app')

@section('header', 'Tambah Sosial Media')

@section('content')
<div class="bg-white rounded shadow p-6">
    <form action="{{ route('social_media.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Platform</label>
                <input type="text" name="platform" class="w-full border rounded px-3 py-2 @error('platform') border-red-500 @enderror" value="{{ old('platform') }}" placeholder="Contoh: Facebook, Instagram" required>
                @error('platform') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">URL</label>
                <input type="url" name="url" class="w-full border rounded px-3 py-2 @error('url') border-red-500 @enderror" value="{{ old('url') }}" placeholder="https://..." required>
                @error('url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">FontAwesome Icon Class</label>
                <input type="text" name="icon" class="w-full border rounded px-3 py-2 @error('icon') border-red-500 @enderror" value="{{ old('icon') }}" placeholder="Contoh: fab fa-facebook" required>
                <p class="text-xs text-gray-500 mt-1">Cari di <a href="https://fontawesome.com/icons" target="_blank" class="text-blue-500 underline">FontAwesome</a></p>
                @error('icon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Urutan (Order)</label>
                <input type="number" name="order" class="w-full border rounded px-3 py-2" value="{{ old('order', 0) }}">
            </div>
        </div>

        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                <span class="text-gray-700 font-bold">Aktif</span>
            </label>
        </div>

        <div class="flex items-center justify-between border-t pt-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded font-bold">Simpan</button>
            <a href="{{ route('social_media.index') }}" class="text-gray-600 hover:underline">Batal</a>
        </div>
    </form>
</div>
@endsection
