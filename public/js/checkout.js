document.addEventListener("DOMContentLoaded", function () {

    const checkoutItems = document.getElementById("checkoutItems");
    const subtotalEl = document.getElementById("checkoutSubtotal");
    const totalEl = document.getElementById("checkoutTotal");

    let cart = [];

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

    function renderCheckout() {

        if (!checkoutItems || !subtotalEl || !totalEl) {
            return;
        }

        checkoutItems.innerHTML = "";

        if (cart.length === 0) {

            checkoutItems.innerHTML = `
                <div class="ml-checkout-empty">
                    <p>Your cart is empty.</p>
                    <a href="/store">
                        Return to Store
                    </a>
                </div>
            `;

            subtotalEl.textContent = "A$0.00";
            totalEl.textContent = "A$0.00";

            return;
        }

        let subtotal = 0;

        cart.forEach(function (item) {

            const itemPrice = Number(item.price) || 0;
            const itemQty = Number(item.qty) || 1;
            const itemTotal = itemPrice * itemQty;
            const colour = normaliseColour(item.colour);

            subtotal += itemTotal;

            const itemBox = document.createElement("div");

            itemBox.className = "ml-order-v2-item";

            itemBox.innerHTML = `
                <div class="ml-order-v2-product">

                    <div class="ml-order-v2-image">
                        <img
                            src="${escapeHtml(item.image)}"
                            alt="${escapeHtml(item.name)} - ${escapeHtml(colour)}"
                        >
                    </div>

                    <div class="ml-order-v2-info">

                        <h4>
                            ${escapeHtml(item.name)}
                        </h4>

                        ${colour !== "Default"
                    ? `
                                    <p class="ml-order-v2-colour">
                                        Colour:
                                        <strong>
                                            ${escapeHtml(colour)}
                                        </strong>
                                    </p>
                                `
                    : ""
                }

                        <p>
                            Quantity:
                            <strong>${itemQty}</strong>
                        </p>

                    </div>

                </div>

                <strong class="ml-order-v2-price">
                    A$${itemTotal.toFixed(2)}
                </strong>
            `;

            checkoutItems.appendChild(itemBox);
        });

        subtotalEl.textContent =
            "A$" + subtotal.toFixed(2);

        totalEl.textContent =
            "A$" + subtotal.toFixed(2);
    }

    renderCheckout();

});