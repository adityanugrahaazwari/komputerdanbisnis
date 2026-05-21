<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - JKB POLITALA</title>
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
            <a href="{{ url('/') }}" class="bg-gray-100 text-red-700 px-6 py-2 rounded-full font-bold hover:bg-red-50 transition border border-red-200 text-sm">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </nav>

    <!-- Post Content -->
    <main class="container mx-auto px-4 md:px-12 py-16">
        <div class="max-w-5xl mx-auto bg-white rounded-[3rem] shadow-2xl overflow-hidden border-b-[12px] border-red-700">
            @if($post->image)
                <div class="relative h-[400px] md:h-[600px]">
                    <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-10 left-10 right-10 text-white">
                        <div class="flex items-center text-sm font-bold uppercase tracking-widest mb-4">
                            <span class="bg-red-600 px-3 py-1 rounded-md mr-4 italic">News & Update</span>
                            <span>{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        <h1 class="text-3xl md:text-5xl font-black leading-tight">{{ $post->title }}</h1>
                    </div>
                </div>
            @else
                <div class="p-10 md:p-20 bg-gradient-to-br from-red-900 to-red-600 text-white">
                    <div class="flex items-center text-sm font-bold uppercase tracking-widest mb-6">
                         <span class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-md mr-4 italic border border-white/30">News & Update</span>
                         <span>{{ $post->created_at->format('d M Y') }}</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-black leading-tight tracking-tight">{{ $post->title }}</h1>
                </div>
            @endif
            
            <div class="p-10 md:p-20">
                <div class="flex items-center text-sm text-gray-500 mb-10 pb-6 border-b border-gray-100">
                    <span class="mr-8 flex items-center"><i class="fas fa-user-circle mr-3 text-red-600 text-xl"></i> Ditulis oleh: <strong class="ml-2 text-gray-900 font-black">{{ $post->user->name }}</strong></span>
                </div>
                
                <div class="prose prose-xl max-w-none text-gray-700 leading-relaxed space-y-6">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <div class="mt-20 pt-10 border-t-2 border-gray-50 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="flex items-center space-x-6">
                        <span class="text-gray-900 font-black uppercase tracking-widest text-sm">Bagikan Berita:</span>
                        <div class="flex space-x-4">
                            <a href="#" class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center hover:scale-110 transition"><i class="fab fa-facebook-f text-lg"></i></a>
                            <a href="#" class="w-12 h-12 rounded-full bg-sky-400 text-white flex items-center justify-center hover:scale-110 transition"><i class="fab fa-twitter text-lg"></i></a>
                            <a href="#" class="w-12 h-12 rounded-full bg-green-500 text-white flex items-center justify-center hover:scale-110 transition"><i class="fab fa-whatsapp text-lg"></i></a>
                        </div>
                    </div>
                    <a href="{{ route('landing.news') }}" class="text-red-700 font-black hover:underline uppercase tracking-widest text-sm">
                        <i class="fas fa-th-large mr-2"></i> Lihat Berita Lainnya
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-gray-400 py-20 border-t-8 border-red-700">
        <div class="container mx-auto px-4 md:px-12 text-center">
             <div class="mb-10">
                <a href="{{ url('/') }}" class="text-3xl font-black text-white flex items-center justify-center mb-6 tracking-tighter">
                    <i class="fas fa-university mr-3 text-red-600"></i> JKB POLITALA
                </a>
                <p class="max-w-xl mx-auto italic">Terimakasih telah mengunjungi portal informasi resmi Jurusan Komputer dan Bisnis Politeknik Negeri Tanah Laut.</p>
             </div>
             <div class="flex justify-center space-x-8 text-3xl mb-12">
                    @foreach($socialMedia as $social)
                        <a href="{{ $social->url }}" target="_blank" class="text-gray-600 hover:text-red-500 transition-colors" title="{{ $social->platform }}">
                            <i class="{{ $social->icon }}"></i>
                        </a>
                    @endforeach
                </div>
            <div class="text-sm font-bold tracking-widest opacity-50 uppercase">
                &copy; {{ date('Y') }} JURUSAN KOMPUTER DAN BISNIS POLITALA.
            </div>
        </div>
    </footer>

</body>
</html>
