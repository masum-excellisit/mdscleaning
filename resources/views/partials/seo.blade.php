{{-- SEO meta tags. Use @push('head') in your layout to render this in the <head>.
     Variables (all optional):
       $seoTitle        — page title
       $seoDescription  — meta description
       $seoImage        — absolute URL to a representative image
       $seoCanonical    — canonical URL
       $seoNoIndex      — boolean to add noindex directive --}}
@php
    $title       = $seoTitle ?? setting('site_name', 'cstees') . ' | ' . setting('site_tagline', 'Wear the Story');
    $description = $seoDescription ?? setting('meta_description_default', setting('site_tagline', 'Premium graphic essentials designed in-house for effortless everyday wear.'));
    $image       = $seoImage ?? asset('assets/extracted/image-18.png');
    $canonical   = $seoCanonical ?? url()->current();
    $noindex     = $seoNoIndex ?? false;
    $siteName    = setting('site_name', 'cstees');
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $canonical }}">

@if($noindex)
    <meta name="robots" content="noindex, nofollow">
@endif

{{-- Open Graph --}}
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:url" content="{{ $canonical }}">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">

@if($ga = setting('google_analytics_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $ga }}');
    </script>
@endif
