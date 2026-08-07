@extends('layouts.auth')

@section('title', 'Reset Password | MediLeaf Admin')

@section('content')

    <x-auth-shell icon="bi-key-fill" subtitle="Choose a strong new password for your admin account."
        :back-route="route('admin.login')" footer-text="Your account recovery is protected with OTP verification.">
        <x-slot:title>Set New <span>Password</span></x-slot:title>

        <form method="POST" action="{{ route('admin.password.reset.update') }}">
            @csrf

            <div class="form-group">
                <label for="password" class="form-label required">New Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" name="password" id="password"
                        class="admin-login-input @error('password') is-invalid @enderror" placeholder="Enter new password"
                        required>
                    <button type="button" class="password-toggle toggle-password" aria-label="Show password">
                        <i class="bi bi-eye"></i>
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
                    <input type="password" name="password_confirmation" id="password_confirmation" class="admin-login-input"
                        placeholder="Confirm new password" required>
                    <button type="button" class="password-toggle toggle-password" aria-label="Show password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="sign-in-button">
                <i class="bi bi-check-circle"></i>
                <span>Reset Password</span>
            </button>
        </form>

    </x-auth-shell>

@endsection

@push('scripts')

    <script src="{{ asset('js/admin-login.js') }}"></script>

@endpush