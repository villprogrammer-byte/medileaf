@extends('admin.layouts.app')

@section('title', 'Add Product')

@section('content')

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

    <form class="ml-product-create-form">

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

                        <div class="col-md-8">
                            <label class="ml-admin-label">Product Name</label>
                            <input type="text" class="ml-admin-input" id="productName" placeholder="Enter product name">
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Product SKU</label>
                            <input type="text" class="ml-admin-input" placeholder="ML-001">
                        </div>

                        <div class="col-md-6">
                            <label class="ml-admin-label">Slug</label>
                            <input type="text" class="ml-admin-input" id="productSlug" placeholder="product-slug">
                        </div>

                        <div class="col-md-6">
                            <label class="ml-admin-label">Category</label>
                            <select class="ml-admin-input">
                                <option>Select Category</option>
                                <option>Vaporisers</option>
                                <option>Accessories</option>
                                <option>Wellness Products</option>
                                <option>Pharmacy Support</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="ml-admin-label">Brand</label>
                            <input type="text" class="ml-admin-input" placeholder="STORZ & BICKEL">
                        </div>

                        <div class="col-md-6">
                            <label class="ml-admin-label">Product Type</label>
                            <select class="ml-admin-input">
                                <option>Physical Product</option>
                                <option>Medical Device</option>
                                <option>Accessory</option>
                            </select>
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
                            <label class="ml-admin-label">Regular Price</label>
                            <input type="number" class="ml-admin-input" placeholder="0.00">
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Sale Price</label>
                            <input type="number" class="ml-admin-input" placeholder="0.00">
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Cost Price</label>
                            <input type="number" class="ml-admin-input" placeholder="0.00">
                        </div>

                    </div>

                </div>

                <!-- Description -->
                <div class="ml-admin-card ml-product-form-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-card-text"></i>
                            Product Description
                        </h4>
                    </div>

                    <div class="mb-4">
                        <label class="ml-admin-label">Short Description</label>
                        <textarea class="ml-admin-textarea" rows="4"
                            placeholder="Write short product description..."></textarea>
                    </div>

                    <div>
                        <label class="ml-admin-label">Full Description</label>
                        <textarea class="ml-admin-textarea ml-admin-long-textarea" rows="8"
                            placeholder="Write full product details, features, specifications and usage guidance..."></textarea>
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
                            <label class="ml-admin-label">Stock Quantity</label>
                            <input type="number" class="ml-admin-input" placeholder="Enter PCS">
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Low Stock Alert</label>
                            <input type="number" class="ml-admin-input" placeholder="Example: 5">
                        </div>

                        <div class="col-md-4">
                            <label class="ml-admin-label">Stock Status</label>
                            <select class="ml-admin-input">
                                <option>In Stock</option>
                                <option>Out of Stock</option>
                                <option>Low Stock</option>
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
                        <input type="text" class="ml-admin-input" placeholder="Enter SEO title">
                    </div>

                    <div class="mb-4">
                        <label class="ml-admin-label">Meta Description</label>
                        <textarea class="ml-admin-textarea" rows="4" placeholder="Enter meta description"></textarea>
                    </div>

                    <div>
                        <label class="ml-admin-label">Image ALT Text</label>
                        <input type="text" class="ml-admin-input" placeholder="Enter image alt text">
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

                        <label class="ml-admin-label">Product Status</label>

                        <select class="ml-admin-input">
                            <option>Published</option>
                            <option>Draft</option>
                            <option>Hidden</option>
                        </select>

                    </div>

                    <div class="ml-product-toggle-row">
                        <span>Featured Product</span>
                        <label class="ml-admin-switch">
                            <input type="checkbox">
                            <small></small>
                        </label>
                    </div>

                    <div class="ml-product-toggle-row">
                        <span>Prescription Required</span>
                        <label class="ml-admin-switch">
                            <input type="checkbox">
                            <small></small>
                        </label>
                    </div>

                    <div class="ml-product-publish-actions">
                        <button type="button" class="ml-product-draft-btn">
                            Save Draft
                        </button>

                        <button type="submit" class="ml-product-publish-btn">
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
                        <input type="file" id="featuredImageInput" accept="image/*" hidden>

                        <div id="featuredPreview">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <strong>Upload Image</strong>
                            <span>PNG, JPG, WEBP up to 5MB</span>
                        </div>
                    </label>

                </div>

                <!-- RIGHT SIDE -->
                <div class="col-xl-4">
                    <!-- Product Gallery -->
                    <div class="ml-admin-card ml-product-side-card">

                        <div class="ml-admin-card-head">
                            <h4>
                                <i class="bi bi-images"></i>
                                Product Gallery
                            </h4>
                        </div>

                        <label class="ml-upload-box ml-gallery-upload">
                            <input type="file" id="galleryInput" multiple accept="image/*" hidden>

                            <i class="bi bi-images"></i>
                            <strong>Upload Gallery</strong>
                            <span>Select multiple product images</span>
                        </label>

                        <div class="ml-gallery-preview" id="galleryPreview"></div>

                        <div class="ml-gallery-item">
                            <i class="bi bi-image"></i>
                        </div>

                        <div class="ml-gallery-item">
                            <i class="bi bi-image"></i>
                        </div>

                        <div class="ml-gallery-item">
                            <i class="bi bi-image"></i>
                        </div>

                    </div>

                </div>


                <!-- Shipping -->
                <div class="ml-admin-card ml-product-side-card ml-product-publish-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-truck"></i>
                            Shipping
                        </h4>
                    </div>

                    <div class="mb-3">
                        <label class="ml-admin-label">Weight</label>
                        <input class="ml-admin-input" placeholder="0.00 kg">
                    </div>

                    <div class="mb-3">
                        <label class="ml-admin-label">Length</label>
                        <input class="ml-admin-input" placeholder="0 cm">
                    </div>

                    <div class="mb-3">
                        <label class="ml-admin-label">Width</label>
                        <input class="ml-admin-input" placeholder="0 cm">
                    </div>

                    <div>
                        <label class="ml-admin-label">Height</label>
                        <input class="ml-admin-input" placeholder="0 cm">
                    </div>

                </div>

            </div>

        </div>

        </div>

    </form>

@endsection