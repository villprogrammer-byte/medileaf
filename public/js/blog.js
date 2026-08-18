
document.addEventListener('DOMContentLoaded', function () {
    const cartDrawer = document.getElementById('mlCartDrawer');
    const cartOverlay = document.getElementById('mlCartOverlay');

    if (cartDrawer) {
        cartDrawer.classList.remove('active');
    }

    if (cartOverlay) {
        cartOverlay.classList.remove('active');
    }

    document.querySelectorAll('#mlCartOpen, .ml-cart-btn').forEach(function (button) {
        button.classList.remove('active');
    });
});