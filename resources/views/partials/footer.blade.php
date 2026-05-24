<!-- Footer -->
<footer class="bg-slate-950 text-gray-400 py-16 md:py-24 border-t-8 border-red-700 dark:border-red-900">
    <div class="container mx-auto px-4 md:px-12">
        <div class="flex flex-col lg:flex-row justify-between items-start gap-12 md:gap-16">
            <div class="w-full lg:w-1/3 text-center md:text-left">
                <a href="{{ url('/') }}" class="text-2xl md:text-3xl font-black text-white flex items-center justify-center md:justify-start mb-6 md:mb-8 tracking-tighter">
                    @if(isset($siteSettings['logo']) && $siteSettings['logo'])
                        <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="{{ $siteSettings['name'] }}" class="h-10 mr-3">
                    @else
                        <i class="fas fa-university mr-3 text-red-600"></i>
                    @endif
                    {{ $siteSettings['name'] }}
                </a>
                <p class="text-base md:text-lg leading-relaxed mb-8">
                    {{ $siteSettings['description'] ?? ($siteSettings['name'] . ' - Politeknik Negeri Tanah Laut. Menghasilkan lulusan yang unggul, profesional, dan berjiwa wirausaha.') }}
                </p>
                <div class="flex justify-center md:justify-start space-x-6 text-2xl md:text-3xl">
                    @if(isset($socialMedia))
                        @foreach($socialMedia as $social)
                            <a href="{{ $social->url }}" target="_blank" class="text-gray-500 hover:text-red-500 transition-colors" title="{{ $social->platform }}">
                                <i class="{{ $social->icon }}"></i>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="w-full lg:w-1/4 text-center md:text-left">
                <h5 class="text-white font-black uppercase tracking-widest mb-6 md:mb-8 border-b-2 border-red-700 inline-block">{{ __('messages.quick_links') }}</h5>
                <ul class="space-y-3 md:space-y-4 font-bold text-xs md:text-sm">
                    <li><a href="{{ url('/') }}" class="hover:text-red-500 transition-colors uppercase">{{ __('messages.home') }}</a></li>
                    <li><a href="{{ route('landing.profile') }}" class="hover:text-red-500 transition-colors uppercase">{{ __('messages.profile') }}</a></li>
                    <li><a href="{{ route('landing.news') }}" class="hover:text-red-500 transition-colors uppercase">{{ __('messages.news') }}</a></li>
                    <li><a href="{{ url('/#prodi') }}" class="hover:text-red-500 transition-colors uppercase">{{ __('messages.study_programs') }}</a></li>
                    <li><a href="{{ url('/#kontak') }}" class="hover:text-red-500 transition-colors uppercase">{{ __('messages.contact_us') }}</a></li>
                </ul>
            </div>
            <div class="w-full lg:w-1/3 text-center md:text-left">
                <h5 class="text-white font-black uppercase tracking-widest mb-6 md:mb-8 border-b-2 border-red-700 inline-block">{{ __('messages.contact_us') }}</h5>
                <ul class="space-y-4 md:space-y-6 text-sm md:text-base">
                    <li class="flex flex-col md:flex-row items-center md:items-start">
                        <i class="fas fa-map-marker-alt mb-2 md:mt-1.5 md:mr-4 text-red-600"></i>
                        <span>{{ $siteSettings['address'] ?? 'Jl. Ahmad Yani KM.06, Desa Panggung, Pelaihari, Tanah Laut, Kalimantan Selatan.' }}</span>
                    </li>
                    <li class="flex items-center justify-center md:justify-start">
                        <i class="fas fa-phone-alt mr-4 text-red-600"></i>
                        <span>{{ $siteSettings['phone'] ?? '(0512) 2021065' }}</span>
                    </li>
                    <li class="flex items-center justify-center md:justify-start">
                        <i class="fas fa-envelope mr-4 text-red-600"></i>
                        <span>{{ $siteSettings['email'] ?? 'jkb@politala.ac.id' }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/5 mt-16 md:mt-20 pt-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left text-[10px] md:text-sm font-bold tracking-widest uppercase">
                {{ $siteSettings['footer'] }}
            </div>
            
            <div class="flex items-center gap-4 bg-white/5 px-6 py-2 rounded-2xl border border-white/10">
                <i class="fas fa-users text-red-600 text-xs"></i>
                <div class="flex items-baseline gap-2">
                    <span class="text-white font-black text-sm">{{ number_format($visitorCount) }}</span>
                    <span class="text-[8px] text-gray-500 font-bold uppercase tracking-widest">Unique Visitors</span>
                </div>
            </div>
        </div>
    </div>
</footer>
