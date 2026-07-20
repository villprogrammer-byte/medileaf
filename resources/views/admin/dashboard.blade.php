@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="ml-admin-page-head">
        <div>
            <h1>Dashboard</h1>
            <p>Welcome back! Here is your MediLeaf store overview.</p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="ml-admin-add-btn">
            <i class="bi bi-plus-circle"></i>
            Add Product
        </a>
    </div>

    <div class="ml-admin-stats-grid">

        {{-- Total Products --}}
        <div class="ml-admin-stat-card">
            <div class="ml-admin-stat-icon green">
                <i class="bi bi-box-seam"></i>
            </div>

            <div>
                <p>Total Products</p>
                <h3>{{ number_format($totalProducts ?? 0) }}</h3>
            </div>
        </div>

        {{-- In Stock PCS --}}
        <div class="ml-admin-stat-card">
            <div class="ml-admin-stat-icon lime">
                <i class="bi bi-check-circle"></i>
            </div>

            <div>
                <p>In Stock PCS</p>
                <h3>{{ number_format($inStockPcs ?? 0) }}</h3>
            </div>
        </div>

        {{-- Out of Stock --}}
        <div class="ml-admin-stat-card">
            <div class="ml-admin-stat-icon red">
                <i class="bi bi-exclamation-circle"></i>
            </div>

            <div>
                <p>Out of Stock</p>
                <h3>{{ number_format($outOfStockProducts ?? 0) }}</h3>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="ml-admin-stat-card">
            <div class="ml-admin-stat-icon blue">
                <i class="bi bi-cart-check"></i>
            </div>

            <div>
                <p>Total Orders</p>
                <h3>0</h3>
            </div>
        </div>

    </div>

    {{-- Dashboard Bottom --}}
    <div class="row g-4 mt-2">

        {{-- Low Stock Products --}}
        <div class="col-xl-5">

            <div class="ml-admin-card">

                <div class="ml-admin-card-head">

                    <h4>
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        Low Stock Products
                    </h4>

                    <a href="{{ route('admin.products.index') }}">
                        View All
                    </a>

                </div>

                <div class="ml-low-stock-list">

                    @forelse($lowStockProducts ?? [] as $product)

                        <div class="ml-low-stock-item">

                            <div>
                                <h6>
                                    {{ $product->name ?? $product->product_name ?? 'Product' }}
                                </h6>

                                <small>
                                    SKU:
                                    {{ !empty($product->sku) ? $product->sku : 'N/A' }}
                                </small>
                            </div>

                            @php
                                $quantity = (int) ($product->stock_quantity ?? 0);
                            @endphp

                            <span class="badge {{ $quantity <= 3 ? 'bg-danger' : 'bg-warning text-dark' }}">
                                {{ $quantity }} PCS
                            </span>

                        </div>

                    @empty

                        <div class="text-center py-4">

                            <i class="bi bi-check-circle-fill text-success fs-3"></i>

                            <p class="mb-0 mt-2">
                                No low-stock products found.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

        {{-- Recent Orders --}}
        <div class="col-xl-7">

            <div class="ml-admin-card">

                <div class="ml-admin-card-head">

                    <h4>
                        <i class="bi bi-cart-check-fill"></i>
                        Recent Orders
                    </h4>

                    <a href="{{ route('admin.orders.pending') }}">
                        View All
                    </a>

                </div>

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td colspan="4" class="text-center py-4">

                                    <i class="bi bi-cart-x fs-3 text-muted"></i>

                                    <p class="mb-0 mt-2 text-muted">
                                        No orders available yet.
                                    </p>

                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection