@extends('layouts.app')

@section('header', 'Permission Management')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl p-8 md:p-10 border border-gray-100 dark:border-slate-800">
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
        <div>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Daftar Izin Akses</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola izin sistem yang dikelompokkan berdasarkan modul.</p>
        </div>
        @can('permissions_create')
            <a href="{{ route('permissions.create') }}" class="bg-red-700 hover:bg-red-800 text-white font-black px-8 py-3 rounded-2xl shadow-lg shadow-red-200 dark:shadow-none transition-all uppercase tracking-widest text-xs flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Izin Baru
            </a>
        @endcan
    </div>

    <div class="overflow-hidden rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
            <thead class="bg-gray-50 dark:bg-slate-800">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Group</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Slug (System Key)</th>
                    <th class="px-6 py-4 text-center text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-100 dark:divide-slate-800">
                @foreach($permissions as $permission)
                <tr class="hover:bg-red-50/30 dark:hover:bg-red-900/5 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-[10px] font-black rounded-full uppercase tracking-tighter border border-red-200 dark:border-red-900/50">
                            {{ $permission->group ?: 'Lainnya' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $permission->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <code class="text-xs text-red-600 dark:text-red-400 font-mono bg-red-50 dark:bg-slate-800 px-2 py-1 rounded-lg">
                            {{ $permission->slug }}
                        </code>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <div class="flex justify-center gap-3">
                            @can('permissions_edit')
                                <a href="{{ route('permissions.edit', $permission->id) }}" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" title="Edit">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                            @endcan
                            @can('permissions_delete')
                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus izin ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 dark:hover:text-red-500 transition-colors" title="Delete">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-10">
        {{ $permissions->links() }}
    </div>
</div>
@endsection
