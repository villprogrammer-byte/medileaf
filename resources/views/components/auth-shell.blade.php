@props([
    'icon' => 'bi-shield-check',
    'subtitle' => null,
    'backRoute' => null,
    'footerText' => 'Secure Admin Access',
    'bgImage' => null,
    'securityFeatures' => null,
])

<div class="admin-main-area">

    <section class="admin-visual-panel"
        @if ($bgImage) style="background-image: url('{{ $bgImage }}')" @endif>

        <i class="bi bi-leaf-fill leaf-decoration top"></i>
        <i class="bi bi-leaf-fill leaf-decoration bottom"></i>

    </section>

    <section class="admin-form-panel">

        <div class="admin-login-card">

            {{-- COMMON BACK BUTTON --}}
            @if ($backRoute)
                <a href="{{ $backRoute }}"
                    class="back-home-btn"
                    aria-label="Back"
                    title="Back">

                    <i class="bi bi-arrow-left"></i>

                </a>
            @endif


            {{-- COMMON MOBILE / TABLET LOGO --}}
            <div class="auth-mobile-logo">
                <img
                    src="{{ asset('img/medileaf-logo.webp') }}"
                    alt="MediLeaf">
            </div>


            <div class="admin-login-brand-icon">
                <i class="bi {{ $icon }}"></i>
            </div>

            <div class="admin-login-heading">

                <h2>{{ $title }}</h2>

                @if ($subtitle)
                    <p>{{ $subtitle }}</p>
                @endif

            </div>


            @if (session('status'))
                <div class="alert alert-success auth-alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success auth-alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger auth-alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger auth-alert">
                    {{ $errors->first() }}
                </div>
            @endif


            <div class="admin-login-form-scroll">
                {{ $slot }}
            </div>


            @isset($afterForm)
                {{ $afterForm }}
            @endisset


            <div class="admin-login-card-footer">

                <div class="footer-security">
                    <i class="bi bi-lock"></i>
                    <span>{{ $footerText }}</span>
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

@include('partials.security-strip', [
    'features' => $securityFeatures
])