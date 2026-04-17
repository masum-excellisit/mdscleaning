<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Sign In') - {{ setting('site_name', 'Cstees') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body.cstees-admin-auth {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            background:
                radial-gradient(circle at top left, rgba(121, 175, 227, 0.28), transparent 0 28%),
                linear-gradient(135deg, #0f172a 0%, #162033 42%, #1e293b 100%);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #0f172a;
        }

        .admin-auth-shell {
            width: min(100%, 1040px);
            display: grid;
            grid-template-columns: minmax(280px, 1fr) minmax(360px, 460px);
            background: rgba(255, 255, 255, 0.97);
            border: 1px solid rgba(148, 163, 184, 0.22);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.35);
        }

        .admin-auth-side {
            padding: 48px;
            background:
                linear-gradient(160deg, rgba(30, 41, 59, 0.96), rgba(15, 23, 42, 0.98)),
                #0f172a;
            color: #e2e8f0;
        }

        .admin-auth-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(121, 175, 227, 0.16);
            color: #bfdbfe;
            font-size: 0.88rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .admin-auth-side h1 {
            margin: 26px 0 14px;
            font-size: clamp(2rem, 3vw, 3.1rem);
            line-height: 1.02;
            color: #fff;
        }

        .admin-auth-side p {
            margin: 0;
            max-width: 30rem;
            color: #cbd5e1;
            font-size: 1rem;
            line-height: 1.7;
        }

        .admin-auth-points {
            margin: 34px 0 0;
            padding: 0;
            list-style: none;
            display: grid;
            gap: 14px;
        }

        .admin-auth-points li {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #e2e8f0;
        }

        .admin-auth-points i {
            color: #7dd3fc;
        }

        .admin-auth-card {
            padding: 42px 36px;
            background: #fff;
        }

        .admin-auth-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            color: #0f172a;
            font-size: 1.2rem;
            font-weight: 700;
            text-decoration: none;
        }

        .admin-auth-brand i {
            color: #2563eb;
        }

        @media (max-width: 900px) {
            .admin-auth-shell {
                grid-template-columns: 1fr;
            }

            .admin-auth-side,
            .admin-auth-card {
                padding: 32px 24px;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="cstees-admin-auth">
    <div class="admin-auth-shell">
        <section class="admin-auth-side">
            <div class="admin-auth-badge">
                <i class="bi bi-shield-lock-fill"></i>
                Admin Access
            </div>
            <h1>Manage products, orders, content, and operations.</h1>
            <p>Use the admin portal to access the control panel for catalog updates, customer support workflows, marketing content, and reporting.</p>

            <ul class="admin-auth-points">
                <li><i class="bi bi-check2-circle"></i><span>Separate sign-in for staff and store customers</span></li>
                <li><i class="bi bi-check2-circle"></i><span>Direct access to the cstees admin dashboard</span></li>
                <li><i class="bi bi-check2-circle"></i><span>Role-restricted entry for approved admin accounts</span></li>
            </ul>
        </section>

        <section class="admin-auth-card">
            <a href="{{ route('home') }}" class="admin-auth-brand">
                <i class="bi bi-bag-heart-fill"></i>
                {{ setting('site_name', 'Cstees') }} Admin
            </a>

            @include('partials.alerts')

            @yield('content')
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
