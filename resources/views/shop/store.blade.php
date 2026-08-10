@extends('layouts.app')
@section('title', 'MediLeaf Store')
@section('meta_description', 'Browse MediLeaf products, medical devices, accessories and healthcare products available across Australia.')

@section('content')

    <section class="ml-shop-v2-section">

        <div class="container">

            {{-- =========================================================
            BREADCRUMB
            ========================================================== --}}
            <div class="ml-product-breadcrumb">

                <a href="{{ route('home') }}">
                    Home
                </a>

                <span>/</span>

                <strong>
                    Store
                </strong>

            </div>


            {{-- =========================================================
            FILTER BAR
            ========================================================== --}}
            <div class="ml-shop-v2-filterbar">

                <div>

                    <span class="ml-shop-v2-eyebrow">
                        All Products
                    </span>

                    <h2>
                        Browse Our Collection
                    </h2>

                </div>


                <div class="ml-shop-v2-tools">

                    {{-- Search --}}
                    <div class="ml-shop-v2-search">

                        <input type="text" id="mlShopSearch" placeholder="Search products" autocomplete="off">

                        <i class="bi bi-search"></i>

                    </div>


                    {{-- Sort --}}
                    <div class="ml-shop-v2-sort">

                        <label for="mlShopSortTrigger">
                            Sort by
                        </label>


                        <div class="ml-custom-select" id="mlShopSortSelect">

                            <button type="button" class="ml-custom-select-trigger" id="mlShopSortTrigger"
                                aria-expanded="false">

                                <span id="mlShopSortLabel">
                                    Default sorting
                                </span>

                                <i class="bi bi-chevron-down"></i>

                            </button>


                            <div class="ml-custom-options">

                                <button type="button" class="ml-custom-option ml-sort-option active" data-value="default">
                                    <span>
                                        Default sorting
                                    </span>
                                </button>


                                <button type="button" class="ml-custom-option ml-sort-option" data-value="latest">
                                    <span>
                                        Latest products
                                    </span>
                                </button>


                                <button type="button" class="ml-custom-option ml-sort-option" data-value="low">
                                    <span>
                                        Price low to high
                                    </span>
                                </button>


                                <button type="button" class="ml-custom-option ml-sort-option" data-value="high">
                                    <span>
                                        Price high to low
                                    </span>
                                </button>


                                <button type="button" class="ml-custom-option ml-sort-option" data-value="az">
                                    <span>
                                        Name A to Z
                                    </span>
                                </button>

                            </div>

                        </div>


                        {{-- Native hidden select --}}
                        <select id="mlShopSort" style="display:none;" aria-hidden="true">

                            <option value="default">
                                Default sorting
                            </option>

                            <option value="latest">
                                Latest products
                            </option>

                            <option value="low">
                                Price low to high
                            </option>

                            <option value="high">
                                Price high to low
                            </option>

                            <option value="az">
                                Name A to Z
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- =========================================================
            CATEGORY FILTER
            ========================================================== --}}
            <div class="ml-shop-v2-category-scroll">

                <a href="#" class="active" data-category="all">
                    All
                </a>


                <a href="#" data-category="vaporisers">
                    Vaporisers
                </a>


                <a href="#" data-category="wellness-products">
                    Wellness Products
                </a>


                <a href="#" data-category="pharmacy-support">
                    Pharmacy Support
                </a>


                <a href="#" data-category="accessories">
                    Accessories
                </a>

            </div>


            {{-- =========================================================
            PRODUCT GRID
            ========================================================== --}}
            <div class="row g-4" id="mlShopGrid">

                @forelse ($products as $product)

                    @php

                        $finalPrice = $product->sale_price
                            ?: $product->regular_price;

                        $categorySlug = $product->category_slug;

                        $productImage = $product->featured_image
                            ? asset('storage/' . $product->featured_image)
                            : asset('img/product-placeholder.webp');

                        $productUrl = $product->public_url;

                    @endphp


                    <div class="col-sm-6 col-lg-4 col-xl-3 ml-shop-product-item" data-id="{{ $product->id }}"
                        data-category="{{ $categorySlug }}" data-name="{{ strtolower($product->name) }}"
                        data-price="{{ $finalPrice }}">

                        <div class="ml-shop-v2-card">


                            {{-- =================================================
                            PRODUCT IMAGE
                            ================================================== --}}
                            <div class="ml-shop-v2-img">

                                @if ($product->stock_status === 'out_of_stock')

                                    <span class="ml-shop-v2-tag sold">
                                        Sold Out
                                    </span>

                                @elseif ($product->featured)

                                    <span class="ml-shop-v2-tag">
                                        Featured
                                    </span>

                                @endif


                                <a href="{{ $productUrl }}" class="ml-shop-v2-image-link"
                                    aria-label="View {{ $product->name }}">

                                    <img src="{{ $productImage }}" alt="{{ $product->featured_image_alt }}" loading="lazy"
                                        width="500" height="500">

                                </a>

                            </div>


                            {{-- =================================================
                            PRODUCT BODY
                            ================================================== --}}
                            <div class="ml-shop-v2-body">


                                {{-- Category --}}
                                <span class="ml-shop-v2-category">
                                    {{ $product->category ?: 'Uncategorised' }}
                                </span>


                                {{-- Product Name --}}
                                <h3>

                                    <a href="{{ $productUrl }}" class="ml-shop-v2-title-link">
                                        {{ $product->name }}
                                    </a>

                                </h3>


                                {{-- Price --}}
                                <div class="ml-shop-v2-price-wrap">

                                    @if (
                                            $product->sale_price &&
                                            $product->sale_price < $product->regular_price
                                        )

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


                                {{-- =================================================
                                VIEW PRODUCT
                                ================================================== --}}
                                <a href="{{ $productUrl }}" class="product-view-btn">
                                    View Product
                                </a>


                                {{-- =================================================
                                ADD TO BAG
                                ================================================== --}}
                                @if ($product->stock_status === 'out_of_stock')

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

                        <div class="ml-shop-no-products d-block">

                            <i class="bi bi-box-seam" style="font-size:42px;"></i>

                            <p class="mt-3 mb-0">
                                No products are currently available.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>


            {{-- =========================================================
            SEARCH/FILTER EMPTY RESULT
            ========================================================== --}}
            <p class="ml-shop-no-products" id="mlShopNoProducts">
                No products found.
            </p>


            {{-- =========================================================
            CLIENT-SIDE PAGINATION
            ========================================================== --}}
            <div class="ml-shop-v2-pagination" id="mlShopPagination"></div>

        </div>

    </section>

@endsection


@push('scripts')
@endpush