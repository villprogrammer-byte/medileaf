@extends('admin.layouts.app')

@section('title', 'Edit Product')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product-variants.css') }}">
@endpush

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <strong>Product update nahi hua:</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="ml-admin-page-head">
        <div>
            <h1>Edit Product</h1>
            <p>Update product details, colour variants, pricing, stock, images and SEO information.</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="ml-admin-add-btn">
            <i class="bi bi-arrow-left"></i>
            Back to Products
        </a>
    </div>


    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
        class="ml-product-create-form" id="mlProductForm">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- =========================================================
            LEFT SIDE
            ========================================================== --}}
            <div class="col-xl-8">


                {{-- =====================================================
                BASIC INFORMATION
                ====================================================== --}}
                <div class="ml-admin-card ml-product-form-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-info-circle-fill"></i>
                            Basic Information
                        </h4>
                    </div>


                    <div class="row g-4">

                        <div class="col-md-12">
                            <label class="ml-admin-label">
                                Product Name
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" id="productName" value="{{ old('name', $product->name) }}"
                                class="ml-admin-input" placeholder="Enter product name" required>
                        </div>


                        <div class="col-md-4">
                            <label class="ml-admin-label">
                                Product SKU
                            </label>

                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="ml-admin-input"
                                placeholder="ML-001">
                        </div>


                        <div class="col-md-4">
                            <label class="ml-admin-label">
                                Category
                            </label>

                            <select name="category" id="productCategory" class="ml-admin-input">
                                <option value="">
                                    Select Category
                                </option>

                                <option value="Vaporisers" {{ old('category', $product->category) === 'Vaporisers' ? 'selected' : '' }}>
                                    Vaporisers
                                </option>

                                <option value="Accessories" {{ old('category', $product->category) === 'Accessories' ? 'selected' : '' }}>
                                    Accessories
                                </option>

                                <option value="Wellness Products" {{ old('category', $product->category) === 'Wellness Products' ? 'selected' : '' }}>
                                    Wellness Products
                                </option>

                                <option value="Pharmacy Support" {{ old('category', $product->category) === 'Pharmacy Support' ? 'selected' : '' }}>
                                    Pharmacy Support
                                </option>
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label class="ml-admin-label">
                                Brand
                            </label>

                            <input type="text" name="brand" value="{{ old('brand', $product->brand) }}"
                                class="ml-admin-input" placeholder="STORZ & BICKEL">
                        </div>


                        {{-- =================================================
                        COLOUR VARIANTS
                        ================================================== --}}
                        <div class="col-md-12">

                            <div class="d-flex align-items-start justify-content-between gap-3 mb-3">

                                <div>
                                    <label class="ml-admin-label mb-1">
                                        Colour Variants
                                    </label>

                                    <p class="text-muted mb-0">
                                        Add colour variants only when this product has different colour options.
                                    </p>
                                </div>


                                <button type="button" class="ml-add-colour-btn" id="addVariantBtn">
                                    <i class="bi bi-plus-circle"></i>
                                    Add Colour
                                </button>

                            </div>


                            @php
                                $existingVariants = $product->variants
                                    ->map(function ($variant) {
                                        return [
                                            'id' => $variant->id,
                                            'colour_name' => $variant->colour_name,
                                            'colour_code' => $variant->colour_code ?: '#31A050',
                                            'sku' => $variant->sku,
                                            'quantity' => $variant->quantity,
                                            'price_adjustment' => $variant->price_adjustment,
                                            'status' => $variant->status,
                                            'image' => $variant->image,
                                            'image_alt' => $variant->image_alt,
                                        ];
                                    })
                                    ->values()
                                    ->toArray();

                                $oldVariants = old(
                                    'variants',
                                    $existingVariants
                                );
                            @endphp


                            <div id="variantList" class="ml-variant-list">

                                @foreach ($oldVariants as $variantIndex => $variant)

                                    <div class="ml-variant-card" data-variant-row>

                                        @if (!empty($variant['id']))
                                            <input type="hidden" name="variants[{{ $variantIndex }}][id]"
                                                value="{{ $variant['id'] }}" data-field="id">
                                        @endif


                                        <div class="ml-variant-card-head">

                                            <div class="d-flex align-items-center gap-3">

                                                <span class="ml-variant-number">
                                                    {{ $loop->iteration }}
                                                </span>

                                                <div>
                                                    <strong>
                                                        Colour Variant
                                                    </strong>

                                                    <small>
                                                        SKU, stock, image and ALT text for this colour
                                                    </small>
                                                </div>

                                            </div>


                                            <button type="button" class="ml-variant-remove-btn" data-remove-variant
                                                aria-label="Remove colour variant">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </div>


                                        <div class="row g-3">

                                            <div class="col-md-5">
                                                <label class="ml-admin-label">
                                                    Colour Name
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" name="variants[{{ $variantIndex }}][colour_name]"
                                                    value="{{ $variant['colour_name'] ?? '' }}" class="ml-admin-input"
                                                    placeholder="Example: Black" required>
                                            </div>


                                            <div class="col-md-3">
                                                <label class="ml-admin-label">
                                                    Colour Code
                                                </label>

                                                <div class="ml-colour-code-field">

                                                    <input type="color" class="ml-colour-picker"
                                                        value="{{ $variant['colour_code'] ?? '#31A050' }}" data-colour-picker>

                                                    <input type="text" name="variants[{{ $variantIndex }}][colour_code]"
                                                        value="{{ $variant['colour_code'] ?? '#31A050' }}"
                                                        class="ml-admin-input" placeholder="#000000" maxlength="20"
                                                        data-colour-code>

                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <label class="ml-admin-label">
                                                    Variant SKU
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" name="variants[{{ $variantIndex }}][sku]"
                                                    value="{{ $variant['sku'] ?? '' }}" class="ml-admin-input"
                                                    placeholder="ML-001-BLK" required>
                                            </div>


                                            <div class="col-md-4">
                                                <label class="ml-admin-label">
                                                    Quantity
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="number" name="variants[{{ $variantIndex }}][quantity]"
                                                    value="{{ $variant['quantity'] ?? 0 }}" min="0"
                                                    class="ml-admin-input ml-variant-quantity" placeholder="0" required>
                                            </div>


                                            <div class="col-md-4">
                                                <label class="ml-admin-label">
                                                    Price Adjustment
                                                </label>

                                                <input type="number" name="variants[{{ $variantIndex }}][price_adjustment]"
                                                    value="{{ $variant['price_adjustment'] ?? 0 }}" step="0.01" min="0"
                                                    class="ml-admin-input" placeholder="0.00">

                                                <small class="text-muted d-block mt-2">
                                                    Keep 0 when this colour uses the normal product price.
                                                </small>
                                            </div>


                                            <div class="col-md-4">
                                                <label class="ml-admin-label">
                                                    Status
                                                </label>

                                                <select name="variants[{{ $variantIndex }}][status]" class="ml-admin-input">
                                                    <option value="active" {{ ($variant['status'] ?? 'active') === 'active' ? 'selected' : '' }}>
                                                        Active
                                                    </option>

                                                    <option value="inactive" {{ ($variant['status'] ?? '') === 'inactive' ? 'selected' : '' }}>
                                                        Inactive
                                                    </option>
                                                </select>
                                            </div>


                                            <div class="col-md-6">

                                                <label class="ml-admin-label">
                                                    Colour Image
                                                </label>


                                                @if (!empty($variant['image']))
                                                    <div class="ml-variant-current-image mb-3">

                                                        <img src="{{ asset('storage/' . $variant['image']) }}"
                                                            alt="{{ $variant['image_alt'] ?: ($variant['colour_name'] ?? 'Variant') }}">

                                                        <span>
                                                            Current image
                                                        </span>

                                                    </div>
                                                @endif


                                                <input type="file" name="variants[{{ $variantIndex }}][image]"
                                                    class="form-control ml-variant-image-input" accept=".jpg,.jpeg,.png,.webp"
                                                    data-variant-image>


                                                <small class="text-muted d-block mt-2">
                                                    Upload a new image only when you want to replace the current image.
                                                </small>


                                                @if (!empty($variant['image']))
                                                    <label class="form-check mt-3">

                                                        <input type="checkbox" name="variants[{{ $variantIndex }}][remove_image]"
                                                            value="1" class="form-check-input">

                                                        <span class="form-check-label text-danger">
                                                            Remove current colour image
                                                        </span>

                                                    </label>
                                                @endif


                                                <div class="ml-variant-image-preview" data-variant-preview></div>

                                            </div>


                                            <div class="col-md-6">

                                                <label class="ml-admin-label">
                                                    Colour Image ALT Text
                                                </label>

                                                <input type="text" name="variants[{{ $variantIndex }}][image_alt]"
                                                    value="{{ $variant['image_alt'] ?? '' }}" class="ml-admin-input"
                                                    placeholder="Mighty+ Medic black colour">

                                                <small class="text-muted d-block mt-2">
                                                    Describe this specific colour image.
                                                </small>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>


                            <div class="ml-variant-summary">

                                <div>
                                    <span>
                                        Total Colour Variants
                                    </span>

                                    <strong id="variantCount">
                                        {{ count($oldVariants) }}
                                    </strong>
                                </div>


                                <div>
                                    <span>
                                        Total Stock
                                    </span>

                                    <strong>
                                        <span id="variantTotalStock">0</span>
                                        PCS
                                    </strong>
                                </div>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="ml-admin-label">
                                Product Type
                            </label>

                            <select name="product_type" class="ml-admin-input">
                                <option value="Physical Product" {{ old('product_type', $product->product_type) === 'Physical Product' ? 'selected' : '' }}>
                                    Physical Product
                                </option>

                                <option value="Medical Device" {{ old('product_type', $product->product_type) === 'Medical Device' ? 'selected' : '' }}>
                                    Medical Device
                                </option>

                                <option value="Accessory" {{ old('product_type', $product->product_type) === 'Accessory' ? 'selected' : '' }}>
                                    Accessory
                                </option>
                            </select>

                        </div>


                        <div class="col-md-6">

                            <label class="ml-admin-label">
                                Reference Number
                            </label>

                            <input type="text" name="reference_number"
                                value="{{ old('reference_number', $product->reference_number) }}" class="ml-admin-input"
                                placeholder="e.g. 01 01 MM">

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                PRICING
                ====================================================== --}}
                <div class="ml-admin-card ml-product-form-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-currency-dollar"></i>
                            Pricing
                        </h4>
                    </div>


                    <div class="row g-4">

                        <div class="col-md-4">

                            <label class="ml-admin-label">
                                Regular Price
                                <span class="text-danger">*</span>
                            </label>

                            <input type="number" name="regular_price"
                                value="{{ old('regular_price', $product->regular_price) }}" step="0.01" min="0"
                                class="ml-admin-input" required>

                        </div>


                        <div class="col-md-4">

                            <label class="ml-admin-label">
                                Sale Price
                            </label>

                            <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}"
                                step="0.01" min="0" class="ml-admin-input">

                        </div>


                        <div class="col-md-4">

                            <label class="ml-admin-label">
                                Cost Price
                            </label>

                            <input type="number" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}"
                                step="0.01" min="0" class="ml-admin-input">

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                DESCRIPTION
                ====================================================== --}}
                <div class="ml-admin-card ml-product-form-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-card-text"></i>
                            Product Description
                        </h4>
                    </div>


                    <div class="mb-4">

                        <label class="ml-admin-label">
                            Short Description
                        </label>

                        <textarea name="short_description" class="ml-admin-textarea"
                            rows="4">{{ old('short_description', $product->short_description) }}</textarea>

                    </div>


                    <div>

                        <label class="ml-admin-label">
                            Full Description
                        </label>

                        <textarea id="description" name="description" class="ml-admin-textarea ml-admin-long-textarea"
                            rows="8">{{ old('description', $product->description) }}</textarea>

                    </div>

                </div>


                {{-- =====================================================
                INVENTORY
                ====================================================== --}}
                <div class="ml-admin-card ml-product-form-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-boxes"></i>
                            Inventory
                        </h4>
                    </div>


                    <div class="row g-4">

                        <div class="col-md-4">

                            <label class="ml-admin-label">
                                Total Stock Quantity
                            </label>

                            <input type="number" name="stock_quantity" id="stockQuantity"
                                value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" class="ml-admin-input"
                                readonly>

                            <small class="text-muted d-block mt-2">
                                Automatically calculated when colour variants are added.
                            </small>

                        </div>


                        <div class="col-md-4">

                            <label class="ml-admin-label">
                                Low Stock Alert
                            </label>

                            <input type="number" name="low_stock_alert" id="lowStockAlert"
                                value="{{ old('low_stock_alert', $product->low_stock_alert) }}" min="0"
                                class="ml-admin-input">

                        </div>


                        <div class="col-md-4">

                            <label class="ml-admin-label">
                                Stock Status
                            </label>

                            <input type="hidden" name="stock_status" id="stockStatus"
                                value="{{ old('stock_status', $product->stock_status) }}">

                            <div class="ml-auto-stock-status" id="stockStatusDisplay">
                                {{ ucfirst(str_replace('_', ' ', $product->stock_status)) }}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                SEO DETAILS
                ====================================================== --}}
                <div class="ml-admin-card ml-product-form-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-search-heart"></i>
                            SEO Details
                        </h4>
                    </div>


                    <div class="mb-4">

                        <label class="ml-admin-label">
                            URL Slug
                        </label>

                        <input type="text" name="slug" id="productSlug" value="{{ old('slug', $product->slug) }}"
                            class="ml-admin-input" placeholder="mighty-plus-medic">

                        <div class="mt-2">
                            <small class="text-muted">
                                Product URL:
                                <strong id="productUrlPreview">
                                    /{{ $product->category_slug }}/{{ $product->slug }}
                                </strong>
                            </small>
                        </div>

                    </div>


                    <div class="mb-4">

                        <label class="ml-admin-label">
                            SEO Title
                        </label>

                        <input type="text" name="seo_title" value="{{ old('seo_title', $product->seo_title) }}"
                            class="ml-admin-input" maxlength="255">

                    </div>


                    <div class="mb-4">

                        <label class="ml-admin-label">
                            Meta Description
                        </label>

                        <textarea name="meta_description" class="ml-admin-textarea" rows="4"
                            maxlength="500">{{ old('meta_description', $product->meta_description) }}</textarea>

                    </div>


                    <div class="mb-4">

                        <label class="ml-admin-label">
                            Canonical URL Override
                        </label>

                        <input type="url" name="canonical_url" value="{{ old('canonical_url', $product->canonical_url) }}"
                            class="ml-admin-input" placeholder="Leave blank to use automatic product URL">

                        <small class="text-muted d-block mt-2">
                            Automatic canonical:
                            {{ $product->public_url }}
                        </small>

                    </div>


                    <div class="ml-product-toggle-row mb-4">

                        <div>
                            <strong>
                                Search Engine Visibility
                            </strong>

                            <small class="text-muted d-block mt-1">
                                Allow search engines to index this product.
                            </small>
                        </div>


                        <label class="ml-admin-switch">

                            <input type="checkbox" name="is_indexable" value="1" {{ old('is_indexable', $product->is_indexable) ? 'checked' : '' }}>

                            <small></small>

                        </label>

                    </div>


                    <div class="ml-admin-subsection">

                        <div class="mb-4">
                            <h5>
                                Social Sharing
                            </h5>

                            <p class="text-muted mb-0">
                                Optional Open Graph values.
                            </p>
                        </div>


                        <div class="mb-4">

                            <label class="ml-admin-label">
                                OG Title
                            </label>

                            <input type="text" name="og_title" value="{{ old('og_title', $product->og_title) }}"
                                class="ml-admin-input" maxlength="255">

                        </div>


                        <div class="mb-4">

                            <label class="ml-admin-label">
                                OG Description
                            </label>

                            <textarea name="og_description" class="ml-admin-textarea" rows="4"
                                maxlength="500">{{ old('og_description', $product->og_description) }}</textarea>

                        </div>


                        @if ($product->og_image)

                            <div class="ml-current-og-image mb-3">

                                <img src="{{ asset('storage/' . $product->og_image) }}" alt="Current social sharing image">

                            </div>

                        @endif


                        <div>

                            <label class="ml-admin-label">
                                OG Image
                            </label>

                            <input type="file" name="og_image" id="ogImageInput" class="form-control"
                                accept=".jpg,.jpeg,.png,.webp">

                            <small class="text-muted d-block mt-2">
                                Upload a new file to replace the current OG image.
                            </small>


                            @if ($product->og_image)

                                <label class="form-check mt-3">

                                    <input type="checkbox" name="remove_og_image" value="1" class="form-check-input">

                                    <span class="form-check-label text-danger">
                                        Remove current OG image
                                    </span>

                                </label>

                            @endif


                            <div id="ogImagePreview" class="ml-og-image-preview mt-3"></div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
            RIGHT SIDE
            ========================================================== --}}
            <div class="col-xl-4">


                {{-- =====================================================
                UPDATE PRODUCT
                ====================================================== --}}
                <div class="ml-admin-card ml-product-side-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-rocket-takeoff-fill"></i>
                            Update Product
                        </h4>
                    </div>


                    <div class="ml-product-status-box">

                        <label class="ml-admin-label">
                            Product Status
                            <span class="text-danger">*</span>
                        </label>

                        <select name="status" class="ml-admin-input" required>
                            <option value="published" {{ old('status', $product->status) === 'published' ? 'selected' : '' }}>
                                Published
                            </option>

                            <option value="draft" {{ old('status', $product->status) === 'draft' ? 'selected' : '' }}>
                                Draft
                            </option>

                            <option value="hidden" {{ old('status', $product->status) === 'hidden' ? 'selected' : '' }}>
                                Hidden
                            </option>
                        </select>

                    </div>


                    <div class="ml-product-toggle-row">

                        <span>
                            Featured Product
                        </span>

                        <label class="ml-admin-switch">

                            <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}>

                            <small></small>

                        </label>

                    </div>


                    <div class="ml-product-toggle-row">

                        <span>
                            Prescription Required
                        </span>

                        <label class="ml-admin-switch">

                            <input type="checkbox" name="prescription_required" value="1" {{ old('prescription_required', $product->prescription_required) ? 'checked' : '' }}>

                            <small></small>

                        </label>

                    </div>


                    <div class="ml-product-publish-actions">

                        <button type="submit" name="status" value="draft" class="ml-product-draft-btn">
                            Save as Draft
                        </button>

                        <button type="submit" name="status" value="published" class="ml-product-publish-btn">
                            Update Product
                        </button>

                    </div>

                </div>


                {{-- =====================================================
                FEATURED IMAGE
                ====================================================== --}}
                <div class="ml-admin-card ml-product-side-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-image-fill"></i>
                            Featured Image
                        </h4>
                    </div>


                    <label class="ml-upload-box" id="featuredUpload">

                        <input type="file" name="featured_image" id="featuredImageInput" accept=".jpg,.jpeg,.png,.webp"
                            hidden>


                        <div id="featuredPreview">

                            @if ($product->featured_image)

                                <img src="{{ asset('storage/' . $product->featured_image) }}"
                                    alt="{{ $product->featured_image_alt }}" class="ml-featured-preview">

                            @else

                                <i class="bi bi-cloud-arrow-up"></i>

                                <strong>
                                    Upload Image
                                </strong>

                                <span>
                                    PNG, JPG, WEBP up to 5MB
                                </span>

                            @endif

                        </div>

                    </label>


                    <div class="mt-3">

                        <label class="ml-admin-label">
                            Featured Image ALT Text
                        </label>

                        <input type="text" name="image_alt" value="{{ old('image_alt', $product->image_alt) }}"
                            class="ml-admin-input" placeholder="Describe the featured product image">

                    </div>

                </div>


                {{-- =====================================================
                PRODUCT GALLERY
                ====================================================== --}}
                <div class="ml-admin-card ml-product-side-card">

                    <div class="ml-admin-card-head">

                        <h4>
                            <i class="bi bi-images"></i>
                            Product Gallery
                        </h4>


                        <button type="button" class="ml-gallery-add-btn" id="addGalleryImageBtn">
                            <i class="bi bi-plus-circle"></i>
                            Add Image
                        </button>

                    </div>


                    <p class="text-muted mb-3">
                        Rename, update ALT text, replace or remove images individually.
                    </p>


                    @php
                        $galleryRecords = $product->images;

                        $oldGalleryItems = old('gallery_items');

                        if ($oldGalleryItems === null) {
                            $galleryItems = $galleryRecords
                                ->map(function ($image) {
                                    return [
                                        'id' => $image->id,
                                        'image' => $image->image,
                                        'image_name' => $image->image_name,
                                        'alt_text' => $image->alt_text,
                                        'sort_order' => $image->sort_order,
                                    ];
                                })
                                ->values()
                                ->toArray();
                        } else {
                            $galleryItems = $oldGalleryItems;
                        }
                    @endphp


                    <div id="galleryItemList" class="ml-gallery-manager">

                        @foreach ($galleryItems as $galleryIndex => $galleryItem)

                            <div class="ml-gallery-manager-item" data-gallery-row>

                                @if (!empty($galleryItem['id']))
                                    <input type="hidden" name="gallery_items[{{ $galleryIndex }}][id]"
                                        value="{{ $galleryItem['id'] }}" data-gallery-field="id">
                                @endif


                                <div class="ml-gallery-manager-head">

                                    <strong data-gallery-number>
                                        Image {{ $loop->iteration }}
                                    </strong>


                                    <button type="button" class="ml-gallery-remove-btn" data-remove-gallery
                                        aria-label="Remove gallery image">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>


                                <div class="ml-gallery-upload-preview" data-gallery-preview>

                                    @if (!empty($galleryItem['image']))

                                        <img src="{{ asset('storage/' . $galleryItem['image']) }}"
                                            alt="{{ $galleryItem['alt_text'] ?: ($galleryItem['image_name'] ?? $product->name) }}">

                                    @else

                                        <i class="bi bi-image"></i>

                                    @endif

                                </div>


                                <div class="mb-3">

                                    <label class="ml-admin-label">
                                        Replace Image
                                    </label>

                                    <input type="file" name="gallery_items[{{ $galleryIndex }}][image]" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp" data-gallery-image>

                                    <small class="text-muted d-block mt-2">
                                        Leave empty to keep the current image.
                                    </small>

                                </div>


                                <div class="mb-3">

                                    <label class="ml-admin-label">
                                        Image Name
                                    </label>

                                    <input type="text" name="gallery_items[{{ $galleryIndex }}][image_name]"
                                        value="{{ $galleryItem['image_name'] ?? '' }}" class="ml-admin-input"
                                        placeholder="Front View" data-gallery-field="image_name">

                                </div>


                                <div class="mb-3">

                                    <label class="ml-admin-label">
                                        ALT Text
                                    </label>

                                    <input type="text" name="gallery_items[{{ $galleryIndex }}][alt_text]"
                                        value="{{ $galleryItem['alt_text'] ?? '' }}" class="ml-admin-input"
                                        placeholder="Product front view" data-gallery-field="alt_text">

                                </div>


                                <input type="hidden" name="gallery_items[{{ $galleryIndex }}][sort_order]"
                                    value="{{ $galleryItem['sort_order'] ?? $galleryIndex }}" data-gallery-field="sort_order">


                                @if (!empty($galleryItem['id']))

                                    <input type="hidden" name="gallery_items[{{ $galleryIndex }}][remove]" value="0"
                                        data-gallery-remove>

                                @endif

                            </div>

                        @endforeach

                    </div>


                    <div class="ml-gallery-empty-state {{ count($galleryItems) ? 'd-none' : '' }}" id="galleryEmptyState">

                        <i class="bi bi-images"></i>

                        <strong>
                            No gallery images added
                        </strong>

                        <span>
                            Click “Add Image” to add a product gallery image.
                        </span>

                    </div>

                </div>


                {{-- =====================================================
                SHIPPING
                ====================================================== --}}
                <div class="ml-admin-card ml-product-side-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-truck"></i>
                            Shipping
                        </h4>
                    </div>


                    <div class="mb-3">

                        <label class="ml-admin-label">
                            Weight
                        </label>

                        <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" step="0.01" min="0"
                            class="ml-admin-input">

                    </div>


                    <div class="mb-3">

                        <label class="ml-admin-label">
                            Length
                        </label>

                        <input type="number" name="length" value="{{ old('length', $product->length) }}" step="0.01" min="0"
                            class="ml-admin-input">

                    </div>


                    <div class="mb-3">

                        <label class="ml-admin-label">
                            Width
                        </label>

                        <input type="number" name="width" value="{{ old('width', $product->width) }}" step="0.01" min="0"
                            class="ml-admin-input">

                    </div>


                    <div>

                        <label class="ml-admin-label">
                            Height
                        </label>

                        <input type="number" name="height" value="{{ old('height', $product->height) }}" step="0.01" min="0"
                            class="ml-admin-input">

                    </div>

                </div>

            </div>

        </div>

    </form>


    {{-- =============================================================
    VARIANT TEMPLATE
    ============================================================== --}}
    <template id="variantTemplate">

        <div class="ml-variant-card" data-variant-row>

            <div class="ml-variant-card-head">

                <div class="d-flex align-items-center gap-3">

                    <span class="ml-variant-number">
                        1
                    </span>

                    <div>
                        <strong>
                            Colour Variant
                        </strong>

                        <small>
                            SKU, stock, image and ALT text for this colour
                        </small>
                    </div>

                </div>


                <button type="button" class="ml-variant-remove-btn" data-remove-variant aria-label="Remove colour variant">
                    <i class="bi bi-trash"></i>
                </button>

            </div>


            <div class="row g-3">

                <div class="col-md-5">

                    <label class="ml-admin-label">
                        Colour Name
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" data-field="colour_name" class="ml-admin-input" placeholder="Example: Black"
                        required>

                </div>


                <div class="col-md-3">

                    <label class="ml-admin-label">
                        Colour Code
                    </label>

                    <div class="ml-colour-code-field">

                        <input type="color" class="ml-colour-picker" value="#31A050" data-colour-picker>

                        <input type="text" data-field="colour_code" value="#31A050" class="ml-admin-input"
                            placeholder="#000000" maxlength="20" data-colour-code>

                    </div>

                </div>


                <div class="col-md-4">

                    <label class="ml-admin-label">
                        Variant SKU
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" data-field="sku" class="ml-admin-input" placeholder="ML-001-BLK" required>

                </div>


                <div class="col-md-4">

                    <label class="ml-admin-label">
                        Quantity
                        <span class="text-danger">*</span>
                    </label>

                    <input type="number" data-field="quantity" value="0" min="0" class="ml-admin-input ml-variant-quantity"
                        required>

                </div>


                <div class="col-md-4">

                    <label class="ml-admin-label">
                        Price Adjustment
                    </label>

                    <input type="number" data-field="price_adjustment" value="0" step="0.01" min="0" class="ml-admin-input">

                </div>


                <div class="col-md-4">

                    <label class="ml-admin-label">
                        Status
                    </label>

                    <select data-field="status" class="ml-admin-input">
                        <option value="active">
                            Active
                        </option>

                        <option value="inactive">
                            Inactive
                        </option>
                    </select>

                </div>


                <div class="col-md-6">

                    <label class="ml-admin-label">
                        Colour Image
                    </label>

                    <input type="file" data-field="image" class="form-control ml-variant-image-input"
                        accept=".jpg,.jpeg,.png,.webp" data-variant-image>

                    <div class="ml-variant-image-preview" data-variant-preview></div>

                </div>


                <div class="col-md-6">

                    <label class="ml-admin-label">
                        Colour Image ALT Text
                    </label>

                    <input type="text" data-field="image_alt" class="ml-admin-input" placeholder="Product black colour">

                </div>

            </div>

        </div>

    </template>


    {{-- =============================================================
    GALLERY TEMPLATE
    ============================================================== --}}
    <template id="galleryItemTemplate">

        <div class="ml-gallery-manager-item" data-gallery-row>

            <div class="ml-gallery-manager-head">

                <strong data-gallery-number>
                    Image
                </strong>


                <button type="button" class="ml-gallery-remove-btn" data-remove-gallery aria-label="Remove gallery image">
                    <i class="bi bi-trash"></i>
                </button>

            </div>


            <div class="ml-gallery-upload-preview" data-gallery-preview>
                <i class="bi bi-image"></i>
            </div>


            <div class="mb-3">

                <label class="ml-admin-label">
                    Image File
                </label>

                <input type="file" data-gallery-field="image" class="form-control" accept=".jpg,.jpeg,.png,.webp"
                    data-gallery-image required>

            </div>


            <div class="mb-3">

                <label class="ml-admin-label">
                    Image Name
                </label>

                <input type="text" data-gallery-field="image_name" class="ml-admin-input" placeholder="Front View">

            </div>


            <div class="mb-3">

                <label class="ml-admin-label">
                    ALT Text
                </label>

                <input type="text" data-gallery-field="alt_text" class="ml-admin-input" placeholder="Product front view">

            </div>


            <input type="hidden" data-gallery-field="sort_order" value="0">

        </div>

    </template>

@endsection


@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script src="{{ asset('js/product-variants.js') }}"></script>
@endpush