@extends('layouts.app')

@section('title', 'About MediLeaf')

@section('content')
    <section class="ml-login-page">

        <div class="ml-login-container">
            <div class="ml-login-left">

                <div class="ml-login-logo">
                    <img src="img/medileaf-logo.webp" alt="">
                </div>

                <div class="ml-login-content">

                    <h1>
                        Welcome Back!<br>
                        Good to See
                        <span>You Again</span>
                    </h1>
                    <p>
                        Login to your account and explore natural and quality
                        products for a healthier lifestyle with Medileaf.
                    </p>
                </div>

                <div class="ml-login-features">

                    <div class="ml-login-feature">
                        <div class="icon">
                            <i class="bi bi-flower1"></i>
                        </div>
                        <div>
                            <h4>100% Natural Products</h4>
                            <p>Carefully selected for your wellbeing.</p>
                        </div>

                    </div>
                    <div class="ml-login-feature">
                        <div class="icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <h4>Secure Shopping</h4>
                            <p>Your privacy and security always come first.</p>
                        </div>

                    </div>

                    <div class="ml-login-feature">
                        <div class="icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div>
                            <h4>Fast Delivery</h4>
                            <p>Quick and reliable pharmacy dispatch.</p>
                        </div>
                    </div>

                    <div class="ml-login-feature">
                        <div class="icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div>
                            <h4>24/7 Support</h4>
                            <p>We're here whenever you need assistance.</p>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="ml-login-products">
                    <img src="{{ asset('img/login/products.webp') }}" alt="">
                </div>

            </div>
            <!-- RIGHT SIDE -->

            <div class="ml-login-right">
                <div class="ml-login-card">
                    <div class="ml-user-icon">
                        <div class="circle">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <h2>User Login</h2>
                    <p>
                        Enter your credentials to access your account.
                    </p>

                    <form>
                        <div class="ml-form-group">
                            <label>Email Address</label>
                            <div class="ml-input">
                                <i class="bi bi-envelope"></i>
                                <input type="email" placeholder="Enter your email address">
                            </div>

                        </div>


                        <div class="ml-form-group">
                            <label>Password</label>
                            <div class="ml-input">
                                <i class="bi bi-lock"></i>
                                <input id="password" type="password" placeholder="Enter your password">
                                <button type="button" class="toggle-password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="ml-login-options">
                            <label>
                                <input type="checkbox">
                                Remember Me
                            </label>
                            <a href="#">
                                Forgot Password?
                            </a>
                        </div>


                        <button class="ml-login-btn">
                            Login to Your Account

                            <i class="bi bi-arrow-right"></i>
                        </button>


                        <div class="ml-divider">
                            <span>OR</span>
                        </div>

                        <div class="ml-social-login">
                            <button type="button">
                                <i class="bi bi-google"></i>
                                Google
                            </button>

                            <button type="button">
                                <i class="bi bi-facebook"></i>
                                Facebook
                            </button>
                            <button type="button">
                                <i class="bi bi-apple"></i>
                                Apple
                            </button>

                        </div>
                        <div class="ml-register">
                            Don't have an account?
                            <a href="#">
                                Register Now
                            </a>
                        </div>
                    </form>
                </div>


                <div class="ml-bottom-features">

                    <div>
                        <i class="bi bi-truck"></i>
                        <span>
                            <strong>Free Shipping</strong>
                            On Orders Above $99
                        </span>
                    </div>

                    <div>

                        <i class="bi bi-credit-card"></i>
                        <span>
                            <strong>Secure Payment</strong>
                            Safe Checkout
                        </span>
                    </div>

                    <div>
                        <i class="bi bi-arrow-repeat"></i>
                        <span>
                            <strong>Easy Returns</strong>
                            Hassle Free
                        </span>
                    </div>

                    <div>
                        <i class="bi bi-patch-check"></i>
                        <span>
                            <strong>Premium Quality</strong>
                            Genuine Products
                        </span>
                    </div>
                </div>


                <div class="ml-login-footer">
                    © {{ date('Y') }} MediLeaf Health.
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
@endsection