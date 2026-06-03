<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        :root {
            --primary-color: #ef4444;
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
                            500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300 min-h-screen flex flex-col items-center justify-center p-6">
    
    <div class="max-w-md w-full text-center">
        <!-- Icon -->
        <div class="mb-12 relative inline-block">
            <div class="w-32 h-32 bg-red-100 dark:bg-red-900/30 rounded-[2.5rem] flex items-center justify-center text-red-700 text-6xl transform rotate-12">
                @yield('icon')
            </div>
            <div class="absolute -bottom-2 -right-2 w-16 h-16 bg-white dark:bg-slate-900 rounded-2xl shadow-xl flex items-center justify-center text-gray-900 dark:text-white font-black text-xl">
                @yield('code')
            </div>
        </div>

        <!-- Content -->
        <h1 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-4 tracking-tight uppercase">
            @yield('message')
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mb-12 text-lg">
            @yield('description')
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}" class="bg-red-700 text-white px-8 py-4 rounded-2xl font-black uppercase text-xs tracking-[0.2em] hover:bg-red-800 transition shadow-xl shadow-red-900/20 dark:shadow-none">
                <i class="fas fa-home mr-2"></i> Beranda
            </a>
            <button onclick="window.history.back()" class="bg-white dark:bg-slate-900 text-gray-900 dark:text-white px-8 py-4 rounded-2xl font-black uppercase text-xs tracking-[0.2em] hover:bg-slate-100 dark:hover:bg-slate-800 transition border border-gray-100 dark:border-slate-800">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </button>
        </div>
    </div>

    <!-- Footer decoration -->
    <div class="mt-20 text-[10px] font-black uppercase tracking-[0.5em] text-gray-400 opacity-30">
        {{ config('app.name') }} &bull; Politeknik Negeri Tanah Laut
    </div>

</body>
</html>
