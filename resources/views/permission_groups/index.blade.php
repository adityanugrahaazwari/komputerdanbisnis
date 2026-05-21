@extends('layouts.app')

@section('header', 'Permission Group Management')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl p-8 md:p-10 border border-gray-100 dark:border-slate-800">
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
        <div>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Grup Izin Akses</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola pengelompokan izin akses sistem.</p>
        </div>
        @can('permission_groups_create')
            <a href="{{ route('permission-groups.create') }}" class="bg-red-700 hover:bg-red-800 text-white font-black px-8 py-3 rounded-2xl shadow-lg shadow-red-200 dark:shadow-none transition-all uppercase tracking-widest text-xs flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Grup Baru
            </a>
        @endcan
    </div>

    <div class="overflow-hidden rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
            <thead class="bg-gray-50 dark:bg-slate-800">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Slug</th>
                    <th class="px-6 py-4 text-center text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Permissions Count</th>
                    <th class="px-6 py-4 text-center text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-100 dark:divide-slate-800">
                @foreach($groups as $group)
                <tr class="hover:bg-red-50/30 dark:hover:bg-red-900/5 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $group->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <code class="text-xs text-red-600 dark:text-red-400 font-mono bg-red-50 dark:bg-slate-800 px-2 py-1 rounded-lg">
                            {{ $group->slug }}
                        </code>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-3 py-1 bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-300 text-[10px] font-black rounded-full uppercase">
                            {{ $group->permissions_count }} Permissions
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <div class="flex justify-center gap-3">
                            @can('permission_groups_edit')
                                <a href="{{ route('permission-groups.edit', $group->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                            @endcan
                            @can('permission_groups_delete')
                                <form action="{{ route('permission-groups.destroy', $group->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus grup ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition shadow-sm" title="Delete" {{ $group->permissions_count > 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-trash-alt text-xs {{ $group->permissions_count > 0 ? 'opacity-20 cursor-not-allowed' : '' }}"></i>
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
        {{ $groups->links() }}
    </div>
</div>
@endsection
