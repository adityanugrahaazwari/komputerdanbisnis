<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true'
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktori Dosen & Staf - JKB POLITALA</title>
    @include('partials.seo', [
        'seoTitle' => 'Direktori Dosen & Staf - JKB POLITALA',
        'seoDescription' => 'Kenali lebih dekat para pengajar dan staf profesional di Jurusan Komputer dan Bisnis.'
    ])
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
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
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
    <header class="bg-gradient-to-r from-red-900 to-red-600 text-white py-16 md:py-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        <div class="container mx-auto px-4 md:px-12 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight uppercase">Direktori Dosen & Staf</h1>
            
            <!-- Breadcrumbs -->
            @include('partials.breadcrumbs', [
                'items' => [
                    ['label' => 'Dosen & Staf', 'url' => route('landing.lecturers')]
                ],
                'class' => 'text-white/70 justify-center',
                'activeClass' => 'text-red-200'
            ])

            <!-- Search & Filter Bar -->
            <div class="max-w-4xl mx-auto bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 shadow-2xl">
                <form action="{{ route('landing.lecturers') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, keahlian, atau jabatan..." class="w-full bg-white/10 border border-white/20 rounded-xl py-3 pl-12 pr-4 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 transition">
                    </div>
                    <div class="md:w-64">
                        <select name="prodi" class="w-full bg-white/10 border border-white/20 rounded-xl py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-white/30 transition appearance-none cursor-pointer">
                            <option value="" class="bg-red-800">Semua Program Studi</option>
                            @foreach($studyPrograms as $prodi)
                                <option value="{{ $prodi->slug }}" class="bg-red-800" {{ request('prodi') == $prodi->slug ? 'selected' : '' }}>{{ $prodi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-white text-red-700 px-8 py-3 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-red-50 transition shadow-lg">
                        CARI
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="container mx-auto px-4 md:px-12 py-16 md:py-24">
        @if(request('search') || request('prodi'))
            <div class="mb-12 text-center">
                <p class="text-gray-500 dark:text-gray-400 font-bold uppercase tracking-widest text-xs">
                    Hasil pencarian untuk: 
                    @if(request('search')) <span class="text-red-600 dark:text-red-400">"{{ request('search') }}"</span> @endif
                    @if(request('prodi')) <span class="ml-2 px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-full text-[10px]">{{ request('prodi') }}</span> @endif
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-16">
            @forelse($lecturers as $lecturer)
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100 dark:border-slate-800 group relative">
                <div class="aspect-[3/4] overflow-hidden relative">
                    @if($lecturer->photo)
                        <img src="{{ asset('storage/' . $lecturer->photo) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 grayscale group-hover:grayscale-0">
                    @else
                        <div class="w-full h-full bg-red-50 dark:bg-red-900/10 flex items-center justify-center text-red-100 dark:text-red-900/30">
                            <i class="fas fa-user text-9xl"></i>
                        </div>
                    @endif
                    
                    <!-- Social Links Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-red-900/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
                        <div class="flex justify-center gap-4 translate-y-10 group-hover:translate-y-0 transition-transform duration-500">
                            @if($lecturer->google_scholar_url)
                                <a href="{{ $lecturer->google_scholar_url }}" target="_blank" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-700 hover:bg-red-700 hover:text-white transition shadow-lg" title="Google Scholar">
                                    <i class="fas fa-graduation-cap"></i>
                                </a>
                            @endif
                            @if($lecturer->sinta_url)
                                <a href="{{ $lecturer->sinta_url }}" target="_blank" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-700 hover:bg-red-700 hover:text-white transition shadow-lg" title="Sinta">
                                    <i class="fas fa-microscope"></i>
                                </a>
                            @endif
                            @if($lecturer->email)
                                <a href="mailto:{{ $lecturer->email }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-700 hover:bg-red-700 hover:text-white transition shadow-lg" title="Email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 text-center">
                    <h3 class="text-lg font-black text-gray-900 dark:text-white mb-1 group-hover:text-red-700 dark:group-hover:text-red-400 transition-colors">{{ $lecturer->name }}</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-3">NIP: {{ $lecturer->nip ?? '-' }}</p>
                    
                    <div class="inline-block px-3 py-1 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">
                        {{ $lecturer->position ?? 'Dosen / Staf' }}
                    </div>
                    
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium line-clamp-2 h-10 mb-4">
                        {{ $lecturer->expertise ?? 'Bidang Keahlian Umum' }}
                    </p>
                    
                    <div class="pt-4 border-t border-gray-50 dark:border-slate-800 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                        {{ $lecturer->studyProgram->name ?? 'Jurusan Komputer & Bisnis' }}
                    </div>
                </div>
            </div>
            @empty
                <div class="col-span-full text-center py-32 bg-white dark:bg-slate-900 rounded-[3rem] shadow-inner border border-gray-100 dark:border-slate-800">
                    <i class="fas fa-search text-8xl text-red-100 dark:text-red-900/30 mb-6"></i>
                    <p class="text-gray-400 text-xl md:text-2xl font-medium">Data dosen atau staf tidak ditemukan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $lecturers->links() }}
        </div>
    </main>

@include('partials.footer')

</body>
</html>
