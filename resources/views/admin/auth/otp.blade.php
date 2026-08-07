@extends('layouts.auth')

@section('title', 'Verify Admin OTP | MediLeaf')

@section('content')

    <x-auth-shell icon="bi-envelope-check"
        subtitle="We've sent a secure verification code to your registered admin email address."
        :back-route="route('admin.login')" footer-text="Secure Admin Access" :bg-image="asset('img/admin.webp')"
        :security-features="[
            [
                'icon' => 'bi-shield-lock',
                'title' => 'Secure Admin Access',
                'text' => 'Multi layer authentication keeps your admin portal protected.'
            ],
            [
                'icon' => 'bi-speedometer2',
                'title' => 'Smart Dashboard',
                'text' => 'Manage patients, appointments and operations from one place.'
            ],
            [
                'icon' => 'bi-person-workspace',
                'title' => 'Staff Management',
                'text' => 'Control access levels for doctors, staff and administrators.'
            ],
            [
                'icon' => 'bi-clipboard2-pulse',
                'title' => 'Real Time Monitoring',
                'text' => 'Track appointments, prescriptions and daily activities instantly.'
            ],
        ]">

        <x-slot:title>
            Verify <span>OTP</span>
        </x-slot:title>

        <div class="otp-note">
            Enter the 6-digit code to continue securely to your admin dashboard.
        </div>

        <form method="POST" action="{{ route('admin.otp.verify') }}" id="otpForm">
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
                <span>Verify &amp; Continue</span>
            </button>

        </form>

        <div class="resend-area">

            <form method="POST" action="{{ route('admin.otp.resend') }}">
                @csrf

                <button type="submit" class="resend-btn">
                    Resend OTP
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