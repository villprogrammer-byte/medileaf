@extends('layouts.auth')

@section('title', 'Forgot Password | MediLeaf')

@section('content')

    <x-auth-shell icon="bi-key-fill" subtitle="Enter your email address and we'll send you a verification code."
        :back-route="route('login')" footer-text="Your account recovery is protected with OTP verification."
        :bg-image="asset('img/login.webp')" :security-features="[
            [
                'icon' => 'bi-lock',
                'title' => 'Secure & Encrypted',
                'text' => 'Your data is always protected with advanced security.'
            ],
            [
                'icon' => 'bi-cloud-arrow-up',
                'title' => 'Daily Backup',
                'text' => 'Automatic backup ensures your data is never lost.'
            ],
            [
                'icon' => 'bi-people',
                'title' => 'Role Based Access',
                'text' => 'Secure access management for you and your team.'
            ],
            [
                'icon' => 'bi-headset',
                'title' => '24/7 Support',
                'text' => 'We are here anytime you need help.'
            ],
        ]">

        <x-slot:title>
            Forgot <span>Password?</span>
        </x-slot:title>


        {{-- Forgot Password Form --}}
        <form method="POST" action="{{ route('password.otp.send') }}" id="forgotPasswordForm">
            @csrf

            {{-- Email Address --}}
            <div class="form-group">

                <label for="email" class="form-label required">
                    Email Address
                </label>

                <div class="input-wrap">

                    <i class="bi bi-envelope input-icon"></i>

                    <input type="email" name="email" id="email"
                        class="admin-login-input @error('email') is-invalid @enderror"
                        placeholder="Enter your email address" value="{{ old('email') }}" required autofocus
                        autocomplete="email">

                </div>

                @error('email')
                    <small class="field-error">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- Cloudflare Turnstile --}}
            <div class="form-group mt-3">

                <div class="turnstile-wrap">

                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"
                        data-size="flexible"></div>

                </div>

                @error('cf-turnstile-response')
                    <small class="field-error d-block mt-2">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- Submit --}}
            <button type="submit" class="sign-in-button mt-3" id="sendResetOtpBtn">
                <i class="bi bi-send"></i>
                <span>Send Verification Code</span>
            </button>

        </form>


        {{-- After Form --}}
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

            const form = document.getElementById('forgotPasswordForm');
            const submitButton = document.getElementById('sendResetOtpBtn');

            if (!form || !submitButton) {
                return;
            }

            form.addEventListener('submit', function () {

                submitButton.disabled = true;

                submitButton.innerHTML =
                    '<i class="bi bi-hourglass-split"></i>' +
                    '<span>Sending Code...</span>';

            });

        });
    </script>

@endpush