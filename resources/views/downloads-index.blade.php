<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true'
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.downloads') }} - JKB POLITALA</title>
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
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">

@include('partials.navbar')

    <!-- Header -->

    <!-- Header -->
    <header class="bg-gradient-to-r from-primary to-primary/80 text-white py-12 md:py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        <div class="container mx-auto px-4 md:px-12 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight uppercase">Pusat <span class="text-red-200">{{ __('messages.downloads') }}</span></h1>
            
            <!-- Breadcrumbs -->
            <nav class="flex justify-center mb-8 text-xs font-bold uppercase tracking-widest opacity-70">
                <a href="{{ url('/') }}" class="hover:text-red-200 transition">{{ __('messages.home') }}</a>
                <span class="mx-3">/</span>
                <span class="text-red-200">{{ __('messages.downloads') }}</span>
            </nav>
            
            <p class="max-w-2xl mx-auto text-red-50 font-medium leading-relaxed opacity-90">
                {{ __('messages.downloads_desc') }}
            </p>
        </div>
    </header>

    <!-- Documents List -->
    <main class="container mx-auto px-4 md:px-12 py-16 md:py-24">
        @forelse($documents as $category => $items)
            <div class="mb-20">
                <div class="flex items-center gap-4 mb-10">
                    <div class="h-10 w-2 bg-red-700 rounded-full"></div>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-wider">{{ $category ?: 'Lain-lain' }}</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($items as $doc)
                        <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-slate-800 flex flex-col group hover:border-red-500 transition-all duration-500 transform hover:-translate-y-2">
                            @php
                                $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                                $icon = match($ext) {
                                    'pdf' => 'fa-file-pdf text-red-600',
                                    'doc', 'docx' => 'fa-file-word text-blue-600',
                                    'xls', 'xlsx' => 'fa-file-excel text-green-600',
                                    'ppt', 'pptx' => 'fa-file-powerpoint text-orange-600',
                                    'zip', 'rar' => 'fa-file-archive text-purple-600',
                                    default => 'fa-file text-gray-400'
                                };
                            @endphp
                            <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-3xl flex items-center justify-center mb-8 group-hover:bg-red-50 dark:group-hover:bg-red-900/20 transition-colors duration-500">
                                <i class="fas {{ $icon }} text-4xl"></i>
                            </div>
                            
                            <h3 class="font-black text-gray-900 dark:text-white text-lg uppercase tracking-tight mb-3 group-hover:text-red-700 transition-colors">{{ $doc->title }}</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-8 line-clamp-2 leading-relaxed italic">
                                "{{ $doc->description ?: 'Tidak ada deskripsi tambahan untuk file ini.' }}"
                            </p>
                            
                            <div class="mt-auto pt-6 border-t border-gray-50 dark:border-slate-800 flex items-center justify-between">
                                <div class="text-[10px] font-black uppercase tracking-widest text-gray-400">
                                    {{ strtoupper($ext) }} &bull; {{ $doc->created_at->format('d M Y') }}
                                </div>
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="bg-red-700 text-white w-12 h-12 rounded-2xl flex items-center justify-center hover:bg-red-800 transition shadow-lg shadow-primary/20 dark:shadow-none">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-32 bg-white dark:bg-slate-900 rounded-[3rem] shadow-inner border border-gray-100 dark:border-slate-800">
                <i class="fas fa-file-excel text-8xl text-red-50 dark:text-red-900/20 mb-6"></i>
                <p class="text-gray-400 text-xl font-medium">Belum ada dokumen yang tersedia untuk diunduh.</p>
            </div>
        @endforelse
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-gray-400 py-16 border-t-8 border-red-700 dark:border-red-900 text-center">
        <div class="container mx-auto px-4 md:px-12">
            <p class="text-sm font-bold tracking-widest uppercase">&copy; {{ date('Y') }} {{ __('messages.copyright') }}</p>
        </div>
    </footer>

</body>
</html>
