<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>User register | MediLeaf</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>

    <main class="user-register-page">

        <div class="user-main-area">

            <!-- LEFT 60% IMAGE SECTION -->
            <section class="user-visual-panel">
                <i class="bi bi-leaf-fill leaf-decoration top"></i>
                <i class="bi bi-leaf-fill leaf-decoration bottom"></i>
            </section>

            <!-- RIGHT 40% register SECTION -->
            <section class="user-form-panel">

                <!-- <div class="secure-access-label mb-5">
                    <i class="bi bi-shield-check"></i>
                    <span>Secure Patient Registration</span>
                </div> -->

                <div class="register-card">
                    
               <!-- BACK TO HOME BUTTON -->
                 <a href="{{ route('home') }}" class="back-home-btn" aria-label="Back to home" title="Back to home">
                  <i class="bi bi-arrow-left"></i>
                     </a>
                   
                    <!-- FIXED TOP (does not scroll) -->
                    <div class="register-brand-icon">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="register-heading">
                        <h2>
                            Join <span>MediLeaf</span> Today
                        </h2>

                        <p>
                            Create your secure patient account to book consultations and manage your healthcare online.
                        </p>
                    </div>

                    <!-- SCROLLABLE AREA (only this scrolls) -->
                    <div class="register-form-scroll">

                        <form id="registerForm" action="{{ route('register') }}" method="POST" novalidate>
                            @csrf

                            <!-- Name -->
                            <div class="form-group">
                                <label class="form-label required">Full Name</label>

                                <div class="input-wrap">
                                    <i class="bi bi-person input-icon"></i>

                                    <input type="text" name="name" class="register-input" placeholder="Enter your full name"
                                        value="{{ old('name') }}" required>
                                </div>
                                @error('name')
                                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="form-label required">Email Address</label>

                                <div class="input-wrap">
                                    <i class="bi bi-envelope input-icon"></i>

                                    <input type="email" name="email" id="email" class="register-input"
                                        placeholder="Enter your email address" value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Mobile -->
                            <div class="form-group">
                                <label class="form-label required">Mobile Number</label>

                                <div class="input-wrap">
                                    <i class="bi bi-phone input-icon"></i>

                                    <input type="tel" name="mobile" class="register-input" placeholder="04XX XXX XXX"
                                        value="{{ old('mobile') }}" required>
                                </div>
                                @error('mobile')
                                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Password Row -->
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="form-label required">Password</label>

                                        <div class="input-wrap">
                                            <i class="bi bi-lock input-icon"></i>
                                            <input type="password" name="password" class="register-input" id="password"
                                                required>

                                            <button type="button" class="password-toggle">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="form-label required">Confirm Password</label>

                                        <div class="input-wrap">
                                            <i class="bi bi-lock input-icon"></i>
                                            <input type="password" name="password_confirmation" class="register-input"
                                                id="confirm_password" required>

                                            <button type="button" class="password-toggle">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- DOB -->
                            <div class="form-group mt-3">
                                <label class="form-label required">Date of Birth</label>

                                <div class="input-wrap">
                                    <i class="bi bi-calendar-event input-icon"></i>
                                    <input type="date" id="dob" name="dob" class="register-input" value="{{ old('dob') }}"
                                        required>
                                </div>

                                <small class="text-muted mt-2 d-block">
                                    You must be 18 years or older to register.
                                </small>
                                @error('dob')
                                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Consent -->
                            <div class="mt-3">

                                <label class="remember-wrap mb-2">
                                    <input type="checkbox" name="age_confirm" required>
                                    <span>I confirm I am 18 years of age or older.</span>
                                </label>

                                <label class="remember-wrap mb-2">
                                    <input type="checkbox" name="terms" required>
                                    <span>
                                        I agree to the
                                        <a href="#">Terms &amp; Conditions</a>
                                        and
                                        <a href="#">Privacy Policy</a>.
                                    </span>
                                </label>

                                <label class="remember-wrap">
                                    <input type="checkbox" name="health_consent" required>
                                    <span>
                                        I consent to MediLeaf securely processing my health information
                                        for consultation and treatment purposes.
                                    </span>
                                </label>

                            </div>

                            <div class="cf-turnstile my-3" data-sitekey="{{ config('services.turnstile.site_key') }}">
                            </div>

                            @error('cf-turnstile-response')
                                <div class="text-danger small mb-3">
                                    {{ $message }}
                                </div>
                            @enderror

                            <button type="submit" class="sign-in-button mt-4">
                                <i class="bi bi-person-plus"></i>
                                <span>Create Account</span>
                            </button>

                        </form>

                    </div>
                    <!-- END SCROLLABLE AREA -->

                    <!-- FIXED BOTTOM (does not scroll) -->
                    <div class="register-card-footer">

                        <div class="footer-security">
                            <i class="bi bi-lock"></i>
                            <span>Secure user Access</span>
                        </div>

                        <p class="copyright">
                            © {{ date('Y') }} <strong>Medileaf.</strong>
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
                    <strong>Secure &amp; Encrypted</strong>
                    <span>Your data is always protected with advanced security.</span>
                </div>
            </div>

            <div class="security-feature">
                <div class="security-feature-icon">
                    <i class="bi bi-cloud-arrow-up"></i>
                </div>
                <div class="security-feature-copy">
                    <strong>Daily Backup</strong>
                    <span>Automatic backup ensures your data is never lost.</span>
                </div>
            </div>

            <div class="security-feature">
                <div class="security-feature-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="security-feature-copy">
                    <strong>Role Based Access</strong>
                    <span>Secure access management for you and your team.</span>
                </div>
            </div>

            <div class="security-feature">
                <div class="security-feature-icon">
                    <i class="bi bi-headset"></i>
                </div>
                <div class="security-feature-copy">
                    <strong>24/7 Support</strong>
                    <span>We are here anytime you need help.</span>
                </div>
            </div>

        </section>

    </main>

    <!-- Email Verification Modal -->
    <div class="verify-modal-overlay" id="verifyModalOverlay">
        <div class="verify-modal" role="dialog" aria-modal="true" aria-labelledby="verifyModalTitle">

            <button type="button" class="verify-modal-close" id="verifyModalClose" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="verify-modal-icon">
                <i class="bi bi-envelope-check"></i>
            </div>

            <h3 class="verify-modal-title" id="verifyModalTitle">Verify your email</h3>

            <p class="verify-modal-text">
                We've sent a verification link to <strong id="verifyModalEmail">your email address</strong>.
                Open your inbox and click the link to activate your MediLeaf account.
            </p>

            <p class="verify-modal-subtext">
                Can't find it? Check your spam folder, or request a new link.
            </p>

            <div class="verify-modal-actions">
                <button type="button" class="verify-modal-resend" id="verifyModalResend">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Resend Email</span>
                </button>

                <button type="button" class="verify-modal-continue" id="verifyModalContinue">
                    <span>Continue</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <!-- Page JS -->
    <script src="{{ asset('js/register.js') }}"></script>
</body>

</html>