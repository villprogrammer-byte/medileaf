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
    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    @stack('styles')

</head>

<body class="pt-0">
    <section class="ml-login-page">

        <div class="ml-login-container">
            <div class="ml-login-left">

                <div class="ml-login-logo">
                    <img src="{{ asset('img/medileaf-logo.webp') }}" alt="Admin Dashboard">
                </div>

                <div class="ml-login-content">

                    <h1>
                        Welcome
                        <span>Admin!</span>
                    </h1>
                    <p>
                        Securely manage your pharmacy operations from one centralized dashboard.
                    </p>
                </div>

                <div class="ml-login-features">

                    <div class="ml-login-feature">
                        <div class="icon">
                            <i class="bi bi-bar-chart-line"></i>
                        </div>
                        <div>
                            <h4>Dashboard Analytics</h4>
                            <p>Monitor sales, orders, revenue, and business performance in real time.</p>
                        </div>

                    </div>
                    <div class="ml-login-feature">
                        <div class="icon">
                            <i class="bi bi-box"></i>
                        </div>
                        <div>
                            <h4>Product Management</h4>
                            <p>Add, update, organize, and manage your product inventory with ease.</p>
                        </div>

                    </div>

                    <div class="ml-login-feature">
                        <div class="icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div>
                            <h4>Order Management</h4>
                            <p>Track, process, and fulfill customer orders efficiently.</p>
                        </div>
                    </div>

                    <div class="ml-login-feature">
                        <div class="icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div>
                            <h4>Customer Management</h4>
                            <p>Access customer information, purchase history, and account details securely.</p>
                        </div>
                    </div>
                </div>
                <div class="ml-login-products">
                    <img src="{{ asset('img/admin-dashboard-bg.webp') }}" alt="Admin Dashboard">
                </div>

            </div>
            <!-- RIGHT SIDE -->

            <div class="ml-login-right">
                <div class="ml-login-card">
                    <div class="ml-user-icon">
                        <div class="circle">
                            <i class="bi bi-shield-check"></i>
                        </div>
                    </div>
                    <h2>Admin Login</h2>
                    <p>
                        Sign to access your admin dashboard.
                    </p>

                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf

                        <div class="ml-form-group">
                            <label>Email Address</label>
                            <div class="ml-input">
                                <i class="bi bi-envelope"></i>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="Enter your email address" required autofocus>
                            </div>

                            @error('email')
                                <small style="color:red">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="ml-form-group">
                            <label>Password</label>

                            <div class="ml-input">
                                <i class="bi bi-lock"></i>

                                <input id="password" type="password" name="password" placeholder="Enter your password"
                                    required>

                                <button type="button" class="toggle-password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>

                            @error('password')
                                <small style="color:red">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="ml-login-options">

                            <label>
                                <input type="checkbox" name="remember">

                                Remember Me
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif

                        </div>

                        <button type="submit" class="ml-login-btn">
                            Sign In to Dashboard
                            <i class="bi bi-arrow-right"></i>
                        </button>

                        <div class="ml-secure-access">
                            <span class="ml-line"></span>

                            <div class="ml-secure-text">
                                <i class="bi bi-shield-check"></i>
                                <span>Secure Admin Access</span>
                            </div>

                            <span class="ml-line"></span>
                        </div>

                    </form>
                </div>
                <div class="ml-login-footer">
                    MediLeaf Health.
                    All Rights Reserved.
                </div>

            </div>

        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const toggle = document.querySelector(".toggle-password");

            const password = document.getElementById("password");

            if (toggle) {

                toggle.addEventListener("click", function () {

                    if (password.type === "password") {

                        password.type = "text";

                        this.innerHTML = '<i class="bi bi-eye-slash"></i>';

                    } else {

                        password.type = "password";

                        this.innerHTML = '<i class="bi bi-eye"></i>';

                    }

                });

            }

        });
    </script>

</body>

</html>