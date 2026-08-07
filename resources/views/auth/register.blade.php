@extends('layouts.auth')

@section('title', 'User Register | MediLeaf')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')

    <x-auth-shell icon="bi-person-fill"
        subtitle="Create your secure patient account to book consultations and manage your healthcare online."
        :back-route="route('home')" footer-text="Secure Account Registration" bg-image="{{ asset('img/register.webp') }}"
        :security-features="[
                ['icon' => 'bi-person-check', 'title' => 'Quick Registration', 'text' => 'Create your account in just a few simple steps.'],
                ['icon' => 'bi-calendar-check', 'title' => 'Book Appointments', 'text' => 'Schedule and manage your appointments anytime.'],
                ['icon' => 'bi-file-earmark-medical', 'title' => 'Access Medical Records', 'text' => 'View your consultation history and prescriptions securely.'],
                ['icon' => 'bi-shield-check', 'title' => 'Safe & Secure', 'text' => 'Your personal information is protected with secure encryption.'],
            ]">
        <x-slot:title>Join <span>MediLeaf</span> Today</x-slot:title>

        <form id="registerForm" action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            {{-- Name --}}
            <div class="form-group">
                <label class="form-label required">Full Name</label>
                <div class="input-wrap">
                    <i class="bi bi-person input-icon"></i>
                    <input type="text" name="name" class="admin-login-input" placeholder="Enter your full name"
                        value="{{ old('name') }}" required>
                </div>
                @error('name')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label class="form-label required">Email Address</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" name="email" id="email" class="admin-login-input"
                        placeholder="Enter your email address" value="{{ old('email') }}" required>
                </div>
                @error('email')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                @enderror
            </div>

            {{-- Mobile --}}
            <div class="form-group">
                <label class="form-label required">Mobile Number</label>
                <div class="input-wrap">
                    <i class="bi bi-phone input-icon"></i>
                    <input type="tel" name="mobile" class="admin-login-input" placeholder="04XX XXX XXX"
                        value="{{ old('mobile') }}" required>
                </div>
                @error('mobile')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                @enderror
            </div>

            {{-- Password Row --}}
            <div class="row g-3">

                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label class="form-label required">Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" name="password" class="admin-login-input" id="password" required>
                            <button type="button" class="password-toggle" data-target="password" aria-label="Show password">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        @error('password')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label class="form-label required">Confirm Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" name="password_confirmation" class="admin-login-input"
                                id="confirm_password" required>
                            <button type="button" class="password-toggle" data-target="confirm_password" aria-label="Show password">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            {{-- DOB --}}
            <div class="form-group mt-3">
                <label class="form-label required">Date of Birth</label>
                <div class="input-wrap">
                    <i class="bi bi-calendar-event input-icon"></i>
                    <input type="date" id="dob" name="dob" class="admin-login-input" value="{{ old('dob') }}" required>
                </div>
                <small class="text-muted mt-2 d-block">
                    You must be 18 years or older to register.
                </small>
                @error('dob')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                @enderror
            </div>

            {{-- Consent --}}
            <div class="mt-3">

                <label class="remember-wrap mb-2">
                    <input type="checkbox" name="age_confirm" required>
                    <span>I confirm I am 18 years of age or older.</span>
                </label>

                <label class="remember-wrap mb-2">
                    <input type="checkbox" name="terms" required>
                    <span>
                        I agree to the
                        <a href="#">Terms &amp; Conditions</a>
                        and
                        <a href="#">Privacy Policy</a>.
                    </span>
                </label>

                <label class="remember-wrap">
                    <input type="checkbox" name="health_consent" required>
                    <span>
                        I consent to MediLeaf securely processing my health information
                        for consultation and treatment purposes.
                    </span>
                </label>

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

            <button type="submit" class="sign-in-button mt-4">
                <i class="bi bi-person-plus"></i>
                <span>Create Account</span>
            </button>

        </form>

    </x-auth-shell>

    {{-- Email Verification Modal --}}
    <div class="verify-modal-overlay" id="verifyModalOverlay">
        <div class="verify-modal" role="dialog" aria-modal="true" aria-labelledby="verifyModalTitle">

            <button type="button" class="verify-modal-close" id="verifyModalClose" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="verify-modal-icon">
                <i class="bi bi-envelope-check"></i>
            </div>

            <h3 class="verify-modal-title" id="verifyModalTitle">Verify your email</h3>

            <p class="verify-modal-text">
                We've sent a verification link to <strong id="verifyModalEmail">your email address</strong>.
                Open your inbox and click the link to activate your MediLeaf account.
            </p>

            <p class="verify-modal-subtext">
                Can't find it? Check your spam folder, or request a new link.
            </p>

            <div class="verify-modal-actions">
                <button type="button" class="verify-modal-resend" id="verifyModalResend">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Resend Email</span>
                </button>

                <button type="button" class="verify-modal-continue" id="verifyModalContinue">
                    <span>Continue</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script src="{{ asset('js/register.js') }}"></script>
@endpush