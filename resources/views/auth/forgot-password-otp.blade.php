@extends('layouts.auth')

@section('title', 'Verify OTP | MediLeaf')

@section('content')

    <div class="user-login-page">

        <div class="user-main-area">

            <div class="user-visual-panel">
                <i class="bi bi-leaf-fill leaf-decoration top"></i>
                <i class="bi bi-leaf-fill leaf-decoration bottom"></i>
            </div>

            <div class="user-form-panel">

                <div class="secure-access-label">
                    <i class="bi bi-shield-check"></i>
                    Secure OTP Verification
                </div>

                <div class="login-card">

                    <div class="login-brand-icon">
                        <i class="bi bi-envelope-check"></i>
                    </div>

                    <div class="login-heading">
                        <h2>Verify <span>Code</span></h2>
                        <p>We've sent a 6-digit verification code to your email address.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success auth-alert">{{ session('success') }}</div>
                    @endif

                    <div class="otp-note">
                        Enter the code to continue resetting your password.
                    </div>

                    <form method="POST" action="{{ route('password.otp.verify') }}" id="otpForm">
                        @csrf

                        <div class="otp-box">
                            <input type="text" name="otp" maxlength="6" autocomplete="one-time-code" inputmode="numeric"
                                class="otp-input @error('otp') is-invalid @enderror" placeholder="000000"
                                value="{{ old('otp') }}" required>
                        </div>

                        @error('otp')
                            <small class="field-error">{{ $message }}</small>
                        @enderror

                        <button type="submit" class="sign-in-button" id="verifyBtn">
                            <i class="bi bi-shield-lock-fill"></i>
                            Verify Code
                        </button>
                    </form>

                    <div class="login-divider">Didn't receive the code?</div>

                    <div class="resend-area">
                        <form method="POST" action="{{ route('password.otp.resend') }}">
                            @csrf
                            <button type="submit" class="resend-btn">Resend Code</button>
                        </form>
                    </div>

                    <div class="back-login">
                        <a href="{{ route('login') }}">
                            <i class="bi bi-arrow-left"></i>
                            Back to Login
                        </a>
                    </div>

                    <div class="login-card-footer">
                        <p class="copyright">© {{ date('Y') }} <strong>MediLeaf Health</strong></p>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const otp = document.querySelector(".otp-input");
            otp.addEventListener("input", function () {
                this.value = this.value.replace(/\D/g, "").substring(0, 6);
            });
        });
    </script>
@endpush