@extends('layouts.app')

@section('header', 'Buat Pengumuman Baru')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
        <form action="{{ route('announcements.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Judul Pengumuman</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                       class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 focus:bg-white dark:focus:bg-slate-700 transition-all outline-none text-gray-700 dark:text-gray-200 font-bold" 
                       placeholder="Contoh: Pemeliharaan Sistem Mendatang" required>
                @error('title') <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="type" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Tipe Pesan</label>
                <select name="type" id="type" class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 transition-all outline-none text-gray-700 dark:text-gray-200 font-bold">
                    <option value="info">Informasi (Biru)</option>
                    <option value="success">Sukses (Hijau)</option>
                    <option value="warning">Peringatan (Kuning)</option>
                    <option value="danger">Penting/Bahaya (Merah)</option>
                </select>
                @error('type') <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="message" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Isi Pesan</label>
                <textarea name="message" id="message" rows="5" 
                          class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 focus:bg-white dark:focus:bg-slate-700 transition-all outline-none text-gray-700 dark:text-gray-200 font-bold" 
                          placeholder="Tuliskan detail pengumuman di sini..." required>{{ old('message') }}</textarea>
                @error('message') <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
            </div>

            <div class="mt-12 flex justify-end gap-4">
                <a href="{{ route('announcements.index') }}" class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center justify-center group">
                    <i class="fas fa-paper-plane mr-3 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                    Broadcast Pesan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
