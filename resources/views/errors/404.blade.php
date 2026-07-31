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

    <body>

        <main class="ml-404-page">

            <div class="ml-404-container">

                {{-- LEFT CONTENT --}}
                <section class="ml-404-content">

                    <div class="ml-404-oops">
                        OoPS!
                    </div>

                    <h1 class="ml-404-number">
                        404
                    </h1>

                    <h2 class="ml-404-title">
                        Page <span>Not Found</span>
                    </h2>

                    <div class="ml-404-lines" aria-hidden="true">
                        <span></span>
                        <span></span>
                    </div>

                    <p class="ml-404-description">
                        Looks like you’ve wandered off<br>
                        the healthy path.<br>
                        Let’s get you back on track!
                        <i class="bi bi-leaf ml-leaf"></i>
                    </p>

                    <div class="ml-404-actions">

                        <a href="{{ url('/') }}" class="ml-404-home-btn">
                            <i class="bi bi-house-door-fill"></i>
                            Back to Home
                        </a>
                    </div>

                </section>

                {{-- RIGHT IMAGE --}}
                <div class="ml-404-visual">

                    <img src="{{ asset('img/404.webp') }}" alt="Leaf covered 404 illustration with a glowing pathway"
                        class="ml-404-image">
                </div>

            </div>

        </main>

    </body>

</html>