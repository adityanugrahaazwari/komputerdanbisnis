<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true'
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.gallery') }} - JKB POLITALA</title>
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
    <header class="bg-gradient-to-r from-primary to-primary/80 text-white py-12 md:py-20 relative overflow-hidden text-center">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        <div class="container mx-auto px-4 md:px-12 relative z-10">
            <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight uppercase">{{ __('messages.gallery') }} <span class="text-red-200">Kegiatan</span></h1>
            
            <!-- Breadcrumbs -->
            <nav class="flex justify-center mb-8 text-xs font-bold uppercase tracking-widest opacity-70">
                <a href="{{ url('/') }}" class="hover:text-red-200 transition">{{ __('messages.home') }}</a>
                <span class="mx-3">/</span>
                <span class="text-red-200">{{ __('messages.gallery') }}</span>
            </nav>
            
            <p class="max-w-2xl mx-auto text-red-50 font-medium leading-relaxed opacity-90 italic">
                {{ __('messages.gallery_desc') }}
            </p>
        </div>
    </header>

    <!-- Gallery Grid -->
    <main class="container mx-auto px-4 md:px-12 py-16 md:py-24 space-y-24">
        
        @foreach($galleryGroups as $group)
            @if($group->galleries->count() > 0)
                <section>
                    <div class="mb-10 text-center md:text-left border-l-8 border-red-600 pl-6">
                        <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $group->name }}</h2>
                        @if($group->description)
                            <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">{{ $group->description }}</p>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        @foreach($group->galleries as $gallery)
                            <div class="group relative overflow-hidden rounded-[2.5rem] aspect-square shadow-2xl border border-gray-100 dark:border-slate-800 bg-white dark:bg-slate-900 transition-all duration-500 transform hover:-translate-y-2" x-data="{ open: false }">
                                <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                
                                {{-- Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-8">
                                    <div class="transform translate-y-8 group-hover:translate-y-0 transition-transform duration-500">
                                        <h3 class="text-white font-black uppercase text-lg tracking-tight mb-3">{{ $gallery->title }}</h3>
                                        <p class="text-gray-300 text-xs line-clamp-3 leading-relaxed mb-6 italic opacity-80">
                                            "{{ $gallery->description ?: 'Dokumentasi kegiatan akademik Jurusan Komputer dan Bisnis.' }}"
                                        </p>
                                        <div class="flex items-center gap-4">
                                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest border-l-2 border-red-600 pl-3">
                                                {{ $gallery->created_at->format('M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach

        @if($ungroupedGalleries->count() > 0)
            <section>
                <div class="mb-10 text-center md:text-left border-l-8 border-gray-400 pl-6">
                    <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Lainnya</h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Koleksi foto lainnya.</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($ungroupedGalleries as $gallery)
                        <div class="group relative overflow-hidden rounded-[2.5rem] aspect-square shadow-2xl border border-gray-100 dark:border-slate-800 bg-white dark:bg-slate-900 transition-all duration-500 transform hover:-translate-y-2" x-data="{ open: false }">
                            <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            
                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-8">
                                <div class="transform translate-y-8 group-hover:translate-y-0 transition-transform duration-500">
                                    <span class="text-gray-400 font-black text-[10px] uppercase tracking-[0.3em] mb-2 block">JKB MOMENT</span>
                                    <h3 class="text-white font-black uppercase text-lg tracking-tight mb-3">{{ $gallery->title }}</h3>
                                    <p class="text-gray-300 text-xs line-clamp-3 leading-relaxed mb-6 italic opacity-80">
                                        "{{ $gallery->description ?: 'Dokumentasi kegiatan akademik Jurusan Komputer dan Bisnis.' }}"
                                    </p>
                                    <div class="flex items-center gap-4">
                                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest border-l-2 border-red-600 pl-3">
                                            {{ $gallery->created_at->format('M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-16 flex justify-center">
                    {{ $ungroupedGalleries->links() }}
                </div>
            </section>
        @endif

        @if($galleryGroups->isEmpty() && $ungroupedGalleries->isEmpty())
            <div class="text-center py-32 bg-white dark:bg-slate-900 rounded-[3rem] shadow-inner border border-gray-100 dark:border-slate-800">
                <i class="fas fa-camera-retro text-8xl text-red-50 dark:text-red-900/20 mb-6"></i>
                <p class="text-gray-400 text-xl font-medium">Belum ada koleksi foto yang tersedia.</p>
            </div>
        @endif
    </main>

@include('partials.footer')

</body>
</html>
