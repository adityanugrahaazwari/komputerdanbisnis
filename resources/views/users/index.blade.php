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
