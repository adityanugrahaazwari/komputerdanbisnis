@extends('layouts.app')

@section('header', 'Create Role')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl p-8 md:p-10 max-w-5xl mx-auto border border-gray-100 dark:border-slate-800">
    <form action="{{ route('roles.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="block text-gray-700 dark:text-gray-300 text-xs font-black uppercase tracking-widest mb-3 ml-1">Nama Peran (Role Name)</label>
                <input type="text" name="name" placeholder="Contoh: Koordinator Berita" class="w-full px-4 py-4 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 outline-none transition-all dark:text-white font-medium">
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 text-xs font-black uppercase tracking-widest mb-3 ml-1">Deskripsi Singkat</label>
                <input type="text" name="description" placeholder="Penjelasan tugas peran ini..." class="w-full px-4 py-4 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-red-600 outline-none transition-all dark:text-white font-medium">
            </div>
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-300 text-xs font-black uppercase tracking-widest mb-6 ml-1 flex items-center">
                <i class="fas fa-key mr-2 text-red-600"></i> Atur Izin Akses (Grouped Permissions)
            </label>
            
            <div class="space-y-6">
                @foreach($permissions as $group => $groupPerms)
                    <div class="bg-gray-50 dark:bg-slate-800/50 rounded-3xl p-6 border border-gray-100 dark:border-slate-800">
                        <h4 class="text-sm font-black text-red-700 dark:text-red-500 uppercase tracking-tighter mb-4 pb-2 border-b border-red-100 dark:border-red-900/30 flex justify-between items-center">
                            <span><i class="fas fa-folder-open mr-2 opacity-50"></i> {{ $group ?: 'Lainnya' }}</span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($groupPerms as $permission)
                                <label class="flex items-center p-3 bg-white dark:bg-slate-900 rounded-xl border border-gray-100 dark:border-slate-700 hover:border-red-200 dark:hover:border-red-900 transition cursor-pointer group">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="w-5 h-5 rounded-lg border-gray-300 dark:border-slate-600 text-red-600 focus:ring-red-500 transition duration-200">
                                    <span class="ml-3 text-xs font-bold text-gray-700 dark:text-gray-300 group-hover:text-red-700 dark:group-hover:text-red-400 transition">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-12 flex justify-end gap-4">
            <a href="{{ route('roles.index') }}" 
               class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                Batal
            </a>
            <button type="submit" 
                    class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl flex items-center justify-center group">
                <span>Simpan Peran</span>
                <i class="fas fa-save ml-3 group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>
    </form>
</div>
@endsection
