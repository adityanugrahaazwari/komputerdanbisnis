@extends('layouts.app')

@section('header', 'Manajemen Galeri')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Koleksi Foto</h3>
            <p class="text-gray-500 text-sm">Kelola gambar yang tampil di halaman galeri publik.</p>
        </div>
        @can('galleries_create')
            <a href="{{ route('galleries.create') }}" class="bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition flex items-center shadow-lg shadow-red-200">
                <i class="fas fa-plus mr-2"></i> Tambah Foto
            </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($galleries as $gallery)
            <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300">
                <div class="relative aspect-video overflow-hidden">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        @can('galleries_edit')
                            <a href="{{ route('galleries.edit', $gallery->id) }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-600 hover:scale-110 transition">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endcan
                        @can('galleries_delete')
                            <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus foto ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-600 hover:scale-110 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="font-bold text-gray-900 truncate flex-1 mr-2">{{ $gallery->title }}</h4>
                        <span class="bg-slate-100 text-[10px] font-black px-2 py-0.5 rounded text-gray-500">#{{ $gallery->order ?? 0 }}</span>
                    </div>
                    <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $gallery->description ?? 'Tidak ada deskripsi.' }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold uppercase tracking-widest {{ $gallery->is_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $gallery->is_active ? 'Aktif' : 'Non-aktif' }}
                        </span>
                        <span class="text-[10px] text-gray-400 italic">{{ $gallery->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $galleries->links() }}
    </div>
</div>
@endsection
