@extends('layouts.app')

@section('header', 'Edit Grup Galeri')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800 max-w-3xl mx-auto">
    <div class="mb-8">
        <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Perbarui Grup</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Ubah informasi grup galeri yang ada.</p>
    </div>

    <form action="{{ route('gallery-groups.update', $galleryGroup->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Nama Grup</label>
                <input type="text" name="name" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white" value="{{ old('name', $galleryGroup->name) }}">
                @error('name') <span class="text-red-500 text-xs ml-4">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4">Deskripsi (Opsional)</label>
                <textarea name="description" rows="4" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-red-600 transition-all font-bold text-gray-900 dark:text-white">{{ old('description', $galleryGroup->description) }}</textarea>
                @error('description') <span class="text-red-500 text-xs ml-4">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-4 ml-4 mt-6">
                <input type="hidden" name="is_active" value="0">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $galleryGroup->is_active ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                    <span class="ml-3 text-xs font-black text-gray-600 dark:text-gray-400 uppercase tracking-widest">Grup Aktif</span>
                </label>
            </div>
        </div>

        <div class="mt-12 flex justify-end gap-4">
            <a href="{{ route('gallery-groups.index') }}" class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                Batal
            </a>
            <button type="submit" class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center justify-center group">
                <i class="fas fa-save mr-3 group-hover:rotate-12 transition-transform"></i>
                Perbarui Grup
            </button>
        </div>
    </form>
</div>
@endsection
