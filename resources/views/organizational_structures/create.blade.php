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
            <input type="text" name="name" placeholder="e.g. Dr. John Doe, M.Kom" class="w-full px-4 py-4 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 outline-none transition-all dark:text-white font-medium">
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-300 text-xs font-black uppercase tracking-widest mb-3 ml-1">Jabatan</label>
            <input type="text" name="position" placeholder="e.g. Ketua Program Studi" class="w-full px-4 py-4 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 outline-none transition-all dark:text-white font-medium">
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

        <div class="mt-12 flex justify-end gap-4">
            <a href="{{ route('organizational-structures.index') }}" 
               class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                Batal
            </a>
            <button type="submit" 
                    class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center justify-center group">
                <span>Simpan Struktur</span>
                <i class="fas fa-save ml-3 group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>
    </form>
</div>
@endsection
