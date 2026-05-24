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
            <x-admin.button href="{{ route('posts.create') }}">
                <i class="fas fa-plus mr-2"></i> Tambah Berita
            </x-admin.button>
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
                            $variants = [
                                'draft' => 'gray',
                                'pending' => 'yellow',
                                'published' => 'green',
                                'rejected' => 'red',
                            ];
                        @endphp
                        <x-admin.badge :variant="$variants[$post->status] ?? 'gray'">
                            {{ $post->status }}
                        </x-admin.badge>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <x-admin.action-button variant="view" href="{{ route('posts.show', $post->id) }}" title="Lihat" />
                            @can('posts_edit')
                                @if(auth()->user()->can('posts_publish') || $post->user_id === auth()->id())
                                    <x-admin.action-button variant="edit" href="{{ route('posts.edit', $post->id) }}" title="Edit" />
                                @endif
                            @endcan
                            @can('posts_delete')
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.action-button type="button" variant="delete" title="Hapus" />
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
