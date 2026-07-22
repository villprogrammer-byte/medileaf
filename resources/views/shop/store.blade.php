@extends('layouts.app')

@section('title', 'About MediLeaf')

@section('content')
    <section class="ml-shop-v2-section">
        <div class="container">

            <div class="ml-product-breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <a href="{{ route('store') }}">Store</a>
            </div>

            <div class="ml-shop-v2-filterbar">
                <div>
                    <span class="ml-shop-v2-eyebrow">All Products</span>
                    <h2>Browse Our Collection</h2>
                </div>

                <div class="ml-shop-v2-tools">
                    <div class="ml-shop-v2-search">
                        <input type="text" id="mlShopSearch" placeholder="Search products">
                        <i class="bi bi-search"></i>
                    </div>

                    <div class="ml-shop-v2-sort">
                        <label for="mlShopSort">Sort by</label>
                        <select id="mlShopSort">
                            <option value="default">Default sorting</option>
                            <option value="latest">Latest products</option>
                            <option value="low">Price low to high</option>
                            <option value="high">Price high to low</option>
                            <option value="az">Name A to Z</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="ml-shop-v2-category-scroll">
                <a href="#" class="active" data-category="all">All</a>
                <a href="#" data-category="vaporisers">Vaporisers</a>
                <a href="#" data-category="health">Health</a>
                <a href="#" data-category="supplements">Supplements</a>
                <a href="#" data-category="personal-care">Personal Care</a>
                <a href="#" data-category="accessories">Accessories</a>
            </div>

            <div class="row g-4" id="mlShopGrid">
                @forelse($products as $product)
                    @php
                        $finalPrice = $product->sale_price ?: $product->regular_price;
                        $categorySlug = \Illuminate\Support\Str::slug($product->category ?: 'uncategorised');
                        $productImage = $product->featured_image
                            ? asset('storage/' . $product->featured_image)
                            : asset('img/product-placeholder.webp');
                    @endphp

                    <div class="col-md-6 col-xl-3 ml-shop-product-item" data-id="{{ $product->id }}"
                        data-category="{{ $categorySlug }}" data-name="{{ $product->name }}" data-price="{{ $finalPrice }}">

                        <div class="ml-shop-v2-card">
                            <div class="ml-shop-v2-img">
                                @if($product->stock_status === 'out_of_stock')
                                    <span class="ml-shop-v2-tag sold">Sold Out</span>
                                @elseif($product->featured)
                                    <span class="ml-shop-v2-tag">Featured</span>
                                @endif

                                <img src="{{ $productImage }}" alt="{{ $product->image_alt ?: $product->name }}">

                                <div class="ml-shop-v2-body">
                                    <span>{{ $product->category ?: 'Uncategorised' }}</span>
                                    <h3>{{ $product->name }}</h3>

                                    <p>
                                        @if($product->sale_price)
                                            <span class="text-decoration-line-through me-2">
                                                A${{ number_format($product->regular_price, 2) }}
                                            </span>
                                            <strong>A${{ number_format($product->sale_price, 2) }}</strong>
                                        @else
                                            A${{ number_format($product->regular_price, 2) }}
                                        @endif
                                    </p>

                                    <a href="{{ route('product-view', $product) }}" class="product-view-btn">
                                        View Product
                                    </a>

                                    @if($product->stock_status === 'out_of_stock')
                                        <button type="button" class="disabled" disabled>Sold Out</button>
                                    @elseif($product->prescription_required)
                                        <a href="{{ route('upload.prescription') }}" class="add-to-bag-btn">
                                            Upload Prescription
                                        </a>
                                    @else
                                        <button type="button" class="add-to-bag-btn mt-2">Add to Bag</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="ml-shop-no-products d-block">No products are currently available.</p>
                    </div>
                @endforelse
            </div>

            <p class="ml-shop-no-products" id="mlShopNoProducts">No products found.</p>
            <div class="ml-shop-v2-pagination" id="mlShopPagination"></div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('js/store.js') }}"></script>
@endpush