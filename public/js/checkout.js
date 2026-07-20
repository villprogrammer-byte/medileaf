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

document.querySelectorAll(".ml-payment-v2-option").forEach(option => {
    option.addEventListener("click", function () {
        document.querySelectorAll(".ml-payment-v2-option").forEach(item => {
            item.classList.remove("active");
        });

        this.classList.add("active");
        this.querySelector("input").checked = true;
    });
});
