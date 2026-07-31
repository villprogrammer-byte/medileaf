@extends('layouts.auth')

@section('title', 'Email Verified | MediLeaf')

@section('content')

    <div class="user-login-page">
        <div class="user-main-area">

            <div class="user-visual-panel">
                <i class="bi bi-leaf-fill leaf-decoration top"></i>
                <i class="bi bi-leaf-fill leaf-decoration bottom"></i>
            </div>

            <div class="user-form-panel">

                <div class="secure-access-label">
                    <i class="bi bi-check-circle"></i>
                    Email Verified
                </div>

                <div class="login-card">

                    <div class="login-brand-icon">
                        <i class="bi bi-patch-check-fill" style="color:#16a34a;"></i>
                    </div>

                    <div class="login-heading">
                        <h2>You're <span>Verified!</span></h2>
                        <p>Your account is ready. You'll be redirected to book your appointment shortly.</p>
                    </div>

                    <div class="alert alert-warning text-center">
                        For a smooth and secure booking experience, please use the <strong>same phone number</strong> and
                        <strong>email</strong> address that
                        you registered with when scheduling your appointment.
                    </div>

                    <a href="https://www.halaxy.com/book/appointment/medileaf-health/location/1332127"
                        class="sign-in-button mt-3 text-decoration-none" id="redirect-btn">
                        <i class="bi bi-calendar-check"></i>
                        <span>Continue to Book Appointment</span>
                    </a>

                    <p class="text-center mt-3" style="font-size:13px;color:#888;">
                        Redirecting automatically in <span id="countdown">5</span> seconds...
                    </p>

                </div>

            </div>

        </div>
    </div>

    <!-- <script>
                                        let seconds = 5;
                                        const countdownEl = document.getElementById('countdown');
                                        const redirectUrl = 'https://www.halaxy.com/book/appointment/medileaf-health/location/1332127';

                                        const timer = setInterval(() => {
                                            seconds--;
                                            countdownEl.textContent = seconds;
                                            if (seconds <= 0) {
                                                clearInterval(timer);
                                                window.location.href = redirectUrl;
                                            }
                                        }, 1000);
                                    </script> -->

@endsection