<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurusan Komputer dan Bisnis - Politeknik Negeri Tanah Laut</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #991b1b 0%, #dc2626 100%);
        }
        .bg-red-custom {
            background-color: #dc2626;
        }
        .text-red-custom {
            color: #dc2626;
        }
        .border-red-custom {
            border-color: #dc2626;
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-gray-900">

    <!-- Navbar -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b-4 border-red-700">
        <div class="container mx-auto px-4 md:px-12 py-4 flex justify-between items-center">
            <a href="#" class="text-xl md:text-2xl font-black text-red-700 flex items-center tracking-tighter">
                <i class="fas fa-university mr-2 text-3xl"></i> JKB POLITALA
            </a>
            <div class="hidden md:flex space-x-8 font-bold text-gray-700">
                <a href="#beranda" class="hover:text-red-600 transition-colors uppercase text-sm">Beranda</a>
                <a href="#profil" class="hover:text-red-600 transition-colors uppercase text-sm">Profil</a>
                <a href="#prodi" class="hover:text-red-600 transition-colors uppercase text-sm">Program Studi</a>
                <a href="{{ route('landing.news') }}" class="hover:text-red-600 transition-colors uppercase text-sm">Berita</a>
            </div>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-red-700 text-white px-6 py-2 rounded-full font-bold hover:bg-red-800 transition shadow-lg shadow-red-200">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-gray-100 text-red-700 px-6 py-2 rounded-full font-bold hover:bg-red-50 transition border border-red-200">Login Staff</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header id="beranda" class="hero-gradient text-white py-24 md:py-40 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 0 L100 0 L100 100 L0 100 Z" fill="url(#grid)"></path>
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"></path>
                    </pattern>
                </defs>
            </svg>
        </div>
        <div class="container mx-auto px-4 md:px-12 flex flex-col md:flex-row items-center relative z-10">
            <div class="md:w-3/5 mb-12 md:mb-0">
                <span class="inline-block px-4 py-1 bg-red-800/50 rounded-full text-sm font-bold mb-4 backdrop-blur-sm border border-red-400/30">POLITEKNIK NEGERI TANAH LAUT</span>
                <h1 class="text-5xl md:text-7xl font-black leading-none mb-6 drop-shadow-md">
                    UNGGUL <br><span class="text-red-200">INOVATIF</span> <br>PROFESIONAL
                </h1>
                <p class="text-xl md:text-2xl text-red-50 mb-10 max-w-2xl font-medium leading-relaxed opacity-90">
                    Mencetak tenaga kerja handal di bidang teknologi informasi dan manajemen bisnis yang siap bersaing di kancah nasional dan global.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#prodi" class="bg-white text-red-700 px-10 py-4 rounded-xl font-black hover:bg-red-50 transition transform hover:-translate-y-1 shadow-2xl uppercase tracking-wider">Pilihan Prodi</a>
                    <a href="#profil" class="bg-red-800/40 border-2 border-white/50 text-white px-10 py-4 rounded-xl font-black hover:bg-red-800 transition transform hover:-translate-y-1 backdrop-blur-md uppercase tracking-wider">Tentang Kami</a>
                </div>
            </div>
            <div class="md:w-2/5 flex justify-center relative">
                <div class="absolute w-72 h-72 bg-red-400 rounded-full blur-3xl opacity-30 animate-pulse"></div>
                <i class="fas fa-graduation-cap text-[15rem] md:text-[22rem] text-white/20 relative z-10 rotate-12"></i>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-slate-50 to-transparent"></div>
    </header>

    <!-- History Section -->
    <section id="profil" class="py-32 bg-slate-50">
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex flex-col md:flex-row items-center gap-16">
                <div class="md:w-1/2">
                    <h2 class="text-4xl font-black text-gray-900 mb-8 flex items-center">
                        <span class="w-12 h-1.5 bg-red-600 mr-4 rounded-full"></span>
                        {{ $profiles['history']->title ?? 'Sejarah Kami' }}
                    </h2>
                    <p class="text-gray-600 leading-relaxed text-xl mb-8">
                        {{ $profiles['history']->content ?? 'Jurusan Komputer dan Bisnis Politala berkomitmen untuk memberikan pendidikan vokasi terbaik.' }}
                    </p>
                    <div class="grid grid-cols-2 gap-6 mt-10">
                        <div class="bg-white p-8 rounded-3xl shadow-xl border-b-8 border-red-600 transform hover:scale-105 transition">
                            <div class="text-5xl font-black text-red-700 mb-2">14+</div>
                            <div class="text-sm text-gray-500 uppercase font-bold tracking-widest">Tahun Mengabdi</div>
                        </div>
                        <div class="bg-white p-8 rounded-3xl shadow-xl border-b-8 border-red-600 transform hover:scale-105 transition">
                            <div class="text-5xl font-black text-red-700 mb-2">1K+</div>
                            <div class="text-sm text-gray-500 uppercase font-bold tracking-widest">Alumni Sukses</div>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 relative">
                    <div class="absolute -top-4 -left-4 w-24 h-24 bg-red-600 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                    <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-orange-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                    @if(isset($profiles['history']->image))
                        <img src="{{ asset('storage/' . $profiles['history']->image) }}" class="rounded-[2rem] shadow-2xl relative z-10 border-8 border-white">
                    @else
                        <div class="bg-red-700 aspect-video rounded-[2rem] flex items-center justify-center text-white shadow-2xl relative z-10 border-8 border-white overflow-hidden">
                             <i class="fas fa-university text-9xl opacity-20 absolute -right-4 -bottom-4"></i>
                             <span class="text-2xl font-black italic tracking-widest">POLITALA</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="py-32 bg-gray-900 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-red-700 rounded-full blur-[120px] opacity-20"></div>
        <div class="container mx-auto px-4 md:px-12 relative z-10">
            <div class="grid md:grid-cols-2 gap-10">
                <div class="bg-white/5 backdrop-blur-lg p-10 rounded-[3rem] border border-white/10 hover:bg-white/10 transition">
                    <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-red-600/30">
                        <i class="fas fa-eye text-3xl text-white"></i>
                    </div>
                    <h3 class="text-3xl font-black text-white mb-6 uppercase tracking-tight">{{ $profiles['vision']->title ?? 'Visi' }}</h3>
                    <p class="text-gray-400 leading-relaxed text-lg italic">
                        "{{ $profiles['vision']->content ?? 'Menjadi pusat unggulan teknologi dan bisnis.' }}"
                    </p>
                </div>
                <div class="bg-white/5 backdrop-blur-lg p-10 rounded-[3rem] border border-white/10 hover:bg-white/10 transition">
                    <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-red-600/30">
                        <i class="fas fa-bullseye text-3xl text-white"></i>
                    </div>
                    <h3 class="text-3xl font-black text-white mb-6 uppercase tracking-tight">{{ $profiles['mission']->title ?? 'Misi' }}</h3>
                    <div class="text-gray-400 leading-relaxed text-lg space-y-4">
                        {!! nl2br(e($profiles['mission']->content ?? 'Mengembangkan SDM berkualitas.')) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Study Programs -->
    <section id="prodi" class="py-32 bg-white relative">
        <div class="container mx-auto px-4 md:px-12">
            <div class="text-center mb-24">
                <span class="text-red-600 font-black tracking-[0.2em] uppercase text-sm mb-4 block">Academic Programs</span>
                <h2 class="text-5xl font-black text-gray-900 mb-6">Program Studi</h2>
                <div class="h-2 w-24 bg-red-600 mx-auto rounded-full"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-10">
                @forelse($studyPrograms as $prodi)
                <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-2xl hover:shadow-red-200 transition-all duration-500 border border-gray-100 flex flex-col transform hover:-translate-y-2">
                    <div class="h-64 bg-gray-200 relative overflow-hidden">
                        @if($prodi->image)
                            <img src="{{ asset('storage/' . $prodi->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-red-50 text-red-200">
                                <i class="fas fa-graduation-cap text-8xl"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-red-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-8">
                             <span class="text-white font-bold">Lihat Kurikulum <i class="fas fa-arrow-right ml-2"></i></span>
                        </div>
                        <div class="absolute top-6 left-6 bg-red-700 text-white text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                            {{ $prodi->level }}
                        </div>
                    </div>
                    <div class="p-10 flex-1 flex flex-col">
                        <h4 class="text-2xl font-black text-gray-900 mb-4 tracking-tight">{{ $prodi->name }}</h4>
                        <p class="text-gray-500 leading-relaxed mb-8 flex-1">
                            {{ $prodi->description }}
                        </p>
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                            <span class="text-red-700 font-black text-sm uppercase tracking-widest">KODE: {{ $prodi->code }}</span>
                            <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center text-red-600 group-hover:bg-red-700 group-hover:text-white transition">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-center text-gray-400 col-span-3 py-10 italic">Data program studi sedang diperbarui.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section id="berita" class="py-32 bg-red-50 relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-12 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center mb-20 gap-8">
                <div class="text-center md:text-left">
                    <h2 class="text-5xl font-black text-gray-900 mb-4">Informasi Terkini</h2>
                    <p class="text-gray-600 text-lg font-medium">Berita dan artikel terbaru dari Jurusan Komputer dan Bisnis.</p>
                </div>
                <a href="{{ route('landing.news') }}" class="bg-red-700 text-white px-10 py-4 rounded-2xl font-black hover:bg-red-800 transition shadow-xl shadow-red-200 uppercase tracking-widest">
                    Lihat Semua Berita
                </a>
            </div>
            <div class="grid md:grid-cols-3 gap-10">
                @forelse($latestPosts as $post)
                <article class="bg-white rounded-[2rem] overflow-hidden shadow-xl flex flex-col border-b-8 border-red-700 transform hover:scale-[1.02] transition duration-300">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="h-56 w-full object-cover">
                    @else
                        <div class="h-56 w-full bg-red-100 flex items-center justify-center text-red-200">
                            <i class="fas fa-newspaper text-7xl"></i>
                        </div>
                    @endif
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex items-center text-xs font-bold text-red-600 mb-4 uppercase tracking-widest">
                            <i class="fas fa-clock mr-2"></i> {{ $post->created_at->format('d M Y') }}
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-4 leading-tight line-clamp-2 h-16">{{ $post->title }}</h3>
                        <p class="text-gray-500 text-sm mb-8 line-clamp-3 leading-relaxed">
                            {{ strip_tags($post->content) }}
                        </p>
                        <a href="{{ route('landing.post', $post->slug) }}" class="text-red-700 font-black hover:text-red-900 flex items-center mt-auto uppercase text-sm tracking-widest group">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-2"></i>
                        </a>
                    </div>
                </article>
                @empty
                    <p class="text-center text-gray-400 col-span-3 py-10">Arsip berita sedang diproses.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Organizational Structure -->
    <section class="py-32 bg-white">
        <div class="container mx-auto px-4 md:px-12">
            <div class="max-w-6xl mx-auto bg-slate-900 rounded-[4rem] p-12 md:p-24 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <h2 class="text-4xl md:text-5xl font-black text-white mb-16 relative z-10 tracking-tight">{{ $profiles['structure']->title ?? 'Struktur Organisasi' }}</h2>
                <div class="flex justify-center relative z-10">
                    @if(isset($profiles['structure']->image))
                        <div class="bg-white p-6 rounded-[2rem] shadow-2xl shadow-red-900/50">
                            <img src="{{ asset('storage/' . $profiles['structure']->image) }}" class="max-w-full h-auto rounded-xl">
                        </div>
                    @else
                        <div class="bg-white/5 backdrop-blur-md p-16 rounded-[3rem] border-2 border-dashed border-white/20 w-full">
                            <i class="fas fa-sitemap text-7xl text-red-600 mb-6"></i>
                            <p class="text-gray-400 text-xl">{{ $profiles['structure']->content ?? 'Diagram struktur organisasi belum diunggah.' }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 text-gray-400 py-24 border-t-8 border-red-700">
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex flex-col md:flex-row justify-between items-start gap-16">
                <div class="md:w-1/3">
                    <a href="#" class="text-3xl font-black text-white flex items-center mb-8 tracking-tighter">
                        <i class="fas fa-university mr-3 text-red-600"></i> JKB POLITALA
                    </a>
                    <p class="text-lg leading-relaxed mb-8">
                        Jurusan Komputer dan Bisnis - Politeknik Negeri Tanah Laut. Menghasilkan lulusan yang unggul, profesional, dan berjiwa wirausaha.
                    </p>
                    <div class="flex space-x-6 text-3xl">
                        @foreach($socialMedia as $social)
                            <a href="{{ $social->url }}" target="_blank" class="text-gray-500 hover:text-red-500 transition-colors" title="{{ $social->platform }}">
                                <i class="{{ $social->icon }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="md:w-1/4">
                    <h5 class="text-white font-black uppercase tracking-widest mb-8 border-b-2 border-red-700 inline-block">Quick Links</h5>
                    <ul class="space-y-4 font-bold text-sm">
                        <li><a href="#beranda" class="hover:text-red-500 transition-colors">BERANDA</a></li>
                        <li><a href="#profil" class="hover:text-red-500 transition-colors">PROFIL JURUSAN</a></li>
                        <li><a href="#prodi" class="hover:text-red-500 transition-colors">PROGRAM STUDI</a></li>
                        <li><a href="{{ route('landing.news') }}" class="hover:text-red-500 transition-colors">BERITA TERKINI</a></li>
                    </ul>
                </div>
                <div class="md:w-1/3">
                    <h5 class="text-white font-black uppercase tracking-widest mb-8 border-b-2 border-red-700 inline-block">Contact Us</h5>
                    <ul class="space-y-6">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1.5 mr-4 text-red-600"></i>
                            <span>Jl. Ahmad Yani KM.06, Desa Panggung, Pelaihari, Tanah Laut, Kalimantan Selatan.</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-4 text-red-600"></i>
                            <span>(0512) 2021065</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-4 text-red-600"></i>
                            <span>jkb@politala.ac.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/5 mt-20 pt-10 text-center text-sm font-bold tracking-widest">
                &copy; {{ date('Y') }} JURUSAN KOMPUTER DAN BISNIS POLITALA. ALL RIGHTS RESERVED.
            </div>
        </div>
    </footer>

</body>
</html>
