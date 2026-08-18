@extends('layouts.app')

@php
    use App\Models\BlogCategory;
@endphp

@php
    /*
    |--------------------------------------------------------------------------
    | Dynamic Blog Article
    |--------------------------------------------------------------------------
    |
    | BlogController passes:
    | $post
    | $relatedPosts
    | $popularPosts
    |
    */

    $canonicalUrl = url('/blog/' . $post->slug);

    $categories = BlogCategory::where('is_active', true)
        ->withCount([
            'posts' => function ($query) {
                $query->published();
            }
        ])
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();
@endphp


@section('title', ($post->meta_title ?: $post->title) . ' | MediLeaf Australia')

@section('meta_description',
    $post->meta_description
        ?: ($post->excerpt ?: 'Trusted health information from MediLeaf Australia.')
)

@section('canonical_url', $post->canonical_url ?: $canonicalUrl)

@section('og_title',
    $post->og_title
        ?: ($post->meta_title ?: $post->title)
)

@section('og_description',
    $post->og_description
        ?: ($post->meta_description ?: $post->excerpt)
)

@section('og_image',
    $post->og_image
        ? asset($post->og_image)
        : ($post->featured_image ? asset($post->featured_image) : asset('img/blog/blog-hero.webp'))
)


@push('styles')

    <link
        rel="stylesheet"
        href="{{ asset('css/blog.css') }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/blog-view.css') }}"
    >

@endpush


@section('content')

<section class="ml-blog-page ml-blog-view-page">


    {{-- ================================================================
        Breadcrumb
    ================================================================= --}}

    <section class="ml-blog-breadcrumb-wrap">

        <div class="container">

            <nav
                class="ml-blog-breadcrumb"
                aria-label="Breadcrumb"
            >

                <a href="{{ route('home') }}">

                    <i class="bi bi-house-fill"></i>

                    <span>
                        Home
                    </span>

                </a>


                <i class="bi bi-chevron-right"></i>


                <a href="{{ route('blog') }}">
                    Blog
                </a>


                <i class="bi bi-chevron-right"></i>


                @if($post->category)

                    <a href="{{ route('blog') }}">

                        {{ $post->category->name }}

                    </a>

                    <i class="bi bi-chevron-right"></i>

                @endif


                <span>
                    {{ $post->title }}
                </span>

            </nav>

        </div>

    </section>



    {{-- ================================================================
        Article
    ================================================================= --}}

    <section class="ml-blog-article-section">

        <div class="container">

            <div class="ml-blog-view-layout">


                {{-- ====================================================
                    Main Article
                ===================================================== --}}

                <main class="ml-blog-article-main">


                    {{-- Article Header --}}

                    <header class="ml-blog-article-header">


                        <span class="ml-blog-label">

                            {{ $post->category?->name ?? 'Health & Wellness' }}

                        </span>


                        <h1>
                            {{ $post->title }}
                        </h1>


                        @if($post->excerpt)

                            <p class="ml-blog-article-excerpt">

                                {{ $post->excerpt }}

                            </p>

                        @endif


                        <div class="ml-blog-article-meta-row">


                            <div class="ml-blog-article-meta">


                                @if($post->published_at)

                                    <span>

                                        <i class="bi bi-calendar3"></i>

                                        {{ $post->published_at->format('M d, Y') }}

                                    </span>

                                @endif


                                @if($post->author)

                                    <span>

                                        <i class="bi bi-person"></i>

                                        By {{ $post->author->name }}

                                    </span>

                                @else

                                    <span>

                                        <i class="bi bi-person"></i>

                                        By MediLeaf Team

                                    </span>

                                @endif


                                @if($post->reading_time)

                                    <span>

                                        <i class="bi bi-clock"></i>

                                        {{ $post->reading_time }} min read

                                    </span>

                                @endif


                            </div>


                            {{-- Share --}}

                            <div class="ml-blog-share">

                                <span>
                                    Share:
                                </span>


                                <a
                                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($canonicalUrl) }}"
                                    target="_blank"
                                    rel="noopener"
                                    aria-label="Share on Facebook"
                                >

                                    <i class="bi bi-facebook"></i>

                                </a>


                                <a
                                    href="https://twitter.com/intent/tweet?url={{ urlencode($canonicalUrl) }}&text={{ urlencode($post->title) }}"
                                    target="_blank"
                                    rel="noopener"
                                    aria-label="Share on X"
                                >

                                    <i class="bi bi-twitter-x"></i>

                                </a>


                                <a
                                    href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($canonicalUrl) }}"
                                    target="_blank"
                                    rel="noopener"
                                    aria-label="Share on LinkedIn"
                                >

                                    <i class="bi bi-linkedin"></i>

                                </a>


                                <a
                                    href="mailto:?subject={{ rawurlencode($post->title) }}&body={{ rawurlencode($canonicalUrl) }}"
                                    aria-label="Share by email"
                                >

                                    <i class="bi bi-envelope"></i>

                                </a>

                            </div>

                        </div>

                    </header>



                    {{-- =================================================
                        Featured Image
                    ================================================== --}}

                    @if($post->featured_image)

                        <figure class="ml-blog-article-hero">

                            <img
                               src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image) }}"
                                alt="{{ $post->featured_image_alt ?: $post->title }}"
                                fetchpriority="high"
                                decoding="async"
                            >

                        </figure>

                    @endif



                    {{-- =================================================
                        Key Takeaway
                    ================================================== --}}

                    @if($post->excerpt)

                        <aside class="ml-blog-key-takeaway">

                            <div class="ml-blog-key-icon">

                                <i class="bi bi-lightbulb"></i>

                            </div>


                            <div>

                                <strong>
                                    Key Takeaway
                                </strong>

                                <p>
                                    {{ $post->excerpt }}
                                </p>

                            </div>


                            <span class="ml-blog-takeaway-decoration">

                                <i class="bi bi-leaf-fill"></i>

                            </span>

                        </aside>

                    @endif



                    {{-- =================================================
                        ACTUAL DATABASE CONTENT
                    ================================================== --}}

                    <article class="ml-blog-article-content">

                        {!! $post->content !!}

                    </article>



                    {{-- =================================================
                        Reviewer
                    ================================================== --}}

                    @if($post->reviewer)

                        <section class="ml-blog-author-card">

                            <div class="ml-blog-author-avatar">

                                <i class="bi bi-patch-check-fill"></i>

                            </div>


                            <div class="ml-blog-author-content">

                                <span>
                                    Reviewed By
                                </span>


                                <h2>
                                    {{ $post->reviewer->name }}
                                </h2>


                                @if($post->reviewer->credentials)

                                    <p>
                                        {{ $post->reviewer->credentials }}
                                    </p>

                                @elseif($post->reviewer->bio)

                                    <p>
                                        {{ $post->reviewer->bio }}
                                    </p>

                                @endif

                            </div>

                        </section>

                    @elseif($post->author)

                        <section class="ml-blog-author-card">

                            <div class="ml-blog-author-avatar">

                                <i class="bi bi-leaf-fill"></i>

                            </div>


                            <div class="ml-blog-author-content">

                                <span>
                                    About the Author
                                </span>


                                <h2>
                                    {{ $post->author->name }}
                                </h2>


                                @if($post->author->bio)

                                    <p>
                                        {{ $post->author->bio }}
                                    </p>

                                @endif


                                @if($post->author->credentials)

                                    <p>
                                        {{ $post->author->credentials }}
                                    </p>

                                @endif

                            </div>

                        </section>

                    @endif



                    {{-- =================================================
                        Previous / Next
                    ================================================== --}}

                    @if($relatedPosts->count())

                        <nav
                            class="ml-blog-post-navigation"
                            aria-label="Related articles"
                        >

                            @foreach($relatedPosts->take(2) as $related)

                                <a
                                    href="{{ route('blog.view', $related->slug) }}"
                                    class="ml-blog-post-nav"
                                >

                                    <span class="ml-blog-nav-copy">

                                        <small>
                                            Related Post
                                        </small>

                                        <strong>
                                            {{ $related->title }}
                                        </strong>

                                    </span>


                                    @if($related->featured_image)

                                        <span class="ml-blog-nav-thumb">

                                            <img
                                                src="{{ asset($related->featured_image) }}"
                                                alt="{{ $related->featured_image_alt ?: $related->title }}"
                                                loading="lazy"
                                            >

                                        </span>

                                    @endif


                                    <span class="ml-blog-nav-arrow">

                                        <i class="bi bi-arrow-right"></i>

                                    </span>

                                </a>

                            @endforeach

                        </nav>

                    @endif


                </main>



                {{-- ====================================================
                    Sidebar
                ===================================================== --}}

                <aside class="ml-blog-sidebar ml-blog-view-sidebar">


                    {{-- Search --}}

                    <form
                        class="ml-blog-search"
                        action="{{ route('blog') }}"
                        method="GET"
                    >

                        <label
                            for="blogViewSearch"
                            class="visually-hidden"
                        >
                            Search Blog
                        </label>


                        <input
                            id="blogViewSearch"
                            type="search"
                            name="q"
                            placeholder="Search articles..."
                            value="{{ request('q') }}"
                        >


                        <button
                            type="submit"
                            aria-label="Search articles"
                        >

                            <i class="bi bi-search"></i>

                        </button>

                    </form>



                    {{-- Categories --}}

                    <section class="ml-blog-sidebar-card">

                        <h2>
                            Categories
                        </h2>


                        <div class="ml-blog-view-categories">

                            @forelse($categories as $category)

                                <a
                                    href="{{ route('blog') }}"
                                    class="{{ $post->category_id == $category->id ? 'active' : '' }}"
                                >

                                    <span>

                                        <i class="bi bi-folder"></i>

                                        {{ $category->name }}

                                    </span>


                                    <strong>
                                        ({{ $category->posts_count }})
                                    </strong>

                                </a>

                            @empty

                                <p class="mb-0">
                                    No categories available.
                                </p>

                            @endforelse

                        </div>


                        @if($categories->count())

                            <a
                                href="{{ route('blog') }}"
                                class="ml-blog-sidebar-view-all"
                            >

                                View All Categories

                                <i class="bi bi-arrow-right"></i>

                            </a>

                        @endif

                    </section>



                    {{-- Popular Posts --}}

                    <section class="ml-blog-sidebar-card">

                        <h2>
                            Popular Posts
                        </h2>


                        @if($popularPosts->count())

                            <div class="ml-blog-popular">


                                @foreach($popularPosts as $popular)

                                    <a
                                        href="{{ route('blog.view', $popular->slug) }}"
                                        class="ml-blog-popular-item"
                                    >


                                        <span class="ml-blog-popular-image">

                                            @if($popular->featured_image)

                                                <img
                                                    src="{{ asset($popular->featured_image) }}"
                                                    alt="{{ $popular->featured_image_alt ?: $popular->title }}"
                                                    loading="lazy"
                                                    decoding="async"
                                                >

                                            @else

                                                <span class="ml-blog-image-placeholder">

                                                    <i class="bi bi-image"></i>

                                                </span>

                                            @endif

                                        </span>


                                        <span class="ml-blog-popular-text">

                                            <strong>
                                                {{ $popular->title }}
                                            </strong>


                                            @if($popular->published_at)

                                                <small>

                                                    {{ $popular->published_at->format('M d, Y') }}

                                                </small>

                                            @endif

                                        </span>


                                    </a>

                                @endforeach


                            </div>

                        @else

                            <p class="mb-0">
                                No other published articles yet.
                            </p>

                        @endif

                    </section>



                    {{-- Newsletter --}}

                    <section class="ml-blog-newsletter">

                        <div class="ml-blog-newsletter-icon">

                            <i class="bi bi-envelope-heart"></i>

                        </div>


                        <h2>
                            Stay Updated with MediLeaf
                        </h2>


                        <p>
                            Subscribe for trusted health tips, wellness updates and useful information.
                        </p>


                        <form
                            action="#"
                            method="POST"
                        >

                            @csrf


                            <input
                                type="email"
                                name="email"
                                placeholder="Enter your email"
                                required
                            >


                            <button type="submit">
                                Subscribe Now
                            </button>

                        </form>


                        <small>
                            We respect your privacy.
                        </small>

                    </section>



                    {{-- Sidebar Promotion --}}

                    <section class="ml-blog-sidebar-promo">

                        <div>

                            <span>
                                Natural Care
                            </span>


                            <h2>
                                for a Better You
                            </h2>


                            <p>
                                Explore wellness products selected for everyday healthy living.
                            </p>


                            <a href="{{ route('store') }}">

                                Shop Now

                                <i class="bi bi-arrow-right"></i>

                            </a>

                        </div>


                        <div class="ml-blog-sidebar-promo-image">

                            <img
                                src="{{ asset('img/blog/immunity-foods.webp') }}"
                                alt="MediLeaf natural wellness products"
                                loading="lazy"
                            >

                        </div>

                    </section>


                </aside>

            </div>

        </div>

    </section>



    {{-- ================================================================
        Bottom CTA
    ================================================================= --}}

    <section class="ml-pharmacy-cta ml-blog-view-cta">

        <div class="container">

            <div class="ml-pharmacy-cta-card">


                <div class="ml-pharmacy-botanical left">

                    <svg
                        viewBox="0 0 200 300"
                        fill="none"
                        aria-hidden="true"
                    >

                        <path
                            d="M100 285C98 210 104 120 120 25"
                            stroke="currentColor"
                            stroke-width="3"
                        ></path>

                        <path
                            d="M112 95C58 80 35 48 25 22C70 25 100 52 112 95Z"
                            fill="currentColor"
                        ></path>

                        <path
                            d="M104 150C50 142 20 110 8 80C58 82 92 108 104 150Z"
                            fill="currentColor"
                        ></path>

                        <path
                            d="M100 205C52 203 22 174 10 145C55 142 90 165 100 205Z"
                            fill="currentColor"
                        ></path>

                        <path
                            d="M122 72C164 54 184 30 192 8C154 10 130 34 122 72Z"
                            fill="currentColor"
                        ></path>

                        <path
                            d="M113 130C160 120 188 90 196 62C152 66 124 92 113 130Z"
                            fill="currentColor"
                        ></path>

                        <path
                            d="M106 188C154 182 180 154 190 126C146 128 116 151 106 188Z"
                            fill="currentColor"
                        ></path>

                    </svg>

                </div>


                <div class="ml-pharmacy-botanical right">

                    <svg
                        viewBox="0 0 200 300"
                        fill="none"
                        aria-hidden="true"
                    >

                        <path
                            d="M100 285C98 210 104 120 120 25"
                            stroke="currentColor"
                            stroke-width="3"
                        ></path>

                        <path
                            d="M112 95C58 80 35 48 25 22C70 25 100 52 112 95Z"
                            fill="currentColor"
                        ></path>

                        <path
                            d="M104 150C50 142 20 110 8 80C58 82 92 108 104 150Z"
                            fill="currentColor"
                        ></path>

                        <path
                            d="M100 205C52 203 22 174 10 145C55 142 90 165 100 205Z"
                            fill="currentColor"
                        ></path>

                        <path
                            d="M122 72C164 54 184 30 192 8C154 10 130 34 122 72Z"
                            fill="currentColor"
                        ></path>

                        <path
                            d="M113 130C160 120 188 90 196 62C152 66 124 92 113 130Z"
                            fill="currentColor"
                        ></path>

                        <path
                            d="M106 188C154 182 180 154 190 126C146 128 116 151 106 188Z"
                            fill="currentColor"
                        ></path>

                    </svg>

                </div>


                <div class="ml-blog-view-cta-grid">


                    <div class="ml-pharmacy-cta-content">

                        <div class="ml-commitment-badge px-4">

                            <i class="bi bi-headset"></i>

                            Patient Support

                        </div>


                        <h2>
                            Need Guidance Before You Begin?
                        </h2>


                        <p>
                            Connect with the MediLeaf team for consultation enquiries,
                            prescription support, pharmacy guidance, and product information.
                        </p>


                        <div class="ml-pharmacy-trust-row">

                            <div>
                                <i class="bi bi-shield-check"></i>
                                Doctor Guided
                            </div>

                            <div>
                                <i class="bi bi-truck"></i>
                                Pharmacy Support
                            </div>

                            <div>
                                <i class="bi bi-chat-dots"></i>
                                Friendly Assistance
                            </div>

                        </div>

                    </div>


                    <div class="ml-pharmacy-cta-actions">

                        <a
                            href="#medileaf-pharmacy-enquiry"
                            class="ml-pharmacy-main-btn"
                        >
                            Consultation Enquiry
                        </a>


                        <a
                            href="tel:+61460034851"
                            class="ml-pharmacy-call-btn"
                        >
                            Call Pharmacy
                        </a>

                    </div>


                </div>

            </div>

        </div>

    </section>


</section>

@endsection



@push('scripts')

    {{-- Blog JavaScript --}}
    <script src="{{ asset('js/blog.js') }}"></script>


    {{-- Article Schema --}}

    <script type="application/ld+json">

    {!! json_encode([

        '@context' => 'https://schema.org',

        '@type' => $post->schema_type ?: 'BlogPosting',

        'headline' => $post->title,

        'description' =>
            $post->meta_description
            ?: ($post->excerpt ?: ''),

        'datePublished' =>
            $post->published_at
            ? $post->published_at->toIso8601String()
            : null,

        'dateModified' =>
            $post->updated_at
            ? $post->updated_at->toIso8601String()
            : null,

        'author' => $post->author
            ? [
                '@type' => 'Person',
                'name' => $post->author->name,
            ]
            : [
                '@type' => 'Organization',
                'name' => 'MediLeaf Australia',
            ],

        'reviewedBy' => $post->reviewer
            ? [
                '@type' => 'Person',
                'name' => $post->reviewer->name,
            ]
            : null,

        'publisher' => [
            '@type' => 'Organization',
            'name' => 'MediLeaf Australia',
        ],

        'image' => $post->featured_image
            ? [
                asset($post->featured_image)
            ]
            : [
                asset('img/blog/blog-hero.webp')
            ],

        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => $canonicalUrl,
        ],

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}

    </script>

@endpush