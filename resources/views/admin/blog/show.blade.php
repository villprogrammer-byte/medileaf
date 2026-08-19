@extends('admin.layouts.app')

@section('title', 'View Blog Post')

@section('content')

    <div class="ml-admin-page-head">

        <div>
            <h1>View Post</h1>
            <p>Review the published blog content and post details.</p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.blog.index') }}" class="ml-admin-secondary-btn">
                <i class="bi bi-arrow-left"></i>
                All Posts
            </a>

            <a href="{{ route('admin.blog.edit', ['blogPost' => $blogPost]) }}" class="ml-admin-add-btn">
                <i class="bi bi-pencil"></i>
                Edit Post
            </a>

        </div>

    </div>


    <div class="row g-4">

        {{-- =========================================================
        MAIN CONTENT
        ========================================================== --}}

        <div class="col-xl-8">

            <div class="ml-admin-card ml-admin-blog-show-card">

                <div class="ml-admin-card-head">

                    <div>
                        <h4>
                            <i class="bi bi-journal-text"></i>
                            {{ $blogPost->title }}
                        </h4>

                        <small class="text-muted">
                            /blog/{{ $blogPost->slug }}
                        </small>
                    </div>

                    @php
                        $statusClass = match ($blogPost->status) {
                            'published' => 'published',
                            'scheduled' => 'scheduled',
                            default => 'draft',
                        };
                    @endphp

                    <span class="ml-admin-blog-status {{ $statusClass }}">
                        {{ ucfirst($blogPost->status) }}
                    </span>

                </div>


                <div class="p-4">

                    @if($blogPost->featured_image)

                        <div class="mb-4"
                            style="overflow:hidden;border-radius:18px;border:1px solid #e2ebe4;background:#f7faf7;">

                            <img src="{{ asset('storage/' . ltrim($blogPost->featured_image, '/')) }}"
                                alt="{{ $blogPost->featured_image_alt ?: $blogPost->title }}"
                                style="display:block;width:100%;height:auto;max-height:520px;object-fit:cover;">

                        </div>

                    @endif


                    @if($blogPost->excerpt)

                        <div class="mb-4">

                            <h5 class="mb-2">
                                Excerpt
                            </h5>

                            <p class="text-muted mb-0">
                                {{ $blogPost->excerpt }}
                            </p>

                        </div>

                    @endif


                    <div class="ml-admin-blog-show-content">

                        {!! $blogPost->content !!}

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
        SIDEBAR
        ========================================================== --}}

        <div class="col-xl-4">

            <div class="ml-admin-card mb-4">

                <div class="ml-admin-card-head">
                    <h4>
                        <i class="bi bi-info-circle"></i>
                        Post Details
                    </h4>
                </div>

                <div class="p-4">

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">
                            Category
                        </small>

                        <strong>
                            {{ $blogPost->category?->name ?? 'Uncategorised' }}
                        </strong>
                    </div>


                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">
                            Author
                        </small>

                        <strong>
                            {{ $blogPost->author?->name ?? '—' }}
                        </strong>
                    </div>


                    @if($blogPost->reviewer)

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">
                                Reviewer
                            </small>

                            <strong>
                                {{ $blogPost->reviewer->name }}
                            </strong>
                        </div>

                    @endif


                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">
                            Published
                        </small>

                        <strong>
                            {{ $blogPost->published_at?->format('d M Y, h:i A') ?? 'Not published' }}
                        </strong>
                    </div>


                    <div class="mb-0">
                        <small class="text-muted d-block mb-1">
                            Reading Time
                        </small>

                        <strong>
                            {{ $blogPost->reading_time ?? 1 }} min
                        </strong>
                    </div>

                </div>

            </div>


            @if($blogPost->featured_image)

                <div class="ml-admin-card">

                    <div class="ml-admin-card-head">
                        <h4>
                            <i class="bi bi-image"></i>
                            Featured Image
                        </h4>
                    </div>

                    <div class="p-4">

                        <img src="{{ asset('storage/' . ltrim($blogPost->featured_image, '/')) }}"
                            alt="{{ $blogPost->featured_image_alt ?: $blogPost->title }}"
                            style="display:block;width:100%;height:auto;border-radius:14px;">

                        @if($blogPost->featured_image_alt)

                            <small class="text-muted d-block mt-3">
                                ALT: {{ $blogPost->featured_image_alt }}
                            </small>

                        @endif

                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection