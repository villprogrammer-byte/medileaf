@extends('layouts.app')

@section('title', 'MediLeaf Store')

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
                        <input type="text" id="mlShopSearch" placeholder="Search products" autocomplete="off">
                        <i class="bi bi-search"></i>
                    </div>

                    <div class="ml-shop-v2-sort">
                        <label for="mlShopSortTrigger">Sort by</label>

                        <div class="ml-custom-select" id="mlShopSortSelect">
                            <button type="button" class="ml-custom-select-trigger" id="mlShopSortTrigger"
                                aria-expanded="false">
                                <span id="mlShopSortLabel">Default sorting</span>
                                <i class="bi bi-chevron-down"></i>
                            </button>

                            <div class="ml-custom-options">
                                <button type="button" class="ml-custom-option ml-sort-option active" data-value="default">
                                    <span>Default sorting</span>
                                </button>

                                <button type="button" class="ml-custom-option ml-sort-option" data-value="latest">
                                    <span>Latest products</span>
                                </button>

                                <button type="button" class="ml-custom-option ml-sort-option" data-value="low">
                                    <span>Price low to high</span>
                                </button>

                                <button type="button" class="ml-custom-option ml-sort-option" data-value="high">
                                    <span>Price high to low</span>
                                </button>

                                <button type="button" class="ml-custom-option ml-sort-option" data-value="az">
                                    <span>Name A to Z</span>
                                </button>
                            </div>
                        </div>

                        <select id="mlShopSort" style="display: none;">
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

                        $categorySlug = \Illuminate\Support\Str::slug(
                            $product->category ?: 'uncategorised'
                        );

                        $productImage = $product->featured_image
                            ? asset('storage/' . $product->featured_image)
                            : asset('img/product-placeholder.webp');
                    @endphp

                    <div class="col-sm-6 col-lg-4 col-xl-3 ml-shop-product-item" data-id="{{ $product->id }}"
                        data-category="{{ $categorySlug }}" data-name="{{ strtolower($product->name) }}"
                        data-price="{{ $finalPrice }}">

                        <div class="ml-shop-v2-card">

                            <div class="ml-shop-v2-img">
                                @if($product->stock_status === 'out_of_stock')
                                    <span class="ml-shop-v2-tag sold">Sold Out</span>
                                @elseif($product->featured)
                                    <span class="ml-shop-v2-tag">Featured</span>
                                @endif

                                <a href="{{ route('product-view', $product) }}" class="ml-shop-v2-image-link">
                                    <img src="{{ $productImage }}" alt="{{ $product->image_alt ?: $product->name }}"
                                        loading="lazy">
                                </a>
                            </div>

                            <div class="ml-shop-v2-body">
                                <span class="ml-shop-v2-category">
                                    {{ $product->category ?: 'Uncategorised' }}
                                </span>

                                <h3>
                                    <a href="{{ route('product-view', $product) }}" class="ml-shop-v2-title-link">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <div class="ml-shop-v2-price-wrap">
                                    @if($product->sale_price && $product->sale_price < $product->regular_price)
                                        <div class="ml-shop-v2-old-price">
                                            A${{ number_format($product->regular_price, 2) }}
                                        </div>

                                        <div class="ml-shop-v2-price">
                                            A${{ number_format($product->sale_price, 2) }}
                                        </div>
                                    @else
                                        <div class="ml-shop-v2-price">
                                            A${{ number_format($product->regular_price, 2) }}
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ route('product-view', $product) }}" class="product-view-btn">
                                    View Product
                                </a>

                                @if($product->stock_status === 'out_of_stock')
                                    <button type="button" class="add-to-bag-btn disabled" disabled>
                                        Sold Out
                                    </button>
                                @else
                                    <button type="button" class="add-to-bag-btn" data-product-id="{{ $product->id }}">
                                        Add to Bag
                                    </button>
                                @endif
                            </div>

                        </div>
                    </div>

                @empty
                    <div class="col-12">
                        <p class="ml-shop-no-products d-block">
                            No products are currently available.
                        </p>
                    </div>
                @endforelse
            </div>

            <p class="ml-shop-no-products" id="mlShopNoProducts">
                No products found.
            </p>

            <div class="ml-shop-v2-pagination" id="mlShopPagination"></div>

        </div>
    </section>

@endsection

@push('scripts')
@endpush