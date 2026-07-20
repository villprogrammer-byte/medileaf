<header class="ml-admin-header">

    <button class="ml-admin-menu-toggle" type="button" id="mlAdminMenuToggle">
        <i class="bi bi-list"></i>
    </button>

    <form class="ml-admin-search" action="{{ route('admin.products.index') }}" method="GET">

        <i class="bi bi-search"></i>

        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products...">

    </form>

    <div class="ml-admin-header-actions">

        <button class="ml-admin-icon-btn" type="button">
            <i class="bi bi-bell"></i>
            <span></span>
        </button>

        <div class="ml-admin-profile">
            <div class="ml-admin-avatar">
                <i class="bi bi-person"></i>
            </div>

            <div>
                <h6>Admin</h6>
                <p>MediLeaf Manager</p>
            </div>
        </div>

    </div>

</header>