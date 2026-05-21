@extends('layouts.app')

@section('header', 'Dashboard Overview')

@section('content')
<!-- Welcome Section -->
<div class="mb-10 bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800 flex flex-col md:flex-row items-center justify-between gap-6">
    <div class="flex items-center gap-6">
        <div class="w-16 h-16 bg-red-700 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-red-200 dark:shadow-none">
            <i class="fas fa-rocket text-2xl"></i>
        </div>
        <div>
            <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Hari ini adalah {{ now()->translatedFormat('l, d F Y') }}. Berikut adalah ringkasan sistem Anda.</p>
        </div>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('posts.create') }}" class="bg-gray-900 dark:bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-xs uppercase tracking-widest hover:scale-105 transition-transform flex items-center shadow-lg">
            <i class="fas fa-plus mr-2 text-red-500 dark:text-white"></i> Buat Berita
        </a>
        <a href="{{ url('/') }}" target="_blank" class="bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 border border-gray-100 dark:border-slate-700 px-6 py-3 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-slate-700 transition flex items-center shadow-sm">
            <i class="fas fa-external-link-alt mr-2 text-red-600"></i> Kunjungi Web
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Stat Card: Berita -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800 group hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-50 dark:bg-orange-900/20 rounded-xl flex items-center justify-center text-orange-600">
                <i class="fas fa-newspaper text-xl"></i>
            </div>
            <span class="text-[10px] font-black text-orange-500 bg-orange-50 dark:bg-orange-900/30 px-2 py-1 rounded-lg uppercase">{{ $stats['posts_pending'] }} Pending</span>
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Berita Terbit</p>
        <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $stats['posts_published'] }}</h3>
    </div>

    <!-- Stat Card: Komentar -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800 group hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center text-blue-600">
                <i class="fas fa-comments text-xl"></i>
            </div>
            @if($stats['comments_pending'] > 0)
                <span class="text-[10px] font-black text-red-500 bg-red-50 dark:bg-red-900/30 px-2 py-1 rounded-lg uppercase animate-pulse">{{ $stats['comments_pending'] }} Moderasi</span>
            @endif
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Komentar</p>
        <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ \App\Models\Comment::count() }}</h3>
    </div>

    <!-- Stat Card: Pesan -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800 group hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-50 dark:bg-green-900/20 rounded-xl flex items-center justify-center text-green-600">
                <i class="fas fa-envelope text-xl"></i>
            </div>
            @if($stats['contacts_unread'] > 0)
                <span class="text-[10px] font-black text-green-500 bg-green-50 dark:bg-green-900/30 px-2 py-1 rounded-lg uppercase">{{ $stats['contacts_unread'] }} Baru</span>
            @endif
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Pesan Masuk</p>
        <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ \App\Models\Contact::count() }}</h3>
    </div>

    <!-- Stat Card: Media -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800 group hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 rounded-xl flex items-center justify-center text-purple-600">
                <i class="fas fa-photo-video text-xl"></i>
            </div>
            <span class="text-[10px] font-black text-purple-500 bg-purple-50 dark:bg-purple-900/30 px-2 py-1 rounded-lg uppercase">{{ $stats['documents'] }} Dokumen</span>
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Galeri Foto</p>
        <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $stats['galleries'] }}</h3>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Recent Content (Left/Center Column) -->
    <div class="xl:col-span-2 space-y-8">
        <!-- Recent Posts -->
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-[0.2em]">Berita Terbaru</h4>
                <a href="{{ route('posts.index') }}" class="text-[10px] font-black text-red-600 uppercase tracking-widest hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @foreach($recentPosts as $post)
                    <div class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-slate-800/50 rounded-2xl transition group">
                        <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 border border-gray-100 dark:border-slate-700">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                    <i class="fas fa-image text-xl"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5 class="text-sm font-bold text-gray-900 dark:text-white truncate group-hover:text-red-700 transition">{{ $post->title }}</h5>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-[10px] text-gray-400 flex items-center italic">
                                    <i class="fas fa-user-circle mr-1"></i> {{ $post->user->name }}
                                </span>
                                <span class="text-[10px] text-gray-400 flex items-center italic">
                                    <i class="fas fa-clock mr-1"></i> {{ $post->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase border 
                            {{ $post->status === 'published' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-yellow-50 text-yellow-600 border-yellow-100' }}">
                            {{ $post->status }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Interactions (Comments & Contacts) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Recent Comments -->
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-[0.2em]">Komentar</h4>
                    <a href="{{ route('comments.index') }}" class="text-[10px] font-black text-red-600 uppercase tracking-widest hover:underline">Moderasi</a>
                </div>
                <div class="space-y-4">
                    @foreach($recentComments as $comment)
                        <div class="p-4 bg-slate-50 dark:bg-slate-800/30 rounded-2xl border border-gray-50 dark:border-slate-800">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-xs font-bold text-gray-900 dark:text-white">{{ $comment->user_name }}</span>
                                <span class="text-[8px] text-gray-400 italic">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-[11px] text-gray-600 dark:text-gray-400 line-clamp-2 leading-relaxed">"{{ $comment->comment }}"</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Inbox -->
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-[0.2em]">Pesan Masuk</h4>
                    <a href="{{ route('contacts.index') }}" class="text-[10px] font-black text-red-600 uppercase tracking-widest hover:underline">Semua</a>
                </div>
                <div class="space-y-4">
                    @foreach($recentContacts as $contact)
                        <div class="flex items-center gap-3 p-3 hover:bg-gray-50 dark:hover:bg-slate-800/50 rounded-xl transition">
                            <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 shrink-0">
                                <i class="fas fa-envelope text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-gray-900 dark:text-white truncate">{{ $contact->subject }}</p>
                                <p class="text-[10px] text-gray-400 truncate">{{ $contact->name }}</p>
                            </div>
                            @if(!$contact->is_read)
                                <div class="w-2 h-2 rounded-full bg-blue-600"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Info (Right Column) -->
    <div class="space-y-8">
        <!-- Quick Stats -->
        <div class="bg-red-700 rounded-[2.5rem] p-8 text-white shadow-xl shadow-red-100 dark:shadow-none relative overflow-hidden">
            <i class="fas fa-university absolute -bottom-10 -right-10 text-9xl text-white/10"></i>
            <h4 class="text-xs font-black uppercase tracking-[0.2em] mb-6 opacity-60">Info Akademik</h4>
            <div class="space-y-6 relative z-10">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold">Program Studi</span>
                    <span class="text-2xl font-black">{{ $stats['study_programs'] }}</span>
                </div>
                <div class="h-px bg-white/10 w-full"></div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold">Total Pengguna</span>
                    <span class="text-2xl font-black">{{ $stats['users'] }}</span>
                </div>
                <div class="h-px bg-white/10 w-full"></div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold">File Dokumen</span>
                    <span class="text-2xl font-black">{{ $stats['documents'] }}</span>
                </div>
            </div>
        </div>

        <!-- System Logs -->
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-[0.2em]">Log Aktivitas</h4>
                <i class="fas fa-history text-gray-300"></i>
            </div>
            <div class="space-y-4">
                @foreach($recentLogs as $log)
                    <div class="flex gap-3">
                        <div class="shrink-0 mt-1">
                            <div class="w-2 h-2 rounded-full bg-red-600"></div>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-700 dark:text-gray-300">
                                <strong class="text-gray-900 dark:text-white">{{ $log->user->name ?? 'System' }}</strong> 
                                {{ $log->description }}
                            </p>
                            <p class="text-[9px] text-gray-400 italic mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('logs.index') }}" class="block text-center mt-6 py-3 bg-gray-50 dark:bg-slate-800 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-red-700 transition">Lihat Semua Log</a>
        </div>
    </div>
</div>
@endsection
