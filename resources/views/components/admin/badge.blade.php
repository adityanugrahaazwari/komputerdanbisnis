@props([
    'variant' => 'gray',
])

@php
    $variants = [
        'gray' => 'bg-gray-100 text-gray-600',
        'yellow' => 'bg-yellow-50 text-yellow-600',
        'green' => 'bg-green-50 text-green-600',
        'red' => 'bg-red-50 text-red-600',
        'blue' => 'bg-blue-50 text-blue-600',
        'slate' => 'bg-slate-100 text-slate-600 border-slate-200',
    ];

    $classes = 'rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest border border-black/5 ' . ($variants[$variant] ?? $variants['gray']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
