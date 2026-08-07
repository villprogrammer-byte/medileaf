@extends('layouts.auth')

@section('title', 'Verify OTP | MediLeaf')

@section('content')

    <x-auth-shell icon="bi-envelope-check" subtitle="We've sent a 6-digit verification code to your email address."
        :back-route="route('password.request')" footer-text="Secure User Access" :bg-image="asset('img/login.webp')"
        :security-features="[
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
            Verify <span>Code</span>
        </x-slot:title>


        <div class="otp-note">
            Enter the code to continue resetting your password.
        </div>


        <form method="POST" action="{{ route('password.otp.verify') }}" id="otpForm">
            @csrf

            <div class="otp-box">

                <input type="text" name="otp" maxlength="6" autocomplete="one-time-code" inputmode="numeric"
                    class="otp-input @error('otp') is-invalid @enderror" placeholder="000000" value="{{ old('otp') }}"
                    required>

            </div>

            @error('otp')
                <small class="field-error">
                    {{ $message }}
                </small>
            @enderror


            <button type="submit" class="sign-in-button" id="verifyBtn">
                <i class="bi bi-shield-lock-fill"></i>
                <span>Verify Code</span>
            </button>

        </form>


        <div class="resend-area">

            <form method="POST" action="{{ route('password.otp.resend') }}">
                @csrf

                <button type="submit" class="resend-btn">
                    Resend Code
                </button>

            </form>

        </div>


        <x-slot:afterForm>

            <div class="admin-login-divider">
                <span>Didn't receive the code?</span>
            </div>

        </x-slot:afterForm>

    </x-auth-shell>

@endsection


@push('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const otpInput = document.querySelector(".otp-input");
            const otpForm = document.getElementById("otpForm");
            const verifyButton = document.getElementById("verifyBtn");

            if (otpInput) {
                otpInput.addEventListener("input", function () {

                    this.value = this.value
                        .replace(/\D/g, "")
                        .substring(0, 6);

                });
            }

            if (otpForm && verifyButton) {
                otpForm.addEventListener("submit", function () {

                    verifyButton.disabled = true;

                    verifyButton.innerHTML =
                        '<i class="bi bi-hourglass-split"></i>' +
                        '<span>Verifying...</span>';

                });
            }

        });
    </script>

@endpush