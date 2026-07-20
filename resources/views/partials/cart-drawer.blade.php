<!-- TOAST -->
<div class="ml-product-toast" id="mlProductToast">
    Product added to bag
</div>

<button class="ml-shop-cart-floating d-lg-none" id="mlCartOpen">
    <i class="bi bi-bag"></i>
    <span class="ml-cart-count">0</span>
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

        <button class="ml-shop-checkout-btn" type="button" id="checkoutBtn" data-checkout-url="{{ route('checkout') }}">
            Proceed to Checkout
        </button>

        <button class="ml-shop-clear-cart" id="mlClearCart" type="button">
            Clear Cart
        </button>
    </div>
</div>