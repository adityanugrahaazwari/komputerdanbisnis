@extends('layouts.frontend')

@section('title', __('messages.all_news') . ' - ' . $siteSettings['name'])

@section('content')
    <main class="container mx-auto px-4 md:px-12 py-12 md:py-20 min-h-[60vh]">
        <!-- Breadcrumbs -->
        @include('partials.breadcrumbs', [
            'items' => [
                ['label' => __('messages.news'), 'url' => '#']
            ]
        ])

        <div class="flex flex-col md:flex-row justify-between items-end mb-12 md:mb-16 gap-8">
            <div class="text-center md:text-left">
                <h1 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white mb-4 tracking-tight uppercase">{{ __('messages.all_news') }}</h1>
                <p class="text-gray-500 dark:text-gray-400 max-w-2xl font-medium">{{ __('messages.latest_news_desc') }}</p>
            </div>
            
            <!-- Search & Filter -->
            <div class="w-full md:w-auto flex flex-col sm:flex-row gap-4">
                <form action="{{ route('landing.news') }}" method="GET" class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_news') }}" class="w-full sm:w-64 bg-white dark:bg-slate-900 border-2 border-gray-100 dark:border-slate-800 rounded-2xl py-3 px-6 pr-12 focus:ring-2 focus:ring-primary focus:border-transparent transition text-sm">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-gray-400 group-hover:text-primary transition">
                        <i class="fas fa-search text-xs"></i>
                    </button>
                </form>

                <div class="relative inline-block text-left" x-data="{ open: false }">
                    <button @click="open = !open" class="inline-flex justify-center w-full rounded-2xl border-2 border-gray-100 dark:border-slate-800 shadow-sm px-6 py-3 bg-white dark:bg-slate-900 text-sm font-black text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-800 transition uppercase tracking-widest">
                        {{ request('category') ? ($categories->where('slug', request('category'))->first()->name ?? __('messages.all_categories')) : __('messages.all_categories') }}
                        <i class="fas fa-filter ml-2 text-[10px] mt-1"></i>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-cloak class="origin-top-right absolute right-0 mt-2 w-56 rounded-2xl shadow-2xl bg-white dark:bg-slate-900 ring-1 ring-black ring-opacity-5 z-20 overflow-hidden border border-gray-100 dark:border-slate-800">
                        <div class="py-2">
                            <a href="{{ route('landing.news') }}" class="block px-6 py-3 text-xs font-black uppercase hover:bg-primary/5 dark:hover:bg-primary/10 hover:text-primary {{ !request('category') ? 'text-primary' : '' }}">
                                {{ __('messages.all_categories') }}
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('landing.news', ['category' => $cat->slug]) }}" class="block px-6 py-3 text-xs font-black uppercase hover:bg-primary/5 dark:hover:bg-primary/10 hover:text-primary {{ request('category') == $cat->slug ? 'text-primary' : '' }}">
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($posts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
                @foreach($posts as $post)
                    <article class="bg-white dark:bg-slate-900 rounded-[3rem] overflow-hidden shadow-xl dark:shadow-none flex flex-col border-b-[10px] border-primary transform hover:scale-[1.03] transition duration-500 border border-gray-100 dark:border-slate-800 group">
                        @if($post->image)
                            <div class="h-56 md:h-64 overflow-hidden relative">
                                <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-1000">
                                @if($post->category)
                                    <span class="absolute top-6 left-6 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest text-primary shadow-lg">{{ $post->category->name }}</span>
                                @endif
                            </div>
                        @else
                            <div class="h-56 md:h-64 bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-300 dark:text-slate-700 relative">
                                <i class="fas fa-newspaper text-7xl md:text-8xl"></i>
                                @if($post->category)
                                    <span class="absolute top-6 left-6 bg-white dark:bg-slate-900 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest text-primary shadow-sm">{{ $post->category->name }}</span>
                                @endif
                            </div>
                        @endif
                        <div class="p-8 md:p-10 flex-1 flex flex-col">
                            <div class="flex items-center text-[10px] font-bold text-gray-400 dark:text-gray-500 mb-6 uppercase tracking-[0.2em]">
                                <i class="fas fa-calendar-alt mr-3 text-primary"></i> {{ $post->created_at->format('d M Y') }}
                            </div>
                            <h3 class="text-xl md:text-2xl font-black text-gray-900 dark:text-white mb-6 leading-tight group-hover:text-primary transition line-clamp-2 h-14 md:h-16 uppercase tracking-tight">{{ $post->title }}</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-10 line-clamp-3 leading-relaxed italic">
                                {{ strip_tags($post->content) }}
                            </p>
                            <a href="{{ route('landing.post', $post->slug) }}" class="mt-auto inline-flex items-center gap-4 bg-slate-50 dark:bg-slate-800 text-primary px-8 py-3 rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] hover:bg-primary hover:text-white transition group/btn">
                                {{ __('messages.read_more') }}
                                <i class="fas fa-arrow-right transform group-hover/btn:translate-x-2 transition"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-20">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-32 bg-white dark:bg-slate-900 rounded-[3rem] border-2 border-dashed border-gray-100 dark:border-slate-800">
                <i class="fas fa-search text-6xl text-gray-200 dark:text-slate-800 mb-6 block"></i>
                <p class="text-gray-400 dark:text-gray-600 font-bold uppercase tracking-widest">{{ __('messages.no_data') }}</p>
            </div>
        @endif
    </main>
@endsection
