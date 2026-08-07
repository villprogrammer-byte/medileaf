@extends('layouts.auth')

@section('title', 'Reset Password | MediLeaf')

@section('content')

    <x-auth-shell icon="bi-shield-lock-fill" subtitle="Choose a new password for your account." :back-route="route('login')"
        footer-text="Secure Password Reset" :bg-image="asset('img/login.webp')" :security-features="[
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
            Reset <span>Password</span>
        </x-slot:title>

        <form method="POST" action="{{ route('password.reset.update') }}" id="resetPasswordForm">
            @csrf

            <div class="form-group">

                <label for="password" class="form-label required">
                    New Password
                </label>

                <div class="input-wrap">

                    <i class="bi bi-lock input-icon"></i>

                    <input type="password" name="password" id="password"
                        class="admin-login-input @error('password') is-invalid @enderror" placeholder="Enter new password"
                        autocomplete="new-password" required>

                    <button type="button" class="password-toggle" data-target="password" aria-label="Show password">
                        <i class="bi bi-eye-slash"></i>
                    </button>

                </div>

                @error('password')
                    <small class="field-error">
                        {{ $message }}
                    </small>
                @enderror

            </div>

            <div class="form-group">

                <label for="password_confirmation" class="form-label required">
                    Confirm Password
                </label>

                <div class="input-wrap">

                    <i class="bi bi-lock input-icon"></i>

                    <input type="password" name="password_confirmation" id="password_confirmation" class="admin-login-input"
                        placeholder="Confirm new password" autocomplete="new-password" required>

                    <button type="button" class="password-toggle" data-target="password_confirmation"
                        aria-label="Show password">
                        <i class="bi bi-eye-slash"></i>
                    </button>

                </div>

            </div>

            <button type="submit" class="sign-in-button mt-3" id="resetPasswordBtn">
                <i class="bi bi-check-circle"></i>
                <span>Reset Password</span>
            </button>

        </form>

    </x-auth-shell>

@endsection

{{-- password-toggle.js loads once from layouts/auth.blade.php --}}