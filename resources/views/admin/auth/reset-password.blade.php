@extends('layouts.auth')

@section('title', 'Reset Password | MediLeaf Admin')

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
                    Set New Password
                </div>

                <div class="login-card">

                    <div class="login-brand-icon">
                        <i class="bi bi-key-fill"></i>
                    </div>

                    <div class="login-heading">
                        <h2>Set New <span>Password</span></h2>
                        <p>Choose a strong new password for your admin account.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.password.reset.update') }}">
                        @csrf

                        <div class="form-group">
                            <label for="password" class="form-label required">New Password</label>
                            <div class="input-wrap">
                                <i class="bi bi-lock input-icon"></i>
                                <input type="password" name="password" id="password"
                                    class="login-input @error('password') is-invalid @enderror"
                                    placeholder="Enter new password" required>
                            </div>
                            @error('password')
                                <small class="field-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label required">Confirm Password</label>
                            <div class="input-wrap">
                                <i class="bi bi-lock input-icon"></i>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="login-input" placeholder="Confirm new password" required>
                            </div>
                        </div>

                        <button type="submit" class="sign-in-button mt-3">
                            <i class="bi bi-check-circle"></i>
                            <span>Reset Password</span>
                        </button>
                    </form>

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