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
            <a href="{{ route('users.create') }}" class="bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition flex items-center shadow-lg shadow-red-200">
                <i class="fas fa-user-plus mr-2"></i> Tambah User
            </a>
        @endcan
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
                                <span class="bg-slate-100 text-slate-600 text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-tighter border border-slate-200">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            @can('users_edit')
                                <a href="{{ route('users.edit', $user->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                            @endcan
                            @can('users_delete')
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition shadow-sm" title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
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
