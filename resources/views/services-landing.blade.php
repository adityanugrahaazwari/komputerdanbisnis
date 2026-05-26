<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true'
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.services') }} - JKB POLITALA</title>
    @include('partials.seo', [
        'seoTitle' => __('messages.services') . ' - JKB POLITALA',
        'seoDescription' => 'Layanan digital terintegrasi untuk mendukung aktivitas civitas akademika Jurusan Komputer dan Bisnis.'
    ])
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
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">

@include('partials.navbar')

    <!-- Header -->

    <!-- Header -->
    <header class="bg-slate-900 text-white py-12 md:py-20 text-center relative">
        <div class="container mx-auto px-4">
            <!-- Breadcrumbs -->
            @include('partials.breadcrumbs', [
                'items' => [
                    ['label' => __('messages.services'), 'url' => route('landing.services')]
                ],
                'class' => 'text-white/70 justify-center',
                'activeClass' => 'text-red-500'
            ])
            <span class="text-red-600 font-black tracking-[0.2em] uppercase text-xs mb-4 block">Integrated Platforms</span>
            <h1 class="text-4xl md:text-6xl font-black mb-4 uppercase tracking-tight">{{ __('messages.services') }} <span class="text-red-600">Luar</span></h1>
            <p class="text-gray-400 max-w-2xl mx-auto italic">{{ __('messages.integrated_services_desc') }}</p>
        </div>
    </header>

    <!-- Services Grid -->
    <main class="container mx-auto px-4 md:px-12 py-16 md:py-24">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($services as $service)
                <a href="{{ $service->url }}" target="_blank" class="group bg-white dark:bg-slate-800 p-10 rounded-[3rem] shadow-xl border border-gray-100 dark:border-slate-700 hover:bg-red-700 dark:hover:bg-red-800 transition-all duration-500 flex flex-col items-center text-center transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-white/20 transition-colors">
                        <i class="{{ $service->icon ?: 'fas fa-link' }} text-3xl text-red-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <h4 class="text-xl font-black uppercase tracking-tight mb-4 group-hover:text-white transition-colors">{{ $service->title }}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-red-100 transition-colors leading-relaxed mb-6">
                        {{ $service->description ?: 'Akses layanan sistem ' . $service->title . ' secara langsung.' }}
                    </p>
                    <div class="mt-auto w-12 h-12 rounded-full bg-slate-50 dark:bg-slate-900 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all transform translate-y-4 group-hover:translate-y-0 group-hover:bg-white/20">
                        <i class="fas fa-external-link-alt text-xs text-white"></i>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20 bg-white dark:bg-slate-900 rounded-[3rem] border-2 border-dashed border-gray-100 dark:border-slate-800">
                    <p class="text-gray-400 italic">Belum ada layanan yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-gray-400 py-16 border-t-8 border-red-700 dark:border-red-900 text-center">
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex justify-center space-x-6 text-2xl mb-8">
                @foreach($socialMedia as $social)
                    <a href="{{ $social->url }}" target="_blank" class="text-gray-600 hover:text-red-500 transition-colors" title="{{ $social->platform }}">
                        <i class="{{ $social->icon }}"></i>
                    </a>
                @endforeach
            </div>
            <p class="text-sm font-bold tracking-widest uppercase">&copy; {{ date('Y') }} {{ __('messages.copyright') }}</p>
        </div>
    </footer>

</body>
</html>
