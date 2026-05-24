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
