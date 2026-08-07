@extends('layouts.auth')

@section('title', 'Forgot Password | MediLeaf Admin')

@section('content')

    <x-auth-shell icon="bi-key-fill" subtitle="Enter your registered admin email and we'll send you a verification code."
        :back-route="route('admin.login')" footer-text="Your account recovery is protected with OTP verification.">
        <x-slot:title>Forgot <span>Password?</span></x-slot:title>

        <form method="POST" action="{{ route('admin.password.otp.send') }}" id="adminForgotPasswordForm">

            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label required">Email Address</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" name="email" id="email"
                        class="admin-login-input @error('email') is-invalid @enderror"
                        placeholder="Enter your admin email address" value="{{ old('email') }}" required autofocus
                        autocomplete="email">
                </div>
                @error('email')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            {{-- Cloudflare Turnstile --}}
            <div class="form-group">
                <div class="turnstile-wrap">
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"
                        data-size="flexible"></div>
                </div>
                @error('cf-turnstile-response')
                    <small class="field-error d-block mt-2">{{ $message }}</small>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="sign-in-button" id="sendResetOtpBtn">
                <i class="bi bi-send"></i>
                <span>Send Verification Code</span>
            </button>

        </form>

        <x-slot:afterForm>
            <div class="admin-login-divider">
                <span>Back to Login</span>
            </div>
        </x-slot:afterForm>

    </x-auth-shell>

@endsection

@push('scripts')

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('adminForgotPasswordForm');
            const submitButton = document.getElementById('sendResetOtpBtn');

            if (form && submitButton) {

                form.addEventListener('submit', function () {

                    submitButton.disabled = true;

                    submitButton.innerHTML =
                        '<i class="bi bi-hourglass-split"></i>' +
                        '<span>Sending Code...</span>';

                });

            }

        });

    </script>

@endpush