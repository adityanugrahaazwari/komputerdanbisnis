@props([
    'type' => 'link',
    'variant' => 'view',
    'href' => '#',
    'title' => '',
])

@php
    $variants = [
        'view' => 'text-green-600 hover:bg-green-600',
        'edit' => 'text-blue-600 hover:bg-blue-600',
        'delete' => 'text-red-600 hover:bg-red-600',
    ];

    $icons = [
        'view' => 'fas fa-eye',
        'edit' => 'fas fa-edit',
        'delete' => 'fas fa-trash',
    ];

    $classes = 'w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center transition shadow-sm hover:text-white ' . ($variants[$variant] ?? $variants['view']);
    $icon = $icons[$variant] ?? $icons['view'];
@endphp

@if($type === 'link')
    <a href="{{ $href }}" title="{{ $title }}" {{ $attributes->merge(['class' => $classes]) }}>
        <i class="{{ $icon }} text-xs"></i>
    </a>
@else
    <button type="submit" title="{{ $title }}" {{ $attributes->merge(['class' => $classes]) }}>
        <i class="{{ $icon }} text-xs"></i>
    </button>
@endif
