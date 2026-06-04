@extends('layouts.frontend')

@section('title', __('messages.services') . ' - ' . $siteSettings['name'])

@section('content')
    <!-- Header -->
    <header class="bg-slate-900 text-white py-12 md:py-20 text-center relative">
        <div class="container mx-auto px-4">
            <!-- Breadcrumbs -->
            @include('partials.breadcrumbs', [
                'items' => [
                    ['label' => __('messages.services'), 'url' => route('landing.services')]
                ],
                'class' => 'text-white/70 justify-center',
                'activeClass' => 'text-red-500'
            ])
            <span class="text-red-600 font-black tracking-[0.2em] uppercase text-xs mb-4 block">Integrated Platforms</span>
            <h1 class="text-4xl md:text-6xl font-black mb-4 uppercase tracking-tight">{{ __('messages.services') }} <span class="text-red-600">Luar</span></h1>
            <p class="text-gray-400 max-w-2xl mx-auto italic">{{ __('messages.integrated_services_desc') }}</p>
        </div>
    </header>

    <!-- Services Grid -->
    <main class="container mx-auto px-4 md:px-12 py-16 md:py-24">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($services as $service)
                <a href="{{ $service->url }}" target="_blank" class="group bg-white dark:bg-slate-800 p-10 rounded-[3rem] shadow-xl border border-gray-100 dark:border-slate-700 hover:bg-red-700 dark:hover:bg-red-800 transition-all duration-500 flex flex-col items-center text-center transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-white/20 transition-colors">
                        <i class="{{ $service->icon ?: 'fas fa-link' }} text-3xl text-red-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <h4 class="text-xl font-black uppercase tracking-tight mb-4 group-hover:text-white transition-colors">{{ $service->title }}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-red-100 transition-colors leading-relaxed mb-6">
                        {{ $service->description ?: 'Akses layanan sistem ' . $service->title . ' secara langsung.' }}
                    </p>
                    <div class="mt-auto w-12 h-12 rounded-full bg-slate-50 dark:bg-slate-900 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all transform translate-y-4 group-hover:translate-y-0 group-hover:bg-white/20">
                        <i class="fas fa-external-link-alt text-xs text-white"></i>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20 bg-white dark:bg-slate-900 rounded-[3rem] border-2 border-dashed border-gray-100 dark:border-slate-800">
                    <p class="text-gray-400 italic">Belum ada layanan yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </main>
@endsection
