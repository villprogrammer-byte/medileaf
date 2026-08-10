@extends('admin.layouts.app')

@section('title', 'All Products')

@section('content')

    @if (session('success'))
        <div class="ml-admin-success-alert">
            <div class="ml-admin-success-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="ml-admin-success-content">
                <strong>Success</strong>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif


    <div class="ml-admin-page-head">

        <div>
            <h1>All Products</h1>
            <p>
                Manage MediLeaf products, colour variants, stock and SEO visibility.
            </p>
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


            <form method="GET" class="ml-admin-table-filter">

                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search product, SKU, brand, category or colour..." autocomplete="off">

            </form>

        </div>


        <div class="table-responsive">

            <table class="table align-middle ml-admin-product-table">

                <thead>

                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Colours</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>SEO</th>
                        <th>Updated</th>
                        <th class="text-end">Action</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse ($products as $product)

                        @php
                            $isSeoReady =
                                filled($product->slug) &&
                                filled($product->seo_title) &&
                                filled($product->meta_description);

                            $publicUrl = $product->public_url;
                        @endphp


                        <tr>

                            {{-- =================================================
                            PRODUCT
                            ================================================== --}}
                            <td>

                                <div class="ml-product-cell">

                                    <div class="ml-product-thumb">

                                        @if ($product->featured_image)

                                            <img src="{{ asset('storage/' . $product->featured_image) }}"
                                                alt="{{ $product->featured_image_alt }}" loading="lazy">

                                        @else

                                            <i class="bi bi-box-seam"></i>

                                        @endif

                                    </div>


                                    <div>

                                        <h6>
                                            {{ $product->name }}
                                        </h6>

                                        <small class="d-block">
                                            SKU:
                                            {{ $product->sku ?: 'Not added' }}
                                        </small>

                                        <small class="d-block">
                                            Slug:
                                            {{ $product->slug ?: 'Not generated' }}
                                        </small>

                                    </div>

                                </div>

                            </td>


                            {{-- =================================================
                            CATEGORY
                            ================================================== --}}
                            <td>

                                {{ $product->category ?: 'Uncategorised' }}

                            </td>


                            {{-- =================================================
                            PRICE
                            ================================================== --}}
                            <td>

                                @if (
                                        $product->sale_price &&
                                        $product->sale_price < $product->regular_price
                                    )

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


                            {{-- =================================================
                            COLOURS
                            ================================================== --}}
                            <td>

                                {{ $product->variants_count }}
                                {{ $product->variants_count === 1 ? 'Colour' : 'Colours' }}

                            </td>


                            {{-- =================================================
                            STOCK
                            ================================================== --}}
                            <td>

                                {{ $product->stock_quantity }} PCS

                            </td>


                            {{-- =================================================
                            STOCK STATUS
                            ================================================== --}}
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


                                @if ($product->status !== 'published')

                                    <span class="badge bg-secondary d-block mt-2">
                                        {{ ucfirst($product->status) }}
                                    </span>

                                @endif

                            </td>


                            {{-- =================================================
                            SEO
                            ================================================== --}}
                            <td>

                                <div class="ml-product-seo-status">

                                    @if ($product->is_indexable)

                                        <span class="ml-seo-badge index">
                                            <i class="bi bi-search"></i>
                                            Index
                                        </span>

                                    @else

                                        <span class="ml-seo-badge noindex">
                                            <i class="bi bi-eye-slash"></i>
                                            Noindex
                                        </span>

                                    @endif


                                    @if ($isSeoReady)

                                        <span class="ml-seo-badge ready">
                                            <i class="bi bi-check-circle"></i>
                                            SEO Ready
                                        </span>

                                    @else

                                        <span class="ml-seo-badge incomplete">
                                            <i class="bi bi-exclamation-circle"></i>
                                            SEO Incomplete
                                        </span>

                                    @endif

                                </div>

                            </td>


                            {{-- =================================================
                            UPDATED
                            ================================================== --}}
                            <td>

                                <span class="ml-product-updated-date">
                                    {{ $product->updated_at?->format('d M Y') }}
                                </span>

                                <small class="d-block text-muted">
                                    {{ $product->updated_at?->format('h:i A') }}
                                </small>

                            </td>


                            {{-- =================================================
                            ACTIONS
                            ================================================== --}}
                            <td class="text-end">

                                {{-- Admin View --}}
                                <a href="{{ route('admin.products.show', $product) }}" class="ml-action-btn view"
                                    title="View Product Details">
                                    <i class="bi bi-eye"></i>
                                </a>


                                {{-- Public Product --}}
                                @if ($product->status === 'published')

                                    <a href="{{ $publicUrl }}" target="_blank" rel="noopener" class="ml-action-btn live"
                                        title="View Live Product">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>

                                @endif


                                {{-- Edit --}}
                                <a href="{{ route('admin.products.edit', $product) }}" class="ml-action-btn edit"
                                    title="Edit Product">
                                    <i class="bi bi-pencil"></i>
                                </a>


                                {{-- Delete --}}
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this product? This will also remove its variants and gallery images.');">

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

                            <td colspan="9" class="text-center py-5">

                                <div class="ml-empty-products">

                                    <i class="bi bi-box-seam"></i>

                                    <h5>
                                        No products found
                                    </h5>

                                    <p>
                                        Add your first MediLeaf store product or try another search.
                                    </p>


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