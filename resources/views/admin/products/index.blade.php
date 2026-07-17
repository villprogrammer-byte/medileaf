@extends('admin.layouts.app')

@section('title', 'All Products')

@section('content')

    @if (session('success'))
        <div class="ml-admin-success-alert" id="mlAdminSuccessAlert">
            <div class="ml-admin-success-icon">
                <i class="bi bi-check-lg"></i>
            </div>

            <div class="ml-admin-success-content">
                <strong>Success</strong>
                <span>{{ session('success') }}</span>
            </div>

            <button type="button" class="ml-admin-success-close" id="mlAdminSuccessClose">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

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
                <input type="text" id="productSearch" placeholder="Search product...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle ml-admin-product-table" id="productTable">
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
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <div class="ml-product-cell">
                                    <div class="ml-product-thumb">

                                        @if ($product->featured_image)
                                            <img src="{{ asset('storage/' . $product->featured_image) }}"
                                                alt="{{ $product->image_alt ?: $product->name }}">
                                        @else
                                            <i class="bi bi-box-seam"></i>
                                        @endif

                                    </div>

                                    <div>
                                        <h6>{{ $product->name }}</h6>

                                        <small>
                                            SKU: {{ $product->sku ?: 'Not added' }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                {{ $product->category ?: 'Uncategorised' }}
                            </td>

                            <td>
                                @if ($product->sale_price)
                                    <strong>
                                        A${{ number_format($product->sale_price, 2) }}
                                    </strong>

                                    <small class="d-block text-muted text-decoration-line-through">
                                        A${{ number_format($product->regular_price, 2) }}
                                    </small>
                                @else
                                    <strong>
                                        A${{ number_format($product->regular_price, 2) }}
                                    </strong>
                                @endif
                            </td>

                            <td>
                                {{ $product->stock_quantity }} PCS
                            </td>

                            <td>
                                @if ($product->stock_status === 'in_stock')
                                    <span class="badge bg-success">
                                        In Stock
                                    </span>
                                @elseif ($product->stock_status === 'low_stock')
                                    <span class="badge bg-warning text-dark">
                                        Low Stock
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Out of Stock
                                    </span>
                                @endif
                            </td>

                            <td class="text-end">

                                {{-- View Product --}}
                                <a href="{{ route('admin.products.show', $product) }}" class="ml-action-btn view"
                                    title="View Product">
                                    <i class="bi bi-eye"></i>
                                </a>

                                {{-- Edit Product --}}
                                <a href="{{ route('admin.products.edit', $product) }}" class="ml-action-btn edit"
                                    title="Edit Product">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                {{-- Delete Product --}}
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="ml-action-btn delete" title="Delete Product">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="ml-empty-products">
                                    <i class="bi bi-box-seam"></i>

                                    <h5>No products found</h5>

                                    <p>Add your first product to get started.</p>

                                    <a href="{{ route('admin.products.create') }}" class="ml-admin-add-btn">
                                        <i class="bi bi-plus-circle"></i>
                                        Add Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif

    </div>

@endsection