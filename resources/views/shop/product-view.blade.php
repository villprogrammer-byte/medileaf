@extends('layouts.app')

@section('title', 'About MediLeaf')

@section('content')
    <!-- PRODUCT VIEW PAGE -->
    <section class="ml-product-view">
        <div class="container">

            <div class="ml-product-breadcrumb">
                <a href="index">Home</a>
                <span>/</span>
                <a href="store">Store</a>
                <span>/</span>
                <strong>Portable Vaporiser</strong>
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
                            <img id="mlProductMainImg" src="img/products/vaporisers/Mighty.png" alt="Portable Vaporiser">
                        </div>

                        <div class="ml-product-media-options">

                            <div class="ml-product-thumbs">
                                <button class="active" data-color="#31a050" data-bg="rgba(49,160,80,0.10)"
                                    data-image="img/products/vaporisers/Mighty.png">
                                    <img src="img/products/vaporisers/Mighty.png" alt="">
                                </button>

                                <button data-color="#9c9678" data-bg="rgba(156,150,120,0.16)"
                                    data-image="img/products/vaporisers/Mighty.png">
                                    <img src="img/products/vaporisers/Mighty.png" alt="">
                                </button>

                                <button data-color="#c58a5c" data-bg="rgba(197,138,92,0.16)"
                                    data-image="img/products/vaporisers/Mighty.png">
                                    <img src="img/products/vaporisers/Mighty.png" alt="">
                                </button>

                                <div class="ml-product-color-select">
                                    <label class="ml-color-label">
                                        <span class="ml-color-dot" id="currentColorDot"></span>
                                        Colour
                                    </label>

                                    <div class="ml-custom-select" id="mlCustomColorSelect">

                                        <div class="ml-custom-select-trigger">
                                            <span id="mlSelectedColor">Forest Green</span>
                                            <i class="bi bi-chevron-down"></i>
                                        </div>

                                        <div class="ml-custom-options">

                                            <div class="ml-custom-option" data-index="0">
                                                <span class="color-circle" style="background:#31a050"></span>
                                                Forest Green
                                            </div>

                                            <div class="ml-custom-option" data-index="1">
                                                <span class="color-circle" style="background:#9c9678"></span>
                                                Stone Grey
                                            </div>

                                            <div class="ml-custom-option" data-index="2">
                                                <span class="color-circle" style="background:#c58a5c"></span>
                                                Copper
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

                        <span class="ml-product-category">Vaporisers</span>

                        <h1>MIGHTY+ MEDIC</h1>

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

                        <p class="ml-product-price">A$545.00</p>

                        <div class="ml-product-short">

                            <p>
                                The STORZ & BICKEL Mighty+ Medic is a premium portable medical device designed for patients
                                seeking reliable, efficient, and consistent plant based therapy delivery.

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
                    <p>
                        The STORZ &amp; BICKEL Mighty+ Medic is a premium portable medical device designed for
                        patients seeking reliable, efficient, and consistent plant based therapy delivery. Featuring
                        rapid heat up technology, USB C fast charging, and precise temperature control, it offers a
                        convenient and user friendly experience at home or on the go.
                    </p>

                    <h3>Key Features</h3>

                    <ul>
                        <li>Fast heat up in approximately 60 seconds</li>
                        <li>USB C charging for greater convenience</li>
                        <li>Supercharge function with up to 80% charge in around 40 minutes</li>
                        <li>Hybrid heating technology for efficient performance</li>
                        <li>Ceramic coated filling chamber</li>
                        <li>Precise temperature control</li>
                        <li>Stable design that stands upright</li>
                        <li>Portable and easy to carry</li>
                        <li>Medical grade quality and reliability</li>
                    </ul>

                    <h3>Product Specifications</h3>

                    <ul>
                        <li><strong>Weight:</strong> 0.99 kg</li>
                        <li><strong>Dimensions:</strong> 10 × 10 × 20 cm</li>
                        <li><strong>Charging Port:</strong> USB C</li>
                        <li><strong>Heat Up Time:</strong> Approximately 60 seconds</li>
                        <li><strong>Temperature Control:</strong> Adjustable</li>
                        <li><strong>Usage:</strong> Doctor guided plant based treatment administration</li>
                    </ul>

                    <h3>Package Contents</h3>

                    <ul>
                        <li>1 × MIGHTY+ MEDIC Vaporizer</li>
                        <li>1 × USB Charger</li>
                        <li>1 × USB C Cable (USB Type C to USB Type A Plug)</li>
                        <li>3 × Normal Screen, Small</li>
                        <li>3 × Coarse Screen, Small</li>
                        <li>3 × Base Seal Ring, Small</li>
                        <li>1 × Magazine with 8 Dosing Capsules</li>
                        <li>1 × Herb Mill</li>
                        <li>1 × Cleaning Brush</li>
                        <li>1 × Instructions for Use</li>
                    </ul>

                    <h3>Full Description</h3>

                    <p>
                        The Mighty+ Medic from STORZ &amp; BICKEL is one of the most trusted portable medical
                        devices available in Australia for approved plant based treatment administration. Built with
                        German engineering and medical grade quality, it delivers exceptional performance,
                        reliability, and ease of use.
                    </p>

                    <p>
                        Designed for patients who value consistency and convenience, the Mighty+ Medic features
                        advanced heating technology that combines conduction and convection methods to produce
                        efficient and effective vapour delivery. The device heats up in approximately 60 seconds,
                        allowing users to begin treatment quickly when needed.
                    </p>

                    <p>
                        The upgraded USB C charging system supports faster charging, while the Supercharge function
                        can provide up to 80% battery capacity in around 40 minutes. Its improved housing and stable
                        design allow the unit to stand securely on flat surfaces, making daily use even more
                        practical.
                    </p>

                    <p>
                        The ceramic coated filling chamber ensures durability and easy maintenance, while precise
                        temperature control allows users to personalise their experience according to healthcare
                        professional recommendations.
                    </p>

                    <p>
                        Whether at home or travelling, the Mighty+ Medic offers portable, dependable performance
                        backed by one of the most respected names in medical device technology.
                    </p>

                    <h3>Important Information</h3>

                    <p>
                        This device should only be used as directed by your healthcare professional and in
                        accordance with applicable Australian regulations and prescribing requirements.
                    </p>

                </div>

            </div>

    </section>


    <!-- RELATED PRODUCTS -->
    <section class="ml-related-products">
        <div class="container">

            <div class="ml-related-head">
                <span>Explore More</span>
                <h2>Related Products</h2>
                <p>Discover more pharmacy supported products from the Medileaf range.</p>
            </div>

            <div class="row g-4">

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers"
                    data-name="Portable Vaporiser" data-price="285">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <span class="ml-shop-v2-tag">New</span>
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-00.webp" alt="Portable Vaporiser">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>Portable Vaporiser</h3>
                            <p>A$285.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers"
                    data-name="Portable Vaporiser" data-price="285">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <span class="ml-shop-v2-tag">New</span>
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-00.webp" alt="Portable Vaporiser">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>Portable Vaporiser</h3>
                            <p>A$285.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers"
                    data-name="Portable Vaporiser" data-price="285">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <span class="ml-shop-v2-tag">New</span>
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-00.webp" alt="Portable Vaporiser">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>Portable Vaporiser</h3>
                            <p>A$285.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers"
                    data-name="Portable Vaporiser" data-price="285">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <span class="ml-shop-v2-tag">New</span>
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-00.webp" alt="Portable Vaporiser">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>Portable Vaporiser</h3>
                            <p>A$285.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                        </div>
                    </div>
                </div>

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
            const customTrigger = customSelect?.querySelector(".ml-custom-select-trigger");
            const selectedText = document.getElementById("mlSelectedColor");
            const customOptions = customSelect?.querySelectorAll(".ml-custom-option");

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

            const scrollToDescription = document.getElementById("scrollToDescription");
            const productDescription = document.getElementById("productDescription");

            let cart = JSON.parse(localStorage.getItem("medileafCart")) || [];

            function saveCart() {
                localStorage.setItem("medileafCart", JSON.stringify(cart));
            }

            function showToast() {
                if (!toast) return;
                toast.classList.add("active");
                setTimeout(() => toast.classList.remove("active"), 1800);
            }

            function openCart() {
                if (cartDrawer) cartDrawer.classList.add("active");
                if (cartOverlay) cartOverlay.classList.add("active");
            }

            function closeCart() {
                if (cartDrawer) cartDrawer.classList.remove("active");
                if (cartOverlay) cartOverlay.classList.remove("active");
            }

            function renderCart() {
                if (!cartItemsBox || !cartCount || !cartTotal) return;

                cartItemsBox.innerHTML = "";

                if (cart.length === 0) {
                    cartItemsBox.innerHTML = '<p class="ml-shop-cart-empty">Your cart is empty.</p>';
                }

                let total = 0;
                let count = 0;

                cart.forEach(function (item) {
                    total += item.price * item.qty;
                    count += item.qty;

                    const cartItem = document.createElement("div");
                    cartItem.className = "ml-shop-cart-item";

                    cartItem.innerHTML = `
                    <img src="${item.image}" alt="${item.name}">
                    <div class="ml-shop-cart-info">
                        <h4>${item.name}</h4>
                        <p>A$${(item.price * item.qty).toFixed(2)}</p>

                        <div class="ml-shop-cart-qty">
                            <button type="button" data-action="minus" data-name="${item.name}">-</button>
                            <span>${item.qty}</span>
                            <button type="button" data-action="plus" data-name="${item.name}">+</button>
                        </div>

                        <button class="ml-shop-cart-remove" type="button" data-action="remove" data-name="${item.name}">
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
                return {
                    name: "Portable Vaporiser",
                    price: 285,
                    image: mainImg ? mainImg.getAttribute("src") : "",
                    qty: qtyInput ? Number(qtyInput.value) : 1
                };
            }

            function addCurrentProductToCart() {
                const product = getCurrentProduct();

                const existing = cart.find(item => item.name === product.name);

                if (existing) {
                    existing.qty += product.qty;
                    existing.image = product.image;
                } else {
                    cart.push(product);
                }

                renderCart();
            }

            function setActiveThumb(index) {
                const btn = thumbs[index];
                if (!btn) return;

                thumbs.forEach(function (item) {
                    item.classList.remove("active");
                    item.style.borderColor = "transparent";
                    item.style.background = "#fff";
                });

                const image = btn.dataset.image;
                const color = btn.dataset.color || "#31a050";
                const bg = btn.dataset.bg || "rgba(49,160,80,0.10)";

                btn.classList.add("active");
                btn.style.borderColor = color;
                btn.style.background = bg;

                if (mainBox) {
                    mainBox.style.background = bg;
                }

                if (colorDot) {
                    colorDot.style.background = color;
                    colorDot.style.boxShadow =
                        `0 0 0 1px rgba(0,0,0,.08), 0 4px 14px ${color}55`;
                }

                if (customOptions && customOptions[index] && selectedText) {
                    selectedText.textContent = customOptions[index].textContent.trim();
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
                customTrigger.addEventListener("click", function (e) {
                    e.stopPropagation();
                    customSelect.classList.toggle("active");
                });
            }

            if (customOptions) {
                customOptions.forEach(function (option) {
                    option.addEventListener("click", function (e) {
                        e.stopPropagation();

                        const index = Number(this.dataset.index);

                        customSelect.classList.remove("active");
                        setActiveThumb(index);
                    });
                });
            }

            document.addEventListener("click", function () {
                if (customSelect) customSelect.classList.remove("active");
            });

            const activeThumbIndex = Array.from(thumbs).findIndex(thumb => thumb.classList.contains("active"));
            setActiveThumb(activeThumbIndex >= 0 ? activeThumbIndex : 0);

            if (qtyMinus && qtyInput) {
                qtyMinus.addEventListener("click", function () {
                    let value = Number(qtyInput.value);
                    if (value > 1) qtyInput.value = value - 1;
                });
            }

            if (qtyPlus && qtyInput) {
                qtyPlus.addEventListener("click", function () {
                    let value = Number(qtyInput.value);
                    qtyInput.value = value + 1;
                });
            }

            if (addBtn) {
                addBtn.addEventListener("click", function () {
                    addCurrentProductToCart();
                    showToast();
                });
            }

            if (buyNowBtn) {
                buyNowBtn.addEventListener("click", function () {
                    addCurrentProductToCart();
                    window.location.href = "checkout";
                });
            }

            if (cartItemsBox) {
                cartItemsBox.addEventListener("click", function (e) {
                    const button = e.target.closest("button");
                    if (!button) return;

                    const action = button.dataset.action;
                    const name = button.dataset.name;

                    const item = cart.find(cartItem => cartItem.name === name);
                    if (!item) return;

                    if (action === "plus") item.qty += 1;

                    if (action === "minus") {
                        item.qty -= 1;
                        if (item.qty <= 0) {
                            cart = cart.filter(cartItem => cartItem.name !== name);
                        }
                    }

                    if (action === "remove") {
                        cart = cart.filter(cartItem => cartItem.name !== name);
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

                    window.location.href = "checkout";
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

            if (cartOpen) cartOpen.addEventListener("click", openCart);
            if (cartClose) cartClose.addEventListener("click", closeCart);
            if (cartOverlay) cartOverlay.addEventListener("click", closeCart);

            renderCart();

        });
    </script>
@endsection