@extends('layouts.app')

@section('title', 'About MediLeaf')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <!-- PRODUCT VIEW PAGE -->
    <section class="ml-product-view">
        <div class="container">

            <div class="ml-product-breadcrumb">
                <a href="{{ url('/') }}">Home</a>

                <span>/</span>

                <a href="{{ route('store') }}">Store</a>

                <span>/</span>

                <strong>{{ $product->name }}</strong>
            </div>

            <!-- Back Button -->
            <div class="ml-checkout-back-wrap mb-4">
                <button type="button" class="ml-checkout-back-btn" onclick="history.back()">

                    <i class="bi bi-arrow-left"></i>
                    Back to Store

                </button>
            </div>

            <div class="row g-5 align-items-start">

                <div class="col-lg-6">
                    <div class="ml-product-gallery">

                        <div class="ml-product-main-image" id="mlProductMainBox">
                            <span class="ml-product-badge">New</span>
                            <img id="mlProductMainImg" src="{{ asset('storage/' . $product->featured_image) }}"
                                alt="{{ $product->image_alt ?: $product->name }}">
                        </div>

                        <div class="ml-product-media-options">

                            <div class="ml-product-thumbs">

                                <button type="button" class="active" data-color="#31a050" data-bg="rgba(49,160,80,0.10)"
                                    data-image="{{ asset('storage/' . $product->featured_image) }}">

                                    <img src="{{ asset('storage/' . $product->featured_image) }}"
                                        alt="{{ $product->image_alt ?: $product->name }}">

                                </button>

                                <div class="ml-product-color-select">

                                    <label class="ml-color-label">
                                        <span class="ml-color-dot" id="currentColorDot" style="background:#31a050">
                                        </span>

                                        Colour
                                    </label>

                                    <div class="ml-custom-select" id="mlCustomColorSelect">

                                        <div class="ml-custom-select-trigger">

                                            <span id="mlSelectedColor">
                                                {{ $product->color_name ?? 'Default' }}
                                            </span>

                                            <i class="bi bi-chevron-down"></i>

                                        </div>

                                        <div class="ml-custom-options">

                                            <div class="ml-custom-option" data-index="0">

                                                <span class="color-circle" style="background:#31a050">
                                                </span>

                                                {{ $product->color_name ?? 'Default' }}

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ml-product-info">

                        <span class="ml-product-category">
                            {{ $product->category }}
                        </span>

                        <h1>{{ $product->name }}</h1>

                        <div class="ml-product-rating">
                            <div>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <span>4.8 rating</span>
                        </div>

                        <p class="ml-product-price">

                            @if($product->sale_price)

                                <span class="text-decoration-line-through text-muted">
                                    A${{ number_format($product->regular_price, 2) }}
                                </span>

                                <strong class="text-success ms-2">
                                    A${{ number_format($product->sale_price, 2) }}
                                </strong>

                            @else

                                <strong>
                                    A${{ number_format($product->regular_price, 2) }}
                                </strong>

                            @endif

                        </p>

                        <div class="ml-product-short">

                            <p>
                                {{ Str::words($product->short_description ?: 'No short description available for this product.', 30, '...') }}

                                <a href="javascript:void(0)" class="ml-product-desc-link" id="scrollToDescription">
                                    See Full Description
                                    <i class="bi bi-arrow-down"></i>
                                </a>
                            </p>

                        </div>

                        <div class="ml-product-purchase-box">

                            <div class="ml-product-qty">
                                <button type="button" id="qtyMinus">−</button>
                                <input type="number" id="productQty" value="1" min="1">
                                <button type="button" id="qtyPlus">+</button>
                            </div>

                            <button class="ml-product-add-btn" type="button" id="productAddToBag">
                                Add to Bag
                            </button>

                        </div>

                        <button class="ml-product-buy-btn" type="button" id="productBuyNow">
                            Buy Now
                        </button>

                        <div class="ml-product-support-note">
                            <i class="bi bi-info-circle"></i>
                            <span>
                                Product availability and suitability may depend on pharmacy guidance or prescription
                                requirements.
                            </span>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- PRODUCT DETAILS -->
    <section class="ml-product-details">
        <div class="container">
            <div class="row g-4">

                <div class="ml-product-description-box" id="productDescription">

                    <h2>Product Overview</h2>

                    @if($product->short_description)
                        <p>{!! $product->short_description !!}</p>
                    @endif

                    <h3>Product Specifications</h3>

                    <ul>
                        @if($product->sku)
                            <li><strong>SKU:</strong> {{ $product->sku }}</li>
                        @endif

                        @if($product->category)
                            <li><strong>Category:</strong> {{ $product->category }}</li>
                        @endif

                        @if($product->brand)
                            <li><strong>Brand:</strong> {{ $product->brand }}</li>
                        @endif

                        @if($product->product_type)
                            <li><strong>Product Type:</strong> {{ $product->product_type }}</li>
                        @endif

                        @if($product->weight)
                            <li><strong>Weight:</strong> {{ $product->weight }} kg</li>
                        @endif

                        @if($product->length && $product->width && $product->height)
                            <li>
                                <strong>Dimensions:</strong>
                                {{ $product->length }}
                                ×
                                {{ $product->width }}
                                ×
                                {{ $product->height }} cm
                            </li>
                        @endif

                        <li>
                            <strong>Stock:</strong>
                            {{ $product->stock_quantity }} PCS
                        </li>

                        <li>
                            <strong>Status:</strong>

                            @if($product->stock_status == 'in_stock')
                                In Stock
                            @elseif($product->stock_status == 'low_stock')
                                Low Stock
                            @else
                                Out of Stock
                            @endif
                        </li>

                        @if($product->prescription_required)
                            <li>
                                <strong>Prescription:</strong>
                                Required
                            </li>
                        @endif

                    </ul>

                    <h3>Full Description</h3>

                    <div class="ml-product-description">
                        {!! $product->description !!}
                    </div>

                    <h3>Important Information</h3>

                    <p>
                        Product availability may vary. Please consult our healthcare
                        team before purchasing products that require a prescription.
                    </p>

                </div>

            </div>
        </div>
    </section>


    <!-- RELATED PRODUCTS -->
    <section class="ml-related-products">
        <div class="container">

            <div class="ml-related-head">
                <span>Explore More</span>
                <h2>Related Products</h2>
                <p>Discover more pharmacy supported products from the MediLeaf range.</p>
            </div>

            <div class="row g-4">

                @forelse($relatedProducts as $item)

                    <div class="col-md-6 col-xl-3">

                        <div class="ml-shop-v2-card">

                            <div class="ml-shop-v2-img">

                                @if($item->featured)

                                    <span class="ml-shop-v2-tag">
                                        Featured
                                    </span>

                                @endif

                                <img src="{{ asset('storage/' . $item->featured_image) }}"
                                    alt="{{ $item->image_alt ?: $item->name }}">

                            </div>

                            <div class="ml-shop-v2-body">

                                <span>
                                    {{ $item->category }}
                                </span>

                                <h3>
                                    {{ $item->name }}
                                </h3>

                                <p>

                                    @if($item->sale_price)

                                        <span class="text-decoration-line-through text-muted">
                                            A${{ number_format($item->regular_price, 2) }}
                                        </span>

                                        <strong class="text-success">
                                            A${{ number_format($item->sale_price, 2) }}
                                        </strong>

                                    @else

                                        A${{ number_format($item->regular_price, 2) }}

                                    @endif

                                </p>

                                <a href="{{ route('product-view', $item) }}" class="product-view-btn mb-2">
                                    View Product
                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12 text-center">
                        No related products found.
                    </div>

                @endforelse

            </div>

        </div>
    </section>

    <!-- TOAST -->
    <div class="ml-product-toast" id="mlProductToast">
        Product added to bag
    </div>

    <!-- CART DRAWER -->
    <button class="ml-shop-cart-floating" id="mlCartOpen">
        <i class="bi bi-bag"></i>
        <span class="ml-shop-cart-count" id="mlCartCount">0</span>
    </button>

    <div class="ml-shop-cart-overlay" id="mlCartOverlay"></div>

    <div class="ml-shop-cart-drawer" id="mlCartDrawer">
        <div class="ml-shop-cart-head">
            <h3>Your Cart</h3>
            <button class="ml-shop-cart-close" id="mlCartClose">&times;</button>
        </div>

        <div class="ml-shop-cart-items" id="mlCartItems">
            <p class="ml-shop-cart-empty">Your cart is empty.</p>
        </div>

        <div class="ml-shop-cart-bottom">
            <div class="ml-shop-cart-total">
                <span>Subtotal</span>
                <strong id="mlCartTotal">A$0.00</strong>
            </div>

            <button class="ml-shop-checkout-btn" type="button" id="checkoutBtn">
                Proceed to Checkout
            </button>

            <button class="ml-shop-clear-cart" id="mlClearCart" type="button">
                Clear Cart
            </button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const qtyInput = document.getElementById("productQty");
            const qtyMinus = document.getElementById("qtyMinus");
            const qtyPlus = document.getElementById("qtyPlus");

            const addBtn = document.getElementById("productAddToBag");
            const buyNowBtn = document.getElementById("productBuyNow");

            const mainImg = document.getElementById("mlProductMainImg");
            const mainBox = document.getElementById("mlProductMainBox");
            const thumbs = document.querySelectorAll(".ml-product-thumbs button");

            const colorDot = document.getElementById("currentColorDot");

            const customSelect = document.getElementById("mlCustomColorSelect");
            const customTrigger = customSelect
                ? customSelect.querySelector(".ml-custom-select-trigger")
                : null;

            const selectedText = document.getElementById("mlSelectedColor");

            const customOptions = customSelect
                ? customSelect.querySelectorAll(".ml-custom-option")
                : [];

            const toast = document.getElementById("mlProductToast");

            const cartOpen = document.getElementById("mlCartOpen");
            const cartClose = document.getElementById("mlCartClose");
            const cartOverlay = document.getElementById("mlCartOverlay");
            const cartDrawer = document.getElementById("mlCartDrawer");

            const cartItemsBox = document.getElementById("mlCartItems");
            const cartCount = document.getElementById("mlCartCount");
            const cartTotal = document.getElementById("mlCartTotal");

            const clearCartBtn = document.getElementById("mlClearCart");
            const checkoutBtn = document.getElementById("checkoutBtn");

            const scrollToDescription =
                document.getElementById("scrollToDescription");

            const productDescription =
                document.getElementById("productDescription");

            let cart = [];

            try {
                const storedCart = JSON.parse(
                    localStorage.getItem("medileafCart")
                );

                cart = Array.isArray(storedCart) ? storedCart : [];
            } catch (error) {
                cart = [];
            }

            function saveCart() {
                localStorage.setItem(
                    "medileafCart",
                    JSON.stringify(cart)
                );
            }

            function showToast() {
                if (!toast) return;

                toast.classList.add("active");

                setTimeout(function () {
                    toast.classList.remove("active");
                }, 1800);
            }

            function openCart() {
                if (cartDrawer) {
                    cartDrawer.classList.add("active");
                }

                if (cartOverlay) {
                    cartOverlay.classList.add("active");
                }
            }

            function closeCart() {
                if (cartDrawer) {
                    cartDrawer.classList.remove("active");
                }

                if (cartOverlay) {
                    cartOverlay.classList.remove("active");
                }
            }

            function renderCart() {
                if (!cartItemsBox || !cartCount || !cartTotal) {
                    saveCart();
                    return;
                }

                cartItemsBox.innerHTML = "";

                if (cart.length === 0) {
                    cartItemsBox.innerHTML = `
                                                <p class="ml-shop-cart-empty">
                                                    Your cart is empty.
                                                </p>
                                            `;
                }

                let total = 0;
                let count = 0;

                cart.forEach(function (item) {

                    const itemPrice = Number(item.price) || 0;
                    const itemQty = Number(item.qty) || 1;

                    total += itemPrice * itemQty;
                    count += itemQty;

                    const cartItem = document.createElement("div");
                    cartItem.className = "ml-shop-cart-item";

                    cartItem.innerHTML = `
                                                <img
                                                    src="${item.image}"
                                                    alt="${item.name}"
                                                >

                                                <div class="ml-shop-cart-info">

                                                    <h4>${item.name}</h4>

                                                    <p>
                                                        A$${(itemPrice * itemQty).toFixed(2)}
                                                    </p>

                                                    <div class="ml-shop-cart-qty">

                                                        <button
                                                            type="button"
                                                            data-action="minus"
                                                            data-id="${item.id}"
                                                        >
                                                            −
                                                        </button>

                                                        <span>${itemQty}</span>

                                                        <button
                                                            type="button"
                                                            data-action="plus"
                                                            data-id="${item.id}"
                                                        >
                                                            +
                                                        </button>

                                                    </div>

                                                    <button
                                                        class="ml-shop-cart-remove"
                                                        type="button"
                                                        data-action="remove"
                                                        data-id="${item.id}"
                                                    >
                                                        Remove
                                                    </button>

                                                </div>
                                            `;

                    cartItemsBox.appendChild(cartItem);
                });

                cartCount.textContent = count;
                cartTotal.textContent = "A$" + total.toFixed(2);

                saveCart();
            }

            function getCurrentProduct() {

                let selectedQuantity = qtyInput
                    ? Number(qtyInput.value)
                    : 1;

                if (
                    !Number.isFinite(selectedQuantity) ||
                    selectedQuantity < 1
                ) {
                    selectedQuantity = 1;

                    if (qtyInput) {
                        qtyInput.value = 1;
                    }
                }

                return {
                    id: Number({{ $product->id }}),

                    name: @json($product->name),

                    price: Number(
                        {{ $product->sale_price ?: $product->regular_price }}
                    ),

                    image: mainImg
                        ? mainImg.getAttribute("src")
                        : @json(
                            $product->featured_image
                            ? asset('storage/' . $product->featured_image)
                            : asset('img/product-placeholder.webp')
                        ),

                    qty: selectedQuantity
                };
            }

            function addCurrentProductToCart() {

                const product = getCurrentProduct();

                const existing = cart.find(function (item) {
                    return Number(item.id) === Number(product.id);
                });

                if (existing) {
                    existing.qty =
                        Number(existing.qty) + Number(product.qty);

                    existing.name = product.name;
                    existing.price = product.price;
                    existing.image = product.image;
                } else {
                    cart.push(product);
                }

                renderCart();
            }

            function setActiveThumb(index) {

                const button = thumbs[index];

                if (!button) return;

                thumbs.forEach(function (item) {
                    item.classList.remove("active");
                    item.style.borderColor = "transparent";
                    item.style.background = "#fff";
                });

                const image = button.dataset.image;
                const color = button.dataset.color || "#31a050";
                const background =
                    button.dataset.bg || "rgba(49,160,80,0.10)";

                button.classList.add("active");
                button.style.borderColor = color;
                button.style.background = background;

                if (mainBox) {
                    mainBox.style.background = background;
                }

                if (colorDot) {
                    colorDot.style.background = color;
                    colorDot.style.boxShadow =
                        "0 0 0 1px rgba(0,0,0,.08), " +
                        "0 4px 14px " +
                        color +
                        "55";
                }

                if (
                    customOptions[index] &&
                    selectedText
                ) {
                    selectedText.textContent =
                        customOptions[index].textContent.trim();
                }

                if (mainImg && image) {

                    mainImg.style.opacity = "0";

                    setTimeout(function () {
                        mainImg.src = image;
                        mainImg.style.opacity = "1";
                    }, 150);
                }
            }

            thumbs.forEach(function (thumb, index) {

                thumb.addEventListener("click", function () {
                    setActiveThumb(index);
                });

            });

            if (customTrigger && customSelect) {

                customTrigger.addEventListener("click", function (event) {

                    event.stopPropagation();

                    customSelect.classList.toggle("active");

                });

            }

            customOptions.forEach(function (option) {

                option.addEventListener("click", function (event) {

                    event.stopPropagation();

                    const index = Number(this.dataset.index);

                    if (customSelect) {
                        customSelect.classList.remove("active");
                    }

                    setActiveThumb(index);

                });

            });

            document.addEventListener("click", function () {

                if (customSelect) {
                    customSelect.classList.remove("active");
                }

            });

            const activeThumbIndex = Array.from(thumbs)
                .findIndex(function (thumb) {
                    return thumb.classList.contains("active");
                });

            if (thumbs.length > 0) {
                setActiveThumb(
                    activeThumbIndex >= 0
                        ? activeThumbIndex
                        : 0
                );
            }

            if (qtyMinus && qtyInput) {

                qtyMinus.addEventListener("click", function () {

                    let value = Number(qtyInput.value);

                    if (!Number.isFinite(value) || value < 1) {
                        value = 1;
                    }

                    if (value > 1) {
                        qtyInput.value = value - 1;
                    }

                });

            }

            if (qtyPlus && qtyInput) {

                qtyPlus.addEventListener("click", function () {

                    let value = Number(qtyInput.value);

                    if (!Number.isFinite(value) || value < 1) {
                        value = 1;
                    }

                    qtyInput.value = value + 1;

                });

            }

            if (qtyInput) {

                qtyInput.addEventListener("change", function () {

                    let value = Number(this.value);

                    if (!Number.isFinite(value) || value < 1) {
                        this.value = 1;
                    }

                });

            }

            if (addBtn) {

                addBtn.addEventListener("click", function () {

                    addCurrentProductToCart();
                    showToast();
                    openCart();

                });

            }

            if (buyNowBtn) {

                buyNowBtn.addEventListener("click", function () {

                    addCurrentProductToCart();

                    window.location.href =
                        "{{ route('checkout') }}";

                });

            }

            if (cartItemsBox) {

                cartItemsBox.addEventListener("click", function (event) {

                    const button = event.target.closest("button");

                    if (!button) return;

                    const action = button.dataset.action;
                    const id = Number(button.dataset.id);

                    if (!action || !id) return;

                    const item = cart.find(function (cartItem) {
                        return Number(cartItem.id) === id;
                    });

                    if (!item) return;

                    if (action === "plus") {
                        item.qty = Number(item.qty) + 1;
                    }

                    if (action === "minus") {

                        item.qty = Number(item.qty) - 1;

                        if (item.qty <= 0) {

                            cart = cart.filter(function (cartItem) {
                                return Number(cartItem.id) !== id;
                            });

                        }
                    }

                    if (action === "remove") {

                        cart = cart.filter(function (cartItem) {
                            return Number(cartItem.id) !== id;
                        });

                    }

                    renderCart();

                });

            }

            if (clearCartBtn) {

                clearCartBtn.addEventListener("click", function () {

                    cart = [];
                    renderCart();

                });

            }

            if (checkoutBtn) {

                checkoutBtn.addEventListener("click", function () {

                    if (cart.length === 0) {
                        alert("Your cart is empty.");
                        return;
                    }

                    window.location.href =
                        "{{ route('checkout') }}";

                });

            }

            if (scrollToDescription && productDescription) {

                scrollToDescription.addEventListener("click", function () {

                    productDescription.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });

                });

            }

            if (cartOpen) {
                cartOpen.addEventListener("click", openCart);
            }

            if (cartClose) {
                cartClose.addEventListener("click", closeCart);
            }

            if (cartOverlay) {
                cartOverlay.addEventListener("click", closeCart);
            }

            renderCart();

        });
    </script>
@endsection