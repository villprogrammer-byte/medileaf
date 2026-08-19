@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Storage;

    /*
    |--------------------------------------------------------------------------
    | Database blog normalisation
    |--------------------------------------------------------------------------
    | BlogPost is the database model. The original template was written for
    | array-based demo data, so normalise the model here without changing the
    | existing page design.
    |--------------------------------------------------------------------------
    */

    if (!isset($post) && isset($blogPost)) {
        $post = $blogPost;
    }

    $blogImageUrl = function ($item, $fallback = 'img/blog/featured-health-habits.webp') {
        $path = is_array($item)
            ? ($item['featured_image'] ?? $item['image'] ?? null)
            : ($item->featured_image ?? null);

        if (!$path) {
            return asset($fallback);
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    };

    $blogValue = function ($item, $key, $fallback = null) {
        if (is_array($item)) {
            return $item[$key] ?? $fallback;
        }

        return $item->{$key} ?? $fallback;
    };

    /*
    |--------------------------------------------------------------------------
    | Dynamic article data
    |--------------------------------------------------------------------------
    | Controller can pass $post, $relatedPosts and $popularPosts.
    | These fallbacks let the page render immediately while the database/
    | controller is being connected.
    */

    if (isset($post) && $post instanceof \App\Models\BlogPost) {
        $post = [
            'title' => $post->title,
            'slug' => $post->slug,
            'category' => $post->category?->name ?? 'Health & Wellness',
            'category_slug' => $post->category?->slug ?? '',
            'excerpt' => $post->excerpt,
            'date' => optional($post->published_at ?? $post->created_at)->format('M d, Y'),
            'read_time' => $post->reading_time ? $post->reading_time . ' min read' : '5 min read',
            'author' => $post->author?->name ?? 'MediLeaf Team',
            'author_bio' => $post->author?->bio ?? 'Our team of health experts and writers is dedicated to providing reliable health information.',
            'image' => $post->featured_image,
            'featured_image_alt' => $post->featured_image_alt,
            'content' => $post->content,
        ];
    }

    $post = $post ?? [
        'title' => 'Top 7 Natural Remedies for Common Cold',
        'slug' => 'top-7-natural-remedies-for-common-cold',
        'category' => 'Natural Remedies',
        'category_slug' => 'natural-remedies',
        'excerpt' => 'Discover natural and effective remedies to relieve symptoms and boost recovery. Try these simple home remedies and feel better, naturally.',
        'date' => 'May 15, 2026',
        'read_time' => '7 min read',
        'author' => 'MediLeaf Team',
        'author_bio' => 'Our team of health experts and writers is dedicated to providing you with reliable, evidence-based health information.',
        'image' => 'img/blog/featured-health-habits.webp',
    ];

    $relatedPosts = $relatedPosts ?? [
        [
            'title' => 'How to Boost Your Immune System Naturally',
            'slug' => 'how-to-boost-your-immune-system-naturally',
            'category' => 'Health Tips',
            'date' => 'May 12, 2026',
            'image' => 'img/blog/immunity-foods.webp',
        ],
        [
            'title' => 'Managing Stress for a Better Life',
            'slug' => 'managing-stress-for-a-better-life',
            'category' => 'Wellness',
            'date' => 'May 5, 2026',
            'image' => 'img/blog/stress.webp',
        ],
        [
            'title' => 'The Importance of Quality Sleep',
            'slug' => 'importance-of-quality-sleep',
            'category' => 'Wellness',
            'date' => 'Apr 28, 2026',
            'image' => 'img/blog/quality-sleep.webp',
        ],
    ];

    $popularPosts = $popularPosts ?? [
        ['title' => 'How to Boost Your Immune System Naturally', 'date' => 'May 12, 2026', 'image' => 'img/blog/immunity-foods.webp', 'slug' => 'how-to-boost-your-immune-system-naturally'],
        ['title' => 'Managing Stress for a Better Life', 'date' => 'May 5, 2026', 'image' => 'img/blog/stress.webp', 'slug' => 'managing-stress-for-a-better-life'],
        ['title' => 'The Importance of Hydration Every Day', 'date' => 'Apr 28, 2026', 'image' => 'img/blog/hydration.webp', 'slug' => 'importance-of-hydration'],
        ['title' => 'Natural Skincare Tips for Glowing Skin', 'date' => 'Apr 15, 2026', 'image' => 'img/blog/featured-health-habits.webp', 'slug' => 'natural-skincare-tips'],
    ];

    $canonicalUrl = url('/blog/' . ($post['slug'] ?? 'top-7-natural-remedies-for-common-cold'));
@endphp

@section('title', ($post['title'] ?? 'Health Article') . ' | MediLeaf Australia')
@section('meta_description', $post['excerpt'] ?? 'Trusted health information from MediLeaf Australia.')
@section('canonical_url', $canonicalUrl)
@section('og_title', ($post['title'] ?? 'Health Article') . ' | MediLeaf Australia')
@section('og_description', $post['excerpt'] ?? 'Trusted health information from MediLeaf Australia.')
@section('og_image', $blogImageUrl($post, 'img/blog/featured-health-habits.webp'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/blog-view.css') }}">
@endpush

@section('content')

    <section class="ml-blog-page ml-blog-view-page">

        {{-- Breadcrumb --}}
        <section class="ml-blog-breadcrumb-wrap">
            <div class="container">
                <nav class="ml-blog-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">
                        <i class="bi bi-house-fill"></i>
                        <span>Home</span>
                    </a>
                    <i class="bi bi-chevron-right"></i>
                    <a href="{{ route('blog') }}">Blog</a>
                    <i class="bi bi-chevron-right"></i>
                    <a href="#">{{ $post['category'] }}</a>
                    <i class="bi bi-chevron-right"></i>
                    <span>{{ $post['title'] }}</span>
                </nav>
            </div>
        </section>

        <section class="ml-blog-article-section">
            <div class="container">

                <div class="ml-blog-view-layout">

                    <main class="ml-blog-article-main">

                        {{-- Article header --}}
                        <header class="ml-blog-article-header">

                            <span class="ml-blog-label">
                                {{ $post['category'] }}
                            </span>

                            <h1>{{ $post['title'] }}</h1>

                            <p class="ml-blog-article-excerpt">
                                {{ $post['excerpt'] }}
                            </p>

                            <div class="ml-blog-article-meta-row">

                                <div class="ml-blog-article-meta">
                                    <span>
                                        <i class="bi bi-calendar3"></i>
                                        {{ $post['date'] }}
                                    </span>

                                    <span>
                                        <i class="bi bi-person"></i>
                                        By {{ $post['author'] }}
                                    </span>

                                    <span>
                                        <i class="bi bi-clock"></i>
                                        {{ $post['read_time'] ?? '7 min read' }}
                                    </span>
                                </div>

                                <div class="ml-blog-share">
                                    <span>Share:</span>

                                    <a href="#" aria-label="Share on Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>

                                    <a href="#" aria-label="Share on X">
                                        <i class="bi bi-twitter-x"></i>
                                    </a>

                                    <a href="#" aria-label="Share on LinkedIn">
                                        <i class="bi bi-linkedin"></i>
                                    </a>

                                    <a href="#" aria-label="Share by email">
                                        <i class="bi bi-envelope"></i>
                                    </a>
                                </div>

                            </div>

                        </header>

                        {{-- Main article image --}}
                        <figure class="ml-blog-article-hero">
                            <img src="{{ $blogImageUrl($post) }}" alt="{{ $post['title'] }}" fetchpriority="high"
                                decoding="async">
                        </figure>

                        {{-- Key takeaway --}}
                        <aside class="ml-blog-key-takeaway">
                            <div class="ml-blog-key-icon">
                                <i class="bi bi-lightbulb"></i>
                            </div>

                            <div>
                                <strong>Key Takeaway</strong>
                                <p>
                                    Natural remedies may help relieve common cold symptoms and support
                                    recovery when used appropriately alongside good rest, hydration and
                                    general self-care.
                                </p>
                            </div>

                            <span class="ml-blog-takeaway-decoration">
                                <i class="bi bi-leaf-fill"></i>
                            </span>
                        </aside>

                        {{-- Article content --}}

                        {{-- Article content --}}
                        {{-- Article content --}}
                        <article class="ml-blog-article-content">
                            {!! $post['content'] ?? '' !!}
                        </article>

                        {{-- Author --}}
                        <section class="ml-blog-author-card">
                            <div class="ml-blog-author-avatar">
                                <i class="bi bi-leaf-fill"></i>
                            </div>

                            <div class="ml-blog-author-content">
                                <span>About the Author</span>
                                <h2>{{ $post['author'] }}</h2>
                                <p>{{ $post['author_bio'] }}</p>

                                <div class="ml-blog-author-socials">
                                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                                    <a href="#" aria-label="X"><i class="bi bi-twitter-x"></i></a>
                                    <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                                    <a href="#" aria-label="Email"><i class="bi bi-envelope"></i></a>
                                </div>
                            </div>
                        </section>

                        {{-- Previous / Next --}}
                        @php
                            $previousPost = $previousPost ?? null;
                            $nextPost = $nextPost ?? null;
                        @endphp

                        <nav class="ml-blog-post-navigation" aria-label="Article navigation">

                            @if($previousPost)
                                <a href="{{ route('blog.show', $previousPost['slug']) }}"
                                    class="ml-blog-post-nav ml-blog-post-nav-prev">

                                    <span class="ml-blog-nav-arrow">
                                        <i class="bi bi-arrow-left"></i>
                                    </span>

                                    <span class="ml-blog-nav-copy">
                                        <small>Previous Post</small>

                                        <strong>
                                            {{ $previousPost['title'] }}
                                        </strong>
                                    </span>

                                    @if(!empty($previousPost['image']))
                                        <span class="ml-blog-nav-thumb">
                                            <img src="{{ asset('storage/' . ltrim($previousPost['image'], '/')) }}"
                                                alt="{{ $previousPost['title'] }}" loading="lazy">
                                        </span>
                                    @endif

                                </a>
                            @endif


                            @if($nextPost)
                                <a href="{{ route('blog.show', $nextPost['slug']) }}"
                                    class="ml-blog-post-nav ml-blog-post-nav-next">

                                    <span class="ml-blog-nav-copy">
                                        <small>Next Post</small>

                                        <strong>
                                            {{ $nextPost['title'] }}
                                        </strong>
                                    </span>

                                    @if(!empty($nextPost['image']))
                                        <span class="ml-blog-nav-thumb">
                                            <img src="{{ asset('storage/' . ltrim($nextPost['image'], '/')) }}"
                                                alt="{{ $nextPost['title'] }}" loading="lazy">
                                        </span>
                                    @endif

                                    <span class="ml-blog-nav-arrow">
                                        <i class="bi bi-arrow-right"></i>
                                    </span>

                                </a>
                            @endif

                        </nav>

                    </main>

                    {{-- Sidebar --}}
                    <aside class="ml-blog-sidebar ml-blog-view-sidebar">

                        <form class="ml-blog-search" action="{{ route('blog') }}" method="GET">
                            <label for="blogViewSearch" class="visually-hidden">Search Blog</label>

                            <input id="blogViewSearch" type="search" name="q" placeholder="Search articles..."
                                value="{{ request('q') }}">

                            <button type="submit" aria-label="Search articles">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>

                        <section class="ml-blog-sidebar-card">
                            <h2>Categories</h2>

                            <div class="ml-blog-view-categories">

                                <a href="#">
                                    <span><i class="bi bi-heart-pulse"></i> Health &amp; Wellness</span>
                                    <strong>(8)</strong>
                                </a>

                                <a href="#">
                                    <span><i class="bi bi-capsule"></i> Medicines &amp; Treatments</span>
                                    <strong>(6)</strong>
                                </a>

                                <a class="active" href="#">
                                    <span><i class="bi bi-flower1"></i> Natural Remedies</span>
                                    <strong>(4)</strong>
                                </a>

                                <a href="#">
                                    <span><i class="bi bi-person-check"></i> Healthy Living</span>
                                    <strong>(3)</strong>
                                </a>

                                <a href="#">
                                    <span><i class="bi bi-file-text"></i> News &amp; Updates</span>
                                    <strong>(3)</strong>
                                </a>

                            </div>

                            <a href="{{ route('blog') }}" class="ml-blog-sidebar-view-all">
                                View All Categories
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </section>

                        <section class="ml-blog-sidebar-card">
                            <h2>Popular Posts</h2>

                            <div class="ml-blog-popular">

                                @foreach($popularPosts as $popular)
                                    <a href="{{ (is_array($popular) ? ($popular['slug'] ?? null) : ($popular->slug ?? null)) ? url('/blog/' . (is_array($popular) ? $popular['slug'] : $popular->slug)) : route('blog') }}"
                                        class="ml-blog-popular-item">

                                        <span class="ml-blog-popular-image">
                                            <img src="{{ $blogImageUrl($popular) }}"
                                                alt="{{ $blogValue($popular, 'title', 'Health & Wellness') }}" loading="lazy"
                                                decoding="async">
                                        </span>

                                        <span class="ml-blog-popular-text">
                                            <strong>{{ $blogValue($popular, 'title', 'Health & Wellness') }}</strong>
                                            <small>{{ $blogValue($popular, 'date', is_array($popular) ? '' : optional($popular->published_at ?? $popular->created_at)->format('M d, Y')) }}</small>
                                        </span>

                                    </a>
                                @endforeach

                            </div>
                        </section>

                        <section class="ml-blog-newsletter">
                            <div class="ml-blog-newsletter-icon">
                                <i class="bi bi-envelope-heart"></i>
                            </div>

                            <h2>Stay Updated with MediLeaf</h2>

                            <p>
                                Subscribe for trusted health tips, wellness updates and useful information.
                            </p>

                            <form action="#" method="POST">
                                @csrf

                                <input type="email" name="email" placeholder="Enter your email" required>

                                <button type="submit">
                                    Subscribe Now
                                </button>
                            </form>

                            <small>We respect your privacy.</small>
                        </section>

                        {{-- Small pharmacy promotion --}}
                        <section class="ml-blog-sidebar-promo">
                            <div>
                                <span>Natural Care</span>
                                <h2>for a Better You</h2>
                                <p>Explore wellness products selected for everyday healthy living.</p>
                                <a href="{{ route('store') }}">
                                    Shop Now
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>

                            <div class="ml-blog-sidebar-promo-image">
                                <img src="{{ asset('img/blog/immunity-foods.webp') }}"
                                    alt="MediLeaf natural wellness products" loading="lazy">
                            </div>
                        </section>

                    </aside>

                </div>

            </div>
        </section>

        {{-- Bottom pharmacy/support CTA --}}
        <section class="ml-pharmacy-cta ml-blog-view-cta">
            <div class="container">

                <div class="ml-pharmacy-cta-card">

                    <div class="ml-pharmacy-botanical left">
                        <svg viewBox="0 0 200 300" fill="none" aria-hidden="true">
                            <path d="M100 285C98 210 104 120 120 25" stroke="currentColor" stroke-width="3"></path>
                            <path d="M112 95C58 80 35 48 25 22C70 25 100 52 112 95Z" fill="currentColor"></path>
                            <path d="M104 150C50 142 20 110 8 80C58 82 92 108 104 150Z" fill="currentColor"></path>
                            <path d="M100 205C52 203 22 174 10 145C55 142 90 165 100 205Z" fill="currentColor"></path>
                            <path d="M122 72C164 54 184 30 192 8C154 10 130 34 122 72Z" fill="currentColor"></path>
                            <path d="M113 130C160 120 188 90 196 62C152 66 124 92 113 130Z" fill="currentColor"></path>
                            <path d="M106 188C154 182 180 154 190 126C146 128 116 151 106 188Z" fill="currentColor"></path>
                        </svg>
                    </div>

                    <div class="ml-pharmacy-botanical right">
                        <svg viewBox="0 0 200 300" fill="none" aria-hidden="true">
                            <path d="M100 285C98 210 104 120 120 25" stroke="currentColor" stroke-width="3"></path>
                            <path d="M112 95C58 80 35 48 25 22C70 25 100 52 112 95Z" fill="currentColor"></path>
                            <path d="M104 150C50 142 20 110 8 80C58 82 92 108 104 150Z" fill="currentColor"></path>
                            <path d="M100 205C52 203 22 174 10 145C55 142 90 165 100 205Z" fill="currentColor"></path>
                            <path d="M122 72C164 54 184 30 192 8C154 10 130 34 122 72Z" fill="currentColor"></path>
                            <path d="M113 130C160 120 188 90 196 62C152 66 124 92 113 130Z" fill="currentColor"></path>
                            <path d="M106 188C154 182 180 154 190 126C146 128 116 151 106 188Z" fill="currentColor"></path>
                        </svg>
                    </div>

                    <div class="ml-blog-view-cta-grid">

                        <div class="ml-pharmacy-cta-content">
                            <div class="ml-commitment-badge px-4">
                                <i class="bi bi-headset"></i>
                                Patient Support
                            </div>

                            <h2>Need Guidance Before You Begin?</h2>

                            <p>
                                Connect with the MediLeaf team for consultation enquiries, prescription
                                support, pharmacy guidance, and product information.
                            </p>

                            <div class="ml-pharmacy-trust-row">
                                <div><i class="bi bi-shield-check"></i> Doctor Guided</div>
                                <div><i class="bi bi-truck"></i> Pharmacy Support</div>
                                <div><i class="bi bi-chat-dots"></i> Friendly Assistance</div>
                            </div>
                        </div>

                        <div class="ml-pharmacy-cta-actions">
                            <a href="#medileaf-pharmacy-enquiry" class="ml-pharmacy-main-btn">
                                Consultation Enquiry
                            </a>

                            <a href="tel:+61460034851" class="ml-pharmacy-call-btn">
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartDrawer = document.getElementById('mlCartDrawer');
            const cartOverlay = document.getElementById('mlCartOverlay');

            if (cartDrawer) {
                cartDrawer.classList.remove('active');
            }

            if (cartOverlay) {
                cartOverlay.classList.remove('active');
            }

            document.querySelectorAll('#mlCartOpen, .ml-cart-btn').forEach(function (button) {
                button.classList.remove('active');
            });
        });
    </script>

    <script type="application/ld+json">
                            {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $post['title'],
        'description' => $post['excerpt'],
        'datePublished' => date('c', strtotime($post['date'])),
        'author' => [
            '@type' => 'Organization',
            'name' => $post['author'],
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'MediLeaf Australia',
        ],
        'image' => [$blogImageUrl($post)],
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => $canonicalUrl,
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
                            </script>
@endpush