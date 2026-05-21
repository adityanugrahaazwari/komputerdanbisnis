<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true'
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.profile') }} - JKB POLITALA</title>
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
                            50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171', 500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">

@include('partials.navbar')

    <!-- Page Header -->

    <!-- Page Header -->
    <header class="bg-gradient-to-br from-slate-900 via-slate-800 to-red-900 text-white py-20 md:py-32 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-7xl font-black mb-6 tracking-tight uppercase">{{ __('messages.profile') }} <span class="text-red-600">Jurusan</span></h1>
            <p class="text-gray-400 max-w-2xl mx-auto italic text-lg md:text-xl leading-relaxed">Mengenal lebih dalam sejarah, visi, misi, dan struktur kepemimpinan Jurusan Komputer dan Bisnis.</p>
        </div>
    </header>

    <!-- Navigation Tabs (Anchor Links) -->
    <div class="sticky top-[76px] z-40 bg-white dark:bg-slate-900 border-b border-gray-100 dark:border-slate-800 shadow-sm">
        <div class="container mx-auto px-4 flex justify-center space-x-4 md:space-x-12 py-4">
            <a href="#sejarah" class="text-[10px] md:text-xs font-black uppercase tracking-widest text-gray-500 hover:text-red-700 transition">{{ __('messages.history') }}</a>
            <a href="#visi-misi" class="text-[10px] md:text-xs font-black uppercase tracking-widest text-gray-500 hover:text-red-700 transition">{{ __('messages.vision') }} & {{ __('messages.mission') }}</a>
            <a href="#struktur" class="text-[10px] md:text-xs font-black uppercase tracking-widest text-gray-500 hover:text-red-700 transition">{{ __('messages.structure') }}</a>
        </div>
    </div>

    <main>
        <!-- History Section -->
        <section id="sejarah" class="py-20 md:py-32 bg-white dark:bg-slate-950">
            <div class="container mx-auto px-4 md:px-12">
                <div class="flex flex-col lg:flex-row items-center gap-12 md:gap-20">
                    <div class="lg:w-1/2">
                        <div class="relative">
                            <div class="absolute -top-6 -left-6 w-24 h-24 bg-red-600/20 rounded-full blur-2xl animate-pulse"></div>
                            @if(isset($profiles['history']->image))
                                <img src="{{ asset('storage/' . $profiles['history']->image) }}" class="rounded-[3rem] shadow-2xl relative z-10 border-8 border-slate-50 dark:border-slate-800 w-full object-cover aspect-[4/3]">
                            @else
                                <div class="bg-red-700 aspect-[4/3] rounded-[3rem] flex items-center justify-center text-white shadow-2xl relative z-10 border-8 border-slate-50 dark:border-slate-800 overflow-hidden">
                                     <i class="fas fa-university text-[10rem] opacity-10 absolute"></i>
                                     <span class="text-3xl font-black tracking-widest italic opacity-50">JKB HISTORY</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="lg:w-1/2">
                        <span class="text-red-600 font-black tracking-[0.3em] uppercase text-xs mb-4 block">About Us</span>
                        <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-8 tracking-tight uppercase">
                            {{ $profiles['history']->title ?? __('messages.history') }}
                        </h2>
                        <div class="prose dark:prose-invert prose-lg max-w-none text-gray-600 dark:text-gray-400 leading-relaxed text-lg italic">
                            {!! nl2br(e($profiles['history']->content ?? 'Jurusan Komputer dan Bisnis Politala berkomitmen untuk memberikan pendidikan vokasi terbaik.')) !!}
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6 mt-12">
                            <div class="p-6 bg-slate-50 dark:bg-slate-900 rounded-3xl border border-gray-100 dark:border-slate-800">
                                <p class="text-3xl font-black text-red-700 mb-1">14+</p>
                                <p class="text-[10px] font-black uppercase tracking-widest text-gray-500">Years Excellence</p>
                            </div>
                            <div class="p-6 bg-slate-50 dark:bg-slate-900 rounded-3xl border border-gray-100 dark:border-slate-800">
                                <p class="text-3xl font-black text-red-700 mb-1">1K+</p>
                                <p class="text-[10px] font-black uppercase tracking-widest text-gray-500">Graduates</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vision & Mission -->
        <section id="visi-misi" class="py-20 md:py-32 bg-slate-900 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-red-700/20 rounded-full blur-[120px]"></div>
            <div class="container mx-auto px-4 md:px-12 relative z-10">
                <div class="text-center mb-16 md:mb-24">
                    <span class="text-red-500 font-black tracking-[0.3em] uppercase text-xs mb-4 block">Our Goals</span>
                    <h2 class="text-3xl md:text-5xl font-black text-white mb-6 tracking-tight uppercase">{{ __('messages.vision') }} & {{ __('messages.mission') }}</h2>
                    <div class="h-2 w-24 bg-red-600 mx-auto rounded-full"></div>
                </div>

                <div class="grid lg:grid-cols-2 gap-10 md:gap-16">
                    {{-- Vision Card --}}
                    <div class="bg-white/5 backdrop-blur-xl p-10 md:p-16 rounded-[4rem] border border-white/10 hover:bg-white/10 transition group">
                        <div class="w-20 h-20 bg-red-600 rounded-3xl flex items-center justify-center mb-10 shadow-xl shadow-red-600/30 group-hover:scale-110 transition duration-500">
                            <i class="fas fa-eye text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-black text-white mb-8 uppercase tracking-tight">{{ $profiles['vision']->title ?? __('messages.vision') }}</h3>
                        <p class="text-gray-300 leading-relaxed text-xl italic font-medium">
                            "{{ $profiles['vision']->content ?? 'Menjadi pusat unggulan teknologi dan bisnis.' }}"
                        </p>
                    </div>

                    {{-- Mission Card --}}
                    <div class="bg-white/5 backdrop-blur-xl p-10 md:p-16 rounded-[4rem] border border-white/10 hover:bg-white/10 transition group">
                        <div class="w-20 h-20 bg-red-600 rounded-3xl flex items-center justify-center mb-10 shadow-xl shadow-red-600/30 group-hover:scale-110 transition duration-500">
                            <i class="fas fa-bullseye text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-black text-white mb-8 uppercase tracking-tight">{{ $profiles['mission']->title ?? __('messages.mission') }}</h3>
                        <div class="text-gray-300 leading-relaxed text-lg space-y-6">
                            {!! nl2br(e($profiles['mission']->content ?? 'Mengembangkan SDM berkualitas.')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Organizational Structure -->
        <section id="struktur" class="py-20 md:py-32 bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
            <div class="container mx-auto px-4 md:px-12">
                <div class="text-center mb-16 md:mb-24">
                    <span class="text-red-600 font-black tracking-[0.2em] uppercase text-[10px] md:text-sm mb-4 block">{{ __('messages.leadership') }}</span>
                    <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-6 tracking-tight uppercase">{{ __('messages.structure') }}</h2>
                    <div class="h-2 w-24 bg-red-600 mx-auto rounded-full"></div>
                </div>

                <div class="max-w-6xl mx-auto overflow-x-auto pb-12">
                    <div class="min-w-[800px] lg:min-w-0">
                        {{-- Hierarchical Tree Rendering --}}
                        <div class="flex flex-col items-center gap-16">
                            @foreach($structures as $root)
                                <div class="flex flex-col items-center w-full">
                                    {{-- Level 1 Card --}}
                                    <div class="bg-white dark:bg-slate-800 p-8 rounded-[3rem] shadow-2xl border-2 border-red-600 dark:border-red-900 w-full max-w-sm text-center relative z-10 transform hover:scale-105 transition duration-500">
                                        <div class="w-32 h-32 mx-auto mb-6 rounded-3xl overflow-hidden border-4 border-red-50 dark:border-slate-700 shadow-xl">
                                            @if($root->image)
                                                <img src="{{ asset('storage/' . $root->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600">
                                                    <i class="fas fa-user text-5xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $root->name }}</h3>
                                        <p class="text-red-600 dark:text-red-500 font-black text-xs uppercase tracking-[0.3em] mt-3">{{ $root->position }}</p>
                                    </div>

                                    @if($root->children->count() > 0)
                                        <div class="w-px h-16 bg-red-600/30"></div>
                                        
                                        {{-- Children Grid --}}
                                        <div class="grid grid-cols-1 md:grid-cols-{{ min($root->children->count(), 4) }} gap-12 w-full relative">
                                            {{-- Horizontal Connector --}}
                                            @if($root->children->count() > 1)
                                                <div class="hidden md:block absolute top-0 left-[10%] right-[10%] h-px bg-red-600/30"></div>
                                            @endif

                                            @foreach($root->children as $child)
                                                <div class="flex flex-col items-center">
                                                    <div class="w-px h-10 bg-red-600/30"></div>
                                                    <div class="bg-white dark:bg-slate-800 p-6 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-slate-700 w-full max-w-[280px] text-center hover:border-red-400 transition group duration-500">
                                                        <div class="w-20 h-20 mx-auto mb-4 rounded-2xl overflow-hidden border-2 border-slate-50 dark:border-slate-700 grayscale group-hover:grayscale-0 transition duration-700">
                                                            @if($child->image)
                                                                <img src="{{ asset('storage/' . $child->image) }}" class="w-full h-full object-cover">
                                                            @else
                                                                <div class="w-full h-full bg-slate-50 dark:bg-slate-900 flex items-center justify-center text-slate-400">
                                                                    <i class="fas fa-user text-3xl"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <h4 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $child->name }}</h4>
                                                        <p class="text-gray-500 dark:text-gray-400 font-bold text-[10px] uppercase tracking-widest mt-2">{{ $child->position }}</p>
                                                    </div>

                                                    {{-- Level 3 recursive --}}
                                                    @if($child->children->count() > 0)
                                                        <div class="w-px h-8 bg-red-600/20"></div>
                                                        <div class="flex flex-col gap-4 w-full items-center">
                                                            @foreach($child->children as $subChild)
                                                                <div class="bg-slate-100/50 dark:bg-slate-900/50 px-6 py-3 rounded-2xl border border-dashed border-slate-200 dark:border-slate-800 w-full max-w-[220px] text-center hover:bg-white dark:hover:bg-slate-800 transition duration-300">
                                                                    <p class="text-xs font-black text-gray-800 dark:text-gray-200">{{ $subChild->name }}</p>
                                                                    <p class="text-[9px] text-gray-500 uppercase font-bold mt-1 tracking-tighter">{{ $subChild->position }}</p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                @if($structures->isEmpty())
                    <div class="bg-white dark:bg-slate-900 rounded-[3rem] p-24 text-center border-2 border-dashed border-gray-100 dark:border-slate-800 shadow-inner">
                        <i class="fas fa-sitemap text-7xl text-gray-200 mb-6"></i>
                        <p class="text-gray-400 text-lg italic tracking-widest uppercase font-bold">Data struktur organisasi belum tersedia.</p>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-gray-400 py-16 md:py-24 border-t-8 border-red-700 dark:border-red-900">
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex flex-col lg:flex-row justify-between items-start gap-12 md:gap-16">
                <div class="w-full lg:w-1/3 text-center md:text-left">
                    <a href="{{ url('/') }}" class="text-2xl md:text-3xl font-black text-white flex items-center justify-center md:justify-start mb-6 md:mb-8 tracking-tighter">
                        <i class="fas fa-university mr-3 text-red-600"></i> JKB POLITALA
                    </a>
                    <p class="text-base leading-relaxed mb-8">
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
                    <ul class="space-y-3 font-bold text-xs">
                        <li><a href="{{ url('/') }}" class="hover:text-red-500 transition-colors uppercase">{{ __('messages.home') }}</a></li>
                        <li><a href="{{ route('landing.news') }}" class="hover:text-red-500 transition-colors uppercase">{{ __('messages.news') }}</a></li>
                        <li><a href="{{ route('landing.downloads') }}" class="hover:text-red-500 transition-colors uppercase">{{ __('messages.downloads') }}</a></li>
                    </ul>
                </div>
                <div class="w-full lg:w-1/3 text-center md:text-left">
                    <h5 class="text-white font-black uppercase tracking-widest mb-6 md:mb-8 border-b-2 border-red-700 inline-block">{{ __('messages.contact_us') }}</h5>
                    <ul class="space-y-4 text-sm">
                        <li class="flex flex-col md:flex-row items-center md:items-start">
                            <i class="fas fa-map-marker-alt mb-2 md:mt-1.5 md:mr-4 text-red-600"></i>
                            <span>Jl. Ahmad Yani KM.06, Desa Panggung, Pelaihari, Tanah Laut, Kalimantan Selatan.</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-4 text-red-600"></i>
                            <span>jkb@politala.ac.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/5 mt-16 md:mt-20 pt-10 text-center text-[10px] md:text-sm font-bold tracking-widest uppercase">
                &copy; {{ date('Y') }} {{ __('messages.copyright') }}
            </div>
        </div>
    </footer>

</body>
</html>
