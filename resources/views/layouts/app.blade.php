<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'MediLeaf')</title>

    <meta name="description" content="@yield('meta_description', 'MediLeaf Australia')">

    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/account-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/page-loader.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-choice-popup.css') }}">

    @stack('styles')

</head>

<body>
    @include('partials.page-loader')

    @include('partials.header')

    <main>

        @yield('content')

    </main>

    @include('partials.footer')

    @include('partials.cart-drawer')

    @include('partials.user-choice-popup')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/page-loader.js') }}"></script>
    <script src="{{ asset('js/user-choice-popup.js') }}"></script>
    <script src="{{ asset('js/account-menu.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    @stack('scripts')

</body>

</html>