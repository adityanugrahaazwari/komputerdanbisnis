@extends('layouts.app')

@section('header', 'Grup Galeri (Album)')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Manajemen Grup Galeri</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Kelompokkan foto galeri ke dalam album yang spesifik.</p>
        </div>
        
        <a href="{{ route('gallery-groups.create') }}" class="bg-gray-900 dark:bg-red-700 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-lg flex items-center group">
            <i class="fas fa-plus mr-3 group-hover:rotate-180 transition-transform"></i>
            Tambah Grup
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-separate border-spacing-y-4">
            <thead>
                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                    <th class="px-6 py-3">Nama Grup</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groups as $group)
                <tr class="bg-gray-50 dark:bg-slate-800/50 rounded-2xl group transition-colors hover:bg-gray-100 dark:hover:bg-slate-800">
                    <td class="px-6 py-4 rounded-l-2xl">
                        <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $group->name }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-sm font-medium">
                        {{ Str::limit($group->description, 50) ?: '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="{{ $group->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }} px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">
                            {{ $group->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 rounded-r-2xl text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('gallery-groups.edit', $group->id) }}" class="p-3 bg-white dark:bg-slate-700 text-blue-600 rounded-xl shadow-sm hover:scale-110 transition-transform" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('gallery-groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus grup ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 bg-white dark:bg-slate-700 text-red-600 rounded-xl shadow-sm hover:scale-110 transition-transform" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-12 bg-gray-50 dark:bg-slate-800/50 rounded-2xl italic text-gray-400">
                        Belum ada grup galeri yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $groups->links() }}
    </div>
</div>
@endsection
