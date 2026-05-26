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
                    <div class="w-4 h-4 rounded-full bg-black/10 flex items-center justify-center">
                        <i class="fas fa-user text-[8px]"></i>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest opacity-60">Admin: {{ $announcement->user->name }}</span>
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
            <div class="w-12 h-12 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center text-red-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <span class="text-[10px] font-black text-red-500 bg-red-50 dark:bg-red-900/30 px-2 py-1 rounded-lg uppercase">{{ $stats['visitors_today'] }} Hari Ini</span>
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Pengunjung Unik</p>
        <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $stats['visitors_total'] }}</h3>
    </div>

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
@endif

<!-- Visitors Chart Section -->
<div class="mb-10 bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
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
            <div class="flex items-center gap-2 ml-4">
                <span class="w-3 h-3 rounded-full bg-red-600"></span>
                <span class="text-[10px] font-black text-gray-500 uppercase">Visits</span>
            </div>
        </div>
    </div>
    <div class="h-[300px] w-full relative">
        <div id="chartLoading" class="absolute inset-0 bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm z-10 flex items-center justify-center hidden">
            <i class="fas fa-circle-notch fa-spin text-red-600 text-2xl"></i>
        </div>
        <canvas id="visitorChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Recent Content (Left/Center Column) -->
    <div class="xl:col-span-2 space-y-8">
        <!-- Recent Posts -->
        @if(!$settings || $settings->show_recent_posts)
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
        @endif

        <!-- Recent Interactions (Comments & Contacts) -->
        @if(!$settings || $settings->show_recent_interactions)
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
        @endif
    </div>

    <!-- Sidebar Info (Right Column) -->
    <div class="space-y-8">
        <!-- Quick Stats -->
        @if(!$settings || $settings->show_academic_info)
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
                    <span class="text-sm font-bold">Dosen & Staf</span>
                    <span class="text-2xl font-black">{{ $stats['lecturers'] }}</span>
                </div>
                <div class="h-px bg-white/10 w-full"></div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold">Kegiatan & Event</span>
                    <span class="text-2xl font-black">{{ $stats['events'] }}</span>
                </div>
                <div class="h-px bg-white/10 w-full"></div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold">File Dokumen</span>
                    <span class="text-2xl font-black">{{ $stats['documents'] }}</span>
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
        @endif

        @if(!$settings || $settings->show_my_activity)
        <!-- My Recent Activity -->
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-[0.2em]">Aktivitas Saya</h4>
                <i class="fas fa-user-edit text-gray-300"></i>
            </div>
            <div class="space-y-4">
                @php
                    $myLogs = \App\Models\ActivityLog::where('user_id', auth()->id())->latest()->take(5)->get();
                @endphp
                @forelse($myLogs as $log)
                    <div class="flex gap-3">
                        <div class="shrink-0 mt-1">
                            <div class="w-2 h-2 rounded-full bg-blue-600"></div>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-700 dark:text-gray-300">
                                {{ $log->description }}
                            </p>
                            <p class="text-[9px] text-gray-400 italic mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 italic text-center py-4">Belum ada aktivitas.</p>
                @endforelse
            </div>
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
