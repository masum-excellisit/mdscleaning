@extends('layouts.admin-auth')

@section('title', 'Admin Login')

@section('content')
    <h4 class="mb-1" style="color:#0f172a; font-weight:700;">Admin sign in</h4>
    <p class="text-muted small mb-4">Use an approved admin account to access the control panel.</p>

    <form method="POST" action="{{ route('admin.login.submit') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Admin Email</label>
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

        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-shield-lock me-1"></i> Enter Admin Panel
        </button>
    </form>

@endsection
