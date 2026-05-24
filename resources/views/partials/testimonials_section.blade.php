        </div>
    </section>

    <!-- Testimonials Section -->
    @if($testimonials->count() > 0)
    <section class="py-20 md:py-32 bg-white dark:bg-slate-900 transition-colors duration-300">
        <div class="container mx-auto px-4 md:px-12">
            <div class="text-center mb-16 md:mb-24">
                <span class="text-red-600 font-black tracking-[0.3em] uppercase text-xs mb-4 block">Testimonials</span>
                <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-6 tracking-tight">KATA MEREKA</h2>
                <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto font-medium">Apa kata alumni dan mitra industri tentang Jurusan Komputer dan Bisnis.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
                @foreach($testimonials as $testimonial)
                <div class="bg-slate-50 dark:bg-slate-800 p-8 md:p-10 rounded-[3rem] relative border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-xl transition-all group">
                    <div class="absolute -top-6 left-10 w-12 h-12 bg-red-700 rounded-2xl flex items-center justify-center text-white text-xl shadow-lg transform group-hover:rotate-12 transition">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    
                    <div class="mb-8 mt-4 text-gray-600 dark:text-gray-300 italic leading-relaxed text-sm md:text-base">
                        "{{ $testimonial->quote }}"
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl overflow-hidden border-2 border-white dark:border-slate-700 shadow-md">
                            @if($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 dark:bg-slate-700 flex items-center justify-center text-gray-400">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-black text-gray-900 dark:text-white text-sm uppercase tracking-tight">{{ $testimonial->name }}</h4>
                            <p class="text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-widest">{{ $testimonial->role }}</p>
                            @if($testimonial->company)
                                <p class="text-[9px] text-gray-400 italic">{{ $testimonial->company }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
