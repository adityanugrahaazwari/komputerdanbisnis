@extends('layouts.frontend')

@section('title', 'Kalender Kegiatan - ' . $siteSettings['name'])

@section('styles')
    .fc { font-family: inherit; }
    .fc .fc-toolbar-title { font-weight: 900; text-transform: uppercase; font-size: 1.25rem; letter-spacing: -0.025em; }
    .fc .fc-button-primary { background-color: var(--primary-color); border-color: var(--primary-color); font-weight: 700; text-transform: uppercase; font-size: 0.75rem; padding: 0.75rem 1.25rem; border-radius: 1rem; }
    .fc .fc-button-primary:hover { background-color: var(--primary-color); border-color: var(--primary-color); filter: brightness(0.9); }
    .fc .fc-button-primary:disabled { background-color: #fca5a5; border-color: #fca5a5; opacity: 0.5; }
    .fc-theme-standard td, .fc-theme-standard th { border-color: #f1f5f9; }
    .dark .fc-theme-standard td, .dark .fc-theme-standard th { border-color: #1e293b; }
    .dark .fc .fc-list-day-cushion { background-color: #1e293b; }
@endsection

@section('content')
    <!-- Header -->
    <header class="bg-gradient-to-r from-primary to-primary/80 text-white py-12 md:py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        <div class="container mx-auto px-4 md:px-12 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight uppercase">Kalender Kegiatan</h1>
            
            <!-- Breadcrumbs -->
            @include('partials.breadcrumbs', [
                'items' => [
                    ['label' => 'Kalender', 'url' => '#']
                ],
                'class' => 'text-white/70 justify-center',
                'activeClass' => 'text-red-200'
            ])
        </div>
    </header>

    <main class="container mx-auto px-4 md:px-12 py-16 md:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Calendar Section -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-900 p-8 rounded-[3rem] shadow-2xl border border-gray-100 dark:border-slate-800">
                    <div id='calendar'></div>
                </div>
            </div>

            <!-- Upcoming Events Sidebar -->
            <div class="space-y-8">
                <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight flex items-center gap-3">
                    <i class="fas fa-bolt text-red-600"></i> Mendatang
                </h2>
                
                <div class="space-y-6">
                    @forelse($events->where('start_date', '>=', now())->take(5) as $event)
                        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-lg border border-gray-100 dark:border-slate-800 group hover:border-red-500 transition-all duration-300">
                            <div class="flex gap-4">
                                <div class="shrink-0 w-14 h-14 bg-red-50 dark:bg-red-900/20 rounded-2xl flex flex-col items-center justify-center border border-red-100 dark:border-red-800">
                                    <span class="text-[10px] font-black text-red-600 dark:text-red-400 uppercase tracking-widest">{{ $event->start_date->format('M') }}</span>
                                    <span class="text-xl font-black text-gray-900 dark:text-white leading-none">{{ $event->start_date->format('d') }}</span>
                                </div>
                                <div>
                                    <h3 class="font-black text-gray-900 dark:text-white group-hover:text-red-700 transition">{{ $event->title }}</h3>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">
                                        <i class="fas fa-clock mr-1"></i> {{ $event->start_date->format('H:i') }} WIB
                                        @if($event->location)
                                            <span class="mx-2 opacity-30">|</span>
                                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $event->location }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 dark:bg-slate-800/50 rounded-[2rem] border-2 border-dashed border-gray-200 dark:border-slate-700">
                            <i class="fas fa-calendar-day text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-400 text-sm font-medium">Belum ada kegiatan mendatang.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Event Type Legend -->
                <div class="bg-gray-900 rounded-[2rem] p-8 text-white">
                    <h4 class="text-xs font-black uppercase tracking-[0.2em] mb-6 opacity-60">Tipe Kegiatan</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            <span class="text-xs font-bold">Akademik</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-xs font-bold">Webinar / Workshop</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <span class="text-xs font-bold">Lomba / Kompetisi</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-red-600"></div>
                            <span class="text-xs font-bold">Hari Libur</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
            },
            events: [
                @foreach($events as $event)
                {
                    title: '{{ $event->title }}',
                    start: '{{ $event->start_date->toIso8601String() }}',
                    @if($event->end_date)
                    end: '{{ $event->end_date->toIso8601String() }}',
                    @endif
                    color: '{{ $event->color }}',
                    url: '#', // Can link to detail later
                    description: '{{ $event->description }}'
                },
                @endforeach
            ],
            eventClick: function(info) {
                if(info.event.extendedProps.description) {
                    alert(info.event.title + "\n\n" + info.event.extendedProps.description);
                }
                info.jsEvent.preventDefault();
            }
        });
        calendar.render();
    });
</script>
@endsection
