@extends('layouts.app')

@section('title', 'About MediLeaf')

@section('content')
    <section class="ml-shop-v2-section">
        <div class="container">
            <div class="ml-product-breadcrumb">
                <a href="index">Home</a>
                <span>/</span>
                <a href="store">Store</a>
            </div>

            <div class="ml-shop-v2-filterbar">
                <div>
                    <span class="ml-shop-v2-eyebrow">All Products</span>
                    <h2>Browse Our Collection</h2>
                </div>

                <div class="ml-shop-v2-tools">
                    <div class="ml-shop-v2-search">
                        <input type="text" id="mlShopSearch" placeholder="Search products">
                        <i class="bi bi-search"></i>
                    </div>

                    <div class="ml-shop-v2-sort">
                        <label for="mlShopSort">Sort by</label>
                        <select id="mlShopSort">
                            <option value="default">Default sorting</option>
                            <option value="latest">Latest products</option>
                            <option value="low">Price low to high</option>
                            <option value="high">Price high to low</option>
                            <option value="az">Name A to Z</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="ml-shop-v2-category-scroll">
                <a href="#" class="active" data-category="all">All</a>
                <a href="#" data-category="vaporisers">Vaporisers</a>
                <a href="#" data-category="health">Health</a>
                <a href="#" data-category="hemp">Hemp</a>
                <a href="#" data-category="supplements">Supplements</a>
                <a href="#" data-category="personal-care">Personal Care</a>
                <a href="#" data-category="accessories">Accessories</a>
                <a href="#" data-category="pet-care">Pet Care</a>
            </div>

            <div class="row g-4" id="mlShopGrid">

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers"
                    data-name="Yocan UNI Pro Box Mod" data-price="285">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <span class="ml-shop-v2-tag">New</span>
                            <img src="img/products/vaporisers/YocanUNIProBoxMod_2.webp">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>Yocan UNI Pro Box Mod</h3>
                            <p>A$285.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers" data-name="MIGHTY+ MEDIC"
                    data-price="545">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/products/vaporisers/Mighty.png">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>MIGHTY+ MEDIC</h3>
                            <p>A$545.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers" data-name="VOLCANO HYBRID"
                    data-price="850">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/products/vaporisers/volcano_hybrid_onyx_0.jpg">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>VOLCANO HYBRID</h3>
                            <p>A$850.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="health" data-name="Lion's Mane Mushroom"
                    data-price="42">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/products/health/LM_1.webp">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Health</span>
                            <h3>Lion's Mane Mushroom</h3>
                            <p>A$42.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers" data-name="FENIX Mini"
                    data-price="179">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/products/vaporisers/finix-mini.png">
                        </div>
                        <div class="ml-shop-v2-body">finix-mini
                            <span>Vaporisers</span>
                            <h3>FENIX Mini</h3>
                            <p>A$179.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers"
                    data-name="Vaporiser Glass Stem" data-price="25">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-02.avif" alt="Vaporiser Glass Stem">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>Vaporiser Glass Stem</h3>
                            <p>A$25.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers"
                    data-name="Vaporiser Glass Stem" data-price="25">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-02.avif" alt="Vaporiser Glass Stem">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>Vaporiser Glass Stem</h3>
                            <p>A$25.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers"
                    data-name="Vaporiser Glass Stem" data-price="25">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-02.avif" alt="Vaporiser Glass Stem">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>Vaporiser Glass Stem</h3>
                            <p>A$25.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers"
                    data-name="Vaporiser Glass Stem" data-price="25">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-02.avif" alt="Vaporiser Glass Stem">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>Vaporiser Glass Stem</h3>
                            <p>A$25.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers"
                    data-name="Vaporiser Glass Stem" data-price="25">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-02.avif" alt="Vaporiser Glass Stem">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>Vaporiser Glass Stem</h3>
                            <p>A$25.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="vaporisers"
                    data-name="Vaporiser Glass Stem" data-price="25">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-02.avif" alt="Vaporiser Glass Stem">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Vaporisers</span>
                            <h3>Vaporiser Glass Stem</h3>
                            <p>A$25.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="health" data-name="Care Balm"
                    data-price="42">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-03.avif" alt="Care Balm">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Health</span>
                            <h3>Care Balm</h3>
                            <p>A$42.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="health" data-name="Relief Cream"
                    data-price="29">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <span class="ml-shop-v2-tag">Popular</span>
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-04.avif" alt="Relief Cream">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Health</span>
                            <h3>Relief Cream</h3>
                            <p>A$29.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="health" data-name="Natural Wellness Oil"
                    data-price="30">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <span class="ml-shop-v2-tag sold">Sold Out</span>
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-05.avif" alt="Natural Wellness Oil">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Health</span>
                            <h3>Natural Wellness Oil</h3>
                            <p>A$30.00</p>
                            <button type="button" class="disabled">Sold Out</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="hemp" data-name="Wellness Drops"
                    data-price="58">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-06.avif" alt="Wellness Drops">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Hemp</span>
                            <h3>Wellness Drops</h3>
                            <p>A$58.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="hemp" data-name="Hemp Skin Oil"
                    data-price="45">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-07.avif" alt="Hemp Skin Oil">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Hemp</span>
                            <h3>Hemp Skin Oil</h3>
                            <p>A$45.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="supplements" data-name="Daily Capsules"
                    data-price="39">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <span class="ml-shop-v2-tag">Trending</span>
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-00.webp" alt="Daily Capsules">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Supplements</span>
                            <h3>Daily Capsules</h3>
                            <p>A$39.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="supplements"
                    data-name="Immune Support Tablets" data-price="49">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-01.avif"
                                alt="Immune Support Tablets">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Supplements</span>
                            <h3>Immune Support Tablets</h3>
                            <p>A$49.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="personal-care" data-name="Wellness Serum"
                    data-price="51">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-02.avif" alt="Wellness Serum">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Personal Care</span>
                            <h3>Wellness Serum</h3>
                            <p>A$51.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 ml-shop-product-item" data-category="personal-care"
                    data-name="Hydrating Skin Cream" data-price="36">
                    <div class="ml-shop-v2-card">
                        <div class="ml-shop-v2-img">
                            <img src="img/demo_01G0E9P2R0CFTNBWEEFCEV8EG5_assets_image-03.avif" alt="Hydrating Skin Cream">
                        </div>
                        <div class="ml-shop-v2-body">
                            <span>Personal Care</span>
                            <h3>Hydrating Skin Cream</h3>
                            <p>A$36.00</p>
                            <button type="button" class="product-view-btn mb-2 ">View Product</button>
                            <button type="button" class="add-to-bag-btn">Add to Bag</button>
                        </div>
                    </div>
                </div>

            </div>

            <p class="ml-shop-no-products" id="mlShopNoProducts">No products found.</p>
            <div class="ml-shop-v2-pagination" id="mlShopPagination"></div>

        </div>
    </section>

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

            <button class="ml-shop-clear-cart" id="mlClearCart" type="button">Clear Cart</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const categoryLinks = document.querySelectorAll(".ml-shop-v2-category-scroll a");
            const searchInput = document.getElementById("mlShopSearch");
            const sortSelect = document.getElementById("mlShopSort");
            const grid = document.getElementById("mlShopGrid");
            const pagination = document.getElementById("mlShopPagination");
            const noProducts = document.getElementById("mlShopNoProducts");

            const cartOpen = document.getElementById("mlCartOpen");
            const cartClose = document.getElementById("mlCartClose");
            const cartOverlay = document.getElementById("mlCartOverlay");
            const cartDrawer = document.getElementById("mlCartDrawer");
            const cartItemsBox = document.getElementById("mlCartItems");
            const cartCount = document.getElementById("mlCartCount");
            const cartTotal = document.getElementById("mlCartTotal");
            const clearCartBtn = document.getElementById("mlClearCart");

            const productsPerPage = 8;
            let currentCategory = "all";
            let currentPage = 1;
            let cart = JSON.parse(localStorage.getItem("medileafCart")) || [];

            if (!grid || !pagination) return;

            const allProducts = Array.from(grid.querySelectorAll(".ml-shop-product-item"));

            function getFilteredProducts() {
                const searchValue = searchInput ? searchInput.value.toLowerCase().trim() : "";

                let filtered = allProducts.filter(function (product) {
                    const categoryMatch = currentCategory === "all" || product.dataset.category === currentCategory;
                    const nameMatch = product.dataset.name.toLowerCase().includes(searchValue);
                    return categoryMatch && nameMatch;
                });

                if (sortSelect) {
                    const value = sortSelect.value;

                    filtered.sort(function (a, b) {
                        const nameA = a.dataset.name.toLowerCase();
                        const nameB = b.dataset.name.toLowerCase();
                        const priceA = Number(a.dataset.price);
                        const priceB = Number(b.dataset.price);

                        if (value === "low") return priceA - priceB;
                        if (value === "high") return priceB - priceA;
                        if (value === "az") return nameA.localeCompare(nameB);

                        return 0;
                    });
                }

                return filtered;
            }

            function renderProducts() {
                const filteredProducts = getFilteredProducts();
                const start = (currentPage - 1) * productsPerPage;
                const end = start + productsPerPage;

                allProducts.forEach(function (product) {
                    product.style.display = "none";
                });

                filteredProducts.slice(start, end).forEach(function (product) {
                    product.style.display = "";
                    grid.appendChild(product);
                });

                if (noProducts) {
                    noProducts.style.display = filteredProducts.length === 0 ? "block" : "none";
                }

                renderPagination(filteredProducts.length);
            }

            function renderPagination(totalProducts) {
                const totalPages = Math.ceil(totalProducts / productsPerPage);
                pagination.innerHTML = "";

                if (totalPages <= 1) return;

                function createButton(text, page, isActive, disabled) {
                    const button = document.createElement("button");
                    button.innerHTML = text;
                    button.disabled = disabled;

                    if (isActive) {
                        button.classList.add("active");
                    }

                    button.addEventListener("click", function () {
                        if (!disabled) {
                            currentPage = page;
                            renderProducts();
                            grid.scrollIntoView({
                                behavior: "smooth",
                                block: "start"
                            });
                        }
                    });

                    pagination.appendChild(button);
                }

                createButton("1", 1, currentPage === 1, false);

                if (currentPage > 4) {
                    createButton("...", currentPage, false, true);
                }

                for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
                    createButton(i, i, currentPage === i, false);
                }

                if (currentPage < totalPages - 3) {
                    createButton("...", currentPage, false, true);
                }

                if (totalPages > 1) {
                    createButton(totalPages, totalPages, currentPage === totalPages, false);
                }

                createButton("›", Math.min(currentPage + 1, totalPages), false, currentPage === totalPages);
            }

            categoryLinks.forEach(function (link) {
                link.addEventListener("click", function (e) {
                    e.preventDefault();

                    categoryLinks.forEach(function (item) {
                        item.classList.remove("active");
                    });

                    this.classList.add("active");
                    currentCategory = this.dataset.category;
                    currentPage = 1;

                    renderProducts();
                });
            });

            if (sortSelect) {
                sortSelect.addEventListener("change", function () {
                    currentPage = 1;
                    renderProducts();
                });
            }

            if (searchInput) {
                searchInput.addEventListener("input", function () {
                    currentPage = 1;
                    renderProducts();
                });
            }

            function saveCart() {
                localStorage.setItem("medileafCart", JSON.stringify(cart));
            }

            function openCart() {
                cartDrawer.classList.add("active");
                cartOverlay.classList.add("active");
            }

            function closeCart() {
                cartDrawer.classList.remove("active");
                cartOverlay.classList.remove("active");
            }

            function renderCart() {
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

            function addToCart(button) {
                const product = button.closest(".ml-shop-product-item");
                const name = product.dataset.name;
                const price = Number(product.dataset.price);
                const image = product.querySelector("img").getAttribute("src");

                const existing = cart.find(function (item) {
                    return item.name === name;
                });

                if (existing) {
                    existing.qty += 1;
                } else {
                    cart.push({
                        name: name,
                        price: price,
                        image: image,
                        qty: 1
                    });
                }

                renderCart();
                openCart();
            }

            grid.addEventListener("click", function (e) {
                const button = e.target.closest(".ml-shop-v2-body button");

                if (!button || button.classList.contains("disabled")) return;

                addToCart(button);
            });

            cartItemsBox.addEventListener("click", function (e) {
                const button = e.target.closest("button");
                if (!button) return;

                const action = button.dataset.action;
                const name = button.dataset.name;

                const item = cart.find(function (cartItem) {
                    return cartItem.name === name;
                });

                if (!item) return;

                if (action === "plus") {
                    item.qty += 1;
                }

                if (action === "minus") {
                    item.qty -= 1;

                    if (item.qty <= 0) {
                        cart = cart.filter(function (cartItem) {
                            return cartItem.name !== name;
                        });
                    }
                }

                if (action === "remove") {
                    cart = cart.filter(function (cartItem) {
                        return cartItem.name !== name;
                    });
                }

                renderCart();
            });

            if (clearCartBtn) {
                clearCartBtn.addEventListener("click", function () {
                    cart = [];
                    renderCart();
                });
            }

            if (cartOpen) cartOpen.addEventListener("click", openCart);
            if (cartClose) cartClose.addEventListener("click", closeCart);
            if (cartOverlay) cartOverlay.addEventListener("click", closeCart);

            renderProducts();
            renderCart();
        });
    </script>
    <script>
        document.getElementById("checkoutBtn").addEventListener("click", function () {

            const cart = JSON.parse(localStorage.getItem("medileafCart")) || [];

            if (cart.length === 0) {
                alert("Your cart is empty.");
                return;
            }

            window.location.href = "checkout";
        });
    </script>
    <script>
        document.querySelectorAll(".product-view-btn").forEach(function (btn) {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                window.location.href = "product-view";
            });
        });
    </script>
@endsection