@props([
    'type' => 'button',
    'variant' => 'primary',
    'href' => null,
])

@php
    $baseClasses = 'px-6 py-3 rounded-2xl font-bold text-sm transition flex items-center shadow-lg';
    
    $variants = [
        'primary' => 'bg-red-700 text-white hover:bg-red-800 shadow-red-200',
        'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 shadow-gray-100',
        'success' => 'bg-green-600 text-white hover:bg-green-700 shadow-green-100',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 shadow-red-100',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
