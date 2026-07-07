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

        <div class="ml-admin-stat-card">
            <div class="ml-admin-stat-icon green">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <p>Total Products</p>
                <h3>128</h3>
            </div>
        </div>

        <div class="ml-admin-stat-card">
            <div class="ml-admin-stat-icon lime">
                <i class="bi bi-check-circle"></i>
            </div>
            <div>
                <p>In Stock PCS</p>
                <h3>1,248</h3>
            </div>
        </div>

        <div class="ml-admin-stat-card">
            <div class="ml-admin-stat-icon red">
                <i class="bi bi-exclamation-circle"></i>
            </div>
            <div>
                <p>Out of Stock</p>
                <h3>14</h3>
            </div>
        </div>

        <div class="ml-admin-stat-card">
            <div class="ml-admin-stat-icon blue">
                <i class="bi bi-cart-check"></i>
            </div>
            <div>
                <p>Total Orders</p>
                <h3>342</h3>
            </div>
        </div>

    </div>

    <!-- Dashboard Bottom -->

    <div class="row g-4 mt-2">

        <!-- Low Stock Products -->

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

                    <div class="ml-low-stock-item">
                        <div>
                            <h6>CBD Oil 30ml</h6>
                            <small>SKU : ML1025</small>
                        </div>

                        <span class="badge bg-danger">
                            3 PCS
                        </span>
                    </div>

                    <div class="ml-low-stock-item">
                        <div>
                            <h6>CBD Gummies</h6>
                            <small>SKU : ML1026</small>
                        </div>

                        <span class="badge bg-warning text-dark">
                            7 PCS
                        </span>
                    </div>

                    <div class="ml-low-stock-item">
                        <div>
                            <h6>THC Capsules</h6>
                            <small>SKU : ML1027</small>
                        </div>

                        <span class="badge bg-danger">
                            2 PCS
                        </span>
                    </div>

                    <div class="ml-low-stock-item">
                        <div>
                            <h6>CBD Vape</h6>
                            <small>SKU : ML1028</small>
                        </div>

                        <span class="badge bg-warning text-dark">
                            5 PCS
                        </span>
                    </div>

                </div>

            </div>

        </div>

        <!-- Recent Orders -->

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
                                <td>#ML1001</td>
                                <td>John Smith</td>
                                <td>$189.00</td>
                                <td>
                                    <span class="badge bg-success">
                                        Completed
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>#ML1002</td>
                                <td>Sarah Lee</td>
                                <td>$249.00</td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>#ML1003</td>
                                <td>Michael Brown</td>
                                <td>$98.00</td>
                                <td>
                                    <span class="badge bg-primary">
                                        Processing
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>#ML1004</td>
                                <td>Emma Wilson</td>
                                <td>$321.00</td>
                                <td>
                                    <span class="badge bg-success">
                                        Completed
                                    </span>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection