@props(['lecturer'])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-slate-900 rounded-[2rem] overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100 dark:border-slate-800 group relative']) }}>
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
