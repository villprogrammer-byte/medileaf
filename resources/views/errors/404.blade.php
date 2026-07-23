<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- 404 CSS -->
    <link rel="stylesheet" href="{{ asset('css/error-404.css') }}">
</head>

<body>

    <div class="container">

        <img src="{{ asset('img/404.webp') }}" alt="404 Page" class="desktop-404">
        <img src="{{ asset('img/mobile-404.webp') }}" alt="404 Page" class="mobile-404">


        <a href="{{ url('/') }}" class="ml-glass-btn primary">
            <i class="bi bi-arrow-left"></i>Back to Home
        </a>

    </div>

</body>

</html>