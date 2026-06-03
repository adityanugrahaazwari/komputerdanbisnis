<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true'
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteSettings['name'] }} - Politeknik Negeri Tanah Laut</title>
    @include('partials.seo')
    @if(isset($siteSettings['favicon']) && $siteSettings['favicon'])
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings['favicon']) }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        :root {
            --primary-color: {{ $siteSettings['primary_color'] ?? '#ef4444' }};
        }
    </style>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: 'var(--primary-color)',
                        red: {
                            50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171',
                            500: 'var(--primary-color)', 600: 'var(--primary-color)', 700: 'var(--primary-color)', 800: 'var(--primary-color)', 900: 'var(--primary-color)',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color) 100%);
            filter: saturate(1.1);
        }
        .dark .hero-gradient {
            background: linear-gradient(135deg, #450a0a 0%, var(--primary-color) 100%);
        }
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300" x-data="{ 
    annModalOpen: false, 
    annActive: null 
}">

    <!-- Announcement Bar -->
    @if($announcements->count() > 0)
    <div 
        x-data="{ 
            active: 0, 
            count: {{ $announcements->count() }},
            init() {
                setInterval(() => {
                    this.active = (this.active + 1) % this.count;
                }, 5000);
            }
        }" 
        class="bg-gray-900 text-white py-2 relative overflow-hidden z-[60]"
    >
        <div class="container mx-auto px-4 md:px-12 relative">
            @foreach($announcements as $index => $ann)
                <div 
                    x-show="active === {{ $index }}" 
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4"
                    class="flex items-center justify-center gap-3 text-[10px] md:text-xs font-bold uppercase tracking-widest"
                >
                    <span class="px-2 py-0.5 rounded bg-{{ $ann->type == 'danger' ? 'red' : ($ann->type == 'warning' ? 'amber' : 'blue') }}-600 text-[8px]">
                        {{ $ann->type == 'danger' ? 'PENTING' : ($ann->type == 'warning' ? 'PERHATIAN' : 'INFO') }}
                    </span>
                    <span class="truncate">{{ $ann->title }}</span>
                    <button @click="annActive = {{ json_encode($ann) }}; annModalOpen = true" class="underline hover:text-red-400 ml-2 shrink-0">Detail</button>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Announcement Modal -->
    <div x-show="annModalOpen" 
         x-cloak 
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="annModalOpen = false" 
             class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-[2.5rem] p-8 md:p-12 shadow-2xl relative overflow-hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            
            <!-- Close Button -->
            <button @click="annModalOpen = false" class="absolute top-6 right-6 w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-gray-500 hover:bg-red-700 hover:text-white transition">
                <i class="fas fa-times"></i>
            </button>

            <div class="mb-8">
                <template x-if="annActive">
                    <span :class="{
                        'bg-red-100 text-red-700': annActive.type === 'danger',
                        'bg-amber-100 text-amber-700': annActive.type === 'warning',
                        'bg-blue-100 text-blue-700': annActive.type === 'info'
                    }" class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4 inline-block" x-text="annActive.type === 'danger' ? 'Penting' : (annActive.type === 'warning' ? 'Perhatian' : 'Informasi')"></span>
                </template>
                <h3 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white leading-tight uppercase tracking-tight" x-text="annActive ? annActive.title : ''"></h3>
            </div>

            <div class="text-gray-600 dark:text-gray-400 text-lg leading-relaxed italic mb-10" x-text="annActive ? annActive.message : ''"></div>

            <button @click="annModalOpen = false" class="w-full bg-gray-900 dark:bg-red-700 text-white py-5 rounded-2xl font-black uppercase text-xs tracking-[0.2em] hover:bg-red-700 transition">
                Tutup Pengumuman
            </button>
        </div>
    </div>

@include('partials.navbar')

    <!-- Hero Section -->
    <header id="beranda" class="hero-gradient text-white py-12 md:py-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 0 L100 0 L100 100 L0 100 Z" fill="url(#grid)"></path>
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"></path>
                    </pattern>
                </defs>
            </svg>
        </div>
        <div class="container mx-auto px-4 md:px-12 flex flex-col md:flex-row items-center relative z-10">
            <div class="md:w-3/5 mb-12 md:mb-0 text-center md:text-left">
                <span class="inline-block px-4 py-1 bg-red-800/50 rounded-full text-xs md:text-sm font-bold mb-4 backdrop-blur-sm border border-red-400/30">{{ $siteSettings['hero_badge'] }}</span>
                <h1 class="text-4xl md:text-7xl font-black leading-none mb-6 drop-shadow-md uppercase">
                    @php
                        $titleWords = explode(' ', $siteSettings['hero_title']);
                        $wordCount = count($titleWords);
                    @endphp
                    @foreach($titleWords as $index => $word)
                        @if($index == 1) <br><span class="text-red-200">{{ $word }}</span> @elseif($index > 1) <br>{{ $word }} @else {{ $word }} @endif
                    @endforeach
                </h1>
                <p class="text-lg md:text-2xl text-red-50 mb-10 max-w-2xl font-medium leading-relaxed opacity-90 mx-auto md:mx-0">
                    {{ $siteSettings['hero_subtitle'] }}
                </p>
                <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                    @if($siteSettings['hero_btn1_text'])
                        <a href="{{ $siteSettings['hero_btn1_url'] }}" class="bg-white text-red-700 px-10 py-4 rounded-xl font-black hover:bg-red-50 transition transform hover:-translate-y-1 shadow-2xl uppercase tracking-wider text-sm">{{ $siteSettings['hero_btn1_text'] }}</a>
                    @endif
                    @if($siteSettings['hero_btn2_text'])
                        <a href="{{ Str::startsWith($siteSettings['hero_btn2_url'], '/') ? url($siteSettings['hero_btn2_url']) : $siteSettings['hero_btn2_url'] }}" class="bg-red-800/40 border-2 border-white/50 text-white px-10 py-4 rounded-xl font-black hover:bg-red-800 transition transform hover:-translate-y-1 backdrop-blur-md uppercase tracking-wider text-sm">{{ $siteSettings['hero_btn2_text'] }}</a>
                    @endif
                </div>
            </div>
            <div class="md:w-2/5 flex justify-center relative hidden md:flex">
                <div class="absolute w-72 h-72 bg-red-400 rounded-full blur-3xl opacity-30 animate-pulse"></div>
                <i class="fas fa-graduation-cap text-[15rem] md:text-[22rem] text-white/20 relative z-10 rotate-12"></i>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-slate-50 dark:from-slate-950 to-transparent"></div>
    </header>

    <!-- Short Profile Section -->
    <section class="py-20 md:py-32 bg-white dark:bg-slate-900 transition-colors duration-300">
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex flex-col lg:flex-row items-center gap-12 md:gap-24">
                <div class="lg:w-1/2">
                    <div class="relative group">
                        <div class="absolute -top-10 -left-10 w-40 h-40 bg-red-700/10 rounded-full blur-3xl group-hover:scale-150 transition duration-700"></div>
                        @if(isset($profiles['history']->image))
                            <div class="relative z-10 rounded-[3rem] overflow-hidden shadow-2xl border-4 border-slate-50 dark:border-slate-800">
                                <img src="{{ asset('storage/' . $profiles['history']->image) }}" class="w-full aspect-[4/3] object-cover transform group-hover:scale-110 transition duration-1000">
                            </div>
                        @else
                            <div class="bg-red-700 aspect-[4/3] rounded-[3rem] flex items-center justify-center text-white shadow-2xl relative z-10 border-8 border-slate-50 dark:border-slate-800 overflow-hidden">
                                <i class="fas fa-university text-[10rem] opacity-10 absolute"></i>
                                <span class="text-3xl font-black tracking-widest italic opacity-50 uppercase">JKB PROFILE</span>
                            </div>
                        @endif
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-slate-900 dark:bg-red-800 rounded-3xl z-20 flex flex-col items-center justify-center text-white shadow-xl transform rotate-12 group-hover:rotate-0 transition duration-500">
                            <p class="text-3xl font-black">14+</p>
                            <p class="text-[8px] font-bold uppercase tracking-widest opacity-60">Years Excellence</p>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <span class="text-red-600 font-black tracking-[0.3em] uppercase text-xs mb-4 block">Brief Introduction</span>
                    <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-8 tracking-tight uppercase leading-tight">
                        {{ $profiles['history']->title ?? __('messages.profile') }}
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 text-lg md:text-xl leading-relaxed italic mb-10">
                        {{ Str::limit(strip_tags($profiles['history']->content ?? 'Jurusan Komputer dan Bisnis Politala berkomitmen untuk memberikan pendidikan vokasi terbaik bagi putra-putri daerah.'), 250) }}
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-12">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 shrink-0 bg-red-50 dark:bg-red-900/30 rounded-xl flex items-center justify-center text-red-600">
                                <i class="fas fa-eye text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-gray-900 dark:text-white text-xs uppercase tracking-widest mb-1">{{ __('messages.vision') }}</h4>
                                <p class="text-xs text-gray-500 line-clamp-2 italic">"{{ Str::limit($profiles['vision']->content ?? 'Menjadi pusat unggulan teknologi.', 60) }}"</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 shrink-0 bg-red-50 dark:bg-red-900/30 rounded-xl flex items-center justify-center text-red-600">
                                <i class="fas fa-bullseye text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-gray-900 dark:text-white text-xs uppercase tracking-widest mb-1">{{ __('messages.mission') }}</h4>
                                <p class="text-xs text-gray-500 line-clamp-2 italic">Misi kami berfokus pada pengembangan SDM yang kompeten.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-6 mb-12">
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Follow Us:</span>
                        <div class="flex gap-4">
                            @foreach($socialMedia as $social)
                                <a href="{{ $social->url }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-red-700 hover:text-white transition-all transform hover:scale-110" title="{{ $social->platform }}">
                                    <i class="{{ $social->icon }} text-xs"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('landing.profile') }}" class="inline-flex items-center gap-4 bg-gray-900 dark:bg-red-700 text-white px-10 py-4 rounded-2xl font-black uppercase text-xs tracking-[0.2em] hover:bg-red-700 dark:hover:bg-red-800 transition shadow-xl group">
                        {{ __('messages.read_more') }}
                        <i class="fas fa-arrow-right transform group-hover:translate-x-2 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section id="berita" class="py-20 md:py-32 bg-red-50 dark:bg-slate-950 relative overflow-hidden transition-colors duration-300">
        <div class="container mx-auto px-4 md:px-12 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 md:mb-20 gap-8">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-4 tracking-tight">{{ __('messages.latest_news') }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-base md:text-lg font-medium">Kabar terbaru dari Jurusan Komputer dan Bisnis.</p>
                </div>
                <a href="{{ route('landing.news') }}" class="w-full md:w-auto text-center bg-red-700 text-white px-8 md:px-10 py-3 md:py-4 rounded-2xl font-black hover:bg-red-800 transition shadow-xl dark:shadow-none uppercase tracking-widest text-sm">
                    {{ __('messages.all_news') }}
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                @forelse($latestPosts as $post)
                <article class="bg-white dark:bg-slate-900 rounded-[2rem] overflow-hidden shadow-xl dark:shadow-none flex flex-col border-b-8 border-red-700 transform hover:scale-[1.02] transition duration-300 border border-gray-100 dark:border-slate-800">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="h-48 md:h-56 w-full object-cover">
                    @else
                        <div class="h-48 md:h-56 w-full bg-red-100 dark:bg-red-900/20 flex items-center justify-center text-red-200 dark:text-red-800">
                            <i class="fas fa-newspaper text-6xl md:text-7xl"></i>
                        </div>
                    @endif
                    <div class="p-6 md:p-8 flex-1 flex flex-col">
                        <div class="flex items-center text-[10px] md:text-xs font-bold text-red-600 dark:text-red-400 mb-4 uppercase tracking-widest">
                            <i class="fas fa-clock mr-2"></i> {{ $post->created_at->format('d M Y') }}
                        </div>
                        <h3 class="text-xl md:text-2xl font-black text-gray-900 dark:text-white mb-4 leading-tight line-clamp-2 h-14 md:h-16">{{ $post->title }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6 md:mb-8 line-clamp-3 leading-relaxed">
                            {{ strip_tags($post->content) }}
                        </p>
                        <a href="{{ route('landing.post', $post->slug) }}" class="text-red-700 dark:text-red-400 font-black hover:text-red-900 dark:hover:text-red-300 flex items-center mt-auto uppercase text-[10px] md:text-xs tracking-widest group">
                            {{ __('messages.read_more') }} <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-2"></i>
                        </a>
                    </div>
                </article>
                @empty
                    <p class="text-center text-gray-400 col-span-full py-10">{{ __('messages.no_data') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Lecturers Section -->
    <section id="dosen" class="py-20 md:py-32 bg-white dark:bg-slate-900 transition-colors duration-300">
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex flex-col md:flex-row justify-between items-center mb-16 md:mb-24 gap-8">
                <div class="text-center md:text-left">
                    <span class="text-red-600 font-black tracking-[0.3em] uppercase text-xs mb-4 block">Meet Our Experts</span>
                    <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-6 tracking-tight uppercase">Dosen & Staf</h2>
                    <p class="text-gray-500 dark:text-gray-400 max-w-2xl font-medium">Pengajar profesional dan staf ahli yang siap membimbing mahasiswa mencapai masa depan cemerlang.</p>
                </div>
                <a href="{{ route('landing.lecturers') }}" class="w-full md:w-auto text-center bg-gray-900 dark:bg-red-700 text-white px-8 md:px-10 py-3 md:py-4 rounded-2xl font-black hover:bg-red-700 transition shadow-xl uppercase tracking-widest text-sm">
                    Lihat Semua Direktori
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($lecturers as $lecturer)
                    <div class="group bg-slate-50 dark:bg-slate-800 rounded-[2.5rem] p-6 border border-gray-100 dark:border-slate-700 hover:shadow-2xl hover:border-red-500 transition-all duration-500 text-center flex flex-col items-center">
                        <div class="w-32 h-32 rounded-[2rem] overflow-hidden mb-6 border-4 border-white dark:border-slate-700 shadow-lg transform group-hover:rotate-6 transition-transform">
                            @if($lecturer->image)
                                <img src="{{ asset('storage/' . $lecturer->image) }}" alt="{{ $lecturer->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-red-100 dark:bg-red-900/20 flex items-center justify-center text-red-600">
                                    <i class="fas fa-user text-5xl"></i>
                                </div>
                            @endif
                        </div>
                        <h4 class="font-black text-gray-900 dark:text-white uppercase tracking-tight text-sm mb-2 leading-tight h-10 flex items-center justify-center">{{ $lecturer->name }}</h4>
                        <p class="text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-widest mb-3">{{ $lecturer->position }}</p>
                        
                        <div class="flex gap-3 mb-4">
                            @if($lecturer->google_scholar_url)
                                <a href="{{ $lecturer->google_scholar_url }}" target="_blank" class="text-gray-400 hover:text-red-600 transition-colors" title="Google Scholar">
                                    <i class="fas fa-graduation-cap"></i>
                                </a>
                            @endif
                            @if($lecturer->sinta_url)
                                <a href="{{ $lecturer->sinta_url }}" target="_blank" class="text-gray-400 hover:text-red-600 transition-colors" title="SINTA">
                                    <i class="fas fa-microscope"></i>
                                </a>
                            @endif
                            @if($lecturer->email)
                                <a href="mailto:{{ $lecturer->email }}" class="text-gray-400 hover:text-red-600 transition-colors" title="Email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            @endif
                        </div>

                        <div class="mt-auto pt-4 border-t border-gray-100 dark:border-slate-700 w-full">
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-[0.1em] line-clamp-1 italic">"{{ $lecturer->expertise }}"</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    @if($testimonials->count() > 0)
    <section 
        x-data="{
            active: 0,
            count: {{ $testimonials->count() }},
            init() {
                this.resetPosition();
            },
            resetPosition() {
                let container = this.$refs.slider;
                let firstItem = container.querySelector('[data-index=\'0\']');
                if (firstItem) {
                    let itemWidth = firstItem.offsetWidth + 32;
                    container.scrollLeft = itemWidth * this.count;
                }
            },
            handleScroll() {
                let container = this.$refs.slider;
                let firstItem = container.querySelector('[data-index=\'0\']');
                if (!firstItem) return;
                
                let itemWidth = firstItem.offsetWidth + 32;
                let totalWidth = itemWidth * this.count;
                
                if (container.scrollLeft < itemWidth / 2) {
                    container.scrollTo({ left: container.scrollLeft + totalWidth, behavior: 'instant' });
                } else if (container.scrollLeft > (totalWidth * 2) - (itemWidth / 2)) {
                    container.scrollTo({ left: container.scrollLeft - totalWidth, behavior: 'instant' });
                }
                
                this.active = Math.round((container.scrollLeft - totalWidth) / itemWidth) % this.count;
                if (this.active < 0) this.active += this.count;
            },
            next() {
                let container = this.$refs.slider;
                let firstItem = container.querySelector('[data-index=\'0\']');
                let itemWidth = firstItem.offsetWidth + 32;
                container.scrollBy({ left: itemWidth, behavior: 'smooth' });
            },
            prev() {
                let container = this.$refs.slider;
                let firstItem = container.querySelector('[data-index=\'0\']');
                let itemWidth = firstItem.offsetWidth + 32;
                container.scrollBy({ left: -itemWidth, behavior: 'smooth' });
            }
        }"
        class="py-20 md:py-32 bg-white dark:bg-slate-900 transition-colors duration-300 overflow-hidden"
    >
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 md:mb-24 gap-8">
                <div class="text-center md:text-left">
                    <span class="text-red-600 font-black tracking-[0.3em] uppercase text-xs mb-4 block">Testimonials</span>
                    <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-6 tracking-tight uppercase">Kata Mereka</h2>
                    <p class="text-gray-500 dark:text-gray-400 max-w-2xl font-medium">Apa kata alumni dan mitra industri tentang Jurusan Komputer dan Bisnis Politala.</p>
                </div>
                <div class="flex gap-4 hidden md:flex">
                    <button @click="prev()" class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-red-700 hover:text-white transition shadow-sm">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button @click="next()" class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-red-700 hover:text-white transition shadow-sm">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            
            <div 
                x-ref="slider" 
                @scroll.debounce.10ms="handleScroll()"
                class="flex overflow-x-auto gap-8 pt-10 pb-12 snap-x snap-mandatory no-scrollbar -mx-4 px-4 md:mx-0 md:px-0"
            >
                @foreach($testimonials->concat($testimonials)->concat($testimonials) as $index => $testimonial)
                <div data-index="{{ $index }}" class="flex-none w-[85%] md:w-[45%] lg:w-[30%] snap-center">
                    <div class="bg-slate-50 dark:bg-slate-800 p-8 md:p-10 rounded-[3rem] relative border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-xl transition-all group h-full flex flex-col">
                        <div class="absolute -top-6 left-10 w-12 h-12 bg-red-700 rounded-2xl flex items-center justify-center text-white text-xl shadow-lg transform group-hover:rotate-12 transition">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        
                        <div class="mb-8 mt-4 text-gray-600 dark:text-gray-300 italic leading-relaxed text-sm md:text-base flex-1">
                            "{{ $testimonial->quote }}"
                        </div>
                        
                        <div class="flex items-center gap-4 mt-auto">
                            <div class="w-14 h-14 rounded-2xl overflow-hidden border-2 border-white dark:border-slate-700 shadow-md flex-shrink-0">
                                @if($testimonial->image)
                                    <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 dark:bg-slate-700 flex items-center justify-center text-gray-400">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="overflow-hidden">
                                <h4 class="font-black text-gray-900 dark:text-white text-sm uppercase tracking-tight truncate">{{ $testimonial->name }}</h4>
                                <p class="text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-widest truncate">{{ $testimonial->role }}</p>
                                @if($testimonial->company)
                                    <p class="text-[9px] text-gray-400 italic truncate">{{ $testimonial->company }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Mobile indicator -->
            <div class="flex justify-center gap-2 mt-4 md:hidden">
                @foreach($testimonials as $index => $testimonial)
                    <div 
                        class="w-2 h-2 rounded-full transition-all duration-300"
                        :class="active === {{ $index }} ? 'bg-red-700 w-4' : 'bg-gray-300 dark:bg-slate-700'"
                    ></div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Contact Form Section -->
    <section id="kontak" class="py-20 md:py-32 bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex flex-col lg:flex-row gap-16 items-center">
                <div class="lg:w-1/2">
                    <h2 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white mb-8 tracking-tight uppercase leading-none">
                        @php
                            $titleParts = explode(' ', $siteSettings['contact_title'] ?? 'Kontak Kami');
                            $lastWord = array_pop($titleParts);
                            $firstPart = implode(' ', $titleParts);
                        @endphp
                        {{ $firstPart }} <span class="text-red-700">{{ $lastWord }}</span>
                    </h2>
                    <p class="text-lg text-gray-500 dark:text-gray-400 mb-12 leading-relaxed">
                        {{ $siteSettings['contact_description'] }}
                    </p>
                    
                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="w-14 h-14 bg-white dark:bg-slate-900 rounded-2xl shadow-lg flex items-center justify-center text-red-700 text-2xl mr-6 border border-gray-100 dark:border-slate-800">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-gray-900 dark:text-white uppercase text-xs tracking-widest mb-2">{{ __('messages.location') }}</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $siteSettings['address'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-14 h-14 bg-white dark:bg-slate-900 rounded-2xl shadow-lg flex items-center justify-center text-red-700 text-2xl mr-6 border border-gray-100 dark:border-slate-800">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-gray-900 dark:text-white uppercase text-xs tracking-widest mb-2">{{ __('messages.email') }}</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $siteSettings['email'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12">
                        <h4 class="font-black text-gray-900 dark:text-white uppercase text-xs tracking-[0.3em] mb-6">Connect with us</h4>
                        <div class="flex flex-wrap gap-4">
                            @foreach($socialMedia as $social)
                                <a href="{{ $social->url }}" target="_blank" class="flex items-center gap-3 bg-white dark:bg-slate-900 px-6 py-3 rounded-2xl shadow-md border border-gray-50 dark:border-slate-800 hover:border-red-500 transition group">
                                    <i class="{{ $social->icon }} text-red-600 group-hover:scale-125 transition"></i>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-700 dark:text-gray-300">{{ $social->platform }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2 w-full">
                    <div class="bg-white dark:bg-slate-900 p-8 md:p-12 rounded-[3rem] shadow-2xl border border-gray-100 dark:border-slate-800">
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-8">
                                {{ __('messages.success_message') }}
                            </div>
                        @endif
                        <form action="{{ route('contacts.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">{{ __('messages.full_name') }}</label>
                                    <input type="text" name="name" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-red-600 transition text-sm text-gray-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">{{ __('messages.email') }}</label>
                                    <input type="email" name="email" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-red-600 transition text-sm text-gray-900 dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">{{ __('messages.subject') }}</label>
                                <input type="text" name="subject" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-red-600 transition text-sm text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">{{ __('messages.message') }}</label>
                                <textarea name="message" rows="5" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-red-600 transition text-sm text-gray-900 dark:text-white"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-red-700 text-white py-5 rounded-2xl font-black uppercase text-xs tracking-[0.3em] hover:bg-red-800 transition shadow-xl shadow-primary/20 dark:shadow-none">
                                {{ __('messages.send_message') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@include('partials.footer')

</body>
</html>
