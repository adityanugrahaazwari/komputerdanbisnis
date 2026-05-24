<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true',
    sidebarOpen: false 
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('header', 'Dashboard') - {{ $siteSettings['name'] }} Admin</title>
    @if(isset($siteSettings['favicon']) && $siteSettings['favicon'])
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings['favicon']) }}">
    @endif
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
                            50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171',
                            500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-gradient {
            background: linear-gradient(180deg, #7f1d1d 0%, #450a0a 100%);
        }
        .dark .sidebar-gradient {
            background: linear-gradient(180deg, #450a0a 0%, #000000 100%);
        }
        .active-menu {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #ef4444;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-sans leading-normal tracking-normal min-h-screen transition-colors duration-300" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-cloak
         @click="sidebarOpen = false" 
         class="fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity">
    </div>

    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
         class="sidebar-gradient shadow-2xl h-screen fixed w-64 z-50 transition-transform duration-300 lg:translate-x-0 overflow-y-auto">
        
        <div class="p-6 bg-black/20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if(isset($siteSettings['logo']) && $siteSettings['logo'])
                    <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Logo" class="h-8">
                @else
                    <i class="fas fa-university text-2xl text-red-500"></i>
                @endif
                <span class="text-white font-black tracking-tighter text-xl truncate">{{ $siteSettings['name'] }}</span>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-white/50 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="p-4">
            <p class="text-red-400/50 text-[10px] font-black uppercase tracking-[0.2em] mb-4 ml-2">Menu Utama</p>
            <ul class="list-reset flex flex-col gap-1">
                @foreach($dynamicMenus as $menu)
                    @if(!$menu->permission_slug || auth()->user()->hasPermission($menu->permission_slug))
                        <li class="w-full">
                            @if($menu->url)
                                <a href="{{ url($menu->url) }}" class="flex items-center text-gray-300 hover:text-white hover:bg-white/10 rounded-xl px-4 py-3 transition-all duration-200 group {{ Request::is(trim($menu->url, '/')) ? 'active-menu text-white bg-white/5' : '' }}">
                                    <i class="{{ $menu->icon }} mr-3 w-5 text-center text-lg transition-transform group-hover:scale-110"></i> 
                                    <span class="font-bold text-sm uppercase tracking-wide">
                                        {{ Str::contains($menu->title, 'messages.') ? __($menu->title) : $menu->title }}
                                    </span>
                                </a>
                            @else
                                <div class="text-red-400/50 text-[10px] font-black uppercase tracking-[0.2em] mt-6 mb-2 ml-2 flex items-center">
                                    <span class="mr-2">{{ Str::contains($menu->title, 'messages.') ? __($menu->title) : $menu->title }}</span>
                                    <div class="flex-1 h-px bg-white/10"></div>
                                </div>
                                @if($menu->children->count() > 0)
                                    <ul class="list-reset flex flex-col gap-1">
                                        @foreach($menu->children as $child)
                                            @if(!$child->permission_slug || auth()->user()->hasPermission($child->permission_slug))
                                                <li>
                                                    <a href="{{ $child->url ? url($child->url) : '#' }}" class="flex items-center text-gray-400 hover:text-white hover:bg-white/10 rounded-xl px-4 py-2.5 ml-2 transition-all duration-200 group {{ $child->url && Request::is(trim($child->url, '/')) ? 'text-red-400 font-bold bg-white/5' : '' }}">
                                                        <i class="{{ $child->icon }} mr-3 w-4 text-center group-hover:text-red-500"></i> 
                                                        <span class="text-xs font-bold uppercase tracking-wider flex-1">
                                                            {{ Str::contains($child->title, 'messages.') ? __($child->title) : $child->title }}
                                                        </span>
                                                        
                                                        {{-- Notification Badges --}}
                                                        @if($child->url == '/comments' && $notifications['pending_comments'] > 0)
                                                            <span class="bg-red-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded-full animate-bounce shadow-lg shadow-red-900/50">
                                                                {{ $notifications['pending_comments'] }}
                                                            </span>
                                                        @elseif($child->url == '/contacts' && $notifications['unread_contacts'] > 0)
                                                            <span class="bg-blue-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded-full animate-pulse shadow-lg shadow-blue-900/50">
                                                                {{ $notifications['unread_contacts'] }}
                                                            </span>
                                                        @endif
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
        
        <div class="mt-auto p-4 sticky bottom-0 bg-inherit">
             <div class="bg-black/20 rounded-2xl p-4 flex items-center gap-3 border border-white/5">
                <div class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center text-white font-bold shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-white text-xs font-bold truncate">{{ auth()->user()->name }}</p>
                    <p class="text-red-400/50 text-[10px] uppercase font-black truncate">{{ auth()->user()->roles->first()->name ?? 'Staff' }}</p>
                </div>
             </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-1 bg-gray-50 dark:bg-slate-950 pb-24 lg:ml-64 transition-all duration-300">
        <!-- Header -->
        <div class="bg-white dark:bg-slate-900 p-4 md:p-6 shadow-sm border-b border-gray-200 dark:border-slate-800 flex justify-between items-center sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 dark:text-gray-400 hover:text-red-600 p-2">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="hidden sm:block w-1.5 h-8 bg-red-600 rounded-full"></div>
                <h2 class="font-black text-gray-800 dark:text-white text-lg md:text-2xl tracking-tight uppercase truncate">
                    @yield('header', 'Dashboard')
                </h2>
            </div>
            
            <div class="flex items-center gap-2 md:gap-6">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-red-600 transition">
                    <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                </button>

                <!-- Language Switcher -->
                <div class="relative" x-data="{ langOpen: false }">
                    <button @click="langOpen = !langOpen" class="flex items-center gap-2 p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs font-bold uppercase tracking-widest transition dark:text-gray-300">
                        <i class="fas fa-globe"></i>
                        <span class="hidden sm:inline">{{ strtoupper(app()->getLocale()) }}</span>
                    </button>
                    <div x-show="langOpen" @click.outside="langOpen = false" x-cloak class="absolute right-0 mt-2 w-32 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden">
                        <a href="{{ route('lang.switch', 'id') }}" class="block px-4 py-2 text-xs font-bold hover:bg-red-50 dark:hover:bg-red-900/30 {{ app()->getLocale() == 'id' ? 'text-red-600' : 'dark:text-gray-400' }}">INDONESIA</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-xs font-bold hover:bg-red-50 dark:hover:bg-red-900/30 {{ app()->getLocale() == 'en' ? 'text-red-600' : 'dark:text-gray-400' }}">ENGLISH</a>
                    </div>
                </div>

                <div class="hidden md:flex flex-col items-end">
                    <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] font-bold text-red-600 uppercase tracking-widest">{{ auth()->user()->roles->first()->name ?? 'User' }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gray-100 dark:bg-slate-800 hover:bg-red-50 dark:hover:bg-red-900/20 text-gray-500 dark:text-gray-400 hover:text-red-700 dark:hover:text-red-400 px-3 md:px-4 py-2 rounded-xl transition-all duration-200 border border-gray-200 dark:border-slate-700 hover:border-red-200 group flex items-center">
                        <i class="fas fa-sign-out-alt md:mr-2 group-hover:transform group-hover:translate-x-1 transition-transform"></i>
                        <span class="hidden md:inline text-xs font-black uppercase tracking-widest">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4 md:p-8 max-w-[1600px] mx-auto">
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 text-green-700 dark:text-green-400 p-4 mb-8 rounded-r-xl shadow-sm flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <span class="font-bold text-sm md:text-base">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 text-red-700 dark:text-red-400 p-4 mb-8 rounded-r-xl shadow-sm flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                    <span class="font-bold text-sm md:text-base">{{ session('error') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
