@extends('admin.layouts.app')

@section('title', 'View Product')

@section('content')

    {{-- =========================================================
    PAGE HEADER
    ========================================================== --}}
    <div class="ml-admin-page-head">

        <div>
            <h1>{{ $product->name }}</h1>
            <p>
                View product information, colour variants, stock, images and SEO details.
            </p>
        </div>

        <div class="d-flex gap-2 flex-wrap">

            @if ($product->status === 'published')
                <a href="{{ $product->public_url }}" target="_blank" rel="noopener" class="ml-admin-add-btn">
                    <i class="bi bi-box-arrow-up-right"></i>
                    View Live
                </a>
            @endif

            <a href="{{ route('admin.products.edit', $product) }}" class="ml-admin-add-btn">
                <i class="bi bi-pencil"></i>
                Edit Product
            </a>

            <a href="{{ route('admin.products.index') }}" class="ml-admin-add-btn">
                <i class="bi bi-arrow-left"></i>
                Back to Products
            </a>

        </div>

    </div>


    {{-- =========================================================
    PRODUCT OVERVIEW
    ========================================================== --}}
    <div class="row g-4 mb-4">

        {{-- Featured Image --}}
        <div class="col-xl-4">

            <div class="ml-admin-card h-100">

                <div class="ml-admin-card-head">
                    <h4>
                        <i class="bi bi-image-fill"></i>
                        Featured Image
                    </h4>
                </div>

                @if ($product->featured_image)

                    <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $product->featured_image_alt }}"
                        style="
                                    width:100%;
                                    max-height:380px;
                                    object-fit:contain;
                                    border-radius:18px;
                                    background:#f8fbf7;
                                    padding:18px;
                                ">

                    <div class="mt-3">

                        <small class="text-muted d-block mb-1">
                            Image ALT Text
                        </small>

                        <strong>
                            {{ $product->featured_image_alt }}
                        </strong>

                    </div>

                @else

                    <div class="text-center py-5 text-muted">

                        <i class="bi bi-image" style="font-size:48px;"></i>

                        <p class="mb-0 mt-2">
                            No featured image
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- Product Information --}}
        <div class="col-xl-8">

            <div class="ml-admin-card h-100">

                <div class="ml-admin-card-head">
                    <h4>
                        <i class="bi bi-info-circle"></i>
                        Product Information
                    </h4>
                </div>


                <div class="row g-4">

                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            Product Name
                        </small>

                        <strong>
                            {{ $product->name }}
                        </strong>
                    </div>


                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            SKU
                        </small>

                        <strong>
                            {{ $product->sku ?: 'Not added' }}
                        </strong>
                    </div>


                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            Category
                        </small>

                        <strong>
                            {{ $product->category ?: 'Not added' }}
                        </strong>
                    </div>


                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            Brand
                        </small>

                        <strong>
                            {{ $product->brand ?: 'Not added' }}
                        </strong>
                    </div>


                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            Product Type
                        </small>

                        <strong>
                            {{ $product->product_type ?: 'Not added' }}
                        </strong>
                    </div>


                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            Reference Number
                        </small>

                        <strong>
                            {{ $product->reference_number ?: 'Not added' }}
                        </strong>
                    </div>


                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            Regular Price
                        </small>

                        <strong>
                            A${{ number_format($product->regular_price, 2) }}
                        </strong>
                    </div>


                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            Sale Price
                        </small>

                        <strong>
                            @if ($product->sale_price)
                                A${{ number_format($product->sale_price, 2) }}
                            @else
                                Not added
                            @endif
                        </strong>
                    </div>


                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            Total Stock
                        </small>

                        <strong>
                            {{ $product->stock_quantity }} PCS
                        </strong>
                    </div>


                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            Stock Status
                        </small>

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
                    </div>


                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            Product Status
                        </small>

                        <strong>
                            {{ ucfirst($product->status) }}
                        </strong>
                    </div>


                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            Featured Product
                        </small>

                        <strong>
                            {{ $product->featured ? 'Yes' : 'No' }}
                        </strong>
                    </div>


                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">
                            Prescription Required
                        </small>

                        <strong>
                            {{ $product->prescription_required ? 'Yes' : 'No' }}
                        </strong>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
    PUBLIC URL + SEO
    ========================================================== --}}
    <div class="ml-admin-card mb-4">

        <div class="ml-admin-card-head">

            <h4>
                <i class="bi bi-search-heart"></i>
                SEO Details
            </h4>

            @if ($product->is_indexable)

                <span class="badge bg-success">
                    Index, Follow
                </span>

            @else

                <span class="badge bg-secondary">
                    Noindex, Follow
                </span>

            @endif

        </div>


        <div class="row g-4">

            {{-- Product Slug --}}
            <div class="col-md-6">

                <small class="text-muted d-block mb-1">
                    Product Slug
                </small>

                <strong>
                    {{ $product->slug }}
                </strong>

            </div>


            {{-- Category Slug --}}
            <div class="col-md-6">

                <small class="text-muted d-block mb-1">
                    Category Slug
                </small>

                <strong>
                    {{ $product->category_slug }}
                </strong>

            </div>


            {{-- Public URL --}}
            <div class="col-12">

                <small class="text-muted d-block mb-1">
                    Public Product URL
                </small>

                <a href="{{ $product->public_url }}" target="_blank" rel="noopener" class="text-decoration-none">
                    {{ $product->public_url }}
                    <i class="bi bi-box-arrow-up-right ms-1"></i>
                </a>

            </div>


            {{-- SEO Title --}}
            <div class="col-12">

                <small class="text-muted d-block mb-1">
                    SEO Title
                </small>

                <strong>
                    {{ $product->seo_title ?: $product->name }}
                </strong>

            </div>


            {{-- Meta Description --}}
            <div class="col-12">

                <small class="text-muted d-block mb-1">
                    Meta Description
                </small>

                <div>
                    {{ $product->meta_description ?: 'Not added' }}
                </div>

            </div>


            {{-- Canonical --}}
            <div class="col-12">

                <small class="text-muted d-block mb-1">
                    Canonical URL
                </small>

                <div>
                    {{ $product->canonical_url_value }}
                </div>

                @if (!$product->canonical_url)
                    <small class="text-success">
                        Automatically generated
                    </small>
                @else
                    <small class="text-warning">
                        Manual override
                    </small>
                @endif

            </div>


            {{-- Search Visibility --}}
            <div class="col-md-6">

                <small class="text-muted d-block mb-1">
                    Search Engine Visibility
                </small>

                @if ($product->is_indexable)

                    <span class="badge bg-success">
                        <i class="bi bi-search me-1"></i>
                        Index
                    </span>

                @else

                    <span class="badge bg-secondary">
                        <i class="bi bi-eye-slash me-1"></i>
                        Noindex
                    </span>

                @endif

            </div>


            {{-- Robots --}}
            <div class="col-md-6">

                <small class="text-muted d-block mb-1">
                    Robots Directive
                </small>

                <strong>
                    {{ $product->robots_content }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =========================================================
    OPEN GRAPH
    ========================================================== --}}
    <div class="ml-admin-card mb-4">

        <div class="ml-admin-card-head">
            <h4>
                <i class="bi bi-share-fill"></i>
                Social Sharing
            </h4>
        </div>


        <div class="row g-4">

            <div class="col-12">

                <small class="text-muted d-block mb-1">
                    OG Title
                </small>

                <strong>
                    {{ $product->og_title_value }}
                </strong>

            </div>


            <div class="col-12">

                <small class="text-muted d-block mb-1">
                    OG Description
                </small>

                <div>
                    {{ $product->og_description_value ?: 'Not added' }}
                </div>

            </div>


            <div class="col-12">

                <small class="text-muted d-block mb-2">
                    OG Image
                </small>

                @if ($product->og_image_url)

                    <img src="{{ $product->og_image_url }}" alt="Social sharing preview for {{ $product->name }}" style="
                                    max-width:320px;
                                    width:100%;
                                    max-height:220px;
                                    object-fit:contain;
                                    background:#f8fbf7;
                                    border:1px solid #e5e7eb;
                                    border-radius:16px;
                                    padding:10px;
                                ">

                    @if (!$product->og_image)
                        <small class="d-block text-success mt-2">
                            Using Featured Image fallback
                        </small>
                    @endif

                @else

                    <span class="text-muted">
                        No social sharing image available.
                    </span>

                @endif

            </div>

        </div>

    </div>


    {{-- =========================================================
    PRODUCT GALLERY
    ========================================================== --}}
    <div class="ml-admin-card mb-4">

        <div class="ml-admin-card-head">

            <h4>
                <i class="bi bi-images"></i>
                Product Gallery
            </h4>

            <span class="badge bg-light text-dark">
                {{ $product->images->count() }}
                {{ $product->images->count() === 1 ? 'Image' : 'Images' }}
            </span>

        </div>


        @if ($product->images->isNotEmpty())

            <div class="row g-4">

                @foreach ($product->images as $image)

                    <div class="col-sm-6 col-lg-4 col-xl-3">

                        <div style="
                                            border:1px solid #e5ebe5;
                                            border-radius:18px;
                                            padding:12px;
                                            height:100%;
                                            background:#fbfdfb;
                                        ">

                            <img src="{{ $image->image_url }}" alt="{{ $image->alt_text_value }}" style="
                                                width:100%;
                                                height:180px;
                                                object-fit:contain;
                                                background:#fff;
                                                border-radius:14px;
                                            ">


                            <div class="mt-3">

                                <small class="text-muted d-block">
                                    Image Name
                                </small>

                                <strong>
                                    {{ $image->display_name }}
                                </strong>

                            </div>


                            <div class="mt-3">

                                <small class="text-muted d-block">
                                    ALT Text
                                </small>

                                <span>
                                    {{ $image->alt_text_value }}
                                </span>

                            </div>


                            <div class="mt-3">

                                <small class="text-muted d-block">
                                    Order
                                </small>

                                <span>
                                    {{ $image->sort_order + 1 }}
                                </span>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-4 text-muted">

                <i class="bi bi-images" style="font-size:42px;"></i>

                <p class="mb-0 mt-2">
                    No gallery images added.
                </p>

            </div>

        @endif

    </div>


    {{-- =========================================================
    COLOUR VARIANTS
    ========================================================== --}}
    <div class="ml-admin-card mb-4">

        <div class="ml-admin-card-head">

            <h4>
                <i class="bi bi-palette-fill"></i>
                Colour Variants
            </h4>

            <span class="badge bg-light text-dark">
                {{ $product->variants->count() }}
                {{ $product->variants->count() === 1 ? 'Variant' : 'Variants' }}
            </span>

        </div>


        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Colour</th>
                        <th>SKU</th>
                        <th>Quantity</th>
                        <th>Price Adjustment</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Image ALT</th>
                    </tr>
                </thead>


                <tbody>

                    @forelse ($product->variants as $variant)

                        <tr>

                            <td>

                                <span style="
                                                display:inline-block;
                                                width:18px;
                                                height:18px;
                                                border-radius:50%;
                                                background:{{ $variant->colour_code ?: '#31a050' }};
                                                border:1px solid #ddd;
                                                vertical-align:middle;
                                                margin-right:8px;
                                            "></span>

                                {{ $variant->colour_name }}

                            </td>


                            <td>
                                {{ $variant->sku }}
                            </td>


                            <td>
                                {{ $variant->quantity }} PCS
                            </td>


                            <td>
                                A${{ number_format($variant->price_adjustment, 2) }}
                            </td>


                            <td>

                                @if ($variant->status === 'active')

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if ($variant->image)

                                    <img src="{{ asset('storage/' . $variant->image) }}" alt="{{ $variant->image_alt_value }}"
                                        style="
                                                        width:64px;
                                                        height:64px;
                                                        object-fit:contain;
                                                        border-radius:10px;
                                                        border:1px solid #e5e7eb;
                                                        background:#fff;
                                                        padding:5px;
                                                    ">

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            <td>
                                {{ $variant->image_alt_value }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center text-muted py-4">
                                No colour variants added.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =========================================================
    SHIPPING
    ========================================================== --}}
    <div class="ml-admin-card">

        <div class="ml-admin-card-head">
            <h4>
                <i class="bi bi-truck"></i>
                Shipping
            </h4>
        </div>


        <div class="row g-4">

            <div class="col-md-3">
                <small class="text-muted d-block mb-1">
                    Weight
                </small>

                <strong>
                    {{ $product->weight ? $product->weight . ' kg' : 'Not added' }}
                </strong>
            </div>


            <div class="col-md-3">
                <small class="text-muted d-block mb-1">
                    Length
                </small>

                <strong>
                    {{ $product->length ? $product->length . ' cm' : 'Not added' }}
                </strong>
            </div>


            <div class="col-md-3">
                <small class="text-muted d-block mb-1">
                    Width
                </small>

                <strong>
                    {{ $product->width ? $product->width . ' cm' : 'Not added' }}
                </strong>
            </div>


            <div class="col-md-3">
                <small class="text-muted d-block mb-1">
                    Height
                </small>

                <strong>
                    {{ $product->height ? $product->height . ' cm' : 'Not added' }}
                </strong>
            </div>

        </div>

    </div>

@endsection