<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('header', 'Dashboard') - JKB Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .sidebar-gradient {
            background: linear-gradient(180deg, #7f1d1d 0%, #450a0a 100%);
        }
        .active-menu {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #ef4444;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans leading-normal tracking-normal flex min-h-screen">

    <!-- Sidebar -->
    <div class="sidebar-gradient shadow-2xl h-screen fixed w-64 z-50 transition-all duration-300">
        <div class="p-6 bg-black/20 flex items-center gap-3">
            <i class="fas fa-university text-2xl text-red-500"></i>
            <span class="text-white font-black tracking-tighter text-xl">JKB ADMIN</span>
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
                                    <span class="font-bold text-sm uppercase tracking-wide">{{ $menu->title }}</span>
                                </a>
                            @else
                                <div class="text-red-400/50 text-[10px] font-black uppercase tracking-[0.2em] mt-6 mb-2 ml-2 flex items-center">
                                    <span class="mr-2">{{ $menu->title }}</span>
                                    <div class="flex-1 h-px bg-white/10"></div>
                                </div>
                                @if($menu->children->count() > 0)
                                    <ul class="list-reset flex flex-col gap-1">
                                        @foreach($menu->children as $child)
                                            @if(!$child->permission_slug || auth()->user()->hasPermission($child->permission_slug))
                                                <li>
                                                    <a href="{{ url($child->url) }}" class="flex items-center text-gray-400 hover:text-white hover:bg-white/10 rounded-xl px-4 py-2.5 ml-2 transition-all duration-200 group {{ Request::is(trim($child->url, '/')) ? 'text-red-400 font-bold bg-white/5' : '' }}">
                                                        <i class="{{ $child->icon }} mr-3 w-4 text-center group-hover:text-red-500"></i> 
                                                        <span class="text-xs font-bold uppercase tracking-wider">{{ $child->title }}</span>
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
        
        <div class="absolute bottom-0 w-full p-4">
             <div class="bg-black/20 rounded-2xl p-4 flex items-center gap-3 border border-white/5">
                <div class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center text-white font-bold">
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
    <div class="main-content flex-1 bg-gray-50 pb-24 ml-64 transition-all duration-300">
        <!-- Header -->
        <div class="bg-white p-6 shadow-sm border-b border-gray-200 flex justify-between items-center sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                <h2 class="font-black text-gray-800 text-2xl tracking-tight uppercase">
                    @yield('header', 'Dashboard')
                </h2>
            </div>
            <div class="flex items-center gap-6">
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-sm font-black text-gray-900 uppercase tracking-tighter">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] font-bold text-red-600 uppercase tracking-widest">{{ auth()->user()->roles->first()->name ?? 'User' }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gray-100 hover:bg-red-50 text-gray-500 hover:text-red-700 px-4 py-2 rounded-xl transition-all duration-200 border border-gray-200 hover:border-red-200 group">
                        <i class="fas fa-sign-out-alt mr-2 group-hover:transform group-hover:translate-x-1 transition-transform"></i>
                        <span class="text-xs font-black uppercase tracking-widest">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8 max-w-[1600px] mx-auto">
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-r-xl shadow-sm flex items-center animate-fade-in">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-r-xl shadow-sm flex items-center animate-fade-in">
                    <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>
