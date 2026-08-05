@extends('layouts.auth')

@section('title', 'Verify Reset OTP | MediLeaf Health')

@section('content')

    <div class="user-login-page">

        <div class="user-main-area">

            {{-- LEFT PANEL --}}
            <div class="user-visual-panel">

                <div class="visual-content">
                    <i class="bi bi-leaf-fill leaf-decoration top"></i>
                    <i class="bi bi-leaf-fill leaf-decoration bottom"></i>
                </div>

            </div>

            {{-- RIGHT PANEL --}}
            <div class="user-form-panel">

                <div class="secure-access-label">
                    <i class="bi bi-shield-check"></i>
                    Secure Password Reset
                </div>

                <div class="login-card">

                    <div class="login-brand-icon">
                        <i class="bi bi-envelope-check"></i>
                    </div>

                    <div class="login-heading">

                        <h2>
                            Verify <span>OTP</span>
                        </h2>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success auth-alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('status'))
                        <div class="alert alert-success auth-alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="otp-note">
                        Enter the 6-digit code to continue with your password reset.
                    </div>

                    <form method="POST" action="{{ route('admin.password.otp.verify') }}" id="resetOtpForm">

                        @csrf

                        <div class="otp-box">

                            <input type="text" name="otp" maxlength="6" autocomplete="one-time-code" inputmode="numeric"
                                class="otp-input @error('otp') is-invalid @enderror" placeholder="000000"
                                value="{{ old('otp') }}" required>

                        </div>

                        @error('otp')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror

                        <button type="submit" class="sign-in-button" id="verifyResetOtpBtn">

                            <i class="bi bi-shield-lock-fill"></i>

                            Verify &amp; Continue

                        </button>

                    </form>

                    <div class="login-divider">
                        Didn't receive the code?
                    </div>

                    <div class="resend-area">

                        <form method="POST" action="{{ route('admin.password.otp.resend') }}">
                            @csrf

                            <button type="submit" class="resend-btn">
                                Resend OTP
                            </button>
                        </form>

                    </div>

                    <div class="back-login">

                        <a href="{{ route('admin.password.request') }}">

                            <i class="bi bi-arrow-left"></i>

                            Back to Forgot Password

                        </a>

                    </div>

                    <div class="login-card-footer">

                        <div class="footer-security">

                            <i class="bi bi-shield-check"></i>

                            Your password reset is protected with OTP verification.

                        </div>

                        <p class="copyright">

                            © {{ date('Y') }}

                            <strong>MediLeaf Health</strong>

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

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