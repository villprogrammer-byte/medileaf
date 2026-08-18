@extends('admin.layouts.app')

@section('title', 'Blog Preview')

@section('content')

    <div class="ml-admin-page-head">

        <div>
            <h1>{{ $blogPost->title }}</h1>
            <p>Admin preview of this article.</p>
        </div>

        <div class="d-flex align-items-center gap-2">

            <a href="{{ route('admin.blog.index') }}" class="ml-admin-secondary-btn">
                <i class="bi bi-arrow-left"></i>
                All Posts
            </a>

            <a href="{{ route('admin.blog.edit', $blogPost) }}" class="ml-admin-add-btn">
                <i class="bi bi-pencil"></i>
                Edit Post
            </a>

        </div>

    </div>


    <div class="row g-4">

        {{-- Article Preview --}}
        <div class="col-xl-8">

            <div class="ml-admin-card ml-admin-blog-preview">

                @if($blogPost->featured_image)

                    <div class="ml-admin-blog-preview-image">

                        <img src="{{ asset($blogPost->featured_image) }}"
                            alt="{{ $blogPost->featured_image_alt ?: $blogPost->title }}">

                    </div>

                @endif


                <div class="ml-admin-blog-preview-content">

                    <div class="ml-admin-blog-preview-meta">

                        @if($blogPost->category)

                            <span class="ml-admin-blog-category">
                                {{ $blogPost->category->name }}
                            </span>

                        @endif

                        <span class="ml-admin-blog-date">
                            {{ $blogPost->published_at
        ? $blogPost->published_at->format('d M Y')
        : 'Draft'
                                    }}
                        </span>

                    </div>


                    <h2 class="ml-admin-blog-preview-title">
                        {{ $blogPost->title }}
                    </h2>


                    @if($blogPost->excerpt)

                        <p class="ml-admin-blog-preview-excerpt">
                            {{ $blogPost->excerpt }}
                        </p>

                    @endif


                    <div class="ml-admin-blog-preview-body">
                        {!! $blogPost->content !!}
                    </div>

                </div>

            </div>

        </div>


        {{-- Article Information --}}
        <div class="col-xl-4">

            <div class="ml-admin-card mb-4">

                <div class="ml-admin-card-head">

                    <h4>
                        <i class="bi bi-info-circle"></i>
                        Post Information
                    </h4>

                </div>


                <div class="ml-admin-blog-preview-info">

                    <div>
                        <span>Status</span>

                        @php
                            $statusClass = match ($blogPost->status) {
                                'published' => 'published',
                                'scheduled' => 'scheduled',
                                default => 'draft',
                            };
                        @endphp

                        <strong>
                            <span class="ml-admin-blog-status {{ $statusClass }}">
                                {{ ucfirst($blogPost->status) }}
                            </span>
                        </strong>
                    </div>


                    <div>
                        <span>Author</span>
                        <strong>
                            {{ $blogPost->author?->name ?? '—' }}
                        </strong>
                    </div>


                    <div>
                        <span>Reviewer</span>
                        <strong>
                            {{ $blogPost->reviewer?->name ?? '—' }}
                        </strong>
                    </div>


                    <div>
                        <span>Reading Time</span>
                        <strong>
                            {{ $blogPost->reading_time
        ? $blogPost->reading_time . ' min'
        : '—'
                                    }}
                        </strong>
                    </div>


                    <div>
                        <span>Published</span>
                        <strong>
                            {{ $blogPost->published_at
        ? $blogPost->published_at->format('d M Y, h:i A')
        : 'Not published'
                                    }}
                        </strong>
                    </div>


                    <div>
                        <span>Slug</span>
                        <strong class="ml-admin-blog-preview-slug">
                            /blog/{{ $blogPost->slug }}
                        </strong>
                    </div>

                </div>

            </div>


            @if($blogPost->tags->count())

                <div class="ml-admin-card">

                    <div class="ml-admin-card-head">

                        <h4>
                            <i class="bi bi-tags"></i>
                            Tags
                        </h4>

                    </div>


                    <div class="ml-admin-blog-preview-tags">

                        @foreach($blogPost->tags as $tag)

                            <span class="ml-admin-blog-category">
                                {{ $tag->name }}
                            </span>

                        @endforeach

                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-blog.css') }}">
@endpush