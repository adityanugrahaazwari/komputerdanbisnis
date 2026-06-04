@extends('layouts.app')

@section('header', 'Manajemen Pengguna')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Daftar Pengguna</h3>
            <p class="text-gray-500 text-sm">Kelola akun pengguna dan akses sistem.</p>
        </div>
        @can('users_create')
            <x-admin.button href="{{ route('users.create') }}">
                <i class="fas fa-user-plus mr-2"></i> Tambah User
            </x-admin.button>
        @endcan
    </div>

    <!-- Filter Section -->
    <div class="mb-8 p-6 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="px-8 bg-gray-900 dark:bg-primary text-white font-bold py-2.5 rounded-xl text-xs uppercase tracking-widest hover:opacity-90 transition shadow-lg shadow-gray-200 dark:shadow-none">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('users.index') }}" class="px-4 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-gray-500 hover:text-red-600 transition flex items-center justify-center">
                        <i class="fas fa-undo"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">ID</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Nama & Email</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Role</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $user)
                <tr class="group hover:bg-gray-50 transition-all">
                    <td class="py-4 px-4 text-center text-xs text-gray-400">#{{ $user->id }}</td>
                    <td class="py-4 px-4">
                        <p class="font-bold text-gray-900 group-hover:text-red-700 transition">{{ $user->name }}</p>
                        <p class="text-[10px] text-gray-400 font-medium italic">{{ $user->email }}</p>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <div class="flex flex-wrap justify-center gap-1">
                            @foreach($user->roles as $role)
                                <x-admin.badge variant="slate">
                                    {{ $role->name }}
                                </x-admin.badge>
                            @endforeach
                        </div>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            @can('users_edit')
                                <x-admin.action-button variant="edit" href="{{ route('users.edit', $user->id) }}" title="Edit" />
                            @endcan
                            @can('users_delete')
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.action-button type="button" variant="delete" title="Hapus" />
                                </form>
                                @endif
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-8">
        {{ $users->links() }}
    </div>
</div>
@endsection
