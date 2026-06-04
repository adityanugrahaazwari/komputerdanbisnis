@extends('layouts.app')

@section('header', 'Pengumuman & BroadCast')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Daftar Pengumuman</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Kirim pesan broadcast ke semua pengguna sistem.</p>
        </div>
        <a href="{{ route('announcements.create') }}" class="bg-gray-900 dark:bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-xs uppercase tracking-widest hover:scale-105 transition-transform flex items-center justify-center shadow-lg">
            <i class="fas fa-bullhorn mr-2"></i> Buat Pengumuman Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-separate border-spacing-y-3">
            <thead>
                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Judul & Pesan</th>
                    <th class="px-6 py-3">Target</th>
                    <th class="px-6 py-3">Pembuat</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($announcements as $item)
                <tr class="bg-gray-50 dark:bg-slate-800/50 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors group">
                    <td class="px-6 py-4 rounded-l-2xl">
                        <form action="{{ route('announcements.toggle', $item) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-2">
                                <div class="w-10 h-5 bg-gray-200 dark:bg-slate-700 rounded-full relative transition-colors {{ $item->is_active ? 'bg-green-500 dark:bg-green-600' : '' }}">
                                    <div class="absolute top-1 left-1 w-3 h-3 bg-white rounded-full transition-transform {{ $item->is_active ? 'translate-x-5' : '' }}"></div>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-widest {{ $item->is_active ? 'text-green-600' : 'text-gray-400' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full 
                                    @if($item->type == 'info') bg-blue-500 @elseif($item->type == 'warning') bg-yellow-500 @elseif($item->type == 'danger') bg-red-500 @else bg-green-500 @endif">
                                </span>
                                {{ $item->title }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1 mt-1">{{ $item->message }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($item->target_role == 'all')
                            <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 rounded-full text-[10px] font-black uppercase tracking-widest">Public</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-full text-[10px] font-black uppercase tracking-widest">{{ $item->target_role }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-xs font-medium text-gray-600 dark:text-gray-400">
                        {{ $item->user->name }}<br>
                        <span class="text-[10px] opacity-50">{{ $item->created_at->format('d M Y, H:i') }}</span>
                    </td>
                    <td class="px-6 py-4 rounded-r-2xl text-right">
                        <form action="{{ route('announcements.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengumuman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600 transition p-2">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $announcements->links() }}
    </div>
</div>
@endsection
