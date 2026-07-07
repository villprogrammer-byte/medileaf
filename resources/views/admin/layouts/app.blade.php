<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'MediLeaf Admin')</title>

    <!-- Bootstrap 5.3.8 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @stack('styles')

</head>

<body>

    <div class="ml-admin-wrapper">

        @include('admin.partials.sidebar')

        <main class="ml-admin-main">

            @include('admin.partials.header')

            <div class="ml-admin-content">
                @yield('content')
            </div>

        </main>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Admin JS -->
    <script src="{{ asset('js/admin.js') }}"></script>

    @stack('scripts')

</body>

</html>