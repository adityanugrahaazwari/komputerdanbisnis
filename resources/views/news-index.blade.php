<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true'
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.all_news') }} - JKB POLITALA</title>
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
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">

    <!-- Navbar -->
    <nav class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b-4 border-red-700 dark:border-red-900">
        <div class="container mx-auto px-4 md:px-12 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl md:text-2xl font-black text-red-700 dark:text-red-500 flex items-center tracking-tighter">
                <i class="fas fa-university mr-2 text-3xl"></i> JKB POLITALA
            </a>
            <div class="hidden lg:flex space-x-6 font-bold text-gray-700 dark:text-gray-300">
                <a href="{{ url('/') }}#beranda" class="hover:text-red-600 dark:hover:text-red-400 transition-colors uppercase text-xs">{{ __('messages.home') }}</a>
                <a href="{{ url('/') }}#profil" class="hover:text-red-600 dark:hover:text-red-400 transition-colors uppercase text-xs">{{ __('messages.profile') }}</a>
                <a href="{{ url('/') }}#prodi" class="hover:text-red-600 dark:hover:text-red-400 transition-colors uppercase text-xs">{{ __('messages.study_programs') }}</a>
                <a href="{{ url('/berita') }}" class="text-red-600 dark:text-red-400 font-bold uppercase text-xs">{{ __('messages.news') }}</a>
            </div>
            
            <div class="flex items-center gap-2 md:gap-4">
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-red-600 transition">
                    <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                </button>

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
                        <a href="{{ route('dashboard') }}" class="bg-red-700 text-white px-6 py-2 rounded-full font-bold hover:bg-red-800 transition text-xs">{{ __('messages.dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-gray-100 dark:bg-slate-800 text-red-700 dark:text-red-400 px-6 py-2 rounded-full font-bold hover:bg-red-50 dark:hover:bg-slate-700 transition border border-red-200 dark:border-slate-700 text-xs">{{ __('messages.login_staff') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-gradient-to-r from-red-900 to-red-600 text-white py-16 md:py-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        <div class="container mx-auto px-4 md:px-12 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight uppercase">{{ __('messages.all_news') }}</h1>
            <p class="text-red-100 max-w-2xl mx-auto italic text-lg md:text-xl opacity-90">
                Kumpulan kabar terkini, prestasi, dan pengumuman resmi dari Jurusan Komputer dan Bisnis POLITALA.
            </p>
        </div>
    </header>

    <!-- News List -->
    <main class="container mx-auto px-4 md:px-12 py-16 md:py-24">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 mb-16">
            @forelse($posts as $post)
            <article class="bg-white dark:bg-slate-900 rounded-[2rem] overflow-hidden shadow-xl dark:shadow-none flex flex-col hover:shadow-red-100 dark:hover:shadow-none transition-all duration-300 border-b-8 border-red-700 group border border-gray-100 dark:border-slate-800">
                @if($post->image)
                    <div class="h-56 md:h-64 overflow-hidden">
                        <img src="{{ asset('storage/' . $post->image) }}" class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                @else
                    <div class="h-56 md:h-64 w-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-200 dark:text-red-800">
                        <i class="fas fa-newspaper text-7xl md:text-8xl"></i>
                    </div>
                @endif
                <div class="p-6 md:p-8 flex-1 flex flex-col">
                    <div class="flex items-center text-[10px] md:text-xs font-bold text-red-600 dark:text-red-400 mb-4 uppercase tracking-widest">
                        <i class="fas fa-calendar-alt mr-2"></i> {{ $post->created_at->format('d M Y') }}
                        <span class="mx-3 opacity-30">|</span>
                        <i class="fas fa-user mr-1"></i> {{ $post->user->name }}
                    </div>
                    <h3 class="text-xl md:text-2xl font-black text-gray-900 dark:text-white mb-4 leading-tight line-clamp-2 h-14 md:h-16 group-hover:text-red-700 dark:group-hover:text-red-400 transition-colors">{{ $post->title }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-8 line-clamp-3 leading-relaxed">
                        {{ strip_tags($post->content) }}
                    </p>
                    <a href="{{ route('landing.post', $post->slug) }}" class="text-red-700 dark:text-red-400 font-black hover:text-red-900 dark:hover:text-red-300 flex items-center mt-auto uppercase text-[10px] md:text-xs tracking-widest">
                        {{ __('messages.read_more') }} <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-2"></i>
                    </a>
                </div>
            </article>
            @empty
                <div class="col-span-full text-center py-32 bg-white dark:bg-slate-900 rounded-[3rem] shadow-inner border border-gray-100 dark:border-slate-800">
                    <i class="fas fa-folder-open text-8xl text-red-100 dark:text-red-900/30 mb-6"></i>
                    <p class="text-gray-400 text-xl md:text-2xl font-medium">{{ __('messages.no_data') }}</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $posts->links() }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-gray-400 py-16 border-t-8 border-red-700 dark:border-red-900">
        <div class="container mx-auto px-4 md:px-12 text-center">
            <a href="{{ url('/') }}" class="text-3xl font-black text-white flex items-center justify-center mb-10 tracking-tighter">
                <i class="fas fa-university mr-3 text-red-600"></i> JKB POLITALA
            </a>
            <div class="flex justify-center space-x-8 text-3xl mb-12">
                @foreach($socialMedia as $social)
                    <a href="{{ $social->url }}" target="_blank" class="text-gray-600 hover:text-red-500 transition-colors" title="{{ $social->platform }}">
                        <i class="{{ $social->icon }}"></i>
                    </a>
                @endforeach
            </div>
            <div class="text-sm font-bold tracking-widest opacity-50 uppercase">
                &copy; {{ date('Y') }} JURUSAN KOMPUTER DAN BISNIS POLITALA.
            </div>
        </div>
    </footer>

</body>
</html>
