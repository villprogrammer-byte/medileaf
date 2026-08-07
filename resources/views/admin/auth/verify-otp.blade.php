@extends('layouts.auth')

@section('title', 'Verify Reset OTP | MediLeaf Health')

@section('content')

    <x-auth-shell icon="bi-envelope-check" subtitle="Enter the 6-digit code sent to your registered admin email."
        :back-route="route('admin.password.request')" footer-text="Your password reset is protected with OTP verification.">
        <x-slot:title>Verify <span>OTP</span></x-slot:title>

        <div class="otp-note">
            Enter the 6-digit code to continue with your password reset.
        </div>

        <form method="POST" action="{{ route('admin.password.otp.verify') }}" id="resetOtpForm">

            @csrf

            <div class="otp-box">
                <input type="text" name="otp" maxlength="6" autocomplete="one-time-code" inputmode="numeric"
                    class="otp-input @error('otp') is-invalid @enderror" placeholder="000000" value="{{ old('otp') }}"
                    required>
            </div>

            @error('otp')
                <small class="field-error">{{ $message }}</small>
            @enderror

            <button type="submit" class="sign-in-button" id="verifyResetOtpBtn">
                <i class="bi bi-shield-lock-fill"></i>
                <span>Verify &amp; Continue</span>
            </button>

        </form>

        <div class="resend-area">
            <form method="POST" action="{{ route('admin.password.otp.resend') }}">
                @csrf
                <button type="submit" class="resend-btn">Resend OTP</button>
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
            const otpForm = document.getElementById("resetOtpForm");
            const verifyButton = document.getElementById("verifyResetOtpBtn");

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
                        '<i class="bi bi-hourglass-split"></i> Verifying...';
                });
            }

        });
    </script>

@endpush