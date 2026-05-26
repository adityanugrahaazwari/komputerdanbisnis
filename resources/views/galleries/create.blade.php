@extends('layouts.app')

@section('header', 'Tambah Foto')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="mb-8">
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Upload Foto Baru</h3>
            <p class="text-gray-500 text-sm">Tambahkan gambar ke galeri untuk dilihat oleh publik.</p>
        </div>

        <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Judul Foto</label>
                    <input type="text" name="title" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none @error('title') border-red-500 @enderror" value="{{ old('title') }}" placeholder="Contoh: Kegiatan Workshop">
                    @error('title') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Grup (Album)</label>
                    <select name="gallery_group_id" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none">
                        <option value="">-- Tanpa Grup --</option>
                        @if(isset($groups))
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}" {{ old('gallery_group_id') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Urutan Tampilan</label>
                    <input type="number" name="order" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" value="{{ old('order', 0) }}">
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Pilih File Gambar</label>
                    <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:uppercase file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition">
                    <p class="text-[10px] text-gray-400 mt-2 italic font-bold">Rekomendasi ukuran: 1:1 (Square, e.g. 1000x1000px). Max: 5MB.</p>
                    @error('image') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" rows="4" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" placeholder="Berikan deskripsi singkat tentang foto ini...">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="mt-12 flex justify-end gap-4">
                <a href="{{ route('galleries.index') }}" 
                   class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center justify-center group">
                    <span>Simpan Galeri</span>
                    <i class="fas fa-save ml-3 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
