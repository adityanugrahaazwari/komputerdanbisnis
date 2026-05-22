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

@include('partials.navbar')

    <!-- Header -->

    <!-- Header -->
    <header class="bg-gradient-to-r from-red-900 to-red-600 text-white py-16 md:py-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        <div class="container mx-auto px-4 md:px-12 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight uppercase">{{ __('messages.all_news') }}</h1>
            
            <!-- Breadcrumbs -->
            <nav class="flex justify-center mb-8 text-xs font-bold uppercase tracking-widest opacity-70">
                <a href="{{ url('/') }}" class="hover:text-red-200 transition">{{ __('messages.home') }}</a>
                <span class="mx-3">/</span>
                <span class="text-red-200">{{ __('messages.news') }}</span>
            </nav>

            <!-- Search & Filter Bar -->
            <div class="max-w-4xl mx-auto bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 shadow-2xl">
                <form action="{{ route('landing.news') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_news') }}" class="w-full bg-white/10 border border-white/20 rounded-xl py-3 pl-12 pr-4 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 transition">
                    </div>
                    <div class="md:w-64">
                        <select name="category" class="w-full bg-white/10 border border-white/20 rounded-xl py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-white/30 transition appearance-none cursor-pointer">
                            <option value="" class="bg-red-800">{{ __('messages.all_categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" class="bg-red-800" {{ request('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-white text-red-700 px-8 py-3 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-red-50 transition shadow-lg">
                        {{ __('messages.filter') }}
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- News List -->
    <main class="container mx-auto px-4 md:px-12 py-16 md:py-24">
        @if(request('search') || request('category'))
            <div class="mb-12 text-center">
                <p class="text-gray-500 dark:text-gray-400 font-bold uppercase tracking-widest text-xs">
                    Hasil pencarian untuk: 
                    @if(request('search')) <span class="text-red-600 dark:text-red-400">"{{ request('search') }}"</span> @endif
                    @if(request('category')) <span class="ml-2 px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-full text-[10px]">{{ request('category') }}</span> @endif
                </p>
            </div>
        @endif
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 mb-16">
            @forelse($posts as $post)
            <article class="bg-white dark:bg-slate-900 rounded-[2rem] overflow-hidden shadow-xl dark:shadow-none flex flex-col hover:shadow-red-100 dark:hover:shadow-none transition-all duration-300 border-b-8 border-red-700 group border border-gray-100 dark:border-slate-800">
                @if($post->image)
                    <div class="h-56 md:h-64 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $post->image) }}" class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                        @if($post->category)
                            <span class="absolute top-4 left-4 bg-red-700 text-white px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg">
                                {{ $post->category->name }}
                            </span>
                        @endif
                    </div>
                @else
                    <div class="h-56 md:h-64 w-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-200 dark:text-red-800 relative">
                        <i class="fas fa-newspaper text-7xl md:text-8xl"></i>
                        @if($post->category)
                            <span class="absolute top-4 left-4 bg-red-700 text-white px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg">
                                {{ $post->category->name }}
                            </span>
                        @endif
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

@include('partials.footer')

</body>
</html>
