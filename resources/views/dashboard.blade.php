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
        <a href="{{ route('dashboard-settings.index') }}" class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-6 py-3 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-slate-700 transition flex items-center shadow-sm">
            <i class="fas fa-cog mr-2"></i> Atur Dashboard
        </a>
        <a href="{{ url('/') }}" target="_blank" class="bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 border border-gray-100 dark:border-slate-700 px-6 py-3 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-slate-700 transition flex items-center shadow-sm">
            <i class="fas fa-external-link-alt mr-2 text-red-600"></i> Kunjungi Web
        </a>
    </div>
</div>

<!-- Quick Actions -->
@if(!$settings || $settings->show_quick_actions)
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-10">
    <a href="{{ route('posts.create') }}" class="bg-white dark:bg-slate-900 p-4 rounded-3xl border border-gray-100 dark:border-slate-800 flex flex-col items-center justify-center text-center hover:border-red-500 transition group">
        <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center text-red-600 mb-3 group-hover:scale-110 transition">
            <i class="fas fa-plus"></i>
        </div>
        <span class="text-[10px] font-black uppercase tracking-widest text-gray-600 dark:text-gray-400">Buat Berita</span>
    </a>
    <a href="{{ route('documents.index') }}" class="bg-white dark:bg-slate-900 p-4 rounded-3xl border border-gray-100 dark:border-slate-800 flex flex-col items-center justify-center text-center hover:border-blue-500 transition group">
        <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center text-blue-600 mb-3 group-hover:scale-110 transition">
            <i class="fas fa-file-upload"></i>
        </div>
        <span class="text-[10px] font-black uppercase tracking-widest text-gray-600 dark:text-gray-400">Upload File</span>
    </a>
    <a href="{{ route('lecturers.create') }}" class="bg-white dark:bg-slate-900 p-4 rounded-3xl border border-gray-100 dark:border-slate-800 flex flex-col items-center justify-center text-center hover:border-green-500 transition group">
        <div class="w-10 h-10 bg-green-50 dark:bg-green-900/20 rounded-xl flex items-center justify-center text-green-600 mb-3 group-hover:scale-110 transition">
            <i class="fas fa-user-plus"></i>
        </div>
        <span class="text-[10px] font-black uppercase tracking-widest text-gray-600 dark:text-gray-400">Tambah Dosen</span>
    </a>
    <a href="{{ route('comments.index') }}" class="bg-white dark:bg-slate-900 p-4 rounded-3xl border border-gray-100 dark:border-slate-800 flex flex-col items-center justify-center text-center hover:border-amber-500 transition group relative">
        <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/20 rounded-xl flex items-center justify-center text-amber-600 mb-3 group-hover:scale-110 transition">
            <i class="fas fa-comments"></i>
        </div>
        @if($stats['comments_pending'] > 0)
            <span class="absolute top-3 right-8 w-2 h-2 bg-red-600 rounded-full animate-ping"></span>
        @endif
        <span class="text-[10px] font-black uppercase tracking-widest text-gray-600 dark:text-gray-400">Moderasi</span>
    </a>
    <a href="{{ route('site-settings.index') }}" class="bg-white dark:bg-slate-900 p-4 rounded-3xl border border-gray-100 dark:border-slate-800 flex flex-col items-center justify-center text-center hover:border-purple-500 transition group">
        <div class="w-10 h-10 bg-purple-50 dark:bg-purple-900/20 rounded-xl flex items-center justify-center text-purple-600 mb-3 group-hover:scale-110 transition">
            <i class="fas fa-id-card"></i>
        </div>
        <span class="text-[10px] font-black uppercase tracking-widest text-gray-600 dark:text-gray-400">Info Situs</span>
    </a>
    <a href="{{ route('backups.index') }}" class="bg-white dark:bg-slate-900 p-4 rounded-3xl border border-gray-100 dark:border-slate-800 flex flex-col items-center justify-center text-center hover:border-gray-500 transition group">
        <div class="w-10 h-10 bg-gray-50 dark:bg-slate-800 rounded-xl flex items-center justify-center text-gray-600 mb-3 group-hover:scale-110 transition">
            <i class="fas fa-database"></i>
        </div>
        <span class="text-[10px] font-black uppercase tracking-widest text-gray-600 dark:text-gray-400">Backup</span>
    </a>
</div>
@endif

<!-- Announcements Section -->
@if($announcements->count() > 0 && (!$settings || $settings->show_announcements))
<div class="space-y-4 mb-10">
    @foreach($announcements as $announcement)
        <div class="rounded-3xl p-6 flex gap-6 items-start relative overflow-hidden group border
            @if($announcement->type == 'info') bg-blue-50 dark:bg-blue-900/20 border-blue-100 dark:border-blue-800 text-blue-800 dark:text-blue-300
            @elseif($announcement->type == 'success') bg-green-50 dark:bg-green-900/20 border-green-100 dark:border-green-800 text-green-800 dark:text-green-300
            @elseif($announcement->type == 'warning') bg-amber-50 dark:bg-amber-900/20 border-amber-100 dark:border-amber-800 text-amber-800 dark:text-amber-300
            @elseif($announcement->type == 'danger') bg-red-50 dark:bg-red-900/20 border-red-100 dark:border-red-800 text-red-800 dark:text-red-300
            @endif">
            
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 shadow-lg 
                @if($announcement->type == 'info') bg-blue-600 text-white
                @elseif($announcement->type == 'success') bg-green-600 text-white
                @elseif($announcement->type == 'warning') bg-amber-600 text-white
                @elseif($announcement->type == 'danger') bg-red-600 text-white
                @endif">
                <i class="fas @if($announcement->type == 'info') fa-info-circle @elseif($announcement->type == 'success') fa-check-circle @elseif($announcement->type == 'warning') fa-exclamation-triangle @elseif($announcement->type == 'danger') fa-exclamation-circle @endif text-xl"></i>
            </div>
            
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between mb-1">
                    <h4 class="text-sm font-black uppercase tracking-tight">{{ $announcement->title }}</h4>
                    <span class="text-[10px] font-bold opacity-60">{{ $announcement->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-sm leading-relaxed font-medium opacity-80">{{ $announcement->message }}</p>
                <div class="mt-2 flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded bg-black/10 text-[8px] font-bold uppercase tracking-widest">{{ $announcement->target_role == 'all' ? 'Publik' : 'Internal: ' . $announcement->target_role }}</span>
                </div>
            </div>

            <i class="fas fa-bullhorn absolute -bottom-4 -right-4 text-6xl opacity-10 group-hover:scale-110 transition-transform"></i>
        </div>
    @endforeach
</div>
@endif

<!-- Stats Grid -->
@if(!$settings || $settings->show_stats)
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
    <!-- Stat Card: Visitors -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800 group hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center text-red-600 group-hover:scale-110 transition-transform">
                <i class="fas fa-users text-xl"></i>
            </div>
            <span class="text-[10px] font-black text-red-500 bg-red-50 dark:bg-red-900/30 px-2 py-1 rounded-lg uppercase">+{{ $stats['visitors_today'] }} Hari Ini</span>
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Pengunjung Unik</p>
        <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ number_format($stats['visitors_total']) }}</h3>
    </div>

    <!-- Stat Card: Berita -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800 group hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-50 dark:bg-orange-900/20 rounded-xl flex items-center justify-center text-orange-600 group-hover:scale-110 transition-transform">
                <i class="fas fa-newspaper text-xl"></i>
            </div>
            <div class="flex flex-col items-end">
                <span class="text-[10px] font-black text-orange-500 bg-orange-50 dark:bg-orange-900/30 px-2 py-1 rounded-lg uppercase">{{ $stats['posts_pending'] }} Pending</span>
                <span class="text-[8px] font-bold text-gray-400 mt-1 uppercase">{{ $stats['posts_this_month'] }} Bulan Ini</span>
            </div>
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Berita Terbit</p>
        <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $stats['posts_published'] }}</h3>
    </div>

    <!-- Stat Card: Komentar -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800 group hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                <i class="fas fa-comments text-xl"></i>
            </div>
            @if($stats['comments_pending'] > 0)
                <span class="text-[10px] font-black text-red-500 bg-red-50 dark:bg-red-900/30 px-2 py-1 rounded-lg uppercase animate-pulse">{{ $stats['comments_pending'] }} Moderasi</span>
            @else
                <span class="text-[10px] font-black text-green-500 bg-green-50 dark:bg-green-900/30 px-2 py-1 rounded-lg uppercase">Clean</span>
            @endif
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Komentar</p>
        <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $stats['comments_total'] }}</h3>
    </div>

    <!-- Stat Card: Pesan -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800 group hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-50 dark:bg-green-900/20 rounded-xl flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform">
                <i class="fas fa-envelope text-xl"></i>
            </div>
            @if($stats['contacts_unread'] > 0)
                <span class="text-[10px] font-black text-green-500 bg-green-50 dark:bg-green-900/30 px-2 py-1 rounded-lg uppercase">{{ $stats['contacts_unread'] }} Baru</span>
            @endif
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Pesan Inbox</p>
        <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $stats['contacts_total'] }}</h3>
    </div>

    <!-- Stat Card: Media -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800 group hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 rounded-xl flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform">
                <i class="fas fa-photo-video text-xl"></i>
            </div>
            <span class="text-[10px] font-black text-purple-500 bg-purple-50 dark:bg-purple-900/30 px-2 py-1 rounded-lg uppercase">{{ $stats['galleries'] }} Item</span>
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Galeri & Dokumen</p>
        <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $stats['galleries'] + $stats['documents'] }}</h3>
    </div>
</div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Main Column (Left/Center) -->
    <div class="xl:col-span-2 space-y-8">
        
        <!-- Visitors Chart Section -->
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-[0.2em]">Statistik Pengunjung</h4>
                    <p id="chartDescription" class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Tren kunjungan harian (30 hari terakhir)</p>
                </div>
                <div class="flex items-center gap-3">
                    <select id="chartRange" class="bg-gray-50 dark:bg-slate-800 border-none rounded-xl px-4 py-2 text-[10px] font-black uppercase tracking-widest focus:ring-2 focus:ring-red-600 transition-all outline-none">
                        <option value="daily" selected>Harian</option>
                        <option value="weekly">Mingguan</option>
                        <option value="monthly">Bulanan</option>
                        <option value="yearly">Tahunan</option>
                    </select>
                </div>
            </div>
            <div class="h-[300px] w-full relative">
                <div id="chartLoading" class="absolute inset-0 bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm z-10 flex items-center justify-center hidden">
                    <i class="fas fa-circle-notch fa-spin text-red-600 text-2xl"></i>
                </div>
                <canvas id="visitorChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Popular Content -->
            @if(!$settings || $settings->show_popular_posts)
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-[0.2em]">Berita Populer</h4>
                    <i class="fas fa-fire text-orange-500"></i>
                </div>
                <div class="space-y-4">
                    @foreach($popularPosts as $post)
                        <div class="flex items-center gap-3 group">
                            <div class="w-8 h-8 rounded-lg bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-600 text-[10px] font-black shrink-0">
                                {{ $loop->iteration }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('landing.post', $post->slug) }}" target="_blank" class="text-xs font-bold text-gray-900 dark:text-white truncate block hover:text-red-700 transition">{{ $post->title }}</a>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">{{ number_format($post->views) }} Kali Dilihat</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Upcoming Events -->
            @if(!$settings || $settings->show_upcoming_events)
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-[0.2em]">Agenda Terdekat</h4>
                    <a href="{{ route('events.index') }}" class="text-[10px] font-black text-red-600 uppercase tracking-widest hover:underline">Kalender</a>
                </div>
                <div class="space-y-4">
                    @forelse($upcomingEvents as $event)
                        <div class="flex gap-3">
                            <div class="shrink-0 w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-xl flex flex-col items-center justify-center border border-red-100 dark:border-red-800">
                                <span class="text-[8px] font-black text-red-600 dark:text-red-400 uppercase">{{ $event->start_date->format('M') }}</span>
                                <span class="text-sm font-black text-gray-900 dark:text-white leading-none">{{ $event->start_date->format('d') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-gray-900 dark:text-white truncate">{{ $event->title }}</p>
                                <p class="text-[9px] text-gray-400 truncate uppercase font-bold tracking-widest mt-0.5">
                                    <i class="fas fa-clock mr-1"></i> {{ $event->start_date->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-[11px] text-gray-400 italic text-center py-4">Belum ada agenda.</p>
                    @endforelse
                </div>
            </div>
            @endif
        </div>

        <!-- Recent Posts -->
        @if(!$settings || $settings->show_recent_posts)
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-[0.2em]">Update Berita</h4>
                <a href="{{ route('posts.index') }}" class="text-[10px] font-black text-red-600 uppercase tracking-widest hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @foreach($recentPosts as $post)
                    <div class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-slate-800/50 rounded-2xl transition group">
                        <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 border border-gray-100 dark:border-slate-700">
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
        @endif
    </div>

    <!-- Sidebar (Right Column) -->
    <div class="space-y-8">
        
        <!-- Personal To-Do List -->
        @if(!$settings || $settings->show_todo_list)
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800" x-data="{ adding: false }">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-[0.2em]">Catatan Tugas</h4>
                <button @click="adding = !adding" class="text-red-600 hover:text-red-700 transition">
                    <i class="fas" :class="adding ? 'fa-times' : 'fa-plus-circle'"></i>
                </button>
            </div>
            
            <div x-show="adding" class="mb-6 animate-fade-in">
                <form action="{{ route('todos.store') }}" method="POST">
                    @csrf
                    <input type="text" name="task" placeholder="Tulis tugas baru..." required 
                           class="w-full px-4 py-2 text-xs bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-red-600 outline-none transition">
                </form>
            </div>

            <div class="space-y-3 max-h-[300px] overflow-y-auto no-scrollbar">
                @forelse($myTodos as $todo)
                    <div class="flex items-center gap-3 group">
                        <form action="{{ route('todos.toggle', $todo) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-5 h-5 rounded-lg border-2 flex items-center justify-center transition-colors
                                {{ $todo->is_completed ? 'bg-green-500 border-green-500 text-white' : 'border-gray-200 dark:border-slate-700 text-transparent hover:border-red-500' }}">
                                <i class="fas fa-check text-[10px]"></i>
                            </button>
                        </form>
                        <span class="text-xs font-medium flex-1 truncate {{ $todo->is_completed ? 'text-gray-400 line-through' : 'text-gray-700 dark:text-gray-300' }}">
                            {{ $todo->task }}
                        </span>
                        <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600 transition text-[10px]">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-[10px] text-gray-400 italic text-center py-4">Belum ada tugas.</p>
                @endforelse
            </div>
        </div>
        @endif

        <!-- Server Status Info -->
        @if(!$settings || $settings->show_server_status)
        <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white shadow-xl relative overflow-hidden">
            <i class="fas fa-server absolute -bottom-10 -right-10 text-9xl text-white/5"></i>
            <h4 class="text-xs font-black uppercase tracking-[0.2em] mb-6 opacity-60">Status Server</h4>
            <div class="space-y-6 relative z-10">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase opacity-60">PHP Version</span>
                    <span class="text-xs font-black">{{ $serverInfo['php_version'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase opacity-60">Laravel</span>
                    <span class="text-xs font-black">v{{ $serverInfo['laravel_version'] }}</span>
                </div>
                <div class="h-px bg-white/10 w-full"></div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-bold uppercase opacity-60">Disk Usage</span>
                        <span class="text-[10px] font-black">{{ $serverInfo['disk_usage_percent'] }}%</span>
                    </div>
                    <div class="w-full h-1.5 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-red-500" style="width: {{ $serverInfo['disk_usage_percent'] }}%"></div>
                    </div>
                    <p class="text-[8px] text-right mt-1 opacity-40 uppercase font-black">{{ $serverInfo['disk_free'] }} Free of {{ $serverInfo['disk_total'] }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Info Akademik -->
        @if(!$settings || $settings->show_academic_info)
        <div class="bg-red-700 rounded-[2.5rem] p-8 text-white shadow-xl relative overflow-hidden">
            <i class="fas fa-university absolute -bottom-10 -right-10 text-9xl text-white/10"></i>
            <h4 class="text-xs font-black uppercase tracking-[0.2em] mb-6 opacity-60">Info Akademik</h4>
            <div class="space-y-4 relative z-10">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase opacity-80">Prodi</span>
                    <span class="text-lg font-black">{{ $stats['study_programs'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase opacity-80">Dosen</span>
                    <span class="text-lg font-black">{{ $stats['lecturers'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase opacity-80">Kegiatan</span>
                    <span class="text-lg font-black">{{ $stats['events'] }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- System Logs -->
        @if(!$settings || $settings->show_system_logs)
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-[0.2em]">Log Aktivitas</h4>
                <i class="fas fa-history text-gray-300"></i>
            </div>
            <div class="space-y-4">
                @foreach($recentLogs as $log)
                    <div class="flex gap-3">
                        <div class="shrink-0 mt-1">
                            <div class="w-1.5 h-1.5 rounded-full bg-red-600"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-gray-700 dark:text-gray-300 leading-tight">
                                <strong class="text-gray-900 dark:text-white">{{ $log->user->name ?? 'System' }}</strong> 
                                {{ $log->description }}
                            </p>
                            <p class="text-[8px] text-gray-400 italic mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('logs.index') }}" class="block text-center mt-6 py-3 bg-gray-50 dark:bg-slate-800 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-red-700 transition">Lihat Semua</a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('visitorChart').getContext('2d');
    const chartRange = document.getElementById('chartRange');
    const chartLoading = document.getElementById('chartLoading');
    const chartDescription = document.getElementById('chartDescription');
    
    // Gradient for the chart
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(220, 38, 38, 0.2)');
    gradient.addColorStop(1, 'rgba(220, 38, 38, 0)');

    let visitorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Pengunjung',
                data: {!! json_encode($chartData['data']) !!},
                borderColor: '#dc2626',
                backgroundColor: gradient,
                borderWidth: 4,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#dc2626',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#111827',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    cornerRadius: 12,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 11,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11,
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });

    const updateChart = async (range) => {
        chartLoading.classList.remove('hidden');
        
        const descMap = {
            'daily': 'Tren kunjungan harian (30 hari terakhir)',
            'weekly': 'Tren kunjungan mingguan (12 minggu terakhir)',
            'monthly': 'Tren kunjungan bulanan (12 bulan terakhir)',
            'yearly': 'Tren kunjungan tahunan'
        };
        
        chartDescription.innerText = descMap[range];

        try {
            const response = await fetch(`{{ route('dashboard.chart-data') }}?range=${range}`);
            const data = await response.json();
            
            visitorChart.data.labels = data.labels;
            visitorChart.data.datasets[0].data = data.data;
            visitorChart.update();
        } catch (error) {
            console.error('Error fetching chart data:', error);
        } finally {
            chartLoading.classList.add('hidden');
        }
    };

    chartRange.addEventListener('change', (e) => {
        updateChart(e.target.value);
    });
});
</script>
@endpush
