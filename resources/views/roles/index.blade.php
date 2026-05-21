@extends('layouts.app')

@section('header', 'Manajemen Role')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Role & Hak Akses</h3>
            <p class="text-gray-500 text-sm">Kelola peran pengguna dan pembatasan fitur sistem.</p>
        </div>
        @can('roles_create')
            <a href="{{ route('roles.create') }}" class="bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition flex items-center shadow-lg shadow-red-200">
                <i class="fas fa-user-shield mr-2"></i> Tambah Role
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">ID</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Nama Role</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Izin Akses</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($roles as $role)
                <tr class="group hover:bg-gray-50 transition-all">
                    <td class="py-4 px-4 text-center text-xs text-gray-400">#{{ $role->id }}</td>
                    <td class="py-4 px-4">
                        <p class="font-bold text-gray-900 group-hover:text-red-700 transition uppercase tracking-tight">{{ $role->name }}</p>
                        <code class="text-[9px] text-gray-400 font-mono">{{ $role->slug }}</code>
                    </td>
                    <td class="py-4 px-4">
                        <div class="flex flex-wrap gap-1 max-w-md">
                            @foreach($role->permissions as $perm)
                                <span class="bg-green-50 text-green-600 border border-green-100 rounded px-1.5 py-0.5 text-[8px] font-black uppercase tracking-tighter">{{ $perm->name }}</span>
                            @endforeach
                            @if($role->permissions->isEmpty())
                                <span class="text-[10px] text-gray-400 italic italic">Tidak ada izin akses</span>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            @can('roles_edit')
                                <a href="{{ route('roles.edit', $role->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                            @endcan
                            @can('roles_delete')
                                @if($role->slug !== 'admin')
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus role ini?')">
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
        {{ $roles->links() }}
    </div>
</div>
@endsection
