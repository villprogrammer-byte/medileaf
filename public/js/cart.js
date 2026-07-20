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
        document.querySelectorAll(".ml-cart-count").forEach(function (el) {
            el.textContent = count;
        });
    }

    function renderCart() {

        const count = cart.reduce(function (sum, item) {
            return sum + (Number(item.qty) || 0);
        }, 0);

        updateHeaderCartCount(count);
        saveCart();

        // Agar drawer is page par mount nahi hai (partial include nahi hua),
        // to sirf badge update karke ruk jao
        if (!cartItemsBox || !cartTotal) return;

        cartItemsBox.innerHTML = "";

        if (cart.length === 0) {
            cartItemsBox.innerHTML = `
                <p class="ml-shop-cart-empty">
                    Your cart is empty.
                </p>
            `;
        }

        let total = 0;

        cart.forEach(function (item) {

            const itemPrice = Number(item.price) || 0;
            const itemQty = Number(item.qty) || 1;

            total += itemPrice * itemQty;

            const cartItem = document.createElement("div");
            cartItem.className = "ml-shop-cart-item";

            cartItem.innerHTML = `
                <img src="${item.image}" alt="${item.name}">

                <div class="ml-shop-cart-info">

                    <h4>${item.name}</h4>

                    <p>
                        A$${(itemPrice * itemQty).toFixed(2)}
                    </p>

                    <div class="ml-shop-cart-qty">

                        <button type="button" data-action="minus" data-id="${item.id}">
                            −
                        </button>

                        <span>${itemQty}</span>

                        <button type="button" data-action="plus" data-id="${item.id}">
                            +
                        </button>

                    </div>

                    <button class="ml-shop-cart-remove" type="button" data-action="remove" data-id="${item.id}">
                        Remove
                    </button>

                </div>
            `;

            cartItemsBox.appendChild(cartItem);
        });

        cartTotal.textContent = "A$" + total.toFixed(2);
    }

    // Product page (ya kahi bhi) se product add karne ke liye global entry point.
    // options.openDrawer / options.showToast default true rehte hain (Add to Bag ke liye),
    // Buy Now ke liye product-view.js false pass kar sakta hai taaki drawer na khule.
    function addToCart(product, options) {

        options = options || {};

        const openDrawer = options.openDrawer !== false;
        const shouldShowToast = options.showToast !== false;

        const existing = cart.find(function (item) {
            return Number(item.id) === Number(product.id);
        });

        if (existing) {
            existing.qty = Number(existing.qty) + Number(product.qty || 1);
            existing.name = product.name;
            existing.price = product.price;
            existing.image = product.image;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                qty: Number(product.qty) || 1
            });
        }

        renderCart();

        if (shouldShowToast) showToast();
        if (openDrawer) openCart();
    }

    cartOpenTriggers.forEach(function (trigger) {
        trigger.addEventListener("click", function (event) {
            event.preventDefault();
            openCart();
        });
    });

    if (cartClose) {
        cartClose.addEventListener("click", closeCart);
    }

    if (cartOverlay) {
        cartOverlay.addEventListener("click", closeCart);
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

            window.location.href = checkoutBtn.dataset.checkoutUrl;
        });
    }

    renderCart();

    // Product page (product-view.js) aur kisi bhi future page ke liye
    // global API — window.MedileafCart.addToCart({id, name, price, image, qty})
    window.MedileafCart = {
        addToCart: addToCart,
        open: openCart,
        close: closeCart,
        render: renderCart
    };

});