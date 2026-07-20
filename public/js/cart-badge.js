document.addEventListener("DOMContentLoaded", function () {

    // Har page (home, store, about, etc.) par menu ke cart icon
    // (class="ml-cart-count") ko localStorage wale cart se sync karta hai
    let cart = [];

    try {
        const storedCart = JSON.parse(
            localStorage.getItem("medileafCart")
        );

        cart = Array.isArray(storedCart) ? storedCart : [];
    } catch (error) {
        cart = [];
    }

    const count = cart.reduce(function (sum, item) {
        return sum + (Number(item.qty) || 0);
    }, 0);

    document.querySelectorAll(".ml-cart-count").forEach(function (el) {
        el.textContent = count;
    });

});
