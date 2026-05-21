@extends('layouts.app')

@section('header', 'Detail Komentar')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Informasi Komentar</h3>
                <p class="text-gray-500 text-sm">Detail pengirim dan isi komentar pada konten.</p>
            </div>
            <div class="flex gap-2">
                @if($comment->status === 'pending')
                    @can('comments_approve')
                        <form action="{{ route('comments.approve', $comment->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-xl font-bold text-xs hover:bg-green-700 transition shadow-lg shadow-green-100 uppercase tracking-widest">
                                <i class="fas fa-check mr-2"></i> Approve
                            </button>
                        </form>
                    @endcan
                    @can('comments_reject')
                        <form action="{{ route('comments.reject', $comment->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-xl font-bold text-xs hover:bg-orange-700 transition shadow-lg shadow-orange-100 uppercase tracking-widest">
                                <i class="fas fa-ban mr-2"></i> Spam
                            </button>
                        </form>
                    @endcan
                @endif
                @can('comments_delete')
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Hapus komentar ini selamanya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white text-red-600 border border-red-100 px-6 py-2 rounded-xl font-bold text-xs hover:bg-red-50 transition uppercase tracking-widest">
                            <i class="fas fa-trash mr-2"></i> Hapus
                        </button>
                    </form>
                @endcan
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1 space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status</label>
                    @php
                        $statusClasses = [
                            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                            'approved' => 'bg-green-100 text-green-700 border-green-200',
                            'spam' => 'bg-red-100 text-red-700 border-red-200',
                        ];
                    @endphp
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $statusClasses[$comment->status] }}">
                        {{ $comment->status }}
                    </span>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pengirim</label>
                    <p class="font-bold text-gray-900">{{ $comment->user_name }}</p>
                    <p class="text-xs text-gray-500">{{ $comment->user_email }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Waktu</label>
                    <p class="text-sm font-bold text-gray-800">{{ $comment->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-[10px] text-gray-400 italic">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pada Berita</label>
                    <a href="{{ route('landing.post', $comment->post->slug) }}" target="_blank" class="text-blue-600 font-bold text-xs hover:underline flex items-center gap-2">
                        <i class="fas fa-external-link-alt text-[10px]"></i>
                        {{ $comment->post->title }}
                    </a>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100 relative">
                    <i class="fas fa-quote-left absolute top-4 left-4 text-gray-200 text-4xl"></i>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 relative z-10">Isi Komentar</label>
                    <p class="text-gray-700 leading-relaxed italic relative z-10">
                        "{{ $comment->comment }}"
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-50">
            <a href="{{ route('comments.index') }}" class="text-gray-500 font-bold text-sm hover:text-gray-900 transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-xs"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection
