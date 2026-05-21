@extends('layouts.app')

@section('header', 'Manajemen Layanan')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Daftar Layanan Eksternal</h3>
            <p class="text-gray-500 text-sm">Kelola tautan layanan seperti SIAKAD, E-Learning, dll.</p>
        </div>
        @can('services_create')
            <a href="{{ route('services.create') }}" class="bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition flex items-center shadow-lg shadow-red-200">
                <i class="fas fa-plus mr-2"></i> Tambah Layanan
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Order</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Judul Layanan</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Icon</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">URL Website</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($services as $service)
                <tr class="group hover:bg-gray-50 transition-all">
                    <td class="py-4 px-4 text-center">
                        <span class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-xs font-black text-slate-500 mx-auto">
                            {{ $service->order }}
                        </span>
                    </td>
                    <td class="py-4 px-4">
                        <p class="font-bold text-gray-900 group-hover:text-red-700 transition">{{ $service->title }}</p>
                    </td>
                    <td class="py-4 px-4 text-center text-xl text-gray-700">
                        <i class="{{ $service->icon ?: 'fas fa-link' }}"></i>
                    </td>
                    <td class="py-4 px-4">
                        <a href="{{ $service->url }}" target="_blank" class="text-xs text-blue-600 hover:underline truncate max-w-xs block italic">{{ $service->url }}</a>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <span class="{{ $service->is_active ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100' }} rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest border">
                            {{ $service->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            @can('services_edit')
                                <a href="{{ route('services.edit', $service->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                            @endcan
                            @can('services_delete')
                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus layanan ini?')">
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
        {{ $services->links() }}
    </div>
</div>
@endsection
