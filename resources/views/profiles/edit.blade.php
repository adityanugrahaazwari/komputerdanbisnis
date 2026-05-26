@extends('layouts.app')

@section('header', 'Edit Profil: ' . ucfirst($profile->key))

@section('content')
<div class="bg-white rounded shadow p-6">
    <form action="{{ route('profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Judul (Title)</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror" value="{{ old('title', $profile->title) }}">
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Konten (Content)</label>
            <textarea name="content" rows="10" class="w-full border rounded px-3 py-2 @error('content') border-red-500 @enderror">{{ old('content', $profile->content) }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Gunakan paragraf untuk memisahkan teks.</p>
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Gambar / Struktur (Image)</label>
            @if($profile->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $profile->image) }}" alt="{{ $profile->title }}" class="h-48 object-contain rounded border">
                </div>
            @endif
            <input type="file" name="image" class="w-full border rounded px-3 py-2 @error('image') border-red-500 @enderror">
            <p class="text-[10px] text-gray-400 mt-1 italic">Rekomendasi ukuran: 16:9 (Contoh: 1200x675px). Khusus untuk Struktur Organisasi, disarankan upload gambar diagram. Kosongkan jika tidak ingin mengubah.</p>
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between border-t pt-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded font-bold">Simpan Perubahan</button>
            <a href="{{ route('profiles.index') }}" class="text-gray-600 hover:underline">Batal</a>
        </div>
    </form>
</div>
@endsection
