@php
    $finalTitle = $seoTitle ?? (isset($post) ? $post->title : ($siteSettings['name'] ?? config('app.name')));
    $finalDescription = $seoDescription ?? (isset($post) ? $post->meta_description : ($siteSettings['description'] ?? ''));
    $finalKeywords = $seoKeywords ?? (isset($post) ? $post->meta_keywords : ($siteSettings['keywords'] ?? ''));
    
    $defaultImage = isset($siteSettings['logo']) ? asset('storage/' . $siteSettings['logo']) : asset('favicon.ico');
    $finalImage = $seoImage ?? (isset($post->image) ? asset('storage/' . $post->image) : $defaultImage);
    
    // Ensure absolute URL for image
    if (!Str::startsWith($finalImage, ['http://', 'https://'])) {
        $finalImage = url($finalImage);
    }
@endphp

<!-- Primary Meta Tags -->
<title>{{ $finalTitle }}</title>
<meta name="title" content="{{ $finalTitle }}">
<meta name="description" content="{{ Str::limit(strip_tags($finalDescription), 160) }}">
@if($finalKeywords)
    <meta name="keywords" content="{{ $finalKeywords }}">
@endif

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $ogType ?? 'website' }}">
<meta property="og:url" content="{{ Request::fullUrl() }}">
<meta property="og:title" content="{{ $finalTitle }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($finalDescription), 160) }}">
<meta property="og:image" content="{{ $finalImage }}">
<meta property="og:site_name" content="{{ $siteSettings['name'] ?? config('app.name') }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ Request::fullUrl() }}">
<meta property="twitter:title" content="{{ $finalTitle }}">
<meta property="twitter:description" content="{{ Str::limit(strip_tags($finalDescription), 160) }}">
<meta property="twitter:image" content="{{ $finalImage }}">

<!-- Additional SEO -->
<link rel="canonical" href="{{ Request::fullUrl() }}">
<meta name="robots" content="index, follow">
<meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta name="author" content="{{ $siteSettings['name'] ?? config('app.name') }}">
