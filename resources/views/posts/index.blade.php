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

    <!-- Filter Section -->
    <div class="mb-8 p-6 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800">
        <form action="{{ route('posts.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau isi..." class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            </div>
            
            <select name="category" class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary outline-none transition-all appearance-none cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <select name="status" class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary outline-none transition-all appearance-none cursor-pointer">
                <option value="">Semua Status</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gray-900 dark:bg-primary text-white font-bold py-2.5 rounded-xl text-xs uppercase tracking-widest hover:opacity-90 transition shadow-lg shadow-gray-200 dark:shadow-none">
                    Filter
                </button>
                <a href="{{ route('posts.index') }}" class="px-4 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-gray-500 hover:text-red-600 transition flex items-center justify-center">
                    <i class="fas fa-undo"></i>
                </a>
            </div>
        </form>
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
