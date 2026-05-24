@extends('layouts.app')

@section('header', 'Manajemen Kalender & Kegiatan')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Kalender & Kegiatan</h3>
            <p class="text-gray-500 text-sm">Kelola jadwal kegiatan prodi, webinar, dan kalender akademik.</p>
        </div>
        @can('events_create')
            <a href="{{ route('events.create') }}" class="bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition flex items-center shadow-lg shadow-red-200">
                <i class="fas fa-plus mr-2"></i> Tambah Kegiatan
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Judul Kegiatan</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Waktu</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Tipe</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Lokasi</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($events as $event)
                <tr class="group hover:bg-gray-50 transition-all">
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $event->color }}"></div>
                            <p class="font-bold text-gray-900 group-hover:text-red-700 transition">{{ $event->title }}</p>
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        <p class="text-xs font-bold text-gray-700">
                            {{ $event->start_date->format('d M Y') }}
                            @if($event->end_date && $event->end_date->format('Y-m-d') != $event->start_date->format('Y-m-d'))
                                - {{ $event->end_date->format('d M Y') }}
                            @endif
                        </p>
                        <p class="text-[10px] text-gray-400">{{ $event->start_date->format('H:i') }} WIB</p>
                    </td>
                    <td class="py-4 px-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-1 bg-gray-100 rounded text-gray-600 border border-gray-200">
                            {{ $event->type }}
                        </span>
                    </td>
                    <td class="py-4 px-4">
                        <p class="text-xs text-gray-600">{{ $event->location ?? '-' }}</p>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <span class="{{ $event->is_active ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest border border-black/5">
                            {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            @can('events_edit')
                                <a href="{{ route('events.edit', $event->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                            @endcan
                            @can('events_delete')
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kegiatan ini?')">
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
        {{ $events->links() }}
    </div>
</div>
@endsection
