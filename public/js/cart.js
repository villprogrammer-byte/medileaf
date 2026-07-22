document.addEventListener("DOMContentLoaded", function () {

    const toast = document.getElementById("mlProductToast");

    const cartOpenTriggers = document.querySelectorAll(
        "#mlCartOpen, .ml-cart-btn"
    );

    const cartClose = document.getElementById("mlCartClose");
    const cartOverlay = document.getElementById("mlCartOverlay");
    const cartDrawer = document.getElementById("mlCartDrawer");

    const cartItemsBox = document.getElementById("mlCartItems");
    const cartTotal = document.getElementById("mlCartTotal");

    const clearCartBtn = document.getElementById("mlClearCart");
    const checkoutBtn = document.getElementById("checkoutBtn");

    let cart = [];

    /*
    |--------------------------------------------------------------------------
    | Load Cart
    |--------------------------------------------------------------------------
    */

    try {

        const storedCart = JSON.parse(
            localStorage.getItem("medileafCart")
        );

        cart = Array.isArray(storedCart)
            ? storedCart
            : [];

    } catch (error) {

        cart = [];

    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    function saveCart() {

        localStorage.setItem(
            "medileafCart",
            JSON.stringify(cart)
        );

    }

    function escapeHtml(value) {

        return String(value ?? "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");

    }

    function normaliseColour(colour) {

        const value = String(colour || "").trim();

        return value || "Default";

    }

    function createVariantKey(productId, colour) {

        return String(productId) +
            "::" +
            normaliseColour(colour).toLowerCase();

    }

    function showToast() {

        if (!toast) {
            return;
        }

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

        cartOpenTriggers.forEach(function (trigger) {

            trigger.classList.add("active");

        });

    }

    function closeCart() {

        if (cartDrawer) {
            cartDrawer.classList.remove("active");
        }

        if (cartOverlay) {
            cartOverlay.classList.remove("active");
        }

        cartOpenTriggers.forEach(function (trigger) {

            trigger.classList.remove("active");

        });

    }

    function updateHeaderCartCount(count) {

        document
            .querySelectorAll(".ml-cart-count")
            .forEach(function (element) {

                element.textContent = count;

            });

    }

    /*
    |--------------------------------------------------------------------------
    | Render Cart
    |--------------------------------------------------------------------------
    */

    function renderCart() {

        const count = cart.reduce(function (sum, item) {

            return sum + (Number(item.qty) || 0);

        }, 0);

        updateHeaderCartCount(count);

        saveCart();

        if (!cartItemsBox || !cartTotal) {
            return;
        }

        cartItemsBox.innerHTML = "";

        if (cart.length === 0) {

            cartItemsBox.innerHTML = `
                <p class="ml-shop-cart-empty">
                    Your cart is empty.
                </p>
            `;

            cartTotal.textContent = "A$0.00";

            return;

        }

        let total = 0;

        cart.forEach(function (item) {

            const itemPrice = Number(item.price) || 0;
            const itemQty = Number(item.qty) || 1;

            const colour = normaliseColour(item.colour);

            const variantKey = item.variantKey ||
                createVariantKey(item.id, colour);

            item.variantKey = variantKey;
            item.colour = colour;

            total += itemPrice * itemQty;

            const cartItem = document.createElement("div");

            cartItem.className = "ml-shop-cart-item";

            cartItem.innerHTML = `
                <img
                    src="${escapeHtml(item.image)}"
                    alt="${escapeHtml(item.name)} - ${escapeHtml(colour)}"
                >

                <div class="ml-shop-cart-info">

                    <h4>
                        ${escapeHtml(item.name)}
                    </h4>

                    ${colour !== "Default"
                    ? `
                                <small class="ml-cart-item-colour">
                                    Colour:
                                    <strong>
                                        ${escapeHtml(colour)}
                                    </strong>
                                </small>
                            `
                    : ""
                }

                    <p>
                        A$${(itemPrice * itemQty).toFixed(2)}
                    </p>

                    <div class="ml-shop-cart-qty">

                        <button
                            type="button"
                            data-action="minus"
                            data-variant-key="${escapeHtml(variantKey)}"
                            aria-label="Decrease quantity"
                        >
                            −
                        </button>

                        <span>
                            ${itemQty}
                        </span>

                        <button
                            type="button"
                            data-action="plus"
                            data-variant-key="${escapeHtml(variantKey)}"
                            aria-label="Increase quantity"
                        >
                            +
                        </button>

                    </div>

                    <button
                        class="ml-shop-cart-remove"
                        type="button"
                        data-action="remove"
                        data-variant-key="${escapeHtml(variantKey)}"
                    >
                        Remove
                    </button>

                </div>
            `;

            cartItemsBox.appendChild(cartItem);

        });

        cartTotal.textContent =
            "A$" + total.toFixed(2);

    }

    /*
    |--------------------------------------------------------------------------
    | Add Product to Cart
    |--------------------------------------------------------------------------
    */

    function addToCart(product, options) {

        options = options || {};

        const openDrawer =
            options.openDrawer !== false;

        const shouldShowToast =
            options.showToast !== false;

        const productId = Number(product.id);

        const quantity = Math.max(
            1,
            Number(product.qty) || 1
        );

        const colour = normaliseColour(
            product.colour
        );

        const variantKey = createVariantKey(
            productId,
            colour
        );

        const existing = cart.find(function (item) {

            const itemKey = item.variantKey ||
                createVariantKey(
                    item.id,
                    item.colour
                );

            return itemKey === variantKey;

        });

        if (existing) {

            existing.qty =
                Number(existing.qty || 0) +
                quantity;

            existing.name =
                product.name || existing.name;

            existing.price =
                Number(product.price) || 0;

            existing.image =
                product.image || existing.image;

            existing.colour = colour;
            existing.variantKey = variantKey;

        } else {

            cart.push({

                id: productId,

                variantKey: variantKey,

                name: product.name || "",

                price: Number(product.price) || 0,

                image: product.image || "",

                colour: colour,

                qty: quantity

            });

        }

        renderCart();

        if (shouldShowToast) {
            showToast();
        }

        if (openDrawer) {
            openCart();
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Drawer Events
    |--------------------------------------------------------------------------
    */

    cartOpenTriggers.forEach(function (trigger) {

        trigger.addEventListener(
            "click",
            function (event) {

                event.preventDefault();

                openCart();

            }
        );

    });

    if (cartClose) {

        cartClose.addEventListener(
            "click",
            closeCart
        );

    }

    if (cartOverlay) {

        cartOverlay.addEventListener(
            "click",
            closeCart
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Quantity and Remove Events
    |--------------------------------------------------------------------------
    */

    if (cartItemsBox) {

        cartItemsBox.addEventListener(
            "click",
            function (event) {

                const button = event.target.closest(
                    "button[data-action]"
                );

                if (!button) {
                    return;
                }

                const action =
                    button.dataset.action;

                const variantKey =
                    button.dataset.variantKey;

                if (!action || !variantKey) {
                    return;
                }

                const item = cart.find(
                    function (cartItem) {

                        const itemKey =
                            cartItem.variantKey ||
                            createVariantKey(
                                cartItem.id,
                                cartItem.colour
                            );

                        return itemKey === variantKey;

                    }
                );

                if (!item) {
                    return;
                }

                if (action === "plus") {

                    item.qty =
                        Number(item.qty || 0) + 1;

                }

                if (action === "minus") {

                    item.qty =
                        Number(item.qty || 1) - 1;

                    if (item.qty <= 0) {

                        cart = cart.filter(
                            function (cartItem) {

                                const itemKey =
                                    cartItem.variantKey ||
                                    createVariantKey(
                                        cartItem.id,
                                        cartItem.colour
                                    );

                                return itemKey !== variantKey;

                            }
                        );

                    }

                }

                if (action === "remove") {

                    cart = cart.filter(
                        function (cartItem) {

                            const itemKey =
                                cartItem.variantKey ||
                                createVariantKey(
                                    cartItem.id,
                                    cartItem.colour
                                );

                            return itemKey !== variantKey;

                        }
                    );

                }

                renderCart();

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Clear Cart
    |--------------------------------------------------------------------------
    */

    if (clearCartBtn) {

        clearCartBtn.addEventListener(
            "click",
            function () {

                cart = [];

                renderCart();

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    */

    if (checkoutBtn) {

        checkoutBtn.addEventListener(
            "click",
            function () {

                if (cart.length === 0) {

                    alert("Your cart is empty.");

                    return;

                }

                const checkoutUrl =
                    checkoutBtn.dataset.checkoutUrl;

                if (checkoutUrl) {

                    window.location.href =
                        checkoutUrl;

                }

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Initial Render
    |--------------------------------------------------------------------------
    */

    renderCart();

    /*
    |--------------------------------------------------------------------------
    | Global Cart API
    |--------------------------------------------------------------------------
    */

    window.MedileafCart = {

        addToCart: addToCart,

        open: openCart,

        close: closeCart,

        render: renderCart,

        getItems: function () {

            return [...cart];

        }

    };

});