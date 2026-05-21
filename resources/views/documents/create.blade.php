@extends('layouts.app')

@section('header', 'Upload Dokumen')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="mb-8">
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Upload File Baru</h3>
            <p class="text-gray-500 text-sm">Tambahkan file PDF atau dokumen lainnya ke sistem.</p>
        </div>

        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Judul Dokumen</label>
                    <input type="text" name="title" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none @error('title') border-red-500 @enderror" value="{{ old('title') }}" placeholder="Contoh: Kalender Akademik 2026/2027" required>
                    @error('title') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Kategori</label>
                    <input type="text" name="category" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" value="{{ old('category') }}" placeholder="Contoh: Akademik, Pengumuman">
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Pilih File</label>
                    <input type="file" name="file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:uppercase file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition" required>
                    <p class="text-[10px] text-gray-400 mt-2 italic">* PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP (Max 10MB)</p>
                    @error('file') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-xs font-black uppercase tracking-widest mb-2">Keterangan (Opsional)</label>
                    <textarea name="description" rows="4" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 transition outline-none" placeholder="Berikan keterangan singkat tentang dokumen ini...">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-4 border-t border-gray-50 pt-8">
                <button type="submit" class="bg-red-700 text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition shadow-lg shadow-red-200">
                    Upload Dokumen
                </button>
                <a href="{{ route('documents.index') }}" class="text-gray-500 font-bold text-sm hover:text-gray-900 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
