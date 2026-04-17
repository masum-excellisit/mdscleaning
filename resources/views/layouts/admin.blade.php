<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') — {{ setting('site_name', 'Cstees') }}</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}">

    <style>
        :root {
            --admin-sidebar-bg: #1e293b;
            --admin-sidebar-text: #94a3b8;
            --admin-sidebar-active: #ffffff;
            --admin-content-bg: #f8fafc;
            --admin-card-bg: #ffffff;
            --admin-border: #e2e8f0;
        }
        body.cstees-admin {
            background: var(--admin-content-bg);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--admin-sidebar-bg);
            color: var(--admin-sidebar-text);
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            padding: 1rem 0;
            z-index: 1030;
        }
        .admin-sidebar .brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.4rem;
            padding: .75rem 1.25rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
            margin-bottom: 1rem;
            display: block;
            text-decoration: none;
        }
        .admin-sidebar .nav-section {
            color: #64748b;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 1rem 1.25rem .35rem;
        }
        .admin-sidebar .nav-link {
            color: var(--admin-sidebar-text);
            padding: .55rem 1.25rem;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: .65rem;
            font-size: .92rem;
        }
        .admin-sidebar .nav-link i { font-size: 1.05rem; opacity: .85; }
        .admin-sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,.04); }
        .admin-sidebar .nav-link.active {
            color: #fff;
            background: rgba(121,175,227,.16);
            border-left: 3px solid #79afe3;
            padding-left: calc(1.25rem - 3px);
        }
        .admin-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 1.5rem;
        }
        .admin-topbar {
            background: #fff;
            border: 1px solid var(--admin-border);
            border-radius: .5rem;
            padding: .75rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-card {
            background: var(--admin-card-bg);
            border: 1px solid var(--admin-border);
            border-radius: .5rem;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
        }
        @media (max-width: 768px) {
            .admin-sidebar { transform: translateX(-100%); transition: transform .25s ease; }
            .admin-sidebar.show { transform: translateX(0); }
            .admin-content { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body class="cstees-admin">

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="adminSidebar">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            <i class="bi bi-stars text-primary"></i> {{ setting('site_name', 'MDS Cleaning') }}
        </a>

        <div class="nav-section">Main</div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ active_class('admin.dashboard') }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid"></i> Dashboard</a></li>
        </ul>

        <div class="nav-section">Content</div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ active_class('admin.banners.*') }}" href="{{ route('admin.banners.index') }}"><i class="bi bi-image"></i> Banners</a></li>
            <li class="nav-item"><a class="nav-link {{ active_class('admin.homepage-sections.*') }}" href="{{ route('admin.homepage-sections.index') }}"><i class="bi bi-layout-text-window"></i> Homepage Sections</a></li>
            <li class="nav-item"><a class="nav-link {{ active_class('admin.services.*') }}" href="{{ route('admin.services.index') }}"><i class="bi bi-shield-check"></i> Services</a></li>
            <li class="nav-item"><a class="nav-link {{ active_class('admin.testimonials.*') }}" href="{{ route('admin.testimonials.index') }}"><i class="bi bi-chat-quote"></i> Testimonials</a></li>
            <li class="nav-item"><a class="nav-link {{ active_class('admin.blogs.*', 'admin.blog-categories.*') }}" href="{{ route('admin.blogs.index') }}"><i class="bi bi-newspaper"></i> Blog Posts</a></li>
            <li class="nav-item"><a class="nav-link {{ active_class('admin.pages.*') }}" href="{{ route('admin.pages.index') }}"><i class="bi bi-file-earmark-text"></i> Pages</a></li>
            <li class="nav-item"><a class="nav-link {{ active_class('admin.faqs.*') }}" href="{{ route('admin.faqs.index') }}"><i class="bi bi-question-circle"></i> FAQs</a></li>
        </ul>

        <div class="nav-section">Customer</div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ active_class('admin.contacts.*') }}" href="{{ route('admin.contacts.index') }}"><i class="bi bi-chat-dots"></i> Contact Inquiries</a></li>
            <li class="nav-item"><a class="nav-link {{ active_class('admin.newsletter.*') }}" href="{{ route('admin.newsletter.index') }}"><i class="bi bi-envelope"></i> Newsletter</a></li>
        </ul>

        <div class="nav-section">Media</div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ active_class('admin.media.*') }}" href="{{ route('admin.media.index') }}"><i class="bi bi-images"></i> Media Library</a></li>
        </ul>

        <div class="nav-section">System</div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ active_class('admin.settings.*') }}" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear"></i> Site Settings</a></li>
        </ul>
    </aside>

    {{-- Content --}}
    <div class="admin-content">
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-light d-md-none" type="button" onclick="document.getElementById('adminSidebar').classList.toggle('show')"><i class="bi bi-list"></i></button>
                <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="text-decoration-none small text-muted"><i class="bi bi-box-arrow-up-right"></i> View Site</a>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ auth()->user()?->name ?? 'User' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> {{ auth()->user()?->name ?? 'Admin' }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @include('partials.alerts')

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('scripts')
</body>
</html>
