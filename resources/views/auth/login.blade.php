@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h4 class="mb-1 text-center" style="color:#16324a; font-weight:600;">Welcome back</h4>
    <p class="text-muted small text-center mb-4">Sign in to continue shopping with us.</p>

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   required autocomplete="email" autofocus>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label for="password" class="form-label mb-0">Password</label>
                <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot password?</a>
            </div>
            <input id="password" type="password" name="password"
                   class="form-control mt-1 @error('password') is-invalid @enderror"
                   required autocomplete="current-password">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label small" for="remember">Keep me signed in</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2" style="background:#79afe3; border-color:#4e87c3;">
            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
        </button>
    </form>

    <hr class="my-4">

    <p class="text-center small mb-0">
        New to {{ setting('site_name', 'Cstees') }}?
        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Create an account</a>
    </p>

    <p class="text-center small mt-3 mb-0 text-muted">
        Staff or admin?
        <a href="{{ route('admin.login') }}" class="text-decoration-none fw-semibold">Use the admin login</a>
    </p>
@endsection
