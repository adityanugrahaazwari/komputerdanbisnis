@extends('layouts.frontend')

@section('title', 'Direktori Dosen & Staf - ' . $siteSettings['name'])

@section('content')
    <!-- Header -->
    <header class="bg-gradient-to-r from-primary to-primary/80 text-white py-12 md:py-20 relative overflow-hidden">
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
                <x-lecturer-card :lecturer="$lecturer" />
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
@endsection
