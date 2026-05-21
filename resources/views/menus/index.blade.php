@extends('layouts.app')

@section('header', 'Manajemen Menu')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Daftar Menu Dashboard</h3>
            <p class="text-gray-500 text-sm">Kelola struktur navigasi dan menu sidebar admin.</p>
        </div>
        @can('menus_create')
            <a href="{{ route('menus.create') }}" class="bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition flex items-center shadow-lg shadow-red-200">
                <i class="fas fa-list mr-2"></i> Tambah Menu
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Urutan</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Judul Menu</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Lokasi</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Parent</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">URL</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($menus as $menu)
                <tr class="group hover:bg-gray-50 transition-all">
                    <td class="py-4 px-4 text-center">
                        <span class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-xs font-black text-slate-500 mx-auto">
                            {{ $menu->order }}
                        </span>
                    </td>
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-600">
                                <i class="{{ $menu->icon ?: 'fas fa-link' }}"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 group-hover:text-red-700 transition">
                                    {{ Str::contains($menu->title, 'messages.') ? __($menu->title) : $menu->title }}
                                </p>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">
                                    {{ $menu->permission_slug ?: 'Public Access' }}
                                    @if(Str::contains($menu->title, 'messages.'))
                                        <span class="ml-1 text-[8px] bg-blue-50 text-blue-500 px-1 rounded">Translatable</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full {{ $menu->location === 'admin' ? 'bg-purple-50 text-purple-600' : 'bg-orange-50 text-orange-600' }}">
                            {{ $menu->location }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-xs text-gray-500 font-medium italic">
                        {{ $menu->parent ? (Str::contains($menu->parent->title, 'messages.') ? __($menu->parent->title) : $menu->parent->title) : 'Root Menu' }}
                    </td>
                    <td class="py-4 px-4">
                        <code class="text-[10px] bg-slate-100 px-2 py-1 rounded text-slate-600">{{ $menu->url ?: '#' }}</code>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <span class="{{ $menu->is_active ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100' }} rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest border">
                            {{ $menu->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            @can('menus_edit')
                                <a href="{{ route('menus.edit', $menu->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                            @endcan
                            @can('menus_delete')
                                <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition shadow-sm" title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
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
    <div class="mt-8">
        {{ $menus->links() }}
    </div>
</div>
@endsection
