@extends('admin.layouts.app')

@section('title', 'All Products')

@section('content')

    <div class="ml-admin-page-head">
        <div>
            <h1>All Products</h1>
            <p>Manage MediLeaf store products, stock status and pricing.</p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="ml-admin-add-btn">
            <i class="bi bi-plus-circle"></i>
            Add Product
        </a>
    </div>

    <div class="ml-admin-card">

        <div class="ml-admin-card-head">
            <h4>
                <i class="bi bi-box-seam"></i>
                Product List
            </h4>

            <div class="ml-admin-table-filter">
                <input type="text" placeholder="Search product...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle ml-admin-product-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock PCS</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <div class="ml-product-cell">
                                <div class="ml-product-thumb">
                                    <i class="bi bi-capsule-pill"></i>
                                </div>
                                <div>
                                    <h6>Mighty+ Medic Vaporiser</h6>
                                    <small>SKU: ML-VAP-001</small>
                                </div>
                            </div>
                        </td>

                        <td>Vaporisers</td>
                        <td>A$485.00</td>
                        <td>24 PCS</td>
                        <td><span class="badge bg-success">In Stock</span></td>

                        <td class="text-end">
                            <button class="ml-action-btn edit"><i class="bi bi-pencil"></i></button>
                            <button class="ml-action-btn delete"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="ml-product-cell">
                                <div class="ml-product-thumb">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div>
                                    <h6>Volcano Hybrid Vaporiser</h6>
                                    <small>SKU: ML-VAP-002</small>
                                </div>
                            </div>
                        </td>

                        <td>Vaporisers</td>
                        <td>A$699.00</td>
                        <td>0 PCS</td>
                        <td><span class="badge bg-danger">Out of Stock</span></td>

                        <td class="text-end">
                            <button class="ml-action-btn edit"><i class="bi bi-pencil"></i></button>
                            <button class="ml-action-btn delete"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

@endsection