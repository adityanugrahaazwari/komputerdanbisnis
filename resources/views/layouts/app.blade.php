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
        .sidebar-gradient {
            background: linear-gradient(180deg, var(--primary-color) 0%, #450a0a 100%);
        }
        .dark .sidebar-gradient {
            background: linear-gradient(180deg, #450a0a 0%, #000000 100%);
        }
        .active-menu {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--primary-color);
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-sans leading-normal tracking-normal min-h-screen transition-colors duration-300" x-data="{ sidebarOpen: false }">

    @include('partials.admin.sidebar')

    <!-- Main Content -->
    <div class="main-content flex flex-col min-h-screen lg:ml-64 transition-all duration-300">
        @include('partials.admin.header')

        <!-- Content Area -->
        <div class="p-4 md:p-8 max-w-[1600px] mx-auto flex-1 w-full">
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

        @include('partials.admin.footer')
    </div>

    @stack('scripts')
</body>
</html>
