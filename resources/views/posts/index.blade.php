@extends('layouts.app')

@section('header', 'Manajemen Berita')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Berita & Artikel</h3>
            <p class="text-gray-500 text-sm">Kelola konten berita dan publikasi artikel website.</p>
        </div>
        @can('posts_create')
            <a href="{{ route('posts.create') }}" class="bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-red-800 transition flex items-center shadow-lg shadow-red-200">
                <i class="fas fa-plus mr-2"></i> Tambah Berita
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">ID</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Judul</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Penulis</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($posts as $post)
                <tr class="group hover:bg-gray-50 transition-all">
                    <td class="py-4 px-4 text-center text-xs text-gray-400">#{{ $post->id }}</td>
                    <td class="py-4 px-4">
                        <p class="font-bold text-gray-900 group-hover:text-red-700 transition line-clamp-1">{{ $post->title }}</p>
                        <span class="text-[10px] text-gray-400 italic">{{ $post->created_at->format('d M Y') }}</span>
                    </td>
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-[10px] font-bold text-red-600">
                                {{ substr($post->user->name, 0, 1) }}
                            </div>
                            <span class="text-xs font-medium text-gray-600">{{ $post->user->name }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-4 text-center">
                        @php
                            $statusClasses = [
                                'draft' => 'bg-gray-100 text-gray-600',
                                'pending' => 'bg-yellow-50 text-yellow-600',
                                'published' => 'bg-green-50 text-green-600',
                                'rejected' => 'bg-red-50 text-red-600',
                            ];
                        @endphp
                        <span class="{{ $statusClasses[$post->status] ?? 'bg-gray-100' }} rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest border border-black/5">
                            {{ $post->status }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('posts.show', $post->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-green-600 hover:bg-green-600 hover:text-white transition shadow-sm" title="Lihat">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                            @can('posts_edit')
                                @if(auth()->user()->can('posts_publish') || $post->user_id === auth()->id())
                                    <a href="{{ route('posts.edit', $post->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                @endif
                            @endcan
                            @can('posts_delete')
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus berita ini?')">
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
        {{ $posts->links() }}
    </div>
</div>
@endsection
