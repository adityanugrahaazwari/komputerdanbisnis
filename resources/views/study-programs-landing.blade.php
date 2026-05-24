<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true'
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.study_programs') }} - JKB POLITALA</title>
    @include('partials.seo', [
        'seoTitle' => __('messages.study_programs') . ' - JKB POLITALA',
        'seoDescription' => 'Daftar program studi unggulan di Jurusan Komputer dan Bisnis Politeknik Negeri Tanah Laut.'
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
                            50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171', 500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d',
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
    <header class="bg-slate-900 text-white py-16 md:py-24 text-center relative">
        <div class="container mx-auto px-4">
            <!-- Breadcrumbs -->
            @include('partials.breadcrumbs', [
                'items' => [
                    ['label' => __('messages.study_programs'), 'url' => route('landing.study_programs')]
                ],
                'class' => 'text-white/70 justify-center',
                'activeClass' => 'text-red-500'
            ])
            <span class="text-red-600 font-black tracking-[0.2em] uppercase text-xs mb-4 block">{{ __('messages.academic_programs') }}</span>
            <h1 class="text-4xl md:text-6xl font-black mb-4 uppercase tracking-tight">{{ __('messages.study_programs') }}</h1>
            <p class="text-gray-400 max-w-2xl mx-auto italic">{{ __('messages.academic_programs_desc') }}</p>
        </div>
    </header>

    <!-- Programs Grid -->
    <main class="container mx-auto px-4 md:px-12 py-16 md:py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @forelse($studyPrograms as $prodi)
                <div class="group bg-white dark:bg-slate-800 rounded-[3rem] overflow-hidden shadow-2xl hover:shadow-red-200 dark:hover:shadow-none transition-all duration-500 border border-gray-100 dark:border-slate-700 flex flex-col transform hover:-translate-y-2">
                    <div class="h-64 bg-gray-200 dark:bg-slate-700 relative overflow-hidden">
                        @if($prodi->image)
                            <img src="{{ asset('storage/' . $prodi->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-red-50 dark:bg-red-900/20 text-red-200 dark:text-red-800">
                                <i class="fas fa-graduation-cap text-8xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-6 left-6 bg-red-700 text-white text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                            {{ $prodi->level }}
                        </div>
                    </div>
                    <div class="p-10 flex-1 flex flex-col">
                        <h4 class="text-2xl font-black text-gray-900 dark:text-white mb-6 tracking-tight">{{ $prodi->name }}</h4>
                        <div class="text-gray-500 dark:text-gray-400 text-base leading-relaxed mb-8 flex-1">
                            {!! nl2br(e($prodi->description)) !!}
                        </div>
                        <div class="flex items-center justify-between pt-8 border-t border-gray-100 dark:border-slate-700">
                            <span class="text-red-700 dark:text-red-400 font-black text-sm uppercase tracking-widest">KODE: {{ $prodi->code }}</span>
                            @if($prodi->website_url)
                                <a href="{{ $prodi->website_url }}" target="_blank" class="flex items-center gap-3 bg-red-700 text-white px-6 py-2.5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-red-800 transition shadow-lg shadow-red-200 dark:shadow-none">
                                    Website <i class="fas fa-external-link-alt text-[8px]"></i>
                                </a>
                            @else
                                <div class="w-10 h-10 bg-red-50 dark:bg-red-900/30 rounded-full flex items-center justify-center text-red-600 dark:text-red-400 group-hover:bg-red-700 group-hover:text-white transition">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white dark:bg-slate-900 rounded-[3rem] border-2 border-dashed border-gray-100 dark:border-slate-800">
                    <p class="text-gray-400 italic">{{ __('messages.no_data') }}</p>
                </div>
            @endforelse
        </div>
    </main>

@include('partials.footer')

</body>
</html>
