@extends('layouts.auth')

@section('title', 'Verify Email | MediLeaf')

@section('content')

    <x-auth-shell icon="bi-envelope-check-fill" subtitle="Please verify your email address before continuing."
        :back-route="route('home')" footer-text="Secure Email Verification" :bg-image="asset('img/login.webp')"
        :security-features="[
                [
                    'icon' => 'bi-lock',
                    'title' => 'Secure & Encrypted',
                    'text' => 'Your data is always protected with advanced security.'
                ],
                [
                    'icon' => 'bi-envelope-check',
                    'title' => 'Email Verification',
                    'text' => 'Verification helps keep your MediLeaf account protected.'
                ],
                [
                    'icon' => 'bi-person-check',
                    'title' => 'Verified Account',
                    'text' => 'Only verified users can continue to protected account areas.'
                ],
                [
                    'icon' => 'bi-headset',
                    'title' => '24/7 Support',
                    'text' => 'We are here anytime you need help.'
                ],
            ]">

        <x-slot:title>
            Verify Your <span>Email</span>
        </x-slot:title>

        <div class="otp-note">
            We sent a verification link to the email address you provided during registration.
            Please open the email and click the verification link to activate your account.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success auth-alert text-center">
                <i class="bi bi-check-circle-fill me-1"></i>
                A new verification link has been sent to your registered email address.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" id="resendVerificationForm">
            @csrf

            <button type="submit" class="sign-in-button" id="resendVerificationBtn">
                <i class="bi bi-envelope-arrow-up"></i>
                <span>Resend Verification Email</span>
            </button>
        </form>

        <x-slot:afterForm>

            <div class="admin-login-divider">
                <span>Account Options</span>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf

                <button type="submit" class="resend-btn">
                    <i class="bi bi-box-arrow-left me-1"></i>
                    Log Out
                </button>
            </form>

        </x-slot:afterForm>

    </x-auth-shell>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('resendVerificationForm');
            const button = document.getElementById('resendVerificationBtn');

            if (!form || !button) {
                return;
            }

            form.addEventListener('submit', function () {

                button.disabled = true;

                button.innerHTML =
                    '<i class="bi bi-hourglass-split"></i>' +
                    '<span>Sending Verification Email...</span>';

            });

        });
    </script>

@endpush