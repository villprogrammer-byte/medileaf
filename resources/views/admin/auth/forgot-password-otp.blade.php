@extends('layouts.auth')

@section('title', 'Verify OTP | MediLeaf Admin')

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
                    Verify OTP
                </div>

                <div class="login-card">

                    <div class="login-brand-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>

                    <div class="login-heading">
                        <h2>Enter <span>OTP</span></h2>
                        <p>We've sent a 6-digit verification code to your email.</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.password.otp.verify') }}">
                        @csrf

                        <div class="form-group">
                            <label for="otp" class="form-label required">OTP Code</label>

                            <div class="input-wrap">
                                <i class="bi bi-shield-lock input-icon"></i>
                                <input type="text" name="otp" id="otp" maxlength="6" inputmode="numeric" pattern="[0-9]*"
                                    class="login-input @error('otp') is-invalid @enderror" placeholder="Enter 6-digit code"
                                    required autofocus>
                            </div>

                            @error('otp')
                                <small class="field-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="sign-in-button mt-3">
                            <i class="bi bi-check-circle"></i>
                            <span>Verify & Continue</span>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.password.otp.resend') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="back-login" style="background:none;border:none;width:100%;">
                            Resend OTP
                        </button>
                    </form>

                    <div class="back-login">
                        <a href="{{ route('admin.password.request') }}">
                            <i class="bi bi-arrow-left"></i>
                            Back
                        </a>
                    </div>

                    <div class="login-card-footer">
                        <div class="footer-security">
                            <i class="bi bi-shield-check"></i>
                            Your account recovery is protected with OTP verification.
                        </div>
                        <p class="copyright">
                            © {{ date('Y') }} <strong>MediLeaf Health</strong>
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection