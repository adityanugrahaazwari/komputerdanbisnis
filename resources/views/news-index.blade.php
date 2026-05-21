<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Berita - JKB POLITALA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-slate-50 font-sans text-gray-900">

    <!-- Navbar -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b-4 border-red-700">
        <div class="container mx-auto px-4 md:px-12 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl md:text-2xl font-black text-red-700 flex items-center tracking-tighter">
                <i class="fas fa-university mr-2 text-3xl"></i> JKB POLITALA
            </a>
            <div class="hidden md:flex space-x-8 font-bold text-gray-700">
                <a href="{{ url('/') }}#beranda" class="hover:text-red-600 transition-colors uppercase text-sm">Beranda</a>
                <a href="{{ url('/') }}#profil" class="hover:text-red-600 transition-colors uppercase text-sm">Profil</a>
                <a href="{{ url('/') }}#prodi" class="hover:text-red-600 transition-colors uppercase text-sm">Program Studi</a>
                <a href="{{ url('/berita') }}" class="text-red-600 font-bold uppercase text-sm">Berita</a>
            </div>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-red-700 text-white px-6 py-2 rounded-full font-bold hover:bg-red-800 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-gray-100 text-red-700 px-6 py-2 rounded-full font-bold hover:bg-red-50 transition border border-red-200">Login Staff</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-gradient-to-r from-red-900 to-red-600 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        <div class="container mx-auto px-4 md:px-12 text-center relative z-10">
            <h1 class="text-5xl md:text-6xl font-black mb-6 tracking-tight">BERITA & INFORMASI</h1>
            <p class="text-red-100 max-w-2xl mx-auto italic text-xl opacity-90">
                Kumpulan kabar terkini, prestasi, dan pengumuman resmi dari Jurusan Komputer dan Bisnis POLITALA.
            </p>
        </div>
    </header>

    <!-- News List -->
    <main class="container mx-auto px-4 md:px-12 py-20">
        <div class="grid md:grid-cols-3 gap-10 mb-16">
            @forelse($posts as $post)
            <article class="bg-white rounded-[2rem] overflow-hidden shadow-xl flex flex-col hover:shadow-red-100 transition-all duration-300 border-b-8 border-red-700 group">
                @if($post->image)
                    <div class="h-64 overflow-hidden">
                        <img src="{{ asset('storage/' . $post->image) }}" class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                @else
                    <div class="h-64 w-full bg-red-50 flex items-center justify-center text-red-200">
                        <i class="fas fa-newspaper text-8xl"></i>
                    </div>
                @endif
                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex items-center text-xs font-bold text-red-600 mb-4 uppercase tracking-widest">
                        <i class="fas fa-calendar-alt mr-2"></i> {{ $post->created_at->format('d M Y') }}
                        <span class="mx-3 opacity-30">|</span>
                        <i class="fas fa-user mr-1"></i> {{ $post->user->name }}
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-4 leading-tight line-clamp-2 h-16 group-hover:text-red-700 transition-colors">{{ $post->title }}</h3>
                    <p class="text-gray-500 text-sm mb-8 line-clamp-3 leading-relaxed">
                        {{ strip_tags($post->content) }}
                    </p>
                    <a href="{{ route('landing.post', $post->slug) }}" class="text-red-700 font-black hover:text-red-900 flex items-center mt-auto uppercase text-sm tracking-widest">
                        Baca Selengkapnya <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-2"></i>
                    </a>
                </div>
            </article>
            @empty
                <div class="col-span-3 text-center py-32 bg-white rounded-[3rem] shadow-inner">
                    <i class="fas fa-folder-open text-8xl text-red-100 mb-6"></i>
                    <p class="text-gray-400 text-2xl font-medium">Belum ada berita yang diterbitkan saat ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $posts->links() }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-gray-400 py-16 border-t-8 border-red-700">
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-10">
                <div class="text-center md:text-left">
                    <a href="{{ url('/') }}" class="text-3xl font-black text-white flex items-center justify-center md:justify-start mb-4 tracking-tighter">
                        <i class="fas fa-university mr-3 text-red-600"></i> JKB POLITALA
                    </a>
                </div>
                <div class="flex space-x-8 text-3xl">
                    @foreach($socialMedia as $social)
                        <a href="{{ $social->url }}" target="_blank" class="text-gray-600 hover:text-red-500 transition-colors" title="{{ $social->platform }}">
                            <i class="{{ $social->icon }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="border-t border-white/5 mt-12 pt-8 text-center text-sm font-bold tracking-widest">
                &copy; {{ date('Y') }} JURUSAN KOMPUTER DAN BISNIS POLITALA.
            </div>
        </div>
    </footer>

</body>
</html>
