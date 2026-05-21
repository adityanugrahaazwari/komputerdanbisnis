@extends('layouts.app')

@section('header', 'Moderasi Komentar')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Daftar Komentar</h3>
            <p class="text-gray-500 text-sm">Kelola dan moderasi komentar dari pengunjung website.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-separate border-spacing-y-2">
            <thead>
                <tr>
                    <th class="py-4 px-6 text-xs font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="py-4 px-6 text-xs font-black text-gray-400 uppercase tracking-widest">Pengirim</th>
                    <th class="py-4 px-6 text-xs font-black text-gray-400 uppercase tracking-widest">Komentar</th>
                    <th class="py-4 px-6 text-xs font-black text-gray-400 uppercase tracking-widest">Konten</th>
                    <th class="py-4 px-6 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($comments as $comment)
                <tr class="group hover:bg-gray-50 transition-all duration-200">
                    <td class="py-4 px-6">
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                                'approved' => 'bg-green-50 text-green-600 border-green-100',
                                'spam' => 'bg-red-50 text-red-600 border-red-100',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $statusClasses[$comment->status] }}">
                            {{ $comment->status }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <p class="font-bold text-gray-900 text-sm">{{ $comment->user_name }}</p>
                        <p class="text-[10px] text-gray-400 font-medium">{{ $comment->user_email }}</p>
                    </td>
                    <td class="py-4 px-6">
                        <p class="text-xs text-gray-600 line-clamp-2 max-w-xs italic">"{{ $comment->comment }}"</p>
                        <p class="text-[9px] text-gray-400 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                    </td>
                    <td class="py-4 px-6">
                        <a href="{{ route('landing.post', $comment->post->slug) }}" target="_blank" class="text-blue-500 hover:text-blue-700 font-bold text-[10px] uppercase tracking-wider flex items-center gap-1">
                            <i class="fas fa-link text-[8px]"></i>
                            {{ Str::limit($comment->post->title, 30) }}
                        </a>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('comments.show', $comment->id) }}" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-red-700 hover:text-white transition shadow-sm" title="Detail">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                            
                            @if($comment->status === 'pending')
                                @can('comments_approve')
                                    <form action="{{ route('comments.approve', $comment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600 hover:bg-green-600 hover:text-white transition shadow-sm" title="Approve">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                    </form>
                                @endcan
                                @can('comments_reject')
                                    <form action="{{ route('comments.reject', $comment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600 hover:bg-orange-600 hover:text-white transition shadow-sm" title="Mark as Spam">
                                            <i class="fas fa-ban text-xs"></i>
                                        </button>
                                    </form>
                                @endcan
                            @endif

                            @can('comments_delete')
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus komentar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition shadow-sm" title="Hapus">
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
        {{ $comments->links() }}
    </div>
</div>
@endsection
