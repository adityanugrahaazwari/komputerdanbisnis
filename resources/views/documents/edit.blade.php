@extends('layouts.app')

@section('header', 'Edit Dokumen')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="mb-8">
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Perbarui Informasi Dokumen</h3>
            <p class="text-gray-500 text-sm">Sesuaikan judul, kategori, atau ganti file dokumen.</p>
        </div>

        <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Judul Dokumen</label>
                    <input type="text" name="title" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none @error('title') border-red-500 @enderror" value="{{ old('title', $document->title) }}" required>
                    @error('title') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Kategori</label>
                    <input type="text" name="category" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" value="{{ old('category', $document->category) }}">
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Status</label>
                    <select name="is_active" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none">
                        <option value="1" {{ $document->is_active ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !$document->is_active ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Ganti File (Kosongkan jika tidak diganti)</label>
                    <div class="flex items-center gap-6 p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <div class="w-16 h-16 bg-white rounded-xl shadow-sm flex items-center justify-center text-red-600">
                            <i class="fas fa-file-alt text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-gray-900 truncate max-w-xs">{{ basename($document->file_path) }}</p>
                            <input type="file" name="file" class="mt-2 text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition">
                        </div>
                    </div>
                    @error('file') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Keterangan (Opsional)</label>
                    <textarea name="description" rows="4" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none">{{ old('description', $document->description) }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-4 border-t border-gray-50 pt-8">
                <button type="submit" class="bg-red-700 text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition shadow-lg shadow-red-200">
                    Update Dokumen
                </button>
                <a href="{{ route('documents.index') }}" class="text-gray-500 font-bold text-sm hover:text-gray-900 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
