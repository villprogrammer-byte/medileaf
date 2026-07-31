<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Login | MediLeaf</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <main class="user-login-page">

        <div class="user-main-area">

            <!-- LEFT 60% IMAGE SECTION -->
            <section class="user-visual-panel">

                <i class="bi bi-leaf-fill leaf-decoration top"></i>
                <i class="bi bi-leaf-fill leaf-decoration bottom"></i>

            </section>

            <!-- RIGHT 40% LOGIN SECTION -->
            <section class="user-form-panel">

                <div class="login-card">

                    <!-- BACK TO HOME BUTTON -->
                    <a href="{{ route('home') }}" class="back-home-btn" aria-label="Back to home" title="Back to home">
                        <i class="bi bi-arrow-left"></i>
                    </a>

                    <div class="login-brand-icon">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="login-heading">

                        <h2>
                            Welcome <span>Back!</span>
                        </h2>

                        <p>
                            Sign in to continue to your user dashboard
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

                        <!-- EMAIL + PASSWORD LOGIN -->
                        <form id="loginForm" action="{{ route('login.otp.send') }}" method="POST" novalidate>

                            @csrf

                            <!-- EMAIL -->
                            <div class="form-group">

                                <label for="email" class="form-label required">
                                    Email Address
                                </label>

                                <div class="input-wrap">

                                    <i class="bi bi-envelope input-icon"></i>

                                    <input type="email" name="email" id="email"
                                        class="login-input @error('email') is-invalid @enderror"
                                        placeholder="Enter your email address" value="{{ old('email') }}"
                                        autocomplete="email" required autofocus>

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

                                    <input type="password" name="password" id="password"
                                        class="login-input @error('password') is-invalid @enderror"
                                        placeholder="Enter your password" autocomplete="current-password" required>

                                    <button type="button" class="password-toggle" id="passwordToggle"
                                        aria-label="Show password">

                                        <i class="bi bi-eye-slash" id="passwordToggleIcon"></i>

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

                                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>

                                    <span>Remember Me</span>

                                </label>

                                @if (Route::has('password.request'))

                                    <a href="{{ route('password.request') }}" class="forgot-link">
                                        Forgot Password?
                                    </a>

                                @endif

                            </div>

                            <div class="cf-turnstile my-3" data-sitekey="{{ config('services.turnstile.site_key') }}">
                            </div>

                            @error('cf-turnstile-response')
                                <div class="text-danger small mb-3">
                                    {{ $message }}
                                </div>
                            @enderror

                            <!-- LOGIN BUTTON -->
                            <button type="submit" class="sign-in-button" id="signInButton">

                                <i class="bi bi-box-arrow-in-right"></i>

                                <span>
                                    Sign In &amp; Send OTP
                                </span>

                            </button>

                        </form>

                    </div>
                    <!-- END SCROLLABLE AREA -->

                    <!-- FIXED BOTTOM (does not scroll) -->
                    <div class="login-divider">
                        <span>or continue with</span>
                    </div>

                    <!-- SOCIAL LOGIN -->
                    <div class="social-login-list">

                        <!-- GOOGLE LOGIN -->

                        {{-- <a href="{{ route('social.redirect', ['provider' => 'google']) }}"
                            class="social-button google" aria-label="Continue with Google" title="Continue with Google">

                            <img src="{{ asset('google.svg') }}" alt="Google">

                        </a> --}}

                        <!-- SECURE ICON -->
                        <span class="social-button secure" aria-label="Secure login" title="Secure login">

                            <i class="bi bi-shield-check"></i>

                        </span>

                        <!-- APPLE LOGIN -->
                        {{-- <a href="{{ route('social.redirect', ['provider' => 'apple']) }}"
                            class="social-button apple" aria-label="Continue with Apple" title="Continue with Apple">

                            <i class="bi bi-apple"></i>

                        </a> --}}

                    </div>

                    <!-- REGISTER  -->
                    <div class="register-prompt">
                        <span>Don't have an account?</span>
                        <a href="{{ route('register') }}">Create Account</a>
                    </div>

                    <div class="login-card-footer">

                        <div class="footer-security">

                            <i class="bi bi-lock"></i>

                            <span>
                                Secure User Access
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
                    <i class="bi bi-lock"></i>
                </div>

                <div class="security-feature-copy">

                    <strong>
                        Secure &amp; Encrypted
                    </strong>

                    <span>
                        Your data is always protected with advanced security.
                    </span>

                </div>

            </div>

            <div class="security-feature">

                <div class="security-feature-icon">
                    <i class="bi bi-cloud-arrow-up"></i>
                </div>

                <div class="security-feature-copy">

                    <strong>
                        Daily Backup
                    </strong>

                    <span>
                        Automatic backup ensures your data is never lost.
                    </span>

                </div>

            </div>

            <div class="security-feature">

                <div class="security-feature-icon">
                    <i class="bi bi-people"></i>
                </div>

                <div class="security-feature-copy">

                    <strong>
                        Role Based Access
                    </strong>

                    <span>
                        Secure access management for you and your team.
                    </span>

                </div>

            </div>

            <div class="security-feature">

                <div class="security-feature-icon">
                    <i class="bi bi-headset"></i>
                </div>

                <div class="security-feature-copy">

                    <strong>
                        24/7 Support
                    </strong>

                    <span>
                        We are here anytime you need help.
                    </span>

                </div>

            </div>

        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <!-- Page JS -->
    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>