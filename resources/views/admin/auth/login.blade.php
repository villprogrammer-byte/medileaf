<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | MediLeaf</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Page CSS (same as admin login design) -->
    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>

<body>

    <main class="admin-login-page">

        <div class="admin-main-area">

            <!-- LEFT 60% IMAGE SECTION -->
            <section class="admin-visual-panel">

                <i class="bi bi-leaf-fill leaf-decoration top"></i>
                <i class="bi bi-leaf-fill leaf-decoration bottom"></i>

            </section>

            <!-- RIGHT 40% LOGIN SECTION -->
            <section class="admin-form-panel">

                <div class="login-card">

                    <!-- BACK TO HOME BUTTON -->
                    <a href="{{ route('home') }}" class="back-home-btn" aria-label="Back to home" title="Back to home">
                        <i class="bi bi-arrow-left"></i>
                    </a>

                    <!-- FIXED TOP (does not scroll) -->
                    <div class="login-brand-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div class="login-heading">

                        <h2>
                            Welcome <span>Admin!</span>
                        </h2>

                        <p>
                            Sign in to continue to your admin dashboard
                        </p>

                    </div>

                    @if (session('status'))
                        <div class="alert alert-success auth-alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger auth-alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- SCROLLABLE AREA (only this scrolls) -->
                    <div class="login-form-scroll">

                        <!-- ADMIN EMAIL + PASSWORD LOGIN (same markup/attrs as the working admin form — only classes changed for design) -->
                        <form method="POST" action="{{ route('admin.login.submit') }}">

                            @csrf

                            <!-- EMAIL -->
                            <div class="form-group">

                                <label for="email" class="form-label required">
                                    Email Address
                                </label>

                                <div class="input-wrap">

                                    <i class="bi bi-envelope input-icon"></i>

                                    <input type="email" name="email"
                                        class="login-input @error('email') is-invalid @enderror"
                                        placeholder="Enter your email address" value="{{ old('email') }}" required
                                        autofocus>

                                </div>

                                @error('email')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <!-- PASSWORD -->
                            <div class="form-group">

                                <label for="password" class="form-label required">
                                    Password
                                </label>

                                <div class="input-wrap">

                                    <i class="bi bi-lock input-icon"></i>

                                    <input id="password" type="password" name="password"
                                        class="login-input @error('password') is-invalid @enderror"
                                        placeholder="Enter your password" required>

                                    <button type="button" class="password-toggle toggle-password"
                                        aria-label="Show password">

                                        <i class="bi bi-eye"></i>

                                    </button>

                                </div>

                                @error('password')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <!-- OPTIONS -->
                            <div class="login-options">

                                <label class="remember-wrap">

                                    <input type="checkbox" name="remember">

                                    <span>Remember Me</span>

                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('admin.password.request') }}" class="forgot-link">
                                        Forgot Password?
                                    </a>

                                @endif

                            </div>

                            <!-- LOGIN BUTTON (no OTP / no Turnstile — direct admin login, same as working form) -->
                            <button type="submit" class="sign-in-button">

                                <i class="bi bi-box-arrow-in-right"></i>

                                <span>
                                    Sign In to Dashboard
                                </span>

                            </button>

                        </form>

                    </div>
                    <!-- END SCROLLABLE AREA -->

                    <!-- FIXED BOTTOM (does not scroll) -->
                    <div class="login-divider">
                        <span>Secure Admin Access</span>
                    </div>

                    <div class="login-card-footer">

                        <div class="footer-security">

                            <i class="bi bi-lock"></i>

                            <span>
                                Secure Admin Access
                            </span>

                        </div>

                        <p class="copyright">

                            © {{ date('Y') }}

                            <strong>MediLeaf.</strong>

                            All rights reserved.

                        </p>

                    </div>

                </div>

            </section>

        </div>

        <!-- BOTTOM SECURITY STRIP -->
        <section class="security-strip">

            <div class="security-feature">

                <div class="security-feature-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>

                <div class="security-feature-copy">

                    <strong>
                        Secure Admin Access
                    </strong>

                    <span>
                        Multi layer authentication keeps your admin portal protected.
                    </span>

                </div>

            </div>

            <div class="security-feature">

                <div class="security-feature-icon">
                    <i class="bi bi-speedometer2"></i>
                </div>

                <div class="security-feature-copy">

                    <strong>
                        Smart Dashboard
                    </strong>

                    <span>
                        Manage patients, appointments and operations from one place.
                    </span>

                </div>

            </div>

            <div class="security-feature">

                <div class="security-feature-icon">
                    <i class="bi bi-person-workspace"></i>
                </div>

                <div class="security-feature-copy">

                    <strong>
                        Staff Management
                    </strong>

                    <span>
                        Control access levels for doctors, staff and administrators.
                    </span>

                </div>

            </div>

            <div class="security-feature">

                <div class="security-feature-icon">
                    <i class="bi bi-clipboard2-pulse"></i>
                </div>

                <div class="security-feature-copy">

                    <strong>
                        Real Time Monitoring
                    </strong>

                    <span>
                        Track appointments, prescriptions and daily activities instantly.
                    </span>

                </div>

            </div>

        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <!-- Page JS -->
    <script src="{{ asset('js/admin-login.js') }}"></script>

</body>

</html>