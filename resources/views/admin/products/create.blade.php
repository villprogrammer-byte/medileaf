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
            <p>Create and manage MediLeaf store products with pricing, stock and SEO details.</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="ml-admin-add-btn">
            <i class="bi bi-arrow-left"></i>
            Back to Products
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            <!-- LEFT SIDE -->
            <div class="col-xl-8">

                <!-- Basic Information -->
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

                            <input
                                type="text"
                                name="name"
                                id="productName"
                                value="{{ old('name') }}"
                                class="ml-admin-input"
                                placeholder="Enter product name"
                                required>
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Product SKU</label>

                            <input
                                type="text"
                                name="sku"
                                value="{{ old('sku') }}"
                                class="ml-admin-input"
                                placeholder="ML-001">
                        </div>

                        <div class="col-md-8">
                            <label class="ml-admin-label">Slug</label>

                            <input
                                type="text"
                                name="slug"
                                id="productSlug"
                                value="{{ old('slug') }}"
                                class="ml-admin-input"
                                placeholder="product-slug">
                        </div>

                        <div class="col-md-6">
                            <label class="ml-admin-label">Category</label>

                            <select name="category" class="ml-admin-input">
                                <option value="">Select Category</option>

                                <option value="Vaporisers" {{ old('category') === 'Vaporisers' ? 'selected' : '' }}>
                                    Vaporisers
                                </option>

                                <option value="Accessories" {{ old('category') === 'Accessories' ? 'selected' : '' }}>
                                    Accessories
                                </option>

                                <option value="Wellness Products" {{ old('category') === 'Wellness Products' ? 'selected' : '' }}>
                                    Wellness Products
                                </option>

                                <option value="Pharmacy Support" {{ old('category') === 'Pharmacy Support' ? 'selected' : '' }}>
                                    Pharmacy Support
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="ml-admin-label">Brand</label>

                            <input
                                type="text"
                                name="brand"
                                value="{{ old('brand') }}"
                                class="ml-admin-input"
                                placeholder="STORZ & BICKEL">
                        </div>

                        <!-- Colour Variants -->
                        <div class="col-md-12">
                            <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                                <div>
                                    <label class="ml-admin-label mb-1">Colour Variants</label>
                                    <p class="text-muted mb-0">
                                        Add each colour with its own SKU, quantity and image.
                                    </p>
                                </div>

                                <button type="button" class="ml-add-colour-btn" id="addVariantBtn">
                                    <i class="bi bi-plus-circle"></i>
                                    Add Colour
                                </button>
                            </div>

                            @php
                                $oldVariants = old('variants', [
                                    [
                                        'colour_name' => '',
                                        'colour_code' => '#31A050',
                                        'sku' => '',
                                        'quantity' => 0,
                                        'price_adjustment' => 0,
                                        'status' => 'active',
                                    ],
                                ]);
                            @endphp

                            <div id="variantList" class="ml-variant-list">
                                @foreach ($oldVariants as $variantIndex => $variant)
                                    <div class="ml-variant-card" data-variant-row>
                                        <div class="ml-variant-card-head">
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="ml-variant-number">{{ $loop->iteration }}</span>
                                                <div>
                                                    <strong>Colour Variant</strong>
                                                    <small>SKU, stock and image for this colour</small>
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
                                                    Colour Name <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    name="variants[{{ $variantIndex }}][colour_name]"
                                                    value="{{ $variant['colour_name'] ?? '' }}"
                                                    class="ml-admin-input"
                                                    placeholder="Example: Black"
                                                    required>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="ml-admin-label">Colour Code</label>
                                                <div class="ml-colour-code-field">
                                                    <input type="color"
                                                        class="ml-colour-picker"
                                                        value="{{ $variant['colour_code'] ?? '#31A050' }}"
                                                        data-colour-picker>
                                                    <input type="text"
                                                        name="variants[{{ $variantIndex }}][colour_code]"
                                                        value="{{ $variant['colour_code'] ?? '#31A050' }}"
                                                        class="ml-admin-input"
                                                        placeholder="#000000"
                                                        maxlength="20"
                                                        data-colour-code>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="ml-admin-label">
                                                    Variant SKU <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    name="variants[{{ $variantIndex }}][sku]"
                                                    value="{{ $variant['sku'] ?? '' }}"
                                                    class="ml-admin-input"
                                                    placeholder="ML-001-BLK"
                                                    required>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="ml-admin-label">
                                                    Quantity <span class="text-danger">*</span>
                                                </label>
                                                <input type="number"
                                                    name="variants[{{ $variantIndex }}][quantity]"
                                                    value="{{ $variant['quantity'] ?? 0 }}"
                                                    min="0"
                                                    class="ml-admin-input ml-variant-quantity"
                                                    placeholder="0"
                                                    required>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="ml-admin-label">Price Adjustment</label>
                                                <input type="number"
                                                    name="variants[{{ $variantIndex }}][price_adjustment]"
                                                    value="{{ $variant['price_adjustment'] ?? 0 }}"
                                                    step="0.01"
                                                    min="0"
                                                    class="ml-admin-input"
                                                    placeholder="0.00">
                                                <small class="text-muted d-block mt-2">
                                                    Keep 0 when the colour uses the normal product price.
                                                </small>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="ml-admin-label">Status</label>
                                                <select name="variants[{{ $variantIndex }}][status]"
                                                    class="ml-admin-input">
                                                    <option value="active"
                                                        {{ ($variant['status'] ?? 'active') === 'active' ? 'selected' : '' }}>
                                                        Active
                                                    </option>
                                                    <option value="inactive"
                                                        {{ ($variant['status'] ?? '') === 'inactive' ? 'selected' : '' }}>
                                                        Inactive
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="ml-admin-label">Colour Image</label>
                                                <input type="file"
                                                    name="variants[{{ $variantIndex }}][image]"
                                                    class="form-control ml-variant-image-input"
                                                    accept=".jpg,.jpeg,.png,.webp"
                                                    data-variant-image>
                                                <small class="text-muted d-block mt-2">
                                                    Upload the image that should appear when this colour is selected.
                                                </small>
                                                <div class="ml-variant-image-preview" data-variant-preview></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="ml-variant-summary">
                                <div>
                                    <span>Total Colour Variants</span>
                                    <strong id="variantCount">{{ count($oldVariants) }}</strong>
                                </div>
                                <div>
                                    <span>Total Stock</span>
                                    <strong><span id="variantTotalStock">0</span> PCS</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="ml-admin-label">Product Type</label>

                            <select name="product_type" class="ml-admin-input">

                                <option value="Physical Product" {{ old('product_type', 'Physical Product') === 'Physical Product' ? 'selected' : '' }}>
                                    Physical Product
                                </option>

                                <option value="Medical Device" {{ old('product_type') === 'Medical Device' ? 'selected' : '' }}>
                                    Medical Device
                                </option>

                                <option value="Accessory" {{ old('product_type') === 'Accessory' ? 'selected' : '' }}>
                                    Accessory
                                </option>

                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="ml-admin-label">Reference Number</label>

                            <input
                                type="text"
                                name="reference_number"
                                class="ml-admin-input"
                                placeholder="e.g. 01 01 MM"
                                value="{{ old('reference_number') }}">
                        </div>

                    </div>

                </div>

                <!-- Pricing -->
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
                                Regular Price <span class="text-danger">*</span>
                            </label>

                            <input
                                type="number"
                                name="regular_price"
                                value="{{ old('regular_price') }}"
                                step="0.01"
                                min="0"
                                class="ml-admin-input"
                                placeholder="0.00"
                                required>
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Sale Price</label>

                            <input
                                type="number"
                                name="sale_price"
                                value="{{ old('sale_price') }}"
                                step="0.01"
                                min="0"
                                class="ml-admin-input"
                                placeholder="0.00">
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Cost Price</label>

                            <input
                                type="number"
                                name="cost_price"
                                value="{{ old('cost_price') }}"
                                step="0.01"
                                min="0"
                                class="ml-admin-input"
                                placeholder="0.00">
                        </div>

                    </div>

                </div>

                <!-- Product Description -->
                <div class="ml-admin-card ml-product-form-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-card-text"></i>
                            Product Description
                        </h4>
                    </div>

                    <div class="mb-4">
                        <label class="ml-admin-label">Short Description</label>

                        <textarea
                            name="short_description"
                            class="ml-admin-textarea"
                            rows="4"
                            placeholder="Write short product description...">{{ old('short_description') }}</textarea>
                    </div>

                    <div>
                        <label class="ml-admin-label">Full Description</label>

                        <textarea
                            id="description"
                            name="description"
                            class="ml-admin-textarea ml-admin-long-textarea"
                            rows="8">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>

                </div>

                <!-- Inventory -->
                <div class="ml-admin-card ml-product-form-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-boxes"></i>
                            Inventory
                        </h4>
                    </div>

                    <div class="row g-4">

                        <div class="col-md-4">
                            <label class="ml-admin-label">Total Stock Quantity</label>

                            <input
                                type="number"
                                name="stock_quantity"
                                id="stockQuantity"
                                value="{{ old('stock_quantity', 0) }}"
                                min="0"
                                class="ml-admin-input"
                                readonly>

                            <small class="text-muted d-block mt-2">
                                Automatically calculated from all colour quantities.
                            </small>
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Low Stock Alert</label>

                            <input
                                type="number"
                                name="low_stock_alert"
                                id="lowStockAlert"
                                value="{{ old('low_stock_alert', 5) }}"
                                min="0"
                                class="ml-admin-input"
                                placeholder="Example: 5">
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Stock Status</label>

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

                <!-- SEO -->
                <div class="ml-admin-card ml-product-form-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-search-heart"></i>
                            SEO Details
                        </h4>
                    </div>

                    <div class="mb-4">
                        <label class="ml-admin-label">SEO Title</label>

                        <input
                            type="text"
                            name="seo_title"
                            value="{{ old('seo_title') }}"
                            class="ml-admin-input"
                            placeholder="Enter SEO title">
                    </div>

                    <div class="mb-4">
                        <label class="ml-admin-label">Meta Description</label>

                        <textarea
                            name="meta_description"
                            class="ml-admin-textarea"
                            rows="4"
                            placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
                    </div>

                    <div>
                        <label class="ml-admin-label">Image ALT Text</label>

                        <input
                            type="text"
                            name="image_alt"
                            value="{{ old('image_alt') }}"
                            class="ml-admin-input"
                            placeholder="Enter image alt text">
                    </div>

                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="col-xl-4">

                <!-- Publish -->
                <div class="ml-admin-card ml-product-side-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-rocket-takeoff-fill"></i>
                            Publish
                        </h4>
                    </div>

                    <div class="ml-product-status-box">

                        <label class="ml-admin-label">
                            Product Status <span class="text-danger">*</span>
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
                            <input
                                type="checkbox"
                                name="featured"
                                value="1"
                                {{ old('featured') ? 'checked' : '' }}>

                            <small></small>
                        </label>
                    </div>

                    <div class="ml-product-toggle-row">
                        <span>Prescription Required</span>

                        <label class="ml-admin-switch">
                            <input
                                type="checkbox"
                                name="prescription_required"
                                value="1"
                                {{ old('prescription_required') ? 'checked' : '' }}>

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

                <!-- Featured Image -->
                <div class="ml-admin-card ml-product-side-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-image-fill"></i>
                            Featured Image
                        </h4>
                    </div>

                    <label class="ml-upload-box" id="featuredUpload">

                        <input
                            type="file"
                            name="featured_image"
                            id="featuredImageInput"
                            accept=".jpg,.jpeg,.png,.webp"
                            hidden>

                        <div id="featuredPreview">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <strong>Upload Image</strong>
                            <span>PNG, JPG, WEBP up to 5MB</span>
                        </div>

                    </label>

                </div>

                <!-- Product Gallery -->
                <div class="ml-admin-card ml-product-side-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-images"></i>
                            Product Gallery
                        </h4>
                    </div>

                    <label class="ml-upload-box ml-gallery-upload">

                        <input
                            type="file"
                            name="gallery_images[]"
                            id="galleryInput"
                            accept=".jpg,.jpeg,.png,.webp"
                            multiple
                            hidden>

                        <i class="bi bi-images"></i>
                        <strong>Upload Gallery</strong>
                        <span>Select multiple product images</span>

                    </label>

                    <div class="ml-gallery-preview" id="galleryPreview"></div>

                </div>

                <!-- Shipping -->
                <div class="ml-admin-card ml-product-side-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-truck"></i>
                            Shipping
                        </h4>
                    </div>

                    <div class="mb-3">
                        <label class="ml-admin-label">Weight</label>

                        <input
                            type="number"
                            name="weight"
                            value="{{ old('weight') }}"
                            step="0.01"
                            min="0"
                            class="ml-admin-input"
                            placeholder="0.00 kg">
                    </div>

                    <div class="mb-3">
                        <label class="ml-admin-label">Length</label>

                        <input
                            type="number"
                            name="length"
                            value="{{ old('length') }}"
                            step="0.01"
                            min="0"
                            class="ml-admin-input"
                            placeholder="0 cm">
                    </div>

                    <div class="mb-3">
                        <label class="ml-admin-label">Width</label>

                        <input
                            type="number"
                            name="width"
                            value="{{ old('width') }}"
                            step="0.01"
                            min="0"
                            class="ml-admin-input"
                            placeholder="0 cm">
                    </div>

                    <div>
                        <label class="ml-admin-label">Height</label>

                        <input
                            type="number"
                            name="height"
                            value="{{ old('height') }}"
                            step="0.01"
                            min="0"
                            class="ml-admin-input"
                            placeholder="0 cm">
                    </div>

                </div>

            </div>

        </div>

    </form>

    <template id="variantTemplate">
        <div class="ml-variant-card" data-variant-row>
            <div class="ml-variant-card-head">
                <div class="d-flex align-items-center gap-3">
                    <span class="ml-variant-number">1</span>
                    <div>
                        <strong>Colour Variant</strong>
                        <small>SKU, stock and image for this colour</small>
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
                        Colour Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" data-field="colour_name" class="ml-admin-input"
                        placeholder="Example: Black" required>
                </div>

                <div class="col-md-3">
                    <label class="ml-admin-label">Colour Code</label>
                    <div class="ml-colour-code-field">
                        <input type="color" class="ml-colour-picker" value="#31A050" data-colour-picker>
                        <input type="text" data-field="colour_code" value="#31A050"
                            class="ml-admin-input" placeholder="#000000" maxlength="20" data-colour-code>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="ml-admin-label">
                        Variant SKU <span class="text-danger">*</span>
                    </label>
                    <input type="text" data-field="sku" class="ml-admin-input"
                        placeholder="ML-001-BLK" required>
                </div>

                <div class="col-md-4">
                    <label class="ml-admin-label">
                        Quantity <span class="text-danger">*</span>
                    </label>
                    <input type="number" data-field="quantity" value="0" min="0"
                        class="ml-admin-input ml-variant-quantity" placeholder="0" required>
                </div>

                <div class="col-md-4">
                    <label class="ml-admin-label">Price Adjustment</label>
                    <input type="number" data-field="price_adjustment" value="0" step="0.01"
                        min="0" class="ml-admin-input" placeholder="0.00">
                    <small class="text-muted d-block mt-2">
                        Keep 0 when the colour uses the normal product price.
                    </small>
                </div>

                <div class="col-md-4">
                    <label class="ml-admin-label">Status</label>
                    <select data-field="status" class="ml-admin-input">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="ml-admin-label">Colour Image</label>
                    <input type="file" data-field="image"
                        class="form-control ml-variant-image-input"
                        accept=".jpg,.jpeg,.png,.webp" data-variant-image>
                    <small class="text-muted d-block mt-2">
                        Upload the image that should appear when this colour is selected.
                    </small>
                    <div class="ml-variant-image-preview" data-variant-preview></div>
                </div>
            </div>
        </div>
    </template>

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script src="{{ asset('js/product-variants.js') }}"></script>
    @endpush

@endsection