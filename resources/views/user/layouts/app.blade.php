<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'MediLeaf Patient Portal')</title>

    <!-- Bootstrap 5.3.8 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Admin/User Shared CSS (same design system) -->
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">

    @stack('styles')

</head>

<body>

    <div class="ml-user-wrapper">

        @include('user.partials.sidebar')

        <main class="ml-user-main">

            @include('user.partials.header')

            <div class="ml-user-content">
                @yield('content')
            </div>

        </main>

    </div>

    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Thank You!',
                    text: '{{ session("success") }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#31a050'
                });
            });
        </script>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- User Dashboard JS (own file, ml-user-* selectors) -->
    <script src="{{ asset('js/user.js') }}"></script>

    @stack('scripts')

</body>

</html>
