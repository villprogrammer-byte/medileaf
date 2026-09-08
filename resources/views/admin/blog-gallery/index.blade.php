@extends('admin.layouts.app')

@section('content')

    <div class="container-fluid product-gallery-page">

        {{-- Header --}}
        <div class="product-gallery-header">

            <div>
                <h2 class="product-gallery-title">
                    Blog Gallery
                </h2>

                <p class="product-gallery-subtitle">
                    View, optimise and manage all blog featured images.
                </p>
            </div>

            <button
                type="button"
                class="product-gallery-upload-btn"
                data-bs-toggle="modal"
                data-bs-target="#uploadBlogImageModal"
            >
                <i class="bi bi-cloud-upload"></i>
                <span>Upload Image</span>
            </button>

        </div>


        {{-- Success --}}
        @if(session('success'))

            <div
                class="alert alert-success alert-dismissible fade show product-gallery-alert"
                role="alert"
            >

                <i class="bi bi-check-circle-fill"></i>

                <span>
                    {{ session('success') }}
                </span>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                >
                </button>

            </div>

        @endif


        {{-- Errors --}}
        @if($errors->any())

            <div
                class="alert alert-danger alert-dismissible fade show product-gallery-alert"
                role="alert"
            >

                <i class="bi bi-exclamation-circle-fill"></i>

                <span>
                    {{ $errors->first() }}
                </span>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                >
                </button>

            </div>

        @endif


        {{-- Gallery --}}
        <div class="product-gallery-main-card">

            @if($blogs->count())

                <div class="product-gallery-grid">

                    @foreach($blogs as $blog)

                        @php

                            $featuredUrl = asset(
                                'storage/' . ltrim(
                                    $blog->featured_image,
                                    '/'
                                )
                            );

                            $featuredName =
                                $blog->featured_image_display_name;

                            $filePath = storage_path(
                                'app/public/' .
                                ltrim(
                                    $blog->featured_image,
                                    '/'
                                )
                            );

                            $meta = [
                                'type' => strtoupper(
                                    pathinfo(
                                        $blog->featured_image,
                                        PATHINFO_EXTENSION
                                    )
                                ),

                                'dimensions' => 'Unknown',
                                'size' => 'Unknown',
                                'date' => 'Unknown',
                                'filename' => basename(
                                    $blog->featured_image
                                ),
                            ];

                            if (is_file($filePath)) {

                                $dimensions =
                                    @getimagesize($filePath);

                                if ($dimensions) {

                                    $meta['dimensions'] =
                                        $dimensions[0] .
                                        ' × ' .
                                        $dimensions[1] .
                                        ' px';
                                }


                                $bytes =
                                    @filesize($filePath);

                                if ($bytes !== false) {

                                    if ($bytes >= 1048576) {

                                        $meta['size'] =
                                            number_format(
                                                $bytes / 1048576,
                                                2
                                            ) . ' MB';

                                    } else {

                                        $meta['size'] =
                                            number_format(
                                                $bytes / 1024,
                                                2
                                            ) . ' KB';
                                    }
                                }


                                $modified =
                                    @filemtime($filePath);

                                if ($modified) {

                                    $meta['date'] =
                                        date(
                                            'd M Y',
                                            $modified
                                        );
                                }
                            }

                        @endphp


                        {{-- Featured Image Card --}}
                        <div
                            class="product-gallery-card"
                            role="button"
                            data-bs-toggle="modal"
                            data-bs-target="#viewBlogFeaturedImage{{ $blog->id }}"
                        >

                            <div class="product-gallery-image-wrap">

                                <img
                                    src="{{ $featuredUrl }}"
                                    alt="{{ $blog->featured_image_alt ?: $blog->title }}"
                                    class="product-gallery-image"
                                >


                                <span class="product-gallery-badge">
                                    <i class="bi bi-star-fill"></i>
                                    Featured
                                </span>


                                <form
                                    method="POST"
                                    action="{{ route('admin.blog.gallery.featured.destroy', $blog) }}"
                                    class="product-gallery-card-delete-form"
                                    onclick="event.stopPropagation();"
                                    onsubmit="event.stopPropagation(); return confirm('Are you sure you want to permanently delete this featured image?');"
                                >

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="product-gallery-card-delete-btn"
                                        title="Delete featured image"
                                        aria-label="Delete featured image"
                                        onclick="event.stopPropagation();"
                                    >

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

                                <span
                                    class="product-gallery-name"
                                    title="{{ $featuredName }}"
                                >
                                    {{ $featuredName }}
                                </span>


                                <small
                                    class="product-gallery-product-name"
                                    title="{{ $blog->title }}"
                                >
                                    {{ $blog->title }}
                                </small>

                            </div>

                        </div>


                        {{-- View / Manage Modal --}}
                        <div
                            class="modal fade product-image-manager-modal"
                            id="viewBlogFeaturedImage{{ $blog->id }}"
                            tabindex="-1"
                            aria-hidden="true"
                        >

                            <div
                                class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
                            >

                                <div class="modal-content product-image-manager">


                                    {{-- Header --}}
                                    <div class="product-image-manager-header">

                                        <div>

                                            <span class="product-image-manager-eyebrow">
                                                Featured Blog Image
                                            </span>

                                            <h4 title="{{ $featuredName }}">
                                                {{ $featuredName }}
                                            </h4>

                                        </div>


                                        <button
                                            type="button"
                                            class="product-image-manager-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"
                                        >

                                            <i class="bi bi-x-lg"></i>

                                        </button>

                                    </div>


                                    <div class="product-image-manager-body">


                                        {{-- Left Preview --}}
                                        <div class="product-image-manager-preview">

                                            <div class="product-image-preview-stage">

                                                <img
                                                    src="{{ $featuredUrl }}"
                                                    alt="{{ $blog->featured_image_alt ?: $blog->title }}"
                                                >


                                                <span class="product-image-preview-badge">

                                                    <i class="bi bi-star-fill"></i>

                                                    Featured

                                                </span>

                                            </div>


                                            <div class="product-image-preview-footer">

                                                <div>

                                                    <span>
                                                        Associated Blog Post
                                                    </span>

                                                    <strong>
                                                        {{ $blog->title }}
                                                    </strong>

                                                </div>


                                                <button
                                                    type="button"
                                                    class="product-image-copy-btn copy-image-url"
                                                    data-url="{{ $featuredUrl }}"
                                                >

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

                                                        <h5>
                                                            Image Details
                                                        </h5>

                                                        <p>
                                                            Manage image name and SEO ALT text.
                                                        </p>

                                                    </div>


                                                    <span class="product-image-type-pill">

                                                        {{ $meta['type'] ?: 'IMAGE' }}

                                                    </span>

                                                </div>


                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.blog.gallery.featured.update', $blog) }}"
                                                >

                                                    @csrf
                                                    @method('PUT')


                                                    <div class="product-image-field">

                                                        <label>
                                                            Image Name
                                                        </label>


                                                        <input
                                                            type="text"
                                                            name="featured_image_name"
                                                            value="{{ $blog->featured_image_name }}"
                                                            maxlength="255"
                                                            placeholder="Enter image name"
                                                        >

                                                    </div>


                                                    <div class="product-image-field">

                                                        <label>

                                                            ALT Text

                                                            <span>
                                                                SEO
                                                            </span>

                                                        </label>


                                                        <textarea
                                                            name="featured_image_alt"
                                                            maxlength="255"
                                                            rows="3"
                                                            placeholder="Describe this image for search engines"
                                                        >{{ $blog->featured_image_alt }}</textarea>


                                                        <small>
                                                            Keep it descriptive and relevant to the blog post.
                                                        </small>

                                                    </div>


                                                    <button
                                                        type="submit"
                                                        class="product-image-save-btn"
                                                    >

                                                        <i class="bi bi-check2"></i>

                                                        Save Changes

                                                    </button>

                                                </form>

                                            </div>


                                            {{-- File Information --}}
                                            <div class="product-image-panel-section">

                                                <div class="product-image-section-head">

                                                    <div>

                                                        <h5>
                                                            File Information
                                                        </h5>

                                                        <p>
                                                            Technical image details.
                                                        </p>

                                                    </div>

                                                </div>


                                                <div class="product-image-meta-grid">

                                                    <div class="product-image-meta-item">

                                                        <span>
                                                            File Type
                                                        </span>

                                                        <strong>
                                                            {{ $meta['type'] ?: 'Unknown' }}
                                                        </strong>

                                                    </div>


                                                    <div class="product-image-meta-item">

                                                        <span>
                                                            Dimensions
                                                        </span>

                                                        <strong>
                                                            {{ $meta['dimensions'] }}
                                                        </strong>

                                                    </div>


                                                    <div class="product-image-meta-item">

                                                        <span>
                                                            File Size
                                                        </span>

                                                        <strong>
                                                            {{ $meta['size'] }}
                                                        </strong>

                                                    </div>


                                                    <div class="product-image-meta-item">

                                                        <span>
                                                            File Date
                                                        </span>

                                                        <strong>
                                                            {{ $meta['date'] }}
                                                        </strong>

                                                    </div>

                                                </div>


                                                <div class="product-image-file-name">

                                                    <span>
                                                        Stored File
                                                    </span>

                                                    <strong
                                                        title="{{ $meta['filename'] }}"
                                                    >
                                                        {{ $meta['filename'] }}
                                                    </strong>

                                                </div>

                                            </div>


                                            {{-- Replace Image --}}
                                            <div class="product-image-panel-section">

                                                <div class="product-image-section-head">

                                                    <div>

                                                        <h5>
                                                            Replace Image
                                                        </h5>

                                                        <p>
                                                            Replace the current blog featured image.
                                                        </p>

                                                    </div>

                                                </div>


                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.blog.gallery.featured.replace', $blog) }}"
                                                    enctype="multipart/form-data"
                                                >

                                                    @csrf


                                                    <div class="product-image-replace-box">

                                                        <div class="product-image-replace-icon">

                                                            <i class="bi bi-arrow-repeat"></i>

                                                        </div>


                                                        <div class="product-image-replace-content">

                                                            <strong>
                                                                Select replacement image
                                                            </strong>

                                                            <small>
                                                                JPG, PNG or WebP up to 5 MB
                                                            </small>

                                                        </div>


                                                        <input
                                                            type="file"
                                                            name="image"
                                                            class="product-image-file-input"
                                                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                                            required
                                                        >

                                                    </div>


                                                    <button
                                                        type="submit"
                                                        class="product-image-replace-btn"
                                                    >

                                                        <i class="bi bi-arrow-repeat"></i>

                                                        Replace Image

                                                    </button>

                                                </form>

                                            </div>


                                            {{-- Delete --}}
                                            <div class="product-image-danger-zone">

                                                <div>

                                                    <h5>
                                                        Delete Image
                                                    </h5>

                                                    <p>
                                                        Permanently remove this featured image from the blog post.
                                                    </p>

                                                </div>


                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.blog.gallery.featured.destroy', $blog) }}"
                                                    onsubmit="return confirm('Are you sure you want to permanently delete this featured image?');"
                                                >

                                                    @csrf
                                                    @method('DELETE')


                                                    <button
                                                        type="submit"
                                                        class="product-image-delete-btn"
                                                    >

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


                    <h5>
                        No blog images found
                    </h5>


                    <p>
                        Upload a featured image to start building your blog gallery.
                    </p>


                    <button
                        type="button"
                        class="product-gallery-empty-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#uploadBlogImageModal"
                    >

                        <i class="bi bi-cloud-upload"></i>

                        Upload Image

                    </button>

                </div>

            @endif

        </div>

    </div>


    {{-- =====================================================
    Upload Blog Image Modal
    ====================================================== --}}

    <div
        class="modal fade"
        id="uploadBlogImageModal"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content product-gallery-upload-modal">


                <div class="product-gallery-upload-modal-head">

                    <div class="product-gallery-upload-modal-icon">

                        <i class="bi bi-cloud-upload"></i>

                    </div>


                    <div>

                        <h5>
                            Upload Blog Image
                        </h5>

                        <p>
                            Select a blog post and upload its featured image.
                        </p>

                    </div>


                    <button
                        type="button"
                        class="product-image-manager-close"
                        data-bs-dismiss="modal"
                    >

                        <i class="bi bi-x-lg"></i>

                    </button>

                </div>


                <form
                    method="POST"
                    action="{{ route('admin.blog.gallery.store') }}"
                    enctype="multipart/form-data"
                >

                    @csrf


                    <div class="product-gallery-upload-modal-body">


                        {{-- Blog Post --}}
<div class="product-image-field">

    <label class="ml-admin-label">
        Blog Post
        <span class="text-danger">*</span>
    </label>

    <div class="ml-custom-select">

        <button
            type="button"
            class="ml-custom-select-btn"
        >
            <span class="ml-custom-select-value">
                Select Blog Post
            </span>

            <i class="bi bi-chevron-down"></i>
        </button>


        <div class="ml-custom-select-menu">

            <button
                type="button"
                class="ml-custom-option selected"
                data-value=""
            >
                Select Blog Post
            </button>

            @foreach($allBlogs as $blog)

                <button
                    type="button"
                    class="ml-custom-option"
                    data-value="{{ $blog->id }}"
                >
                    {{ $blog->title }}
                </button>

            @endforeach

        </div>


        <input
            type="hidden"
            name="blog_id"
            value=""
            required
        >

    </div>

    @error('blog_id')
        <div class="invalid-feedback d-block mt-2">
            {{ $message }}
        </div>
    @enderror

</div>


                        {{-- Notice --}}
                        <div class="product-gallery-upload-notice">

                            <i class="bi bi-info-circle"></i>

                            <span>
                                JPG, PNG and <strong>WebP</strong> images up to 5 MB are accepted.
                            </span>

                        </div>


                        {{-- Upload --}}
                        <label class="product-gallery-upload-zone">

                            <span class="product-gallery-upload-zone-icon">

                                <i class="bi bi-file-earmark-image"></i>

                            </span>


                            <strong>
                                Choose Blog Image
                            </strong>


                            <small>
                                Select one image from your computer
                            </small>


                            <input
                                type="file"
                                name="image"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                required
                                hidden
                            >

                        </label>


                        <button
                            type="submit"
                            class="product-image-save-btn mt-3 w-100"
                        >

                            <i class="bi bi-cloud-upload"></i>

                            Upload Image

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection


@push('styles')

    <link
        rel="stylesheet"
        href="{{ asset('css/product-gallery.css') }}"
    >

@endpush


@push('scripts')

    <script
        src="{{ asset('js/product-gallery.js') }}"
    ></script>

@endpush