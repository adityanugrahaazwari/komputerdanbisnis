@extends('layouts.app')

@section('header', 'Tambah Program Studi')

@section('content')
<div class="bg-white rounded shadow p-6">
    <form action="{{ route('study_programs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama Program Studi</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Kode Prodi</label>
                <input type="text" name="code" class="w-full border rounded px-3 py-2 @error('code') border-red-500 @enderror" value="{{ old('code') }}">
                @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Jenjang (Level)</label>
                <select name="level" class="w-full border rounded px-3 py-2">
                    <option value="D3">D3</option>
                    <option value="D4">D4</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Gambar / Logo</label>
                <input type="file" name="image" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Website Program Studi (URL)</label>
                <input type="url" name="website_url" class="w-full border rounded px-3 py-2 @error('website_url') border-red-500 @enderror" value="{{ old('website_url') }}" placeholder="https://prodi.politala.ac.id">
                @error('website_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Deskripsi</label>
            <textarea name="description" rows="5" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                <span class="text-gray-700 font-bold">Aktif</span>
            </label>
        </div>

        <div class="mt-12 flex justify-end gap-4">
            <a href="{{ route('study_programs.index') }}" class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                Batal
            </a>
            <button type="submit" class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center justify-center group">
                <i class="fas fa-save mr-3 group-hover:rotate-12 transition-transform"></i>
                Simpan Program Studi
            </button>
        </div>
    </form>
</div>
@endsection
