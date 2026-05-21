@extends('layouts.app')

@section('header', 'Create Permission Group')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl p-8 md:p-10 max-w-2xl mx-auto border border-gray-100 dark:border-slate-800">
    <form action="{{ route('permission-groups.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <div>
            <label class="block text-gray-700 dark:text-gray-300 text-xs font-black uppercase tracking-widest mb-3 ml-1">Nama Grup (Group Name)</label>
            <input type="text" name="name" placeholder="Contoh: News Management" class="w-full px-4 py-4 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 outline-none transition-all dark:text-white font-medium" required>
            <p class="text-gray-500 text-[10px] mt-2 ml-1 italic tracking-wide uppercase">Gunakan nama yang deskriptif untuk mengelompokkan izin akses.</p>
        </div>

        <div class="flex items-center justify-between pt-8 border-t border-gray-100 dark:border-slate-800">
            <a href="{{ route('permission-groups.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-red-600 font-bold uppercase text-xs tracking-widest transition">
                <i class="fas fa-arrow-left mr-2"></i> Batal
            </a>
            <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-black px-10 py-4 rounded-2xl shadow-xl shadow-red-200 dark:shadow-none uppercase tracking-widest text-sm transition transform active:scale-95">
                <i class="fas fa-save mr-2"></i> Simpan Grup
            </button>
        </div>
    </form>
</div>
@endsection
