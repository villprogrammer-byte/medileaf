@extends('layouts.auth')

@section('title', 'User Login | MediLeaf')

@section('content')

    <x-auth-shell icon="bi-person-fill" subtitle="Sign in to continue to your user dashboard" :back-route="route('home')"
        footer-text="Secure User Access" bg-image="{{ asset('img/login.webp') }}" :security-features="[
                        ['icon' => 'bi-lock', 'title' => 'Secure & Encrypted', 'text' => 'Your data is always protected with advanced security.'],
                        ['icon' => 'bi-cloud-arrow-up', 'title' => 'Daily Backup', 'text' => 'Automatic backup ensures your data is never lost.'],
                        ['icon' => 'bi-people', 'title' => 'Role Based Access', 'text' => 'Secure access management for you and your team.'],
                        ['icon' => 'bi-headset', 'title' => '24/7 Support', 'text' => 'We are here anytime you need help.'],
                    ]">
        <x-slot:title>Welcome <span>Back!</span></x-slot:title>

        <form id="loginForm" action="{{ route('login.otp.send') }}" method="POST" novalidate>
            @csrf

            <div class="form-group">
                <label for="email" class="form-label required">Email Address</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" name="email" id="email"
                        class="admin-login-input @error('email') is-invalid @enderror"
                        placeholder="Enter your email address" value="{{ old('email') }}" autocomplete="email" required
                        autofocus>
                </div>
                @error('email')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label required">Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" name="password" id="password"
                        class="admin-login-input @error('password') is-invalid @enderror" placeholder="Enter your password"
                        autocomplete="current-password" required>
                    <button type="button" class="password-toggle" data-target="password" aria-label="Show password">
                        <i class="bi bi-eye-slash"></i>
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

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                @endif
            </div>

            <div class="form-group mt-3">
                <div class="turnstile-wrap">
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"
                        data-size="flexible"></div>
                </div>
                @error('cf-turnstile-response')
                    <small class="field-error d-block mt-2">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="sign-in-button" id="signInButton">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Sign In &amp; Send OTP</span>
            </button>
        </form>

        <x-slot:afterForm>
            <div class="admin-login-divider">
                <span>or continue with</span>
            </div>

            <div class="social-login-list">
                <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="social-button google"
                    aria-label="Continue with Google" title="Continue with Google">
                    <img src="{{ asset('img/google.svg') }}" alt="Google">
                </a>

                <span class="social-button secure" aria-label="Secure login" title="Secure login">
                    <i class="bi bi-shield-check"></i>
                </span>

                {{-- <a href="{{ route('social.redirect', ['provider' => 'apple']) }}" class="social-button apple"
                    aria-label="Continue with Apple" title="Continue with Apple">
                    <img src="{{ asset('img/apple.svg') }}" alt="Apple">
                </a> --}}
            </div>

            <div class="register-prompt">
                <span>Don't have an account?</span>
                <a href="{{ route('register') }}">Create Account</a>
            </div>
        </x-slot:afterForm>

    </x-auth-shell>

@endsection

@push('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script src="{{ asset('js/login.js') }}"></script>
@endpush
{{-- password-toggle.js loads once from layouts/auth.blade.php, no need to include it here --}}