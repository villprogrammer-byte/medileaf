@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')

    @php
        $defaultColours = ['Black', 'Silver', 'White', 'Blue', 'Green'];
        $selectedColours = old('colors', $product->colors ?? []);
        $customColours = array_values(array_diff($selectedColours, $defaultColours));
    @endphp

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
            <p>Update product details, pricing, stock, images and SEO information.</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="ml-admin-add-btn">
            <i class="bi bi-arrow-left"></i>
            Back to Products
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
        class="ml-product-create-form">

        @csrf
        @method('PUT')

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

                            <input type="text" name="name" id="productName" value="{{ old('name', $product->name) }}"
                                class="ml-admin-input" placeholder="Enter product name" required>
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Product SKU</label>

                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                                class="ml-admin-input" placeholder="ML-001">
                        </div>

                        <div class="col-md-8">
                            <label class="ml-admin-label">Slug</label>

                            <input type="text" name="slug" id="productSlug" value="{{ old('slug', $product->slug) }}"
                                class="ml-admin-input" placeholder="product-slug">
                        </div>

                        <div class="col-md-6">
                            <label class="ml-admin-label">Category</label>

                            <select name="category" class="ml-admin-input">
                                <option value="">Select Category</option>

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

                        <div class="col-md-6">
                            <label class="ml-admin-label">Brand</label>

                            <input type="text" name="brand" value="{{ old('brand', $product->brand) }}"
                                class="ml-admin-input" placeholder="STORZ & BICKEL">
                        </div>

                        <!-- Colours -->
                        <div class="col-md-12">

                            @php
                                $defaultColours = ['Black', 'Silver', 'White', 'Blue', 'Green'];

                                $selectedColours = old(
                                    'colors',
                                    is_array($product->colors) ? $product->colors : []
                                );

                                $existingColourImages = is_array($product->color_images)
                                    ? $product->color_images
                                    : [];

                                $customColours = array_values(
                                    array_diff($selectedColours, $defaultColours)
                                );
                            @endphp

                            <label class="ml-admin-label">
                                Available Colours
                            </label>

                            <p class="text-muted mb-3">
                                Select available colours and upload a separate image for each colour.
                            </p>

                            <div class="ml-colour-image-list">

                                @foreach ($defaultColours as $colour)

                                    @php
                                        $colourId = 'colour-' . \Illuminate\Support\Str::slug($colour);
                                        $isSelected = in_array($colour, $selectedColours, true);
                                        $currentImage = $existingColourImages[$colour] ?? null;
                                    @endphp

                                    <div class="border rounded p-3 mb-3 ml-colour-image-item">

                                        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">

                                            <label class="ml-color-chip mb-0" for="{{ $colourId }}">
                                                <input type="checkbox" name="colors[]" value="{{ $colour }}"
                                                    id="{{ $colourId }}" {{ $isSelected ? 'checked' : '' }}>
                                                <span>{{ $colour }}</span>
                                            </label>

                                            @if ($currentImage)
                                                <span class="badge bg-success">
                                                    Image added
                                                </span>
                                            @endif

                                        </div>

                                        @if ($currentImage)
                                            <div class="mb-3">
                                                <img src="{{ asset('storage/' . $currentImage) }}"
                                                    alt="{{ $colour }} colour image"
                                                    style="width:120px; height:120px; object-fit:contain; border:1px solid #e5e7eb; border-radius:10px; background:#ffffff; padding:8px;">
                                            </div>
                                        @endif

                                        <label class="ml-admin-label">
                                            {{ $currentImage ? 'Replace' : 'Upload' }} {{ $colour }} Image
                                        </label>

                                        <input type="file" name="color_images[{{ $colour }}]" class="form-control"
                                            accept=".jpg,.jpeg,.png,.webp">

                                        <small class="text-muted d-block mt-2">
                                            JPG, PNG or WEBP up to 5MB.
                                        </small>

                                        @if ($currentImage)
                                            <label class="form-check mt-3">
                                                <input type="checkbox" name="remove_color_images[]"
                                                    value="{{ $colour }}" class="form-check-input">
                                                <span class="form-check-label text-danger">
                                                    Remove current {{ $colour }} image
                                                </span>
                                            </label>
                                        @endif

                                    </div>

                                @endforeach

                                {{-- Existing custom colours --}}
                                @foreach ($customColours as $customColour)

                                    @php
                                        $customId = 'custom-colour-' . \Illuminate\Support\Str::slug($customColour) . '-' . $loop->index;
                                        $currentCustomImage = $existingColourImages[$customColour] ?? null;
                                    @endphp

                                    <div class="border rounded p-3 mb-3 ml-colour-image-item">

                                        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">

                                            <label class="ml-color-chip mb-0" for="{{ $customId }}">
                                                <input type="checkbox" name="colors[]" value="{{ $customColour }}"
                                                    id="{{ $customId }}" checked>
                                                <span>{{ $customColour }}</span>
                                            </label>

                                            <span class="badge bg-secondary">
                                                Custom Colour
                                            </span>

                                        </div>

                                        @if ($currentCustomImage)
                                            <div class="mb-3">
                                                <img src="{{ asset('storage/' . $currentCustomImage) }}"
                                                    alt="{{ $customColour }} colour image"
                                                    style="width:120px; height:120px; object-fit:contain; border:1px solid #e5e7eb; border-radius:10px; background:#ffffff; padding:8px;">
                                            </div>
                                        @endif

                                        <label class="ml-admin-label">
                                            {{ $currentCustomImage ? 'Replace' : 'Upload' }} {{ $customColour }} Image
                                        </label>

                                        <input type="file" name="color_images[{{ $customColour }}]" class="form-control"
                                            accept=".jpg,.jpeg,.png,.webp">

                                        <small class="text-muted d-block mt-2">
                                            JPG, PNG or WEBP up to 5MB.
                                        </small>

                                        @if ($currentCustomImage)
                                            <label class="form-check mt-3">
                                                <input type="checkbox" name="remove_color_images[]"
                                                    value="{{ $customColour }}" class="form-check-input">
                                                <span class="form-check-label text-danger">
                                                    Remove current {{ $customColour }} image
                                                </span>
                                            </label>
                                        @endif

                                    </div>

                                @endforeach

                            </div>

                            {{-- Add another custom colour --}}
                            <div class="ml-custom-colour-box border rounded p-3 mt-3">

                                <label class="ml-admin-label">
                                    Add Another Custom Colour
                                </label>

                                <input type="text" name="custom_colour" value="{{ old('custom_colour') }}"
                                    class="ml-admin-input mb-3" placeholder="Example: Titanium Grey">

                                <label class="ml-admin-label">
                                    Custom Colour Image
                                </label>

                                <input type="file" name="custom_colour_image" class="form-control"
                                    accept=".jpg,.jpeg,.png,.webp">

                                <small class="text-muted d-block mt-2">
                                    Enter the custom colour name and upload its image.
                                </small>

                            </div>

                        </div>

                        <div class="col-md-6">
                            <label class="ml-admin-label">Product Type</label>

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
                            <label class="ml-admin-label">Reference Number</label>

                            <input type="text" name="reference_number" class="ml-admin-input"
                                placeholder="e.g. 01 01 MM"
                                value="{{ old('reference_number', $product->reference_number ?? '') }}">
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

                            <input type="number" name="regular_price"
                                value="{{ old('regular_price', $product->regular_price) }}" step="0.01" min="0"
                                class="ml-admin-input" placeholder="0.00" required>
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Sale Price</label>

                            <input type="number" name="sale_price"
                                value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0"
                                class="ml-admin-input" placeholder="0.00">
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Cost Price</label>

                            <input type="number" name="cost_price"
                                value="{{ old('cost_price', $product->cost_price) }}" step="0.01" min="0"
                                class="ml-admin-input" placeholder="0.00">
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

                        <textarea name="short_description" class="ml-admin-textarea" rows="4"
                            placeholder="Write short product description...">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>

                    <div>
                        <label class="ml-admin-label">Full Description</label>

                        <textarea name="description" class="ml-admin-textarea ml-admin-long-textarea" rows="8"
                            placeholder="Write full product details, features, specifications and usage guidance...">{{ old('description', $product->description) }}</textarea>
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
                            <label class="ml-admin-label">
                                Stock Quantity <span class="text-danger">*</span>
                            </label>

                            <input type="number" name="stock_quantity"
                                value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0"
                                class="ml-admin-input" placeholder="Enter PCS" required>
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Low Stock Alert</label>

                            <input type="number" name="low_stock_alert"
                                value="{{ old('low_stock_alert', $product->low_stock_alert) }}" min="0"
                                class="ml-admin-input" placeholder="Example: 5">
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">
                                Stock Status <span class="text-danger">*</span>
                            </label>

                            <select name="stock_status" class="ml-admin-input" required>

                                <option value="in_stock" {{ old('stock_status', $product->stock_status) === 'in_stock' ? 'selected' : '' }}>
                                    In Stock
                                </option>

                                <option value="out_of_stock" {{ old('stock_status', $product->stock_status) === 'out_of_stock' ? 'selected' : '' }}>
                                    Out of Stock
                                </option>

                                <option value="low_stock" {{ old('stock_status', $product->stock_status) === 'low_stock' ? 'selected' : '' }}>
                                    Low Stock
                                </option>

                            </select>
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

                        <input type="text" name="seo_title" value="{{ old('seo_title', $product->seo_title) }}"
                            class="ml-admin-input" placeholder="Enter SEO title">
                    </div>

                    <div class="mb-4">
                        <label class="ml-admin-label">Meta Description</label>

                        <textarea name="meta_description" class="ml-admin-textarea" rows="4"
                            placeholder="Enter meta description">{{ old('meta_description', $product->meta_description) }}</textarea>
                    </div>

                    <div>
                        <label class="ml-admin-label">Image ALT Text</label>

                        <input type="text" name="image_alt" value="{{ old('image_alt', $product->image_alt) }}"
                            class="ml-admin-input" placeholder="Enter image alt text">
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
                            Update Product
                        </h4>
                    </div>

                    <div class="ml-product-status-box">

                        <label class="ml-admin-label">
                            Product Status <span class="text-danger">*</span>
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
                        <span>Featured Product</span>

                        <label class="ml-admin-switch">
                            <input type="checkbox" name="featured" value="1"
                                {{ old('featured', $product->featured) ? 'checked' : '' }}>
                            <small></small>
                        </label>
                    </div>

                    <div class="ml-product-toggle-row">
                        <span>Prescription Required</span>

                        <label class="ml-admin-switch">
                            <input type="checkbox" name="prescription_required" value="1"
                                {{ old('prescription_required', $product->prescription_required) ? 'checked' : '' }}>
                            <small></small>
                        </label>
                    </div>

                    <div class="ml-product-publish-actions">

                        <button type="submit" name="status" value="draft" class="ml-product-draft-btn">
                            Save as Draft
                        </button>

                        <button type="submit" class="ml-product-publish-btn">
                            Update Product
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

                        <input type="file" name="featured_image" id="featuredImageInput"
                            accept=".jpg,.jpeg,.png,.webp" hidden>

                        <div id="featuredPreview">

                            @if ($product->featured_image)
                                <img src="{{ asset('storage/' . $product->featured_image) }}"
                                    alt="{{ $product->image_alt ?: $product->name }}" class="ml-featured-preview">
                            @else
                                <i class="bi bi-cloud-arrow-up"></i>
                                <strong>Upload Image</strong>
                                <span>PNG, JPG, WEBP up to 5MB</span>
                            @endif

                        </div>

                    </label>

                    @if ($product->featured_image)
                        <small class="text-muted d-block mt-2">
                            Upload a new image only when you want to replace the current image.
                        </small>
                    @endif

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

                        <input type="file" name="gallery_images[]" id="galleryInput"
                            accept=".jpg,.jpeg,.png,.webp" multiple hidden>

                        <i class="bi bi-images"></i>
                        <strong>Upload New Gallery Images</strong>
                        <span>Select multiple product images</span>

                    </label>

                    <div class="ml-gallery-preview" id="galleryPreview">

                        @foreach ($product->gallery_images ?? [] as $galleryImage)
                            <div class="ml-gallery-item">
                                <img src="{{ asset('storage/' . $galleryImage) }}"
                                    alt="{{ $product->image_alt ?: $product->name }}">
                            </div>
                        @endforeach

                    </div>

                    @if (!empty($product->gallery_images))
                        <small class="text-muted d-block mt-2">
                            Uploading new gallery images will replace the existing gallery.
                        </small>
                    @endif

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

                        <input type="number" name="weight" value="{{ old('weight', $product->weight) }}"
                            step="0.01" min="0" class="ml-admin-input" placeholder="0.00 kg">
                    </div>

                    <div class="mb-3">
                        <label class="ml-admin-label">Length</label>

                        <input type="number" name="length" value="{{ old('length', $product->length) }}"
                            step="0.01" min="0" class="ml-admin-input" placeholder="0 cm">
                    </div>

                    <div class="mb-3">
                        <label class="ml-admin-label">Width</label>

                        <input type="number" name="width" value="{{ old('width', $product->width) }}"
                            step="0.01" min="0" class="ml-admin-input" placeholder="0 cm">
                    </div>

                    <div>
                        <label class="ml-admin-label">Height</label>

                        <input type="number" name="height" value="{{ old('height', $product->height) }}"
                            step="0.01" min="0" class="ml-admin-input" placeholder="0 cm">
                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection