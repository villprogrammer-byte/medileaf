@extends('admin.layouts.app')

@section('content')

    <div class="container-fluid product-gallery-page">

        {{-- Header --}}
        <div class="product-gallery-header">
            <div>
                <h2 class="product-gallery-title">Product Gallery</h2>
                <p class="product-gallery-subtitle">
                    View, optimise and manage all product images.
                </p>
            </div>

            <button type="button" class="product-gallery-upload-btn" data-bs-toggle="modal"
                data-bs-target="#uploadProductImageModal">
                <i class="bi bi-cloud-upload"></i>
                <span>Upload Image</span>
            </button>
        </div>

        {{-- Success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show product-gallery-alert" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        @endif

        {{-- Errors --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show product-gallery-alert" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ $errors->first() }}</span>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        @endif

        {{-- Gallery --}}
        <div class="product-gallery-main-card">

            @if($featuredImages->count() || $galleryImages->count())

                <div class="product-gallery-grid">

                    {{-- Featured Images --}}
                    @foreach($featuredImages as $product)

                        @php
                            $featuredUrl = asset(
                                'storage/' . ltrim($product->featured_image, '/')
                            );

                            $meta = $featuredMeta[$product->id] ?? [];

                            $featuredName = $product->featured_image_display_name;
                        @endphp

                        <div class="product-gallery-card" role="button" data-bs-toggle="modal"
                            data-bs-target="#viewFeaturedImage{{ $product->id }}">

                            <div class="product-gallery-image-wrap">

                                <img src="{{ $featuredUrl }}" alt="{{ $product->featured_image_alt }}"
                                    class="product-gallery-image">

                                <span class="product-gallery-badge">
                                    <i class="bi bi-star-fill"></i>
                                    Featured
                                </span>

                                <form method="POST" action="{{ route('admin.product-gallery.featured.destroy', $product) }}"
                                    class="product-gallery-card-delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="product-gallery-card-delete-btn" title="Delete featured image"
                                        aria-label="Delete featured image">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>

                                <div class="product-gallery-hover">
                                    <span>
                                        <i class="bi bi-eye"></i>
                                        View
                                    </span>
                                </div>

                            </div>

                            <div class="product-gallery-info">
                                <span class="product-gallery-name">
                                    {{ $featuredName }}
                                </span>

                                <small class="product-gallery-product-name">
                                    {{ $product->name }}
                                </small>
                            </div>

                        </div>

                        {{-- Featured View / Manage Modal --}}
                        <div class="modal fade product-image-manager-modal" id="viewFeaturedImage{{ $product->id }}" tabindex="-1"
                            aria-hidden="true">

                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

                                <div class="modal-content product-image-manager">

                                    {{-- Modal Header --}}
                                    <div class="product-image-manager-header">

                                        <div>
                                            <span class="product-image-manager-eyebrow">
                                                Featured Product Image
                                            </span>

                                            <h4 title="{{ $featuredName }}">
                                                {{ $featuredName }}
                                            </h4>
                                        </div>

                                        <button type="button" class="product-image-manager-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i class="bi bi-x-lg"></i>
                                        </button>

                                    </div>

                                    <div class="product-image-manager-body">

                                        {{-- Left Preview --}}
                                        <div class="product-image-manager-preview">

                                            <div class="product-image-preview-stage">

                                                <img src="{{ $featuredUrl }}" alt="{{ $product->featured_image_alt }}">

                                                <span class="product-image-preview-badge">
                                                    <i class="bi bi-star-fill"></i>
                                                    Featured
                                                </span>

                                            </div>

                                            <div class="product-image-preview-footer">

                                                <div>
                                                    <span>Associated Product</span>

                                                    <strong>
                                                        {{ $product->name }}
                                                    </strong>
                                                </div>

                                                <button type="button" class="product-image-copy-btn copy-image-url"
                                                    data-url="{{ $featuredUrl }}">

                                                    <i class="bi bi-link-45deg"></i>
                                                    Copy URL
                                                </button>

                                            </div>

                                        </div>

                                        {{-- Right Panel --}}
                                        <div class="product-image-manager-panel">

                                            {{-- Edit Details --}}
                                            <div class="product-image-panel-section">

                                                <div class="product-image-section-head">
                                                    <div>
                                                        <h5>Image Details</h5>
                                                        <p>
                                                            Manage image name and SEO ALT text.
                                                        </p>
                                                    </div>

                                                    <span class="product-image-type-pill">
                                                        {{ $meta['type'] ?? 'WEBP' }}
                                                    </span>
                                                </div>

                                                <form method="POST"
                                                    action="{{ route('admin.product-gallery.featured.update', $product) }}">

                                                    @csrf
                                                    @method('PUT')

                                                    <div class="product-image-field">
                                                        <label>
                                                            Image Name
                                                        </label>

                                                        <input type="text" name="featured_image_name"
                                                            value="{{ $product->featured_image_name }}" maxlength="255"
                                                            placeholder="Enter image name">
                                                    </div>

                                                    <div class="product-image-field">
                                                        <label>
                                                            ALT Text
                                                            <span>SEO</span>
                                                        </label>

                                                        <textarea name="image_alt" maxlength="255" rows="3"
                                                            placeholder="Describe this image for search engines">{{ $product->image_alt }}</textarea>

                                                        <small>
                                                            Keep it descriptive and relevant to the product.
                                                        </small>
                                                    </div>

                                                    <button type="submit" class="product-image-save-btn">

                                                        <i class="bi bi-check2"></i>
                                                        Save Changes
                                                    </button>

                                                </form>

                                            </div>

                                            {{-- File Information --}}
                                            <div class="product-image-panel-section">

                                                <div class="product-image-section-head">
                                                    <div>
                                                        <h5>File Information</h5>
                                                        <p>
                                                            Technical image details.
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="product-image-meta-grid">

                                                    <div class="product-image-meta-item">
                                                        <span>File Type</span>
                                                        <strong>
                                                            {{ $meta['type'] ?? 'WEBP' }}
                                                        </strong>
                                                    </div>

                                                    <div class="product-image-meta-item">
                                                        <span>Dimensions</span>
                                                        <strong>
                                                            {{ $meta['dimensions'] ?? 'Unknown' }}
                                                        </strong>
                                                    </div>

                                                    <div class="product-image-meta-item">
                                                        <span>File Size</span>
                                                        <strong>
                                                            {{ $meta['size'] ?? 'Unknown' }}
                                                        </strong>
                                                    </div>

                                                    <div class="product-image-meta-item">
                                                        <span>File Date</span>
                                                        <strong>
                                                            {{ $meta['date'] ?? 'Unknown' }}
                                                        </strong>
                                                    </div>

                                                </div>

                                                <div class="product-image-file-name">
                                                    <span>Stored File</span>

                                                    <strong title="{{ $meta['filename'] ?? '' }}">
                                                        {{ $meta['filename'] ?? 'Unknown' }}
                                                    </strong>
                                                </div>

                                            </div>

                                            {{-- Replace Image --}}
                                            <div class="product-image-panel-section">

                                                <div class="product-image-section-head">
                                                    <div>
                                                        <h5>Replace Image</h5>
                                                        <p>
                                                            Database record stays the same. WebP only.
                                                        </p>
                                                    </div>
                                                </div>

                                                <form method="POST"
                                                    action="{{ route('admin.product-gallery.featured.replace', $product) }}"
                                                    enctype="multipart/form-data">

                                                    @csrf

                                                    <div class="product-image-replace-box">

                                                        <div class="product-image-replace-icon">
                                                            <i class="bi bi-arrow-repeat"></i>
                                                        </div>

                                                        <div class="product-image-replace-content">
                                                            <strong>Select replacement image</strong>
                                                            <small>Only .webp files up to 5 MB</small>
                                                        </div>

                                                        <input type="file" name="image" class="product-image-file-input"
                                                            accept=".webp,image/webp" required>

                                                    </div>

                                                    <button type="submit" class="product-image-replace-btn">

                                                        <i class="bi bi-arrow-repeat"></i>
                                                        Replace Image
                                                    </button>

                                                </form>

                                            </div>

                                            {{-- Danger Zone --}}
                                            <div class="product-image-danger-zone">

                                                <div>
                                                    <h5>Delete Image</h5>
                                                    <p>
                                                        Permanently remove this featured image from the product.
                                                    </p>
                                                </div>

                                                <form method="POST"
                                                    action="{{ route('admin.product-gallery.featured.destroy', $product) }}"
                                                    onsubmit="return confirm('Are you sure you want to permanently delete this featured image?');">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="product-image-delete-btn">

                                                        <i class="bi bi-trash3"></i>
                                                        Delete
                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                    {{-- Gallery Images --}}
                    @foreach($galleryImages as $image)

                        @php
                            $meta = $galleryMeta[$image->id] ?? [];
                        @endphp

                        <div class="product-gallery-card" role="button" data-bs-toggle="modal"
                            data-bs-target="#viewGalleryImage{{ $image->id }}">

                            <div class="product-gallery-image-wrap">
                                <img src="{{ $image->image_url }}" alt="{{ $image->alt_text_value }}" class="product-gallery-image">

                                <form method="POST" action="{{ route('admin.product-gallery.destroy', $image) }}"
                                    class="product-gallery-card-delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="product-gallery-card-delete-btn" title="Delete image"
                                        aria-label="Delete image">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>

                                <div class="product-gallery-hover">
                                    <span>
                                        <i class="bi bi-eye"></i>
                                        View
                                    </span>
                                </div>
                            </div>

                            <div class="product-gallery-info">

                                <div class="product-gallery-card-text">

                                    <span class="product-gallery-name" title="{{ $image->display_name }}">
                                        {{ $image->display_name }}
                                    </span>

                                    @if($image->product)
                                        <small class="product-gallery-product-name" title="{{ $image->product->name }}">
                                            {{ $image->product->name }}
                                        </small>
                                    @else
                                        <small class="product-gallery-product-name">
                                            Not linked to a product
                                        </small>
                                    @endif

                                </div>

                            </div>

                        </div>

                        {{-- Gallery View / Manage Modal --}}
                        <div class="modal fade product-image-manager-modal" id="viewGalleryImage{{ $image->id }}" tabindex="-1"
                            aria-hidden="true">

                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

                                <div class="modal-content product-image-manager">

                                    {{-- Header --}}
                                    <div class="product-image-manager-header">

                                        <div>
                                            <span class="product-image-manager-eyebrow">
                                                Product Gallery Image
                                            </span>

                                            <h4>
                                                {{ $image->display_name }}
                                            </h4>
                                        </div>

                                        <button type="button" class="product-image-manager-close" data-bs-dismiss="modal"
                                            aria-label="Close">

                                            <i class="bi bi-x-lg"></i>
                                        </button>

                                    </div>

                                    <div class="product-image-manager-body">

                                        {{-- Left Preview --}}
                                        <div class="product-image-manager-preview">

                                            <div class="product-image-preview-stage">

                                                <img src="{{ $image->image_url }}" alt="{{ $image->alt_text_value }}">

                                            </div>

                                            <div class="product-image-preview-footer">

                                                <div>
                                                    <span>Associated Product</span>

                                                    <strong>
                                                        {{ $image->product?->name ?? 'Not Linked' }}
                                                    </strong>
                                                </div>

                                                <button type="button" class="product-image-copy-btn copy-image-url"
                                                    data-url="{{ $image->image_url }}">

                                                    <i class="bi bi-link-45deg"></i>
                                                    Copy URL
                                                </button>

                                            </div>

                                        </div>

                                        {{-- Right Panel --}}
                                        <div class="product-image-manager-panel">

                                            {{-- Edit --}}
                                            <div class="product-image-panel-section">

                                                <div class="product-image-section-head">

                                                    <div>
                                                        <h5>Image Details</h5>
                                                        <p>
                                                            Manage image name and SEO ALT text.
                                                        </p>
                                                    </div>

                                                    <span class="product-image-type-pill">
                                                        {{ $meta['type'] ?? 'WEBP' }}
                                                    </span>

                                                </div>

                                                <form method="POST" action="{{ route('admin.product-gallery.update', $image) }}">

                                                    @csrf
                                                    @method('PUT')

                                                    <div class="product-image-field">
                                                        <label>
                                                            Image Name
                                                        </label>

                                                        <input type="text" name="image_name" value="{{ $image->image_name }}"
                                                            maxlength="255" placeholder="Enter image name">
                                                    </div>

                                                    <div class="product-image-field">
                                                        <label>
                                                            ALT Text
                                                            <span>SEO</span>
                                                        </label>

                                                        <textarea name="alt_text" maxlength="255" rows="3"
                                                            placeholder="Describe this image for search engines">{{ $image->alt_text }}</textarea>

                                                        <small>
                                                            Keep it descriptive and relevant to the product.
                                                        </small>
                                                    </div>

                                                    <button type="submit" class="product-image-save-btn">

                                                        <i class="bi bi-check2"></i>
                                                        Save Changes
                                                    </button>

                                                </form>

                                            </div>

                                            {{-- File info --}}
                                            <div class="product-image-panel-section">

                                                <div class="product-image-section-head">
                                                    <div>
                                                        <h5>File Information</h5>
                                                        <p>
                                                            Technical image details.
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="product-image-meta-grid">

                                                    <div class="product-image-meta-item">
                                                        <span>File Type</span>
                                                        <strong>
                                                            {{ $meta['type'] ?? 'WEBP' }}
                                                        </strong>
                                                    </div>

                                                    <div class="product-image-meta-item">
                                                        <span>Dimensions</span>
                                                        <strong>
                                                            {{ $meta['dimensions'] ?? 'Unknown' }}
                                                        </strong>
                                                    </div>

                                                    <div class="product-image-meta-item">
                                                        <span>File Size</span>
                                                        <strong>
                                                            {{ $meta['size'] ?? 'Unknown' }}
                                                        </strong>
                                                    </div>

                                                    <div class="product-image-meta-item">
                                                        <span>Uploaded</span>
                                                        <strong>
                                                            {{ $meta['date'] ?? 'Unknown' }}
                                                        </strong>
                                                    </div>

                                                </div>

                                                <div class="product-image-file-name">
                                                    <span>Stored File</span>

                                                    <strong title="{{ $meta['filename'] ?? '' }}">
                                                        {{ $meta['filename'] ?? 'Unknown' }}
                                                    </strong>
                                                </div>

                                            </div>

                                            {{-- Replace --}}
                                            <div class="product-image-panel-section">

                                                <div class="product-image-section-head">
                                                    <div>
                                                        <h5>Replace Image</h5>
                                                        <p>
                                                            Same database record will be retained.
                                                        </p>
                                                    </div>
                                                </div>

                                                <form method="POST" action="{{ route('admin.product-gallery.replace', $image) }}"
                                                    enctype="multipart/form-data">

                                                    @csrf

                                                    <div class="product-image-replace-box">

                                                        <div class="product-image-replace-icon">
                                                            <i class="bi bi-arrow-repeat"></i>
                                                        </div>

                                                        <div class="product-image-replace-content">
                                                            <strong>Select replacement image</strong>
                                                            <small>Only .webp files up to 5 MB</small>
                                                        </div>

                                                        <input type="file" name="image" class="product-image-file-input"
                                                            accept=".webp,image/webp" required>

                                                    </div>

                                                    <button type="submit" class="product-image-replace-btn">

                                                        <i class="bi bi-arrow-repeat"></i>
                                                        Replace Image
                                                    </button>

                                                </form>

                                            </div>

                                            {{-- Delete --}}
                                            <div class="product-image-danger-zone">

                                                <div>
                                                    <h5>Delete Image</h5>
                                                    <p>
                                                        Permanently remove this image from the product gallery.
                                                    </p>
                                                </div>

                                                <form method="POST" action="{{ route('admin.product-gallery.destroy', $image) }}"
                                                    onsubmit="return confirm('Are you sure you want to permanently delete this image?');">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="product-image-delete-btn">

                                                        <i class="bi bi-trash3"></i>
                                                        Delete
                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                {{-- Empty --}}
                <div class="product-gallery-empty">

                    <div class="product-gallery-empty-icon">
                        <i class="bi bi-images"></i>
                    </div>

                    <h5>No product images found</h5>

                    <p>
                        Upload product images to start building your gallery.
                    </p>

                    <button type="button" class="product-gallery-empty-btn" data-bs-toggle="modal"
                        data-bs-target="#uploadProductImageModal">

                        <i class="bi bi-cloud-upload"></i>
                        Upload Image
                    </button>

                </div>

            @endif

        </div>

    </div>

    {{-- Upload Modal --}}
    <div class="modal fade" id="uploadProductImageModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content product-gallery-upload-modal">

                <div class="product-gallery-upload-modal-head">

                    <div class="product-gallery-upload-modal-icon">
                        <i class="bi bi-cloud-upload"></i>
                    </div>

                    <div>
                        <h5>Upload Product Image</h5>
                        <p>Only optimised WebP images are accepted.</p>
                    </div>

                    <button type="button" class="product-image-manager-close" data-bs-dismiss="modal">

                        <i class="bi bi-x-lg"></i>
                    </button>

                </div>

                <div class="product-gallery-upload-modal-body">

                    <div class="product-gallery-upload-notice">

                        <i class="bi bi-info-circle"></i>

                        <span>
                            Images must be in <strong>WebP</strong> format.
                        </span>

                    </div>

                    <label class="product-gallery-upload-zone">

                        <span class="product-gallery-upload-zone-icon">
                            <i class="bi bi-file-earmark-image"></i>
                        </span>

                        <strong>Choose WebP Images</strong>

                        <small>
                            Select one or multiple images from your computer
                        </small>

                        <input type="file" name="images[]" accept=".webp,image/webp" multiple hidden>

                    </label>

                </div>

            </div>

        </div>

    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product-gallery.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/product-gallery.js') }}"></script>
@endpush
