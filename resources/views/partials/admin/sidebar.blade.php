<!-- Mobile Sidebar Overlay -->
<div x-show="sidebarOpen" 
     x-cloak
     @click="sidebarOpen = false" 
     class="fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity">
</div>

<!-- Sidebar -->
<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
     class="sidebar-gradient shadow-2xl h-screen fixed w-64 z-50 transition-transform duration-300 lg:translate-x-0 overflow-y-auto">
    
    <div class="p-6 bg-black/20 flex items-center justify-between">
        <div class="flex items-center gap-3">
            @if(isset($siteSettings['logo']) && $siteSettings['logo'])
                <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Logo" class="h-8">
            @else
                <i class="fas fa-university text-2xl text-red-500"></i>
            @endif
            <span class="text-white font-black tracking-tighter text-xl truncate">{{ $siteSettings['name'] }}</span>
        </div>
        <button @click="sidebarOpen = false" class="lg:hidden text-white/50 hover:text-white">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
    
    <div class="p-4">
        <p class="text-red-400/50 text-[10px] font-black uppercase tracking-[0.2em] mb-4 ml-2">Menu Utama</p>
        <ul class="list-reset flex flex-col gap-1">
            @foreach($dynamicMenus as $menu)
                @if(!$menu->permission_slug || auth()->user()->hasPermission($menu->permission_slug))
                    <li class="w-full">
                        @if($menu->url)
                            <a href="{{ url($menu->url) }}" class="flex items-center text-gray-300 hover:text-white hover:bg-white/10 rounded-xl px-4 py-3 transition-all duration-200 group {{ Request::is(trim($menu->url, '/')) ? 'active-menu text-white bg-white/5' : '' }}">
                                <i class="{{ $menu->icon }} mr-3 w-5 text-center text-lg transition-transform group-hover:scale-110"></i> 
                                <span class="font-bold text-sm uppercase tracking-wide">
                                    {{ Str::contains($menu->title, 'messages.') ? __($menu->title) : $menu->title }}
                                </span>
                            </a>
                        @else
                            <div class="text-red-400/50 text-[10px] font-black uppercase tracking-[0.2em] mt-6 mb-2 ml-2 flex items-center">
                                <span class="mr-2">{{ Str::contains($menu->title, 'messages.') ? __($menu->title) : $menu->title }}</span>
                                <div class="flex-1 h-px bg-white/10"></div>
                            </div>
                            @if($menu->children->count() > 0)
                                <ul class="list-reset flex flex-col gap-1">
                                    @foreach($menu->children as $child)
                                        @if(!$child->permission_slug || auth()->user()->hasPermission($child->permission_slug))
                                            <li>
                                                <a href="{{ $child->url ? url($child->url) : '#' }}" class="flex items-center text-gray-400 hover:text-white hover:bg-white/10 rounded-xl px-4 py-2.5 ml-2 transition-all duration-200 group {{ $child->url && Request::is(trim($child->url, '/')) ? 'text-red-400 font-bold bg-white/5' : '' }}">
                                                    <i class="{{ $child->icon }} mr-3 w-4 text-center group-hover:text-red-500"></i> 
                                                    <span class="text-xs font-bold uppercase tracking-wider flex-1">
                                                        {{ Str::contains($child->title, 'messages.') ? __($child->title) : $child->title }}
                                                    </span>
                                                    
                                                    {{-- Notification Badges --}}
                                                    @if($child->url == '/comments' && $notifications['pending_comments'] > 0)
                                                        <span class="bg-red-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded-full animate-bounce shadow-lg shadow-red-900/50">
                                                            {{ $notifications['pending_comments'] }}
                                                        </span>
                                                    @elseif($child->url == '/contacts' && $notifications['unread_contacts'] > 0)
                                                        <span class="bg-blue-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded-full animate-pulse shadow-lg shadow-blue-900/50">
                                                            {{ $notifications['unread_contacts'] }}
                                                        </span>
                                                    @endif
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    
    <div class="mt-auto p-4 sticky bottom-0 bg-inherit">
         <div class="bg-black/20 rounded-2xl p-4 flex items-center gap-3 border border-white/5">
            <div class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center text-white font-bold shrink-0">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-white text-xs font-bold truncate">{{ auth()->user()->name }}</p>
                <p class="text-red-400/50 text-[10px] uppercase font-black truncate">{{ auth()->user()->roles->first()->name ?? 'Staff' }}</p>
            </div>
         </div>
    </div>
</div>
