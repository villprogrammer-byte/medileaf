<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2F8E45">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="mobile-web-app-capable" content="yes">

    <title>@yield('title', 'MediLeaf')</title>
    <meta name="description" content="@yield('meta_description', 'MediLeaf Australia')">
    <meta name="robots" content="@yield('robots', 'index,follow')">
    <meta name="google-site-verification" content="google-site-verification=jtnpuIIWLs_FzMtX4zNqXIOSXzOjfAWLdQ6jDysQ6_c">

    @hasSection('canonical_url')
        <link rel="canonical" href="@yield('canonical_url')">
    @else
        <link rel="canonical" href="{{ url()->current() }}">
    @endif

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="MediLeaf">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title', 'MediLeaf')))">
    <meta property="og:description" content="@yield('og_description', trim($__env->yieldContent('meta_description', 'MediLeaf Australia')))">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">

    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif

    <meta name="twitter:card" content="@hasSection('og_image')summary_large_image @else summary @endif">
    <meta name="twitter:title" content="@yield('og_title', trim($__env->yieldContent('title', 'MediLeaf')))">
    <meta name="twitter:description" content="@yield('og_description', trim($__env->yieldContent('meta_description', 'MediLeaf Australia')))">

    @hasSection('og_image')
        <meta name="twitter:image" content="@yield('og_image')">
    @endif

    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/account-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/page-loader.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-choice-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/prescription.css') }}">
    <link rel="stylesheet" href="{{ asset('css/store.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">

    @stack('styles')

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-K44X811DVR"></script>

    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-K44X811DVR');
 </script>
 
</head>

<body>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.cart-drawer')
    @include('partials.user-choice-popup')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

    <script src="{{ asset('js/page-loader.js') }}"></script>
    <script src="{{ asset('js/user-choice-popup.js') }}"></script>
    <script src="{{ asset('js/account-menu.js') }}"></script>
    <script src="{{ asset('js/store.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>

    @stack('scripts')

</body>

</html>