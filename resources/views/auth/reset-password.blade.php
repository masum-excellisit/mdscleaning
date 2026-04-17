@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <h4 class="mb-1 text-center" style="color:#16324a; font-weight:600;">Set a new password</h4>
    <p class="text-muted small text-center mb-4">Choose a strong password to secure your account.</p>

    <form method="POST" action="{{ route('password.update') }}" novalidate>
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email', $email) }}"
                   class="form-control @error('email') is-invalid @enderror"
                   required autocomplete="email" readonly>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="new-password" autofocus>
            <div class="form-text small">Min. 8 characters, with letters and numbers.</div>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="form-control" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2" style="background:#79afe3; border-color:#4e87c3;">
            <i class="bi bi-shield-check me-1"></i> Reset Password
        </button>
    </form>
@endsection
