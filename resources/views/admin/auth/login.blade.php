@extends('layouts.auth')

@section('title', 'Admin Login | MediLeaf')

@section('content')

    <x-auth-shell icon="bi-person-bounding-box" subtitle="Sign in to continue to your admin dashboard"
        :back-route="route('home')" footer-text="Secure Admin Access">
        <x-slot:title>Welcome <span>Admin!</span></x-slot:title>

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label required">Email Address</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope input-icon"></i>
                    <input id="email" type="email" name="email"
                        class="admin-login-input @error('email') is-invalid @enderror"
                        placeholder="Enter your email address" value="{{ old('email') }}" required autofocus
                        autocomplete="email">
                </div>
                @error('email')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label required">Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock input-icon"></i>
                    <input id="password" type="password" name="password"
                        class="admin-login-input @error('password') is-invalid @enderror" placeholder="Enter your password"
                        required autocomplete="current-password">
                    <button type="button" class="password-toggle" data-target="password" aria-label="Show password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="admin-login-options">
                <label class="remember-wrap">
                    <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
                    <span>Remember Me</span>
                </label>

                @if (Route::has('admin.password.request'))
                    <a href="{{ route('admin.password.request') }}" class="forgot-link">Forgot Password?</a>
                @endif
            </div>

            <div class="form-group">
                <div class="turnstile-wrap">
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"
                        data-size="flexible"></div>
                </div>
                @error('cf-turnstile-response')
                    <small class="field-error d-block mt-2">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="sign-in-button">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Sign In to Dashboard</span>
            </button>
        </form>

    </x-auth-shell>

@endsection

@push('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script src="{{ asset('js/admin-login.js') }}"></script>
@endpush