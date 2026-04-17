@extends('layouts.auth')

@section('title', 'Create Account')

@section('content')
    <h4 class="mb-1 text-center" style="color:#16324a; font-weight:600;">Create your account</h4>
    <p class="text-muted small text-center mb-4">Join the {{ setting('site_name', 'Cstees') }} family — fast checkout, wishlist, order tracking.</p>

    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   required autocomplete="name" autofocus>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   required autocomplete="email">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone <span class="text-muted small">(optional)</span></label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                   class="form-control @error('phone') is-invalid @enderror"
                   autocomplete="tel" placeholder="+91 9876543210">
            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="new-password">
            <div class="form-text small">Min. 8 characters, with letters and numbers.</div>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="form-control" required autocomplete="new-password">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="terms" id="terms" class="form-check-input @error('terms') is-invalid @enderror" {{ old('terms') ? 'checked' : '' }}>
            <label class="form-check-label small" for="terms">
                I agree to the <a href="{{ route('pages.show', 'terms') }}" target="_blank">Terms of Service</a>
                &amp; <a href="{{ route('pages.show', 'privacy-policy') }}" target="_blank">Privacy Policy</a>.
            </label>
            @error('terms')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2" style="background:#79afe3; border-color:#4e87c3;">
            <i class="bi bi-person-plus me-1"></i> Create Account
        </button>
    </form>

    <hr class="my-4">

    <p class="text-center small mb-0">
        Already have an account?
        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Sign in</a>
    </p>
@endsection
