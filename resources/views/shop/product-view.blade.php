@extends('layouts.app')

@section('title', $product->seo_title ?: $product->name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product-view.css') }}">
@endpush

@section('content')
    @php
        use Illuminate\Support\Str;

        $variants = $product->activeVariants;
        $firstVariant = $variants->first();
        $basePrice = (float) ($product->sale_price ?: $product->regular_price);

        $featuredImage = $product->featured_image
            ? asset('storage/' . $product->featured_image)
            : asset('img/product-placeholder.webp');

        $galleryItems = collect([
            [
                'label' => 'Main View',
                'image' => $featuredImage,
            ],
        ]);

        $viewLabels = [
            'Front View',
            'Left View',
            'Right View',
            'Back View',
            'Top View',
            'Close-up',
            'Packaging',
            'Lifestyle',
        ];

        foreach (collect($product->gallery_images ?? [])->filter()->values() as $index => $image) {
            $galleryItems->push([
                'label' => $viewLabels[$index] ?? ('View ' . ($index + 1)),
                'image' => asset('storage/' . $image),
            ]);
        }

        $initialImage = $firstVariant?->image
            ? asset('storage/' . $firstVariant->image)
            : $featuredImage;
    @endphp

    <section class="ml-product-view">
        <div class="container">

            <div class="ml-product-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <a href="{{ route('store') }}">Store</a>
                <span>/</span>
                <strong>{{ $product->name }}</strong>
            </div>

            <div class="ml-product-layout">

                {{-- Product Gallery --}}
                <div class="ml-product-gallery-shell">

                    <div class="ml-product-angle-list">
                        @foreach ($galleryItems as $index => $item)
                            <button type="button" class="ml-product-angle-thumb {{ $index === 0 ? 'active' : '' }}"
                                data-gallery-image="{{ $item['image'] }}" data-gallery-label="{{ $item['label'] }}"
                                aria-label="Show {{ $item['label'] }}">
                                <img src="{{ $item['image'] }}" alt="{{ $product->name }} {{ $item['label'] }}">
                                <span>{{ $item['label'] }}</span>
                            </button>
                        @endforeach
                    </div>

                    <div class="ml-product-main-stage">

                        @if ($product->featured)
                            <span class="ml-product-badge">Featured</span>
                        @endif

                        <button type="button" class="ml-product-image-nav prev" id="mlGalleryPrev"
                            aria-label="Previous image">
                            <i class="bi bi-chevron-left"></i>
                        </button>

                        <div class="ml-product-main-image">
                            <img id="mlProductMainImg" src="{{ $initialImage }}"
                                alt="{{ $product->image_alt ?: $product->name }}">
                        </div>

                        <button type="button" class="ml-product-image-nav next" id="mlGalleryNext" aria-label="Next image">
                            <i class="bi bi-chevron-right"></i>
                        </button>

                        <div class="ml-product-image-caption" id="mlGalleryCaption">
                            {{ $firstVariant?->colour_name ? $firstVariant->colour_name . ' Colour' : 'Main View' }}
                        </div>

                    </div>

                </div>

                {{-- Product Details --}}
                <div class="ml-product-info">

                    <span class="ml-product-category">
                        {{ $product->category ?: 'Product' }}
                    </span>

                    <h1>{{ $product->name }}</h1>

                    @php
                        $currentStock = (int) ($firstVariant?->quantity ?? $product->stock_quantity);
                    @endphp

                    <div class="ml-product-stock">
                        <span id="mlVariantStock" class="ml-stock-badge
                                                {{ $currentStock <= 0
        ? 'out-stock'
        : ($currentStock <= 5 ? 'low-stock' : 'in-stock') }}">
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

                    <p class="ml-product-price">
                        <strong id="mlVariantPrice">
                            A${{ number_format($basePrice + (float) ($firstVariant?->price_adjustment ?? 0), 2) }}
                        </strong>
                    </p>

                    <div class="ml-product-short">
                        <p>
                            {{ Str::words($product->short_description ?: 'No short description available.', 25, '...') }}
                            <a href="#fullProductDescription" class="ml-see-full-desc">
                                See full description
                                <i class="bi bi-arrow-down-circle-fill ps-2"></i>
                            </a>
                        </p>
                    </div>

                    @if ($variants->isNotEmpty())
                        <div class="ml-product-colour-control">

                            <label class="ml-color-label">Colour</label>

                            {{-- Selected colour dropdown --}}
                            <div class="ml-custom-select" id="mlProductColourSelect">

                                <button type="button" class="ml-custom-select-trigger" id="mlProductColourTrigger"
                                    aria-expanded="false">
                                    <span class="ml-selected-colour-wrap">
                                        <span class="ml-color-dot" id="mlSelectedColourDot"
                                            style="background: {{ $firstVariant?->colour_code ?: '#31A050' }}"></span>

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
                                        @endphp

                                        <button type="button"
                                            class="ml-custom-option ml-product-variant-option {{ $loop->first ? 'active' : '' }}"
                                            data-variant-id="{{ $variant->id }}" data-name="{{ $variant->colour_name }}"
                                            data-color="{{ $variant->colour_code ?: '#31A050' }}" data-sku="{{ $variant->sku }}"
                                            data-stock="{{ $variant->quantity }}"
                                            data-price="{{ $basePrice + (float) $variant->price_adjustment }}"
                                            data-image="{{ $variantImage }}">
                                            <span class="color-circle"
                                                style="background: {{ $variant->colour_code ?: '#31A050' }}"></span>

                                            <span>{{ $variant->colour_name }}</span>

                                            <img src="{{ $variantImage }}" alt="{{ $variant->colour_name }}">
                                        </button>
                                    @endforeach
                                </div>

                            </div>

                            {{-- Always-visible colour image cards --}}
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
                                        @endphp

                                        <button type="button" class="ml-colour-card {{ $loop->first ? 'active' : '' }}"
                                            data-variant-id="{{ $variant->id }}" data-name="{{ $variant->colour_name }}"
                                            data-color="{{ $variant->colour_code ?: '#31A050' }}" data-sku="{{ $variant->sku }}"
                                            data-stock="{{ $variant->quantity }}"
                                            data-price="{{ $basePrice + (float) $variant->price_adjustment }}"
                                            data-image="{{ $variantImage }}" aria-label="Select {{ $variant->colour_name }}">
                                            <span class="ml-colour-card-check">
                                                <i class="bi bi-check-lg"></i>
                                            </span>

                                            <img src="{{ $variantImage }}" alt="{{ $variant->colour_name }}">

                                            <span>{{ $variant->colour_name }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    @endif

                    <input type="hidden" id="selectedVariantId" value="{{ $firstVariant?->id }}">

                    <label class="ml-quantity-label" for="productQty">
                        Quantity
                    </label>

                    <div class="ml-product-purchase-box">

                        <div class="ml-product-qty">
                            <button type="button" id="qtyMinus" aria-label="Decrease quantity">
                                −
                            </button>

                            <input type="number" id="productQty" value="1" min="1"
                                max="{{ $firstVariant?->quantity ?: max(1, $product->stock_quantity) }}">

                            <button type="button" id="qtyPlus" aria-label="Increase quantity">
                                +
                            </button>
                        </div>

                        <button class="ml-product-add-btn" type="button" id="productAddToBag" {{ (($firstVariant?->quantity ?? $product->stock_quantity) <= 0) ? 'disabled' : '' }}>
                            <i class="bi bi-bag-plus"></i>
                            Add to Bag
                        </button>

                    </div>

                </div>

            </div>

        </div>
    </section>

    <section class="ml-product-details" id="fullProductDescription">
        <div class="container">
            <div class="ml-product-description-box">
                <h2>Product Overview</h2>
                {!! $product->description !!}
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/product-view.js') }}"></script>
@endpush