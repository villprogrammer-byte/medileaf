@extends('layouts.auth')

@section('title', 'Reset Password | MediLeaf')

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
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>

                    <div class="login-heading">
                        <h2>Reset <span>Password</span></h2>
                        <p>Choose a new password for your account.</p>
                    </div>

                    <form method="POST" action="{{ route('password.reset.update') }}">
                        @csrf

                        <div class="form-group">
                            <label for="password" class="form-label required">New Password</label>

                            <div class="input-wrap">
                                <i class="bi bi-lock input-icon"></i>
                                <input type="password" name="password" id="password"
                                    class="login-input @error('password') is-invalid @enderror"
                                    placeholder="Enter new password" required>

                                <button type="button" class="password-toggle" data-target="password">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
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

                                <button type="button" class="password-toggle" data-target="password_confirmation">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="sign-in-button mt-3">
                            <i class="bi bi-check-circle"></i>
                            <span>Reset Password</span>
                        </button>
                    </form>

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
            document.querySelectorAll(".password-toggle").forEach(function (button) {
                button.addEventListener("click", function () {
                    const targetId = this.getAttribute("data-target");
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector("i");

                    if (input.type === "password") {
                        input.type = "text";
                        icon.classList.replace("bi-eye-slash", "bi-eye");
                    } else {
                        input.type = "password";
                        icon.classList.replace("bi-eye", "bi-eye-slash");
                    }
                });
            });
        });
    </script>
@endpush