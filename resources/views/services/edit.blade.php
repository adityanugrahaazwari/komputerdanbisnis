@extends('layouts.app')

@section('header', 'Edit Layanan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="mb-8">
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Edit Layanan</h3>
            <p class="text-gray-500 text-sm">Perbarui informasi atau tautan layanan eksternal.</p>
        </div>

        <form action="{{ route('services.update', $service->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Judul Layanan</label>
                    <input type="text" name="title" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none @error('title') border-red-500 @enderror" value="{{ old('title', $service->title) }}" required>
                    @error('title') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">URL Website</label>
                    <input type="url" name="url" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none @error('url') border-red-500 @enderror" value="{{ old('url', $service->url) }}" required>
                    @error('url') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Icon FontAwesome</label>
                    <input type="text" name="icon" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" value="{{ old('icon', $service->icon) }}">
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Urutan Tampilan</label>
                    <input type="number" name="order" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" value="{{ old('order', $service->order) }}">
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Status</label>
                    <select name="is_active" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none">
                        <option value="1" {{ $service->is_active ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !$service->is_active ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none">{{ old('description', $service->description) }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-4 border-t border-gray-50 pt-8">
                <button type="submit" class="bg-red-700 text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition shadow-lg shadow-red-200">
                    Update Layanan
                </button>
                <a href="{{ route('services.index') }}" class="text-gray-500 font-bold text-sm hover:text-gray-900 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
