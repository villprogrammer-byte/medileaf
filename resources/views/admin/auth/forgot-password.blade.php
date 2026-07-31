@extends('layouts.auth')

@section('title', 'Forgot Password | MediLeaf Admin')

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
                    Admin Password Recovery
                </div>

                <div class="login-card">

                    <div class="login-brand-icon">
                        <i class="bi bi-key-fill"></i>
                    </div>

                    <div class="login-heading">
                        <h2>Forgot <span>Password?</span></h2>
                        <p>Enter your registered admin email and we'll send you a verification code.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.password.otp.send') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label required">Email Address</label>

                            <div class="input-wrap">
                                <i class="bi bi-envelope input-icon"></i>
                                <input type="email" name="email" id="email"
                                    class="login-input @error('email') is-invalid @enderror"
                                    placeholder="Enter your admin email address" value="{{ old('email') }}" required
                                    autofocus>
                            </div>

                            @error('email')
                                <small class="field-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="sign-in-button mt-3">
                            <i class="bi bi-send"></i>
                            <span>Send Verification Code</span>
                        </button>
                    </form>

                    <div class="back-login">
                        <a href="{{ route('admin.login') }}">
                            <i class="bi bi-arrow-left"></i>
                            Back to Login
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