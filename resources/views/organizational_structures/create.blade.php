@extends('layouts.app')

@section('header', 'Create Structure Element')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl p-8 md:p-10 max-w-2xl mx-auto border border-gray-100 dark:border-slate-800">
    <form action="{{ route('organizational-structures.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <div>
            <label class="block text-gray-700 dark:text-gray-300 text-xs font-black uppercase tracking-widest mb-3 ml-1">Atasan (Parent)</label>
            <select name="parent_id" class="w-full px-4 py-4 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 outline-none transition-all dark:text-white font-medium">
                <option value="">-- Struktur Tertinggi (Root) --</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->position }} - {{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-300 text-xs font-black uppercase tracking-widest mb-3 ml-1">Nama Lengkap</label>
            <input type="text" name="name" placeholder="e.g. Dr. John Doe, M.Kom" class="w-full px-4 py-4 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 outline-none transition-all dark:text-white font-medium" required>
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-300 text-xs font-black uppercase tracking-widest mb-3 ml-1">Jabatan</label>
            <input type="text" name="position" placeholder="e.g. Ketua Program Studi" class="w-full px-4 py-4 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 outline-none transition-all dark:text-white font-medium" required>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 dark:text-gray-300 text-xs font-black uppercase tracking-widest mb-3 ml-1">Urutan</label>
                <input type="number" name="order" value="0" class="w-full px-4 py-4 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 outline-none transition-all dark:text-white font-medium">
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 text-xs font-black uppercase tracking-widest mb-3 ml-1">Foto</label>
                <input type="file" name="image" class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 outline-none transition-all dark:text-white font-medium text-sm">
            </div>
        </div>

        <div class="flex items-center justify-between pt-8 border-t border-gray-100 dark:border-slate-800">
            <a href="{{ route('organizational-structures.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-red-600 font-bold uppercase text-xs tracking-widest transition">
                <i class="fas fa-arrow-left mr-2"></i> Batal
            </a>
            <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-black px-10 py-4 rounded-2xl shadow-xl shadow-red-200 dark:shadow-none uppercase tracking-widest text-sm transition transform active:scale-95">
                <i class="fas fa-save mr-2"></i> Simpan Struktur
            </button>
        </div>
    </form>
</div>
@endsection
