<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true',
    mobileMenuOpen: false 
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurusan Komputer dan Bisnis - Politeknik Negeri Tanah Laut</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        red: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #991b1b 0%, #dc2626 100%);
        }
        .dark .hero-gradient {
            background: linear-gradient(135deg, #450a0a 0%, #7f1d1d 100%);
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">

    <!-- Navbar -->
    <nav class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b-4 border-red-700 dark:border-red-900">
        <div class="container mx-auto px-4 md:px-12 py-4 flex justify-between items-center">
            <a href="#" class="text-xl md:text-2xl font-black text-red-700 dark:text-red-500 flex items-center tracking-tighter">
                <i class="fas fa-university mr-2 text-3xl"></i> JKB POLITALA
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden lg:flex space-x-6 font-bold text-gray-700 dark:text-gray-300">
                <a href="#beranda" class="hover:text-red-600 dark:hover:text-red-400 transition-colors uppercase text-xs">{{ __('messages.home') }}</a>
                <a href="#profil" class="hover:text-red-600 dark:hover:text-red-400 transition-colors uppercase text-xs">{{ __('messages.profile') }}</a>
                <a href="#prodi" class="hover:text-red-600 dark:hover:text-red-400 transition-colors uppercase text-xs">{{ __('messages.study_programs') }}</a>
                <a href="{{ route('landing.news') }}" class="hover:text-red-600 dark:hover:text-red-400 transition-colors uppercase text-xs">{{ __('messages.news') }}</a>
            </div>

            <div class="flex items-center gap-2 md:gap-4">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-red-600 transition">
                    <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                </button>

                <!-- Language Switcher -->
                <div class="relative" x-data="{ langOpen: false }">
                    <button @click="langOpen = !langOpen" class="flex items-center gap-2 p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs font-bold uppercase tracking-widest transition">
                        <i class="fas fa-globe"></i>
                        <span>{{ app()->getLocale() }}</span>
                    </button>
                    <div x-show="langOpen" @click.outside="langOpen = false" x-cloak class="absolute right-0 mt-2 w-32 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden">
                        <a href="{{ route('lang.switch', 'id') }}" class="block px-4 py-2 text-xs font-bold hover:bg-red-50 dark:hover:bg-red-900/30 {{ app()->getLocale() == 'id' ? 'text-red-600' : '' }}">INDONESIA</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-xs font-bold hover:bg-red-50 dark:hover:bg-red-900/30 {{ app()->getLocale() == 'en' ? 'text-red-600' : '' }}">ENGLISH</a>
                    </div>
                </div>

                <div class="hidden sm:block">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-red-700 text-white px-6 py-2 rounded-full font-bold hover:bg-red-800 transition shadow-lg shadow-red-200 dark:shadow-none text-xs">{{ __('messages.dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-gray-100 dark:bg-slate-800 text-red-700 dark:text-red-400 px-6 py-2 rounded-full font-bold hover:bg-red-50 dark:hover:bg-slate-700 transition border border-red-200 dark:border-slate-700 text-xs">{{ __('messages.login_staff') }}</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-gray-700 dark:text-gray-300 focus:outline-none p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800">
                    <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'" class="text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="lg:hidden bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-slate-800 absolute w-full shadow-xl">
            <div class="flex flex-col p-4 space-y-2 font-bold text-gray-700 dark:text-gray-300">
                <a href="#beranda" @click="mobileMenuOpen = false" class="p-3 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 rounded-xl transition">{{ __('messages.home') }}</a>
                <a href="#profil" @click="mobileMenuOpen = false" class="p-3 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 rounded-xl transition">{{ __('messages.profile') }}</a>
                <a href="#prodi" @click="mobileMenuOpen = false" class="p-3 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 rounded-xl transition">{{ __('messages.study_programs') }}</a>
                <a href="{{ route('landing.news') }}" class="p-3 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 rounded-xl transition">{{ __('messages.news') }}</a>
                <div class="pt-4 sm:hidden">
                    @auth
                        <a href="{{ route('dashboard') }}" class="block text-center bg-red-700 text-white px-6 py-3 rounded-xl font-bold">{{ __('messages.dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="block text-center bg-gray-100 dark:bg-slate-800 text-red-700 dark:text-red-400 px-6 py-3 rounded-xl font-bold border border-red-200 dark:border-slate-700">{{ __('messages.login_staff') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header id="beranda" class="hero-gradient text-white py-20 md:py-40 relative overflow-hidden">
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
                <span class="inline-block px-4 py-1 bg-red-800/50 rounded-full text-xs md:text-sm font-bold mb-4 backdrop-blur-sm border border-red-400/30">POLITEKNIK NEGERI TANAH LAUT</span>
                <h1 class="text-4xl md:text-7xl font-black leading-none mb-6 drop-shadow-md uppercase">
                    {{ __('messages.excellent') }} <br><span class="text-red-200">{{ __('messages.innovative') }}</span> <br>{{ __('messages.professional') }}
                </h1>
                <p class="text-lg md:text-2xl text-red-50 mb-10 max-w-2xl font-medium leading-relaxed opacity-90 mx-auto md:mx-0">
                    Mencetak tenaga kerja handal di bidang teknologi informasi dan manajemen bisnis yang siap bersaing di kancah nasional dan global.
                </p>
                <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                    <a href="#prodi" class="bg-white text-red-700 px-10 py-4 rounded-xl font-black hover:bg-red-50 transition transform hover:-translate-y-1 shadow-2xl uppercase tracking-wider text-sm">{{ __('messages.study_programs') }}</a>
                    <a href="#profil" class="bg-red-800/40 border-2 border-white/50 text-white px-10 py-4 rounded-xl font-black hover:bg-red-800 transition transform hover:-translate-y-1 backdrop-blur-md uppercase tracking-wider text-sm">{{ __('messages.profile') }}</a>
                </div>
            </div>
            <div class="md:w-2/5 flex justify-center relative hidden md:flex">
                <div class="absolute w-72 h-72 bg-red-400 rounded-full blur-3xl opacity-30 animate-pulse"></div>
                <i class="fas fa-graduation-cap text-[15rem] md:text-[22rem] text-white/20 relative z-10 rotate-12"></i>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-slate-50 dark:from-slate-950 to-transparent"></div>
    </header>

    <!-- History Section -->
    <section id="profil" class="py-20 md:py-32 bg-slate-50 dark:bg-slate-950">
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16">
                <div class="md:w-1/2 order-2 md:order-1 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-8 flex flex-col md:flex-row items-center">
                        <span class="hidden md:block w-12 h-1.5 bg-red-600 mr-4 rounded-full"></span>
                        {{ $profiles['history']->title ?? __('messages.history') }}
                        <span class="md:hidden w-16 h-1 bg-red-600 mt-2 rounded-full"></span>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg md:text-xl mb-8">
                        {{ $profiles['history']->content ?? 'Jurusan Komputer dan Bisnis Politala berkomitmen untuk memberikan pendidikan vokasi terbaik.' }}
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-10">
                        <div class="bg-white dark:bg-slate-900 p-6 md:p-8 rounded-3xl shadow-xl dark:shadow-none border-b-8 border-red-600 transform hover:scale-105 transition border border-gray-100 dark:border-slate-800">
                            <div class="text-4xl md:text-5xl font-black text-red-700 dark:text-red-500 mb-2">14+</div>
                            <div class="text-[10px] md:text-sm text-gray-500 dark:text-gray-400 uppercase font-bold tracking-widest">Tahun Mengabdi</div>
                        </div>
                        <div class="bg-white dark:bg-slate-900 p-6 md:p-8 rounded-3xl shadow-xl dark:shadow-none border-b-8 border-red-600 transform hover:scale-105 transition border border-gray-100 dark:border-slate-800">
                            <div class="text-4xl md:text-5xl font-black text-red-700 dark:text-red-500 mb-2">1K+</div>
                            <div class="text-[10px] md:text-sm text-gray-500 dark:text-gray-400 uppercase font-bold tracking-widest">Alumni Sukses</div>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 order-1 md:order-2 relative">
                    <div class="absolute -top-4 -left-4 w-20 md:w-24 h-20 md:h-24 bg-red-600 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                    @if(isset($profiles['history']->image))
                        <img src="{{ asset('storage/' . $profiles['history']->image) }}" class="rounded-[2rem] shadow-2xl relative z-10 border-4 md:border-8 border-white dark:border-slate-800 w-full">
                    @else
                        <div class="bg-red-700 aspect-video rounded-[2rem] flex items-center justify-center text-white shadow-2xl relative z-10 border-4 md:border-8 border-white dark:border-slate-800 overflow-hidden">
                             <i class="fas fa-university text-7xl md:text-9xl opacity-20 absolute -right-4 -bottom-4"></i>
                             <span class="text-xl md:text-2xl font-black italic tracking-widest">POLITALA</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="py-20 md:py-32 bg-gray-900 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-red-700 rounded-full blur-[120px] opacity-20"></div>
        <div class="container mx-auto px-4 md:px-12 relative z-10">
            <div class="grid md:grid-cols-2 gap-8 md:gap-10">
                <div class="bg-white/5 backdrop-blur-lg p-8 md:p-10 rounded-[2.5rem] md:rounded-[3rem] border border-white/10 hover:bg-white/10 transition">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-red-600 rounded-2xl flex items-center justify-center mb-6 md:mb-8 shadow-lg shadow-red-600/30">
                        <i class="fas fa-eye text-2xl md:text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-black text-white mb-4 md:mb-6 uppercase tracking-tight">{{ $profiles['vision']->title ?? __('messages.vision') }}</h3>
                    <p class="text-gray-400 leading-relaxed text-base md:text-lg italic">
                        "{{ $profiles['vision']->content ?? 'Menjadi pusat unggulan teknologi dan bisnis.' }}"
                    </p>
                </div>
                <div class="bg-white/5 backdrop-blur-lg p-8 md:p-10 rounded-[2.5rem] md:rounded-[3rem] border border-white/10 hover:bg-white/10 transition">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-red-600 rounded-2xl flex items-center justify-center mb-6 md:mb-8 shadow-lg shadow-red-600/30">
                        <i class="fas fa-bullseye text-2xl md:text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-black text-white mb-4 md:mb-6 uppercase tracking-tight">{{ $profiles['mission']->title ?? __('messages.mission') }}</h3>
                    <div class="text-gray-400 leading-relaxed text-base md:text-lg space-y-4">
                        {!! nl2br(e($profiles['mission']->content ?? 'Mengembangkan SDM berkualitas.')) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Study Programs -->
    <section id="prodi" class="py-20 md:py-32 bg-white dark:bg-slate-900 relative transition-colors duration-300">
        <div class="container mx-auto px-4 md:px-12">
            <div class="text-center mb-16 md:mb-24">
                <span class="text-red-600 font-black tracking-[0.2em] uppercase text-[10px] md:text-sm mb-4 block">Academic Programs</span>
                <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-6 tracking-tight">{{ __('messages.study_programs') }}</h2>
                <div class="h-1.5 md:h-2 w-20 md:w-24 bg-red-600 mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                @forelse($studyPrograms as $prodi)
                <div class="group bg-white dark:bg-slate-800 rounded-[2rem] md:rounded-[2.5rem] overflow-hidden shadow-xl hover:shadow-red-200 dark:hover:shadow-none transition-all duration-500 border border-gray-100 dark:border-slate-700 flex flex-col transform hover:-translate-y-2">
                    <div class="h-56 md:h-64 bg-gray-200 dark:bg-slate-700 relative overflow-hidden">
                        @if($prodi->image)
                            <img src="{{ asset('storage/' . $prodi->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-red-50 dark:bg-red-900/20 text-red-200 dark:text-red-800">
                                <i class="fas fa-graduation-cap text-6xl md:text-8xl"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-red-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6 md:p-8">
                             <span class="text-white font-bold text-sm md:text-base">Lihat Selengkapnya <i class="fas fa-arrow-right ml-2"></i></span>
                        </div>
                        <div class="absolute top-4 md:top-6 left-4 md:left-6 bg-red-700 text-white text-[10px] md:text-xs font-black px-3 md:px-4 py-1 md:py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                            {{ $prodi->level }}
                        </div>
                    </div>
                    <div class="p-8 md:p-10 flex-1 flex flex-col">
                        <h4 class="text-xl md:text-2xl font-black text-gray-900 dark:text-white mb-4 tracking-tight">{{ $prodi->name }}</h4>
                        <p class="text-gray-500 dark:text-gray-400 text-sm md:text-base leading-relaxed mb-6 md:mb-8 flex-1 line-clamp-4">
                            {{ $prodi->description }}
                        </p>
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-slate-700">
                            <span class="text-red-700 dark:text-red-400 font-black text-[10px] md:text-sm uppercase tracking-widest">KODE: {{ $prodi->code }}</span>
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-red-50 dark:bg-red-900/30 rounded-full flex items-center justify-center text-red-600 dark:text-red-400 group-hover:bg-red-700 dark:group-hover:bg-red-500 group-hover:text-white transition">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-center text-gray-400 col-span-full py-10 italic">{{ __('messages.no_data') }}</p>
                @endforelse
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

    <!-- Organizational Structure -->
    <section class="py-20 md:py-32 bg-white dark:bg-slate-900 transition-colors duration-300">
        <div class="container mx-auto px-4 md:px-12">
            <div class="max-w-6xl mx-auto bg-slate-900 dark:bg-black rounded-[2.5rem] md:rounded-[4rem] p-8 md:p-24 text-center relative overflow-hidden border border-white/5">
                <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <h2 class="text-2xl md:text-5xl font-black text-white mb-10 md:mb-16 relative z-10 tracking-tight uppercase">{{ $profiles['structure']->title ?? __('messages.structure') }}</h2>
                <div class="flex justify-center relative z-10">
                    @if(isset($profiles['structure']->image))
                        <div class="bg-white p-2 md:p-6 rounded-xl md:rounded-[2rem] shadow-2xl shadow-red-900/50">
                            <img src="{{ asset('storage/' . $profiles['structure']->image) }}" class="max-w-full h-auto rounded-lg md:rounded-xl">
                        </div>
                    @else
                        <div class="bg-white/5 backdrop-blur-md p-10 md:p-16 rounded-[2rem] md:rounded-[3rem] border-2 border-dashed border-white/20 w-full">
                            <i class="fas fa-sitemap text-5xl md:text-7xl text-red-600 mb-6"></i>
                            <p class="text-gray-400 text-lg md:text-xl">{{ $profiles['structure']->content ?? 'Diagram struktur organisasi belum diunggah.' }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 text-gray-400 py-16 md:py-24 border-t-8 border-red-700 dark:border-red-900">
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex flex-col lg:flex-row justify-between items-start gap-12 md:gap-16">
                <div class="w-full lg:w-1/3 text-center md:text-left">
                    <a href="#" class="text-2xl md:text-3xl font-black text-white flex items-center justify-center md:justify-start mb-6 md:mb-8 tracking-tighter">
                        <i class="fas fa-university mr-3 text-red-600"></i> JKB POLITALA
                    </a>
                    <p class="text-base md:text-lg leading-relaxed mb-8">
                        Jurusan Komputer dan Bisnis - Politeknik Negeri Tanah Laut. Menghasilkan lulusan yang unggul, profesional, dan berjiwa wirausaha.
                    </p>
                    <div class="flex justify-center md:justify-start space-x-6 text-2xl md:text-3xl">
                        @foreach($socialMedia as $social)
                            <a href="{{ $social->url }}" target="_blank" class="text-gray-500 hover:text-red-500 transition-colors" title="{{ $social->platform }}">
                                <i class="{{ $social->icon }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="w-full lg:w-1/4 text-center md:text-left">
                    <h5 class="text-white font-black uppercase tracking-widest mb-6 md:mb-8 border-b-2 border-red-700 inline-block">{{ __('messages.quick_links') }}</h5>
                    <ul class="space-y-3 md:space-y-4 font-bold text-xs md:text-sm">
                        <li><a href="#beranda" class="hover:text-red-500 transition-colors uppercase">{{ __('messages.home') }}</a></li>
                        <li><a href="#profil" class="hover:text-red-500 transition-colors uppercase">{{ __('messages.profile') }}</a></li>
                        <li><a href="#prodi" class="hover:text-red-500 transition-colors uppercase">{{ __('messages.study_programs') }}</a></li>
                        <li><a href="{{ route('landing.news') }}" class="hover:text-red-500 transition-colors uppercase">{{ __('messages.news') }}</a></li>
                    </ul>
                </div>
                <div class="w-full lg:w-1/3 text-center md:text-left">
                    <h5 class="text-white font-black uppercase tracking-widest mb-6 md:mb-8 border-b-2 border-red-700 inline-block">{{ __('messages.contact_us') }}</h5>
                    <ul class="space-y-4 md:space-y-6 text-sm md:text-base">
                        <li class="flex flex-col md:flex-row items-center md:items-start">
                            <i class="fas fa-map-marker-alt mb-2 md:mt-1.5 md:mr-4 text-red-600"></i>
                            <span>Jl. Ahmad Yani KM.06, Desa Panggung, Pelaihari, Tanah Laut, Kalimantan Selatan.</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-4 text-red-600"></i>
                            <span>(0512) 2021065</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-4 text-red-600"></i>
                            <span>jkb@politala.ac.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/5 mt-16 md:mt-20 pt-10 text-center text-[10px] md:text-sm font-bold tracking-widest uppercase">
                &copy; {{ date('Y') }} JURUSAN KOMPUTER DAN BISNIS POLITALA. ALL RIGHTS RESERVED.
            </div>
        </div>
    </footer>

</body>
</html>
