@extends('layouts.auth')

@section('title', 'Email Verified | MediLeaf')

@section('content')

    <x-auth-shell icon="bi-patch-check-fill"
        subtitle="Your account is ready. You'll be redirected to book your appointment shortly." :back-route="route('home')"
        footer-text="Secure User Access" :bg-image="asset('img/login.webp')" :security-features="[
                [
                    'icon' => 'bi-lock',
                    'title' => 'Secure & Encrypted',
                    'text' => 'Your data is always protected with advanced security.'
                ],
                [
                    'icon' => 'bi-cloud-arrow-up',
                    'title' => 'Daily Backup',
                    'text' => 'Automatic backup ensures your data is never lost.'
                ],
                [
                    'icon' => 'bi-people',
                    'title' => 'Role Based Access',
                    'text' => 'Secure access management for you and your team.'
                ],
                [
                    'icon' => 'bi-headset',
                    'title' => '24/7 Support',
                    'text' => 'We are here anytime you need help.'
                ],
            ]">

        <x-slot:title>
            You're <span>Verified!</span>
        </x-slot:title>

        {{-- Booking Information --}}
        <div class="alert alert-warning text-center">

            For a smooth and secure booking experience, please use the
            <strong>same phone number</strong> and
            <strong>email address</strong> that you registered with when
            scheduling your appointment.

        </div>

        {{-- Continue to Halaxy --}}
        <a href="https://www.halaxy.com/book/appointment/medileaf-health/location/1332127"
            class="sign-in-button mt-3 text-decoration-none" id="redirect-btn">
            <i class="bi bi-calendar-check"></i>
            <span>Continue to Book Appointment</span>
        </a>

        {{-- Countdown --}}
        <p class="text-center mt-3" style="font-size:13px;color:#888;">
            Redirecting automatically in
            <span id="countdown">5</span> seconds...
        </p>

        <x-slot:afterForm>

            <div class="admin-login-divider">
                <span>Email Verified Successfully</span>
            </div>

        </x-slot:afterForm>

    </x-auth-shell>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let seconds = 5;

            const countdownEl = document.getElementById('countdown');

            const redirectUrl =
                'https://www.halaxy.com/book/appointment/medileaf-health/location/1332127';

            if (!countdownEl) {
                return;
            }

            const timer = setInterval(function () {

                seconds--;

                countdownEl.textContent = seconds;

                if (seconds <= 0) {

                    clearInterval(timer);

                    window.location.href = redirectUrl;

                }

            }, 1000);

        });
    </script>

@endpush