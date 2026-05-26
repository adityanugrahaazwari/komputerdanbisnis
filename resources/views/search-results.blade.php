<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true',
    mobileMenuOpen: false 
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - {{ $siteSettings['name'] }}</title>
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
<body class="bg-slate-50 dark:bg-slate-950 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300 min-h-screen flex flex-col">

@include('partials.navbar')

    <main class="flex-grow pt-32 pb-20">
        <div class="container mx-auto px-4 md:px-12">
            <!-- Breadcrumbs -->
            @include('partials.breadcrumbs', [
                'items' => [
                    ['label' => 'Pencarian', 'url' => '#']
                ]
            ])
            <!-- Search Header -->
            <div class="mb-12">
                <h1 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-4 tracking-tight uppercase">
                    Hasil <span class="text-red-700">Pencarian</span>
                </h1>
                <p class="text-gray-500 dark:text-gray-400">
                    Ditemukan <span class="font-bold text-red-600">{{ $totalCount }}</span> hasil untuk kata kunci <span class="italic font-bold text-gray-900 dark:text-white">"{{ $query }}"</span>
                </p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('search') }}" method="GET" class="mb-16">
                <div class="relative max-w-2xl">
                    <input type="text" name="q" value="{{ $query }}" placeholder="Cari berita, dokumen, atau prodi..." class="w-full bg-white dark:bg-slate-900 border-none rounded-3xl py-5 px-8 pr-16 shadow-xl dark:shadow-none focus:ring-2 focus:ring-red-600 transition text-lg text-gray-900 dark:text-white border border-gray-100 dark:border-slate-800">
                    <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-red-700 text-white rounded-2xl flex items-center justify-center hover:bg-red-800 transition">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                </div>
            </form>

            @if($totalCount > 0)
                <div class="space-y-16">
                    <!-- News Results -->
                    @if($results['posts']->count() > 0)
                    <section>
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center text-red-700">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h2 class="text-xl font-black uppercase tracking-widest text-gray-900 dark:text-white">Berita & Informasi</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($results['posts'] as $post)
                            <article class="bg-white dark:bg-slate-900 rounded-[2rem] overflow-hidden shadow-sm border border-gray-100 dark:border-slate-800 hover:shadow-xl transition flex flex-col">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" class="h-48 w-full object-cover">
                                @endif
                                <div class="p-8 flex flex-col flex-1">
                                    <h3 class="text-lg font-black text-gray-900 dark:text-white mb-4 leading-tight">{{ $post->title }}</h3>
                                    <p class="text-gray-500 text-xs mb-6 line-clamp-2 italic">{{ strip_tags($post->content) }}</p>
                                    <a href="{{ route('landing.post', $post->slug) }}" class="mt-auto text-red-700 font-black text-xs uppercase tracking-widest flex items-center group">
                                        Baca Selengkapnya <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                                    </a>
                                </div>
                            </article>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    <!-- Study Program Results -->
                    @if($results['study_programs']->count() > 0)
                    <section>
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-700">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h2 class="text-xl font-black uppercase tracking-widest text-gray-900 dark:text-white">Program Studi</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($results['study_programs'] as $prodi)
                            <a href="{{ route('landing.study_programs') }}" class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800 flex items-center gap-6 hover:shadow-xl transition group">
                                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-3xl text-red-700 overflow-hidden shrink-0">
                                    @if($prodi->image)
                                        <img src="{{ asset('storage/' . $prodi->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-university"></i>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-black text-gray-900 dark:text-white text-xl uppercase group-hover:text-red-700 transition">{{ $prodi->name }}</h3>
                                    <p class="text-sm text-gray-500 line-clamp-1 italic">{{ $prodi->description }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    <!-- Document Results -->
                    @if($results['documents']->count() > 0)
                    <section>
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center text-green-700">
                                <i class="fas fa-file-download"></i>
                            </div>
                            <h2 class="text-xl font-black uppercase tracking-widest text-gray-900 dark:text-white">Dokumen & Download</h2>
                        </div>
                        <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden">
                            <ul class="divide-y divide-gray-50 dark:divide-slate-800">
                                @foreach($results['documents'] as $doc)
                                <li class="p-6 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-4">
                                            <i class="fas fa-file-pdf text-2xl text-red-500"></i>
                                            <div>
                                                <h4 class="font-bold text-gray-900 dark:text-white">{{ $doc->title }}</h4>
                                                <p class="text-xs text-gray-400 uppercase tracking-widest">{{ $doc->category }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="bg-gray-900 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-700 transition">
                                            Download
                                        </a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </section>
                    @endif
                </div>
            @else
                <div class="text-center py-20 bg-white dark:bg-slate-900 rounded-[3rem] border-2 border-dashed border-gray-100 dark:border-slate-800">
                    <div class="w-24 h-24 bg-red-50 dark:bg-red-900/20 rounded-full flex items-center justify-center text-red-400 mx-auto mb-8 text-4xl">
                        <i class="fas fa-search-minus"></i>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-2">Tidak Ditemukan</h2>
                    <p class="text-gray-500 dark:text-gray-400">Maaf, kami tidak menemukan hasil yang cocok dengan kata kunci Anda.</p>
                </div>
            @endif
        </div>
    </main>

@include('partials.footer')

</body>
</html>
