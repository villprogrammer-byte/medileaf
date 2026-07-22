@extends('layouts.app')

@section('title', 'About MediLeaf')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <!-- PRODUCT VIEW PAGE -->
    <section class="ml-product-view">
        <div class="container">

            <div class="ml-product-breadcrumb">
                <a href="{{ url('/') }}">Home</a>

                <span>/</span>

                <a href="{{ route('store') }}">Store</a>

                <span>/</span>

                <strong>{{ $product->name }}</strong>
            </div>

            <!-- Back Button -->
            <div class="ml-checkout-back-wrap mb-4">
                <button type="button" class="ml-checkout-back-btn" onclick="history.back()">

                    <i class="bi bi-arrow-left"></i>
                    Back to Store

                </button>
            </div>

            <div class="row g-5 align-items-start">

                <div class="col-lg-6">
                    <div class="ml-product-gallery">

                        <div class="ml-product-main-image" id="mlProductMainBox">
                            <span class="ml-product-badge">New</span>
                            <img id="mlProductMainImg" src="{{ asset('storage/' . $product->featured_image) }}"
                                alt="{{ $product->image_alt ?: $product->name }}">
                        </div>

                        <div class="ml-product-media-options">

                            <div class="ml-product-thumbs">

                                <button type="button" data-color="#31a050" data-bg="rgba(49,160,80,0.10)"
                                    data-image="{{ asset('storage/' . $product->featured_image) }}"> <img
                                        src="{{ asset('storage/' . $product->featured_image) }}"
                                        alt="{{ $product->image_alt ?: $product->name }}"> </button>

                                <div class="ml-product-color-select">

                                    <label class="ml-color-label">
                                        <span class="ml-color-dot" id="currentColorDot">
                                        </span>
                                        Colour
                                    </label>

                                    <div class="ml-custom-select" id="mlCustomColorSelect">

                                        <div class="ml-custom-select-trigger">

                                            <span id="mlSelectedColor">
                                                {{ $product->color_name ?? 'Default' }}
                                            </span>

                                            <i class="bi bi-chevron-down"></i>

                                        </div>

                                        <div class="ml-custom-options">

                                            <div class="ml-custom-option" data-index="0">

                                                <span class="color-circle" style="background:#31a050">
                                                </span>

                                                {{ $product->color_name ?? 'Default' }}

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ml-product-info">

                        <span class="ml-product-category">
                            {{ $product->category }}
                        </span>

                        <h1>{{ $product->name }}</h1>

                        <div class="ml-product-rating">
                            <div>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <span>4.8 rating</span>
                        </div>

                        <p class="ml-product-price">

                            @if($product->sale_price)

                                <span class="text-decoration-line-through text-muted">
                                    A${{ number_format($product->regular_price, 2) }}
                                </span>

                                <strong class="text-success ms-2">
                                    A${{ number_format($product->sale_price, 2) }}
                                </strong>

                            @else

                                <strong>
                                    A${{ number_format($product->regular_price, 2) }}
                                </strong>

                            @endif

                        </p>

                        <div class="ml-product-short">

                            <p>
                                {{ Str::words($product->short_description ?: 'No short description available for this product.', 30, '...') }}

                                <a href="javascript:void(0)" class="ml-product-desc-link" id="scrollToDescription">
                                    See Full Description
                                    <i class="bi bi-arrow-down"></i>
                                </a>
                            </p>

                        </div>

                        <div class="ml-product-purchase-box">

                            <div class="ml-product-qty">
                                <button type="button" id="qtyMinus">−</button>
                                <input type="number" id="productQty" value="1" min="1">
                                <button type="button" id="qtyPlus">+</button>
                            </div>

                            <button class="ml-product-add-btn" type="button" id="productAddToBag">
                                Add to Bag
                            </button>

                        </div>

                        <button class="ml-product-buy-btn" type="button" id="productBuyNow">
                            Buy Now
                        </button>

                        <div class="ml-product-support-note">
                            <i class="bi bi-info-circle"></i>
                            <span>
                                Product availability and suitability may depend on pharmacy guidance or prescription
                                requirements.
                            </span>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- PRODUCT DETAILS -->
    <section class="ml-product-details">
        <div class="container">
            <div class="row g-4">

                <div class="ml-product-description-box" id="productDescription">

                    <h2>Product Overview</h2>

                    @if($product->short_description)
                        <p>{!! $product->short_description !!}</p>
                    @endif

                    <h3>Product Specifications</h3>

                    <ul>
                        @if($product->sku)
                            <li><strong>SKU:</strong> {{ $product->sku }}</li>
                        @endif

                        @if($product->category)
                            <li><strong>Category:</strong> {{ $product->category }}</li>
                        @endif

                        @if($product->brand)
                            <li><strong>Brand:</strong> {{ $product->brand }}</li>
                        @endif

                        @if($product->product_type)
                            <li><strong>Product Type:</strong> {{ $product->product_type }}</li>
                        @endif

                        @if($product->weight)
                            <li><strong>Weight:</strong> {{ $product->weight }} kg</li>
                        @endif

                        @if($product->length && $product->width && $product->height)
                            <li>
                                <strong>Dimensions:</strong>
                                {{ $product->length }}
                                ×
                                {{ $product->width }}
                                ×
                                {{ $product->height }} cm
                            </li>
                        @endif

                        <li>
                            <strong>Stock:</strong>
                            {{ $product->stock_quantity }} PCS
                        </li>

                        <li>
                            <strong>Status:</strong>

                            @if($product->stock_status == 'in_stock')
                                In Stock
                            @elseif($product->stock_status == 'low_stock')
                                Low Stock
                            @else
                                Out of Stock
                            @endif
                        </li>

                        @if($product->prescription_required)
                            <li>
                                <strong>Prescription:</strong>
                                Required
                            </li>
                        @endif

                    </ul>

                    <h3>Full Description</h3>

                    <div class="ml-product-description">
                        {!! $product->description !!}
                    </div>

                    <h3>Important Information</h3>

                    <p>
                        Product availability may vary. Please consult our healthcare
                        team before purchasing products that require a prescription.
                    </p>

                </div>

            </div>
        </div>
    </section>


    <!-- RELATED PRODUCTS -->
    <section class="ml-related-products">
        <div class="container">

            <div class="ml-related-head">
                <span>Explore More</span>
                <h2>Related Products</h2>
                <p>Discover more pharmacy supported products from the MediLeaf range.</p>
            </div>

            <div class="row g-4">

                @forelse($relatedProducts as $item)

                    <div class="col-md-6 col-xl-3">

                        <div class="ml-shop-v2-card">

                            <div class="ml-shop-v2-img">

                                @if($item->featured)

                                    <span class="ml-shop-v2-tag">
                                        Featured
                                    </span>

                                @endif

                                <img src="{{ asset('storage/' . $item->featured_image) }}"
                                    alt="{{ $item->image_alt ?: $item->name }}">

                            </div>

                            <div class="ml-shop-v2-body">

                                <span>
                                    {{ $item->category }}
                                </span>

                                <h3>
                                    {{ $item->name }}
                                </h3>

                                <p>

                                    @if($item->sale_price)

                                        <span class="text-decoration-line-through text-muted">
                                            A${{ number_format($item->regular_price, 2) }}
                                        </span>

                                        <strong class="text-success">
                                            A${{ number_format($item->sale_price, 2) }}
                                        </strong>

                                    @else

                                        A${{ number_format($item->regular_price, 2) }}

                                    @endif

                                </p>

                                <a href="{{ route('product-view', $item) }}" class="product-view-btn mb-2">
                                    View Product
                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12 text-center">
                        No related products found.
                    </div>

                @endforelse

            </div>

        </div>
    </section>

    <script>
        window.mlProductConfig = {
            id: Number({{ $product->id }}),
            name: @json($product->name),
            price: Number({{ $product->sale_price ?: $product->regular_price }}),
            image: @json(
                $product->featured_image
                ? asset('storage/' . $product->featured_image)
                : asset('img/product-placeholder.webp')
            ),
            checkoutUrl: @json(route('checkout'))
        };
    </script>

    <script src="{{ asset('js/product-view.js') }}"></script>
@endsection