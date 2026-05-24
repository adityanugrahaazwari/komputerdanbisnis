<!-- Basic Meta Tags -->
<meta name="title" content="{{ $seoTitle ?? ($post->title ?? $siteSettings['name']) }}">
<meta name="description" content="{{ $seoDescription ?? ($post->meta_description ?? $siteSettings['description']) }}">
@if(isset($post->meta_keywords) || isset($seoKeywords))
    <meta name="keywords" content="{{ $seoKeywords ?? $post->meta_keywords }}">
@endif

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $ogType ?? 'website' }}">
<meta property="og:url" content="{{ Request::fullUrl() }}">
<meta property="og:title" content="{{ $seoTitle ?? ($post->title ?? $siteSettings['name']) }}">
<meta property="og:description" content="{{ $seoDescription ?? ($post->meta_description ?? $siteSettings['description']) }}">
<meta property="og:image" content="{{ $seoImage ?? (isset($post->image) ? asset('storage/' . $post->image) : (isset($siteSettings['logo']) ? asset('storage/' . $siteSettings['logo']) : asset('favicon.ico'))) }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ Request::fullUrl() }}">
<meta property="twitter:title" content="{{ $seoTitle ?? ($post->title ?? $siteSettings['name']) }}">
<meta property="twitter:description" content="{{ $seoDescription ?? ($post->meta_description ?? $siteSettings['description']) }}">
<meta property="twitter:image" content="{{ $seoImage ?? (isset($post->image) ? asset('storage/' . $post->image) : (isset($siteSettings['logo']) ? asset('storage/' . $siteSettings['logo']) : asset('favicon.ico'))) }}">
