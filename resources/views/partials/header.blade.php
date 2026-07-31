<header class="ml-new-header">
    <div class="container">
        <div class="ml-new-header-inner">
            <a href="{{ route('home') }}" class="ml-new-logo">
                <img src="{{ asset('img/medileaf-logo.webp') }}" alt="MediLeaf Logo">
            </a>
            <nav class="ml-new-nav" id="mlNewNav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                <a href="{{ route('clinic') }}" class="{{ request()->routeIs('clinic') ? 'active' : '' }}">Clinic</a>
                <a href="{{ route('pharmacy') }}"
                    class="{{ request()->routeIs('pharmacy') ? 'active' : '' }}">Pharmacy</a>
                <a href="{{ route('store') }}" class="{{ request()->routeIs('store') ? 'active' : '' }}">Store</a>
                <a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') ? 'active' : '' }}">Blog</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                <a href="{{ route('cart') }}"
                    class="ml-cart-btn ml-cart-btn d-none d-md-flex {{ request()->routeIs('cart') ? 'active' : '' }}"
                    aria-label="Shopping Bag">
                    <i class="bi bi-bag-fill"></i>
                    <span class="ml-cart-count">0</span>
                </a>
            </nav>

            <div class="ml-new-actions">
                @include('partials.account-menu')
                <button class="ml-new-menu-btn" id="mlNewMenuBtn" type="button">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

        </div>
    </div>
</header>