<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true'
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - JKB POLITALA</title>
    @include('partials.seo', ['ogType' => 'article'])
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
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">

@include('partials.navbar')

    <!-- Post Content -->

    <!-- Post Content -->
    <main class="container mx-auto px-4 md:px-12 py-16">
        <!-- Breadcrumbs -->
        @include('partials.breadcrumbs', [
            'items' => [
                ['label' => __('messages.news'), 'url' => route('landing.news')],
                ['label' => $post->title, 'url' => '#']
            ]
        ])

        <div class="max-w-5xl mx-auto bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl dark:shadow-none overflow-hidden border-b-[12px] border-red-700 border border-gray-100 dark:border-slate-800">
            @if($post->image)
                <div class="relative h-[400px] md:h-[600px]">
                    <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-10 left-10 right-10 text-white">
                        <div class="flex items-center text-sm font-bold uppercase tracking-widest mb-4">
                            @if($post->category)
                                <span class="bg-red-600 px-3 py-1 rounded-md mr-4 italic shadow-lg">{{ $post->category->name }}</span>
                            @else
                                <span class="bg-red-600 px-3 py-1 rounded-md mr-4 italic">News & Update</span>
                            @endif
                            <span>{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        <h1 class="text-3xl md:text-5xl font-black leading-tight">{{ $post->title }}</h1>
                    </div>
                </div>
            @else
                <div class="p-10 md:p-20 bg-gradient-to-br from-red-900 to-red-600 text-white">
                    <div class="flex items-center text-sm font-bold uppercase tracking-widest mb-6">
                         @if($post->category)
                            <span class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-md mr-4 italic border border-white/30">{{ $post->category->name }}</span>
                         @else
                            <span class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-md mr-4 italic border border-white/30">News & Update</span>
                         @endif
                         <span>{{ $post->created_at->format('d M Y') }}</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-black leading-tight tracking-tight">{{ $post->title }}</h1>
                </div>
            @endif
            
            <div class="p-10 md:p-20">
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-10 pb-6 border-b border-gray-100 dark:border-slate-800">
                    <span class="mr-8 flex items-center"><i class="fas fa-user-circle mr-3 text-red-600 dark:text-red-500 text-xl"></i> {{ __('messages.written_by') }}: <strong class="ml-2 text-gray-900 dark:text-white font-black uppercase">{{ $post->user->name }}</strong></span>
                </div>
                
                <div class="prose prose-xl max-w-none text-gray-700 dark:text-gray-300 leading-relaxed space-y-6">
                    {!! $post->content !!}
                </div>

                <!-- Comments Section -->
                <div class="mt-20">
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white mb-10 uppercase tracking-tight">
                        Komentar ({{ $post->approvedComments->count() }})
                    </h3>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-8">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="space-y-8 mb-16">
                        @forelse($post->approvedComments as $comment)
                            <div class="bg-slate-50 dark:bg-slate-800/50 p-6 md:p-8 rounded-3xl border border-gray-100 dark:border-slate-800">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="font-black text-gray-900 dark:text-white uppercase text-sm tracking-widest">{{ $comment->user_name }}</h4>
                                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="text-red-600/20 dark:text-red-500/10">
                                        <i class="fas fa-quote-right text-4xl"></i>
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                    {{ $comment->comment }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-400 italic">Belum ada komentar. Jadilah yang pertama!</p>
                        @endforelse
                    </div>

                    <!-- Comment Form -->
                    <div class="bg-white dark:bg-slate-800 p-8 md:p-12 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-slate-700">
                        <h4 class="text-xl font-black text-gray-900 dark:text-white mb-8 uppercase tracking-widest">Tinggalkan Komentar</h4>
                        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Nama Lengkap</label>
                                    <input type="text" name="user_name" class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-red-600 transition text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Email (Tidak akan dipublikasikan)</label>
                                    <input type="email" name="user_email" class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-red-600 transition text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Komentar Anda</label>
                                <textarea name="comment" rows="5" class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-red-600 transition text-sm"></textarea>
                            </div>
                            <button type="submit" class="bg-red-700 text-white px-10 py-4 rounded-full font-black uppercase text-xs tracking-[0.2em] hover:bg-red-800 transition shadow-lg shadow-red-200 dark:shadow-none">
                                Kirim Komentar
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-20 pt-10 border-t-2 border-gray-50 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="flex items-center space-x-6">
                        <span class="text-gray-900 dark:text-white font-black uppercase tracking-widest text-sm">{{ __('messages.share') }}:</span>
                        <div class="flex space-x-4">
                            {{-- Share to Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" 
                               target="_blank" 
                               class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center hover:scale-110 transition shadow-lg shadow-blue-200 dark:shadow-none"
                               title="Bagikan ke Facebook">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>

                            {{-- Share to X (Twitter) --}}
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(Request::fullUrl()) }}" 
                               target="_blank" 
                               class="w-12 h-12 rounded-full bg-black text-white flex items-center justify-center hover:scale-110 transition shadow-lg shadow-gray-200 dark:shadow-none"
                               title="Bagikan ke X">
                                <i class="fab fa-x-twitter text-lg"></i>
                            </a>

                            {{-- Share to WhatsApp --}}
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . Request::fullUrl()) }}" 
                               target="_blank" 
                               class="w-12 h-12 rounded-full bg-green-500 text-white flex items-center justify-center hover:scale-110 transition shadow-lg shadow-green-200 dark:shadow-none"
                               title="Bagikan ke WhatsApp">
                                <i class="fab fa-whatsapp text-lg"></i>
                            </a>
                        </div>
                    </div>
                    <a href="{{ route('landing.news') }}" class="text-red-700 dark:text-red-400 font-black hover:underline uppercase tracking-widest text-sm">
                        <i class="fas fa-th-large mr-2"></i> {{ __('messages.all_news') }}
                    </a>
                </div>
            </div>
        </div>
    </main>

@include('partials.footer')

</body>
</html>
