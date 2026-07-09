<aside class="ml-admin-sidebar">

    <!-- Logo -->
    <div class="ml-admin-logo">

        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('img/medileaf-white-logo.webp') }}" alt="MediLeaf">
        </a>

    </div>

    <!-- Navigation -->

    <nav class="ml-admin-nav">

        <span class="ml-admin-nav-title">
            MAIN MENU
        </span>

        <a href="{{ route('admin.dashboard') }}" class="active">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.products.index') }}">
            <i class="bi bi-capsule-pill"></i>
            <span>Products</span>
        </a>

        <a href="{{ route('admin.products.create') }}">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Add Product</span>
        </a>

        <a href="{{ route('admin.orders.pending') }}">
            <i class="bi bi-clock-history"></i>
            <span>Pending Orders</span>
        </a>

        <a href="{{ route('admin.orders.completed') }}">
            <i class="bi bi-bag-check-fill"></i>
            <span>Completed Orders</span>
        </a>

        <a href="{{ route('admin.settings') }}">
            <i class="bi bi-gear-fill"></i>
            <span>Settings</span>
        </a>

    </nav>

    <!-- Bottom -->

    <div class="ml-admin-sidebar-bottom">

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf

            <button type="submit" class="ml-admin-logout-btn">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>

    </div>

</aside>