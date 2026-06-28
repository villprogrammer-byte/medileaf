@extends('layouts.app')

@section('title', 'About MediLeaf')

@section('content')

    <section class="ml-checkout-v2">
        <div class="container">

            <div class="ml-checkout-v2-head">
                <span>Secure Checkout</span>
                <h1>Complete Your Order</h1>
                <p>Review your details, choose a payment option, and place your order safely.</p>

                <!-- Back Button -->
                <div class="ml-checkout-back-wrap">
                    <button type="button" class="ml-checkout-back-btn" onclick="history.back()">

                        <i class="bi bi-arrow-left"></i>
                        Back to Product

                    </button>
                </div>

            </div>


            <div class="row g-4">

                <div class="col-lg-7">
                    <div class="ml-checkout-v2-card">
                        <h2>Billing Details</h2>

                        <form class="ml-checkout-v2-form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" placeholder="First name">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" placeholder="Last name">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" placeholder="Email address">
                                </div>
                                <div class="col-md-6">
                                    <input type="tel" placeholder="Phone number">
                                </div>
                                <div class="col-12">
                                    <input type="text" placeholder="Street address">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" placeholder="Suburb / City">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" placeholder="Postcode">
                                </div>
                                <div class="col-12">
                                    <select>
                                        <option>Select delivery option</option>
                                        <option>Pickup from Pharmacy</option>
                                        <option>Home Delivery</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <textarea placeholder="Order notes optional"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="ml-checkout-v2-card mt-4">
                        <h2>Payment Options</h2>

                        <div class="ml-payment-v2-list">

                            <label class="ml-payment-v2-option active">
                                <input type="radio" name="payment" checked>
                                <div class="ml-payment-v2-icon">
                                    <i class="bi bi-credit-card"></i>
                                </div>
                                <div>
                                    <h3>Credit / Debit Card</h3>
                                    <p>Pay securely using Visa, Mastercard, Apple Pay or Google Pay.</p>
                                </div>
                                <span>Recommended</span>
                            </label>

                            <label class="ml-payment-v2-option">
                                <input type="radio" name="payment">
                                <div class="ml-payment-v2-icon">
                                    <i class="bi bi-shop"></i>
                                </div>
                                <div>
                                    <h3>Pay on Pickup</h3>
                                    <p>Submit your order request and pay directly at pharmacy pickup.</p>
                                </div>
                            </label>

                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="ml-checkout-v2-summary">
                        <h2>Your Order</h2>

                        <div id="checkoutItems"></div>

                        <div class="ml-order-v2-line">
                            <span>Subtotal</span>
                            <strong id="checkoutSubtotal">A$0.00</strong>
                        </div>

                        <div class="ml-order-v2-line">
                            <span>Delivery</span>
                            <strong>Calculated later</strong>
                        </div>

                        <div class="ml-order-v2-total">
                            <span>Total</span>
                            <strong id="checkoutTotal">A$0.00</strong>
                        </div>

                        <button type="button" class="ml-checkout-v2-btn">
                            Continue To Payment
                        </button>

                        <p class="ml-checkout-v2-note">
                            Your payment details are processed securely. Medileaf does not store card information.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const cart = JSON.parse(localStorage.getItem("medileafCart")) || [];

            const checkoutItems = document.getElementById("checkoutItems");
            const subtotalEl = document.getElementById("checkoutSubtotal");
            const totalEl = document.getElementById("checkoutTotal");

            let total = 0;

            checkoutItems.innerHTML = "";

            if (cart.length === 0) {
                checkoutItems.innerHTML = `
                        <p style="padding:20px 0;">
                            Your cart is empty.
                        </p>
                    `;
                return;
            }

            cart.forEach(item => {

                total += item.price * item.qty;

                checkoutItems.innerHTML += `
                        <div class="ml-order-v2-item">
                            <img src="${item.image}" alt="${item.name}">
                            <div>
                                <h3>${item.name}</h3>
                                <p>Qty: ${item.qty}</p>
                            </div>
                            <strong>A$${(item.price * item.qty).toFixed(2)}</strong>
                        </div>
                    `;
            });

            subtotalEl.textContent = "A$" + total.toFixed(2);
            totalEl.textContent = "A$" + total.toFixed(2);
        });
    </script>

    <script>
        document.querySelectorAll(".ml-payment-v2-option").forEach(option => {
            option.addEventListener("click", function () {
                document.querySelectorAll(".ml-payment-v2-option").forEach(item => {
                    item.classList.remove("active");
                });

                this.classList.add("active");
                this.querySelector("input").checked = true;
            });
        });
    </script>
@endsection