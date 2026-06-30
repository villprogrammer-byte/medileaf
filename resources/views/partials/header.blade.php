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

                <div class="ml-auth-switch ml-mobile-switch">
                    <button type="button" class="ml-auth-tab active" data-target="user">
                        <i class="bi bi-person"></i>
                        User Login
                    </button>

                    <button type="button" class="ml-auth-tab" data-target="admin">
                        <i class="bi bi-person-bounding-box"></i>
                        Admin Login
                    </button>

                    <span class="ml-auth-switch-bg"></span>
                </div>
            </nav>

            <div class="ml-new-actions">
                <div class="ml-auth-switch ml-desktop-switch">
                    <button type="button" class="ml-auth-tab active" data-target="user">
                        <i class="bi bi-person"></i>
                        User Login
                    </button>

                    <button type="button" class="ml-auth-tab" data-target="admin">
                        <i class="bi bi-person-bounding-box"></i>
                        Admin Login
                    </button>

                    <span class="ml-auth-switch-bg"></span>
                </div>
                <button class="ml-new-menu-btn" id="mlNewMenuBtn" type="button">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

        </div>
    </div>
</header>