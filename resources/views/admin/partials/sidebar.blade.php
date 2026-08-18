<aside class="ml-admin-sidebar">

    <div class="ml-admin-logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('img/medileaf-white-logo.webp') }}" alt="MediLeaf">
        </a>
    </div>

    <nav class="ml-admin-nav">

        <span class="ml-admin-nav-title">
            MAIN MENU
        </span>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.products.index') }}"
            class="{{ request()->routeIs('admin.products.index', 'admin.products.show', 'admin.products.edit') ? 'active' : '' }}">
            <i class="bi bi-capsule-pill"></i>
            <span>Products</span>
        </a>

        <a href="{{ route('admin.products.create') }}"
            class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Add Product</span>
        </a>

        <a href="{{ route('admin.orders.pending') }}"
            class="{{ request()->routeIs('admin.orders.pending') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>Pending Orders</span>
        </a>

        <a href="{{ route('admin.orders.completed') }}"
            class="{{ request()->routeIs('admin.orders.completed') ? 'active' : '' }}">
            <i class="bi bi-bag-check-fill"></i>
            <span>Completed Orders</span>
        </a>

        <div class="ml-admin-nav-group">

            <button class="ml-admin-nav-parent {{ request()->is('admin/blog*') ? 'active' : '' }}" type="button"
                data-bs-toggle="collapse" data-bs-target="#adminBlogMenu"
                aria-expanded="{{ request()->is('admin/blog*') ? 'true' : 'false' }}" aria-controls="adminBlogMenu">

                <i class="bi bi-journal-text"></i>
                <span>Blog</span>
                <i class="bi bi-arrow-down-circle-fill ml-admin-nav-arrow"></i>

            </button>

            <div id="adminBlogMenu" class="collapse {{ request()->is('admin/blog*') ? 'show' : '' }} ml-admin-submenu">

                <a href="{{ url('/admin/blog') }}" class="{{ request()->is('admin/blog') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>All Posts</span>
                </a>

                <a href="{{ url('/admin/blog/create') }}"
                    class="{{ request()->is('admin/blog/create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span>Add New Post</span>
                </a>

                <a href="{{ url('/admin/blog/categories') }}"
                    class="{{ request()->is('admin/blog/categories*') ? 'active' : '' }}">
                    <i class="bi bi-folder2-open"></i>
                    <span>Categories</span>
                </a>

                <a href="{{ url('/admin/blog/tags') }}" class="{{ request()->is('admin/blog/tags*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span>Tags</span>
                </a>

                <a href="{{ url('/admin/blog/authors') }}"
                    class="{{ request()->is('admin/blog/authors*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Authors / Reviewers</span>
                </a>

            </div>

        </div>

        <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i>
            <span>Settings</span>
        </a>

    </nav>

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