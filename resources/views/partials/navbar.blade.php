<!-- Navbar -->
<nav x-data="{ mobileMenuOpen: false }" class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b-4 border-red-700 dark:border-red-900">
    <div class="container mx-auto px-4 md:px-12 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-xl md:text-2xl font-black text-red-700 dark:text-red-500 flex items-center tracking-tighter">
            @if(isset($siteSettings['logo']) && $siteSettings['logo'])
                <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="{{ $siteSettings['name'] }}" class="h-10 mr-3">
            @else
                <i class="fas fa-university mr-2 text-3xl"></i>
            @endif
            {{ $siteSettings['name'] }}
        </a>
        
        <!-- Desktop Menu -->
        <div class="hidden lg:flex space-x-8 font-bold text-gray-700 dark:text-gray-300">
            @foreach($frontendMenus as $menu)
                @if($menu->children->count() > 0)
                    <!-- Dropdown Menu -->
                    <div class="relative group" x-data="{ open: false }">
                        <button @mouseenter="open = true" @mouseleave="open = false" class="hover:text-red-600 dark:hover:text-red-400 transition-colors uppercase text-xs tracking-widest flex items-center">
                            {{ Str::contains($menu->title, 'messages.') ? __($menu->title) : $menu->title }}
                            <i class="fas fa-chevron-down ml-1.5 text-[10px]"></i>
                        </button>
                        <div x-show="open" @mouseenter="open = true" @mouseleave="open = false" x-cloak class="absolute left-0 pt-4 w-48">
                            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-slate-800 py-3 overflow-hidden">
                                @foreach($menu->children as $child)
                                    <a href="{{ Str::startsWith($child->url, '/') ? url($child->url) : $child->url }}" class="block px-6 py-2.5 text-[10px] font-black uppercase hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 transition">
                                        {{ Str::contains($child->title, 'messages.') ? __($child->title) : $child->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ Str::startsWith($menu->url, '/') ? url($menu->url) : $menu->url }}" class="hover:text-red-600 dark:hover:text-red-400 transition-colors uppercase text-xs tracking-widest">
                        {{ Str::contains($menu->title, 'messages.') ? __($menu->title) : $menu->title }}
                    </a>
                @endif
            @endforeach
        </div>

        <div class="flex items-center gap-2 md:gap-4">
            <!-- Global Search -->
            <div x-data="{ searchOpen: false }" class="relative">
                <button @click="searchOpen = !searchOpen" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-red-600 transition">
                    <i class="fas" :class="searchOpen ? 'fa-times' : 'fa-search'"></i>
                </button>
                <div x-show="searchOpen" 
                     x-cloak 
                     @click.outside="searchOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="absolute right-0 mt-4 w-[280px] md:w-[400px] bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-gray-100 dark:border-slate-800 p-4 z-[60]">
                    <form action="{{ route('search') }}" method="GET">
                        <div class="relative">
                            <input type="text" name="q" placeholder="Cari sesuatu..." autofocus class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-3 px-5 pr-12 focus:ring-2 focus:ring-red-600 transition text-sm text-gray-900 dark:text-white">
                            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-red-700 text-white rounded-xl flex items-center justify-center hover:bg-red-800 transition">
                                <i class="fas fa-search text-xs"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Dark Mode Toggle -->
            <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-red-600 transition">
                <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
            </button>

            <!-- Language Switcher -->
            <div class="relative" x-data="{ langOpen: false }">
                <button @click="langOpen = !langOpen" class="flex items-center gap-2 p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-[10px] font-black uppercase tracking-widest transition dark:text-gray-300">
                    <i class="fas fa-globe"></i>
                    <span>{{ strtoupper(app()->getLocale()) }}</span>
                </button>
                <div x-show="langOpen" @click.outside="langOpen = false" x-cloak class="absolute right-0 mt-2 w-32 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <a href="{{ route('lang.switch', 'id') }}" class="block px-4 py-2 text-[10px] font-black hover:bg-red-50 dark:hover:bg-red-900/30 {{ app()->getLocale() == 'id' ? 'text-red-600' : 'dark:text-gray-400' }}">INDONESIA</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-[10px] font-black hover:bg-red-50 dark:hover:bg-red-900/30 {{ app()->getLocale() == 'en' ? 'text-red-600' : 'dark:text-gray-400' }}">ENGLISH</a>
                </div>
            </div>

            <div class="hidden sm:block">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-red-700 text-white px-6 py-2 rounded-full font-bold hover:bg-red-800 transition shadow-lg shadow-red-200 dark:shadow-none text-xs">{{ __('messages.dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="bg-gray-900 dark:bg-slate-800 text-white px-6 py-2 rounded-full font-bold hover:bg-red-700 transition shadow-xl text-xs">{{ __('messages.login_staff') }}</a>
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
         class="lg:hidden bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-slate-800 absolute w-full shadow-xl max-h-[80vh] overflow-y-auto">
        <div class="flex flex-col p-6 space-y-1">
            <!-- Mobile Search -->
            <form action="{{ route('search') }}" method="GET" class="mb-6">
                <div class="relative">
                    <input type="text" name="q" placeholder="Cari sesuatu..." class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 px-6 pr-14 focus:ring-2 focus:ring-red-600 transition text-sm text-gray-900 dark:text-white">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-red-700 text-white rounded-xl flex items-center justify-center hover:bg-red-800 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            @foreach($frontendMenus as $menu)
                @if($menu->children->count() > 0)
                    <div class="p-3 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mt-4 border-b border-gray-50 dark:border-slate-800 mb-2">
                        {{ Str::contains($menu->title, 'messages.') ? __($menu->title) : $menu->title }}
                    </div>
                    @foreach($menu->children as $child)
                        <a href="{{ Str::startsWith($child->url, '/') ? url($child->url) : $child->url }}" @click="mobileMenuOpen = false" class="p-3 text-xs font-bold text-gray-700 dark:text-gray-300 hover:text-red-700 flex items-center">
                            <i class="{{ $child->icon ?: 'fas fa-link' }} mr-3 w-5 text-center opacity-50"></i>
                            {{ Str::contains($child->title, 'messages.') ? __($child->title) : $child->title }}
                        </a>
                    @endforeach
                @else
                    <a href="{{ Str::startsWith($menu->url, '/') ? url($menu->url) : $menu->url }}" @click="mobileMenuOpen = false" class="p-3 text-xs font-black uppercase tracking-widest hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 rounded-xl transition">
                        {{ Str::contains($menu->title, 'messages.') ? __($menu->title) : $menu->title }}
                    </a>
                @endif
            @endforeach

            <div class="pt-6">
                @auth
                    <a href="{{ route('dashboard') }}" class="block text-center bg-red-700 text-white px-6 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-red-200 dark:shadow-none">{{ __('messages.dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="block text-center bg-gray-900 dark:bg-slate-800 text-white px-6 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl">{{ __('messages.login_staff') }}</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
