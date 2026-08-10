@extends('layouts.app')
@section('title', $product->seo_title_value)
@section('meta_description', $product->meta_description_value)
@section('canonical_url', $product->canonical_url_value)
@section('robots', $product->robots_content)
@section('og_title', $product->og_title_value)
@section('og_description', $product->og_description_value)
@section('og_image', $product->og_image_url)
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product-view.css') }}">
@endpush

@section('content')

    @php
        use Illuminate\Support\Str;

        $variants = $product->activeVariants;

        $firstVariant = $variants->first();

        $basePrice = (float) (
            $product->sale_price
            ?: $product->regular_price
        );


        /*
        |--------------------------------------------------------------------------
        | Featured Image
        |--------------------------------------------------------------------------
        */

        $featuredImage = $product->featured_image
            ? asset('storage/' . $product->featured_image)
            : asset('img/product-placeholder.webp');


        /*
        |--------------------------------------------------------------------------
        | Product Gallery
        |--------------------------------------------------------------------------
        |
        | Featured image first.
        | Then one-by-one ProductImage records.
        |
        */

        $galleryItems = collect([
            [
                'label' => 'Main View',
                'image' => $featuredImage,
                'alt' => $product->featured_image_alt,
            ],
        ]);


        foreach ($product->images as $image) {

            $galleryItems->push([
                'label' => $image->display_name,
                'image' => $image->image_url,
                'alt' => $image->alt_text_value,
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Initial Main Image
        |--------------------------------------------------------------------------
        |
        | If first active colour has its own image, show it.
        | Otherwise use featured image.
        |
        */

        $initialImage = $firstVariant?->image
            ? asset('storage/' . $firstVariant->image)
            : $featuredImage;


        $initialImageAlt = $firstVariant?->image
            ? $firstVariant->image_alt_value
            : $product->featured_image_alt;


        /*
        |--------------------------------------------------------------------------
        | Stock
        |--------------------------------------------------------------------------
        */

        $currentStock = (int) (
            $firstVariant?->quantity
            ?? $product->stock_quantity
        );
    @endphp


    {{-- =========================================================
    PRODUCT VIEW
    ========================================================== --}}
    <section class="ml-product-view">

        <div class="container">


            {{-- =====================================================
            BREADCRUMB
            ====================================================== --}}
            <nav class="ml-product-breadcrumb" aria-label="Breadcrumb">

                <a href="{{ route('home') }}">
                    Home
                </a>

                <span>/</span>

                <a href="{{ route('store') }}">
                    Store
                </a>

                <span>/</span>

                <span>
                    {{ $product->category ?: 'Uncategorised' }}
                </span>

                <span>/</span>

                <strong>
                    {{ $product->name }}
                </strong>

            </nav>


            {{-- =====================================================
            MAIN PRODUCT LAYOUT
            ====================================================== --}}
            <div class="ml-product-layout">


                {{-- =================================================
                PRODUCT GALLERY
                ================================================== --}}
                <div class="ml-product-gallery-shell">


                    {{-- Gallery Thumbnails --}}
                    <div class="ml-product-angle-list">

                        @foreach ($galleryItems as $index => $item)

                            <button type="button" class="ml-product-angle-thumb {{ $index === 0 ? 'active' : '' }}"
                                data-gallery-image="{{ $item['image'] }}" data-gallery-label="{{ $item['label'] }}"
                                data-gallery-alt="{{ $item['alt'] }}" aria-label="Show {{ $item['label'] }}">

                                <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}"
                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}">

                                <span>
                                    {{ $item['label'] }}
                                </span>

                            </button>

                        @endforeach

                    </div>


                    {{-- Main Product Image --}}
                    <div class="ml-product-main-stage">


                        @if ($product->featured)

                            <span class="ml-product-badge">
                                Featured
                            </span>

                        @endif


                        <button type="button" class="ml-product-image-nav prev" id="mlGalleryPrev"
                            aria-label="Previous image">
                            <i class="bi bi-chevron-left"></i>
                        </button>


                        <div class="ml-product-main-image">

                            <img id="mlProductMainImg" src="{{ $initialImage }}" alt="{{ $initialImageAlt }}">

                        </div>


                        <button type="button" class="ml-product-image-nav next" id="mlGalleryNext" aria-label="Next image">
                            <i class="bi bi-chevron-right"></i>
                        </button>


                        <div class="ml-product-image-caption" id="mlGalleryCaption">
                            {{ $firstVariant?->colour_name
        ? $firstVariant->colour_name . ' Colour'
        : 'Main View'
                                }}
                        </div>

                    </div>

                </div>


                {{-- =================================================
                PRODUCT INFORMATION
                ================================================== --}}
                <div class="ml-product-info">


                    {{-- Category --}}
                    <span class="ml-product-category">
                        {{ $product->category ?: 'Product' }}
                    </span>


                    {{-- Product Name --}}
                    <h1>
                        {{ $product->name }}
                    </h1>


                    {{-- Stock --}}
                    <div class="ml-product-stock">

                        <span id="mlVariantStock" class="ml-stock-badge
                                    {{ $currentStock <= 0
        ? 'out-stock'
        : ($currentStock <= 5
            ? 'low-stock'
            : 'in-stock')
                                    }}">

                            @if ($currentStock <= 0)

                                <i class="bi bi-x-circle-fill"></i>

                                Out of Stock

                            @elseif ($currentStock <= 5)

                                <i class="bi bi-check-circle-fill"></i>

                                In Stock

                                <small class="ml-low-stock-message">
                                    Hurry, only {{ $currentStock }} left
                                </small>

                            @else

                                <i class="bi bi-check-circle-fill"></i>

                                In Stock

                            @endif

                        </span>

                    </div>


                    {{-- Price --}}
                    <p class="ml-product-price">

                        <strong id="mlVariantPrice">
                            A${{
        number_format(
            $basePrice
            + (float) (
                $firstVariant?->price_adjustment
                ?? 0
            ),
            2
        )
                                }}
                        </strong>

                    </p>


                    {{-- Short Description --}}
                    <div class="ml-product-short">

                        <p>

                            {{
        Str::words(
            $product->short_description
            ?: 'No short description available.',
            25,
            '...'
        )
                                }}

                            <a href="#fullProductDescription" class="ml-see-full-desc">
                                See full description

                                <i class="bi bi-arrow-down-circle-fill ps-2"></i>
                            </a>

                        </p>

                    </div>


                    {{-- =================================================
                    COLOUR VARIANTS
                    ================================================== --}}
                    @if ($variants->isNotEmpty())

                        <div class="ml-product-colour-control">


                            <label class="ml-color-label">
                                Colour
                            </label>


                            {{-- Selected Colour Dropdown --}}
                            <div class="ml-custom-select" id="mlProductColourSelect">

                                <button type="button" class="ml-custom-select-trigger" id="mlProductColourTrigger"
                                    aria-expanded="false">

                                    <span class="ml-selected-colour-wrap">

                                        <span class="ml-color-dot" id="mlSelectedColourDot" style="
                                                        background:
                                                        {{ $firstVariant?->colour_code ?: '#31A050' }}
                                                    "></span>


                                        <span id="mlVariantName">
                                            {{ $firstVariant?->colour_name }}
                                        </span>

                                    </span>


                                    <i class="bi bi-chevron-down"></i>

                                </button>


                                <div class="ml-custom-options">

                                    @foreach ($variants as $variant)

                                        @php

                                            $variantImage = $variant->image
                                                ? asset('storage/' . $variant->image)
                                                : $featuredImage;

                                            $variantAlt = $variant->image
                                                ? $variant->image_alt_value
                                                : $product->featured_image_alt;

                                        @endphp


                                        <button type="button"
                                            class="ml-custom-option ml-product-variant-option {{ $loop->first ? 'active' : '' }}"
                                            data-variant-id="{{ $variant->id }}" data-name="{{ $variant->colour_name }}"
                                            data-color="{{ $variant->colour_code ?: '#31A050' }}" data-sku="{{ $variant->sku }}"
                                            data-stock="{{ $variant->quantity }}"
                                            data-price="{{ $basePrice + (float) $variant->price_adjustment }}"
                                            data-image="{{ $variantImage }}" data-image-alt="{{ $variantAlt }}">

                                            <span class="color-circle" style="
                                                                background:
                                                                {{ $variant->colour_code ?: '#31A050' }}
                                                            "></span>


                                            <span>
                                                {{ $variant->colour_name }}
                                            </span>


                                            <img src="{{ $variantImage }}" alt="{{ $variantAlt }}">

                                        </button>

                                    @endforeach

                                </div>

                            </div>


                            {{-- =================================================
                            AVAILABLE COLOUR CARDS
                            ================================================== --}}
                            <div class="ml-available-colours">

                                <span class="ml-available-colours-title">
                                    Available Colours
                                </span>


                                <div class="ml-colour-card-list">

                                    @foreach ($variants as $variant)

                                        @php

                                            $variantImage = $variant->image
                                                ? asset('storage/' . $variant->image)
                                                : $featuredImage;

                                            $variantAlt = $variant->image
                                                ? $variant->image_alt_value
                                                : $product->featured_image_alt;

                                        @endphp


                                        <button type="button" class="ml-colour-card {{ $loop->first ? 'active' : '' }}"
                                            data-variant-id="{{ $variant->id }}" data-name="{{ $variant->colour_name }}"
                                            data-color="{{ $variant->colour_code ?: '#31A050' }}" data-sku="{{ $variant->sku }}"
                                            data-stock="{{ $variant->quantity }}"
                                            data-price="{{ $basePrice + (float) $variant->price_adjustment }}"
                                            data-image="{{ $variantImage }}" data-image-alt="{{ $variantAlt }}"
                                            aria-label="Select {{ $variant->colour_name }}">

                                            <span class="ml-colour-card-check">
                                                <i class="bi bi-check-lg"></i>
                                            </span>


                                            <img src="{{ $variantImage }}" alt="{{ $variantAlt }}">


                                            <span>
                                                {{ $variant->colour_name }}
                                            </span>

                                        </button>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- Selected Variant --}}
                    <input type="hidden" id="selectedVariantId" value="{{ $firstVariant?->id }}">


                    {{-- =================================================
                    QUANTITY
                    ================================================== --}}
                    <label class="ml-quantity-label" for="productQty">
                        Quantity
                    </label>


                    <div class="ml-product-purchase-box">


                        <div class="ml-product-qty">

                            <button type="button" id="qtyMinus" aria-label="Decrease quantity">
                                −
                            </button>


                            <input type="number" id="productQty" value="1" min="1" max="{{ $firstVariant?->quantity
        ?: max(1, $product->stock_quantity)
                                    }}">


                            <button type="button" id="qtyPlus" aria-label="Increase quantity">
                                +
                            </button>

                        </div>


                        <button class="ml-product-add-btn" type="button" id="productAddToBag" {{
        (($firstVariant?->quantity
            ?? $product->stock_quantity) <= 0)
        ? 'disabled'
        : ''
                                }}>

                            <i class="bi bi-bag-plus"></i>

                            Add to Bag

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
    FULL PRODUCT DESCRIPTION
    ========================================================== --}}
    <section class="ml-product-details" id="fullProductDescription">

        <div class="container">

            <div class="ml-product-description-box">

                <h2>
                    Product Overview
                </h2>

                {!! $product->description !!}

            </div>

        </div>

    </section>


    {{-- =========================================================
    PRODUCT CONFIG FOR CART JS
    ========================================================== --}}
    <script>
        window.mlProductConfig = {
            id: @json($product->id),
            name: @json($product->name),
            url: @json($product->public_url)
        };
    </script>

@endsection


@push('scripts')

    <script src="{{ asset('js/product-view.js') }}"></script>

@endpush