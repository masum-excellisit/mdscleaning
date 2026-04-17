<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', setting('site_name', 'cstees') . ' | ' . setting('site_tagline', 'Wear the Story'))</title>
    <meta name="description" content="@yield('meta_description', setting('site_tagline', 'Premium graphic essentials designed in-house for effortless everyday wear.'))">

    @hasSection('canonical')<link rel="canonical" href="@yield('canonical')">@endif

    @if($favicon = setting('favicon'))
        <link rel="icon" href="{{ asset($favicon) }}">
    @else
        <link rel="icon" href="{{ asset('assets/extracted/shirt-mark.png') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages.css') }}">

    @stack('styles')
</head>
<body>

    @include('partials.topbar')
    @include('partials.header')

    <main class="page-main">
        @if(session('success') || session('error') || session('warning') || session('info') || $errors->any())
            <section class="main-container">
                @include('partials.alerts')
            </section>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}" defer></script>

    @stack('scripts')
</body>
</html>
