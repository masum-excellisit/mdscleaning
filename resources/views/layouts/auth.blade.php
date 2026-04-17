<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sign In') — {{ setting('site_name', 'Cstees') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages.css') }}">

    <style>
        body.cstees-auth {
            background: #edf6ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            padding: 2rem 1rem;
        }
        .auth-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(22,50,74,.08);
            padding: 2.5rem;
            width: 100%;
            max-width: 480px;
        }
        .auth-card .brand {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            font-size: 2rem;
            color: #16324a;
            text-align: center;
            margin-bottom: 1.5rem;
            display: block;
            text-decoration: none;
        }
    </style>

    @stack('styles')
</head>
<body class="cstees-auth">

    <div class="auth-card">
        <a href="{{ route('home') }}" class="brand">
            {{ setting('site_name', 'Cstees') }}
        </a>

        @include('partials.alerts')

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
