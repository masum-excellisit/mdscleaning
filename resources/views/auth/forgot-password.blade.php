@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
    <h4 class="mb-1 text-center" style="color:#16324a; font-weight:600;">Forgot your password?</h4>
    <p class="text-muted small text-center mb-4">No worries — enter your email and we'll send you a reset link.</p>

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   required autocomplete="email" autofocus>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2" style="background:#79afe3; border-color:#4e87c3;">
            <i class="bi bi-envelope me-1"></i> Send Reset Link
        </button>
    </form>

    <hr class="my-4">

    <p class="text-center small mb-0">
        Remembered it? <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Back to login</a>
    </p>
@endsection
