@extends('admin.layouts.app')

@section('title', 'Add Product')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product-variants.css') }}">
@endpush

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <strong>Product save nahi hua:</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="ml-admin-page-head">
        <div>
            <h1>Add Product</h1>
            <p>Create and manage MediLeaf store products with pricing, stock, images and SEO details.</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="ml-admin-add-btn">
            <i class="bi bi-arrow-left"></i>
            Back to Products
        </a>
    </div>


    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
        class="ml-product-create-form" id="mlProductForm">
        @csrf

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
                                Product Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" id="productName" value="{{ old('name') }}" class="ml-admin-input"
                                placeholder="Enter product name" required>
                        </div>


                        <div class="col-md-4">
                            <label class="ml-admin-label">Product SKU</label>

                            <input type="text" name="sku" value="{{ old('sku') }}" class="ml-admin-input"
                                placeholder="ML-001">
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Category</label>

                            <div class="ml-custom-select" data-name="category">

                                <button type="button" class="ml-custom-select-btn">
                                    <span class="ml-custom-select-value">
                                        Select Category
                                    </span>

                                    <i class="bi bi-chevron-down"></i>
                                </button>

                                <div class="ml-custom-select-menu">

                                    <button type="button" class="ml-custom-option" data-value="Vaporisers">
                                        Vaporisers
                                    </button>

                                    <button type="button" class="ml-custom-option" data-value="Accessories">
                                        Accessories
                                    </button>

                                    <button type="button" class="ml-custom-option" data-value="Wellness Products">
                                        Wellness Products
                                    </button>

                                    <button type="button" class="ml-custom-option" data-value="Pharmacy Support">
                                        Pharmacy Support
                                    </button>

                                </div>

                                <input type="hidden" name="category" value="{{ old('category') }}">

                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Brand</label>

                            <input type="text" name="brand" value="{{ old('brand') }}" class="ml-admin-input"
                                placeholder="STORZ & BICKEL">
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
                                        Add colour variants only when the product has different colour options.
                                    </p>
                                </div>

                                <button type="button" class="ml-add-colour-btn" id="addVariantBtn">
                                    <i class="bi bi-plus-circle"></i>
                                    Add Colour
                                </button>

                            </div>


                            @php
                                $oldVariants = old('variants', []);
                            @endphp


                            <div id="variantList" class="ml-variant-list">

                                @foreach ($oldVariants as $variantIndex => $variant)

                                    <div class="ml-variant-card" data-variant-row>

                                        <div class="ml-variant-card-head">

                                            <div class="d-flex align-items-center gap-3">

                                                <span class="ml-variant-number">
                                                    {{ $loop->iteration }}
                                                </span>

                                                <div>
                                                    <strong>Colour Variant</strong>
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

                                                <input type="file" name="variants[{{ $variantIndex }}][image]"
                                                    class="form-control ml-variant-image-input" accept=".jpg,.jpeg,.png,.webp"
                                                    data-variant-image>

                                                <small class="text-muted d-block mt-2">
                                                    Upload the image shown when this colour is selected.
                                                </small>

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
                                                    Describe this specific colour image for accessibility and search.
                                                </small>
                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>


                            <div class="ml-variant-summary">

                                <div>
                                    <span>Total Colour Variants</span>

                                    <strong id="variantCount">
                                        {{ count($oldVariants) }}
                                    </strong>
                                </div>

                                <div>
                                    <span>Total Stock</span>

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

                            <div class="ml-custom-select">

                                <button type="button" class="ml-custom-select-btn">
                                    <span class="ml-custom-select-value">
                                        {{ old('product_type', 'Physical Product') }}
                                    </span>

                                    <i class="bi bi-chevron-down"></i>
                                </button>

                                <div class="ml-custom-select-menu">

                                    <button type="button" class="ml-custom-option" data-value="Physical Product">
                                        Physical Product
                                    </button>

                                    <button type="button" class="ml-custom-option" data-value="Medical Device">
                                        Medical Device
                                    </button>

                                    <button type="button" class="ml-custom-option" data-value="Accessory">
                                        Accessory
                                    </button>

                                </div>

                                <input type="hidden" name="product_type"
                                    value="{{ old('product_type', 'Physical Product') }}">

                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="ml-admin-label">
                                Reference Number
                            </label>

                            <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                                class="ml-admin-input" placeholder="e.g. 01 01 MM">
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

                            <input type="number" name="regular_price" value="{{ old('regular_price') }}" step="0.01" min="0"
                                class="ml-admin-input" placeholder="0.00" required>
                        </div>


                        <div class="col-md-4">
                            <label class="ml-admin-label">
                                Sale Price
                            </label>

                            <input type="number" name="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                                class="ml-admin-input" placeholder="0.00">
                        </div>


                        <div class="col-md-4">
                            <label class="ml-admin-label">
                                Cost Price
                            </label>

                            <input type="number" name="cost_price" value="{{ old('cost_price') }}" step="0.01" min="0"
                                class="ml-admin-input" placeholder="0.00">
                        </div>

                    </div>

                </div>


                {{-- =====================================================
                PRODUCT DESCRIPTION
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

                        <textarea name="short_description" class="ml-admin-textarea" rows="4"
                            placeholder="Write short product description...">{{ old('short_description') }}</textarea>
                    </div>


                    <div>
                        <label class="ml-admin-label">
                            Full Description
                        </label>

                        <textarea id="description" name="description" class="ml-admin-textarea ml-admin-long-textarea"
                            rows="8">{{ old('description', $product->description ?? '') }}</textarea>

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
                                value="{{ old('stock_quantity', 0) }}" min="0" class="ml-admin-input" readonly>

                            <small class="text-muted d-block mt-2">
                                Automatically calculated when colour variants are added.
                            </small>
                        </div>


                        <div class="col-md-4">
                            <label class="ml-admin-label">
                                Low Stock Alert
                            </label>

                            <input type="number" name="low_stock_alert" id="lowStockAlert"
                                value="{{ old('low_stock_alert', 5) }}" min="0" class="ml-admin-input"
                                placeholder="Example: 5">
                        </div>


                        <div class="col-md-4">
                            <label class="ml-admin-label">
                                Stock Status
                            </label>

                            <input type="hidden" name="stock_status" id="stockStatus"
                                value="{{ old('stock_status', 'out_of_stock') }}">

                            <div class="ml-auto-stock-status" id="stockStatusDisplay">
                                Out of Stock
                            </div>

                            <small class="text-muted d-block mt-2">
                                Automatically updated from total stock.
                            </small>
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


                    {{-- URL Slug --}}
                    <div class="mb-4">

                        <label class="ml-admin-label">
                            URL Slug
                        </label>

                        <input type="text" name="slug" id="productSlug" value="{{ old('slug') }}" class="ml-admin-input"
                            placeholder="mighty-plus-medic">

                        <div class="ml-seo-url-preview mt-2">
                            <small class="text-muted">
                                Product URL:
                                <strong id="productUrlPreview">
                                    /category/product-slug
                                </strong>
                            </small>
                        </div>

                        <small class="text-muted d-block mt-1">
                            Automatically generated from the product name. You can edit it before publishing.
                        </small>

                    </div>


                    {{-- SEO Title --}}
                    <div class="mb-4">

                        <label class="ml-admin-label">
                            SEO Title
                        </label>

                        <input type="text" name="seo_title" value="{{ old('seo_title') }}" class="ml-admin-input"
                            maxlength="255" placeholder="Mighty+ Medic Vaporizer Australia | STORZ & BICKEL">

                    </div>


                    {{-- Meta Description --}}
                    <div class="mb-4">

                        <label class="ml-admin-label">
                            Meta Description
                        </label>

                        <textarea name="meta_description" class="ml-admin-textarea" rows="4" maxlength="500"
                            placeholder="Enter a concise product description for search results.">{{ old('meta_description') }}</textarea>

                    </div>


                    {{-- Canonical --}}
                    <div class="mb-4">

                        <label class="ml-admin-label">
                            Canonical URL Override
                        </label>

                        <input type="url" name="canonical_url" value="{{ old('canonical_url') }}" class="ml-admin-input"
                            placeholder="Leave blank to use the automatic product URL">

                        <small class="text-muted d-block mt-2">
                            Leave blank in normal cases. MediLeaf will automatically use the product's public URL as
                            canonical.
                        </small>

                    </div>


                    {{-- Indexability --}}
                    <div class="ml-product-toggle-row mb-4">

                        <div>
                            <strong>Search Engine Visibility</strong>

                            <small class="text-muted d-block mt-1">
                                Allow search engines to index this product.
                            </small>
                        </div>

                        <label class="ml-admin-switch">

                            <input type="checkbox" name="is_indexable" value="1" {{ old('is_indexable', true) ? 'checked' : '' }}>

                            <small></small>

                        </label>

                    </div>


                    {{-- Social Sharing --}}
                    <div class="ml-admin-subsection">

                        <div class="mb-4">
                            <h5 class="mb-1">
                                Social Sharing
                            </h5>

                            <p class="text-muted mb-0">
                                Optional Open Graph values. Empty fields automatically use SEO/product fallbacks.
                            </p>
                        </div>


                        <div class="mb-4">

                            <label class="ml-admin-label">
                                OG Title
                            </label>

                            <input type="text" name="og_title" value="{{ old('og_title') }}" class="ml-admin-input"
                                maxlength="255" placeholder="Leave blank to use SEO Title">

                        </div>


                        <div class="mb-4">

                            <label class="ml-admin-label">
                                OG Description
                            </label>

                            <textarea name="og_description" class="ml-admin-textarea" rows="4" maxlength="500"
                                placeholder="Leave blank to use Meta Description">{{ old('og_description') }}</textarea>

                        </div>


                        <div>

                            <label class="ml-admin-label">
                                OG Image
                            </label>

                            <input type="file" name="og_image" id="ogImageInput" class="form-control"
                                accept=".jpg,.jpeg,.png,.webp">

                            <small class="text-muted d-block mt-2">
                                Optional. If no OG image is uploaded, the Featured Image will be used.
                            </small>

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
                PUBLISH
                ====================================================== --}}
                <div class="ml-admin-card ml-product-side-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-rocket-takeoff-fill"></i>
                            Publish
                        </h4>
                    </div>


                    <div class="ml-product-status-box">

                        <label class="ml-admin-label">
                            Product Status
                            <span class="text-danger">*</span>
                        </label>

                        <select name="status" class="ml-admin-input" required>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                                Published
                            </option>

                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                                Draft
                            </option>

                            <option value="hidden" {{ old('status') === 'hidden' ? 'selected' : '' }}>
                                Hidden
                            </option>
                        </select>

                    </div>


                    <div class="ml-product-toggle-row">

                        <span>Featured Product</span>

                        <label class="ml-admin-switch">

                            <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>

                            <small></small>

                        </label>

                    </div>


                    <div class="ml-product-toggle-row">

                        <span>Prescription Required</span>

                        <label class="ml-admin-switch">

                            <input type="checkbox" name="prescription_required" value="1" {{ old('prescription_required') ? 'checked' : '' }}>

                            <small></small>

                        </label>

                    </div>


                    <div class="ml-product-publish-actions">

                        <button type="submit" name="status" value="draft" class="ml-product-draft-btn">
                            Save Draft
                        </button>

                        <button type="submit" name="status" value="published" class="ml-product-publish-btn">
                            Publish Product
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

                            <i class="bi bi-cloud-arrow-up"></i>

                            <strong>
                                Upload Image
                            </strong>

                            <span>
                                PNG, JPG, WEBP up to 5MB
                            </span>

                        </div>

                    </label>


                    <div class="mt-3">

                        <label class="ml-admin-label">
                            Featured Image ALT Text
                        </label>

                        <input type="text" name="image_alt" value="{{ old('image_alt') }}" class="ml-admin-input"
                            placeholder="STORZ & BICKEL Mighty+ Medic portable medical vaporizer">

                        <small class="text-muted d-block mt-2">
                            Describe the featured product image accurately.
                        </small>

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
                        Add images one at a time. Each image can have its own name and ALT text.
                    </p>


                    @php
                        $oldGalleryItems = old('gallery_items', []);
                    @endphp


                    <div id="galleryItemList" class="ml-gallery-manager">

                        @foreach ($oldGalleryItems as $galleryIndex => $galleryItem)

                            <div class="ml-gallery-manager-item" data-gallery-row>

                                <div class="ml-gallery-manager-head">

                                    <strong>
                                        Image {{ $loop->iteration }}
                                    </strong>

                                    <button type="button" class="ml-gallery-remove-btn" data-remove-gallery
                                        aria-label="Remove gallery image">
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

                                    <input type="file" name="gallery_items[{{ $galleryIndex }}][image]" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp" data-gallery-image>

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
                                        placeholder="Mighty+ Medic front view" data-gallery-field="alt_text">

                                </div>


                                <input type="hidden" name="gallery_items[{{ $galleryIndex }}][sort_order]"
                                    value="{{ $galleryIndex }}" data-gallery-field="sort_order">

                            </div>

                        @endforeach

                    </div>


                    <div class="ml-gallery-empty-state {{ count($oldGalleryItems) ? 'd-none' : '' }}"
                        id="galleryEmptyState">
                        <i class="bi bi-images"></i>

                        <strong>
                            No gallery images added
                        </strong>

                        <span>
                            Click “Add Image” to add your first product gallery image.
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

                        <input type="number" name="weight" value="{{ old('weight') }}" step="0.01" min="0"
                            class="ml-admin-input" placeholder="0.00 kg">
                    </div>


                    <div class="mb-3">
                        <label class="ml-admin-label">
                            Length
                        </label>

                        <input type="number" name="length" value="{{ old('length') }}" step="0.01" min="0"
                            class="ml-admin-input" placeholder="0 cm">
                    </div>


                    <div class="mb-3">
                        <label class="ml-admin-label">
                            Width
                        </label>

                        <input type="number" name="width" value="{{ old('width') }}" step="0.01" min="0"
                            class="ml-admin-input" placeholder="0 cm">
                    </div>


                    <div>
                        <label class="ml-admin-label">
                            Height
                        </label>

                        <input type="number" name="height" value="{{ old('height') }}" step="0.01" min="0"
                            class="ml-admin-input" placeholder="0 cm">
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
                        placeholder="0" required>

                </div>


                <div class="col-md-4">

                    <label class="ml-admin-label">
                        Price Adjustment
                    </label>

                    <input type="number" data-field="price_adjustment" value="0" step="0.01" min="0" class="ml-admin-input"
                        placeholder="0.00">

                    <small class="text-muted d-block mt-2">
                        Keep 0 when this colour uses the normal product price.
                    </small>

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
    GALLERY IMAGE TEMPLATE
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