<nav class="flex mb-8 text-[10px] md:text-xs font-bold uppercase tracking-widest {{ $class ?? 'text-gray-400' }}">
    <ol class="flex list-none p-0">
        <li class="flex items-center">
            <a href="{{ url('/') }}" class="hover:text-red-600 transition">{{ __('messages.home') }}</a>
        </li>
        @foreach($items as $item)
            <li class="flex items-center">
                <span class="mx-2 md:mx-3 opacity-50">/</span>
                @if(!$loop->last)
                    <a href="{{ $item['url'] }}" class="hover:text-red-600 transition">{{ $item['label'] }}</a>
                @else
                    <span class="{{ $activeClass ?? 'text-gray-900 dark:text-white' }} truncate max-w-[150px] md:max-w-xs">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
