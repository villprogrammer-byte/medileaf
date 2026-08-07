@extends('layouts.auth')

@section('title', 'Confirm Password | MediLeaf')

@section('content')

    <x-auth-shell icon="bi-shield-lock-fill" subtitle="For your security, please confirm your password before continuing."
        :back-route="route('login')" footer-text="Secure User Access" :bg-image="asset('img/login.webp')"
        :security-features="[
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
            Confirm <span>Password</span>
        </x-slot:title>


        <form method="POST" action="{{ route('password.confirm') }}" id="confirmPasswordForm">
            @csrf

            {{-- Password --}}
            <div class="form-group">

                <label for="password" class="form-label required">
                    Password
                </label>

                <div class="input-wrap">

                    <i class="bi bi-lock input-icon"></i>

                    <input id="password" type="password" name="password"
                        class="admin-login-input @error('password') is-invalid @enderror" placeholder="Enter your password"
                        required autofocus autocomplete="current-password">

                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password">
                        <i class="bi bi-eye"></i>
                    </button>

                </div>

                @error('password')
                    <small class="field-error">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- Confirm Button --}}
            <button type="submit" class="sign-in-button mt-3" id="confirmPasswordBtn">
                <i class="bi bi-shield-check"></i>
                <span>Confirm Password</span>
            </button>

        </form>


        <x-slot:afterForm>

            <div class="admin-login-divider">
                <span>Secure Verification</span>
            </div>

        </x-slot:afterForm>

    </x-auth-shell>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');

            const form = document.getElementById('confirmPasswordForm');
            const submitButton = document.getElementById('confirmPasswordBtn');


            /* Password Show / Hide */
            if (passwordInput && togglePassword) {

                togglePassword.addEventListener('click', function () {

                    const isPassword = passwordInput.type === 'password';

                    passwordInput.type = isPassword
                        ? 'text'
                        : 'password';

                    const icon = this.querySelector('i');

                    if (icon) {
                        icon.className = isPassword
                            ? 'bi bi-eye-slash'
                            : 'bi bi-eye';
                    }

                    this.setAttribute(
                        'aria-label',
                        isPassword ? 'Hide password' : 'Show password'
                    );

                });

            }


            /* Prevent Double Submit */
            if (form && submitButton) {

                form.addEventListener('submit', function () {

                    submitButton.disabled = true;

                    submitButton.innerHTML =
                        '<i class="bi bi-hourglass-split"></i>' +
                        '<span>Confirming...</span>';

                });

            }

        });
    </script>

@endpush