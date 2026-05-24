@extends('layouts.app')

@section('header', 'Add New Category')

@section('content')
<div class="bg-white rounded shadow p-6">
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" value="{{ old('name') }}">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-12 flex justify-end gap-4">
            <a href="{{ route('categories.index') }}" class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                Batal
            </a>
            <button type="submit" class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center justify-center group">
                <i class="fas fa-save mr-3 group-hover:rotate-12 transition-transform"></i>
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection
