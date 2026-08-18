@extends('layouts.app')

@section('title', 'MediLeaf Blog | Health Tips, Wellness & Medical Insights')

@section('meta_description', 'Trusted health information, wellness tips and medical insights from MediLeaf Australia to help you live a healthier, happier life.')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endpush

@section('content')

    @php
        /*
        |--------------------------------------------------------------------------
        | Blog Data
        |--------------------------------------------------------------------------
        | web.php currently loads this view directly.
        | Therefore the public blog data is loaded here.
        */

        use App\Models\BlogCategory;
        use App\Models\BlogPost;

        $blogCategories = BlogCategory::where('is_active', true)
            ->withCount([
                'posts' => function ($query) {
                    $query->published();
                }
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $featuredPost = BlogPost::published()
            ->with([
                'category',
                'author',
            ])
            ->where('is_featured', true)
            ->latest('published_at')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | If no post is specifically featured,
        | use the latest published post.
        |--------------------------------------------------------------------------
        */

        if (!$featuredPost) {
            $featuredPost = BlogPost::published()
                ->with([
                    'category',
                    'author',
                ])
                ->latest('published_at')
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Other Published Posts
        |--------------------------------------------------------------------------
        */

        $postsQuery = BlogPost::published()
            ->with([
                'category',
                'author',
            ])
            ->latest('published_at');

        if ($featuredPost) {
            $postsQuery->where(
                'id',
                '!=',
                $featuredPost->id
            );
        }

        $posts = $postsQuery
            ->paginate(9)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Popular Posts
        |--------------------------------------------------------------------------
        */

        $popularPosts = BlogPost::published()
            ->with([
                'category',
                'author',
            ])
            ->latest('published_at')
            ->take(4)
            ->get();
    @endphp


    <section class="ml-blog-page">

        {{-- Blog content follows MediLeaf's normal wide desktop page rhythm.
        No Bootstrap .container is used anywhere in this page. --}}

        <section class="ml-blog-hero">

            <div class="container">

                <div class="ml-blog-hero-inner">

                    <div class="ml-blog-hero-copy">

                        <span class="ml-blog-eyebrow">
                            <i class="bi bi-leaf-fill"></i>
                            MEDILEAF BLOG
                        </span>

                        <h1>
                            Your Health, Our
                            <span>Expertise</span>
                        </h1>

                        <p>
                            Trusted health information, wellness tips, and medical insights
                            to help you live a healthier, happier life.
                        </p>

                        <div class="ml-blog-hero-actions">

                            <a href="#health-articles" class="ml-blog-btn ml-blog-btn-primary">
                                Health Tips
                            </a>

                            <a href="#all-articles" class="ml-blog-btn ml-blog-btn-outline">
                                All Articles
                            </a>

                        </div>

                    </div>


                    <div class="ml-blog-hero-image">

                        <img src="{{ asset('img/blog/blog-hero.webp') }}"
                            alt="MediLeaf health blog featuring leaves, tablets and wellness products" loading="eager">

                    </div>

                </div>

            </div>

        </section>


        {{-- Categories --}}

        <section class="ml-blog-categories" id="all-articles">

            <div class="container">

                <div class="ml-blog-section-title">

                    <h2>
                        Explore by Category
                    </h2>

                </div>


                <div class="ml-blog-category-row">

                    @if($blogCategories->count())

                        <a href="#all-articles" class="ml-blog-category active">
                            <i class="bi bi-grid-fill"></i>
                            <span>All Articles</span>
                        </a>


                        @foreach($blogCategories as $category)

                            <a href="#all-articles" class="ml-blog-category">

                                <i class="bi bi-folder"></i>

                                <span>
                                    {{ $category->name }}
                                </span>

                            </a>

                        @endforeach

                    @else

                        <a href="#all-articles" class="ml-blog-category active">
                            <i class="bi bi-grid-fill"></i>
                            <span>All Articles</span>
                        </a>

                    @endif

                </div>

            </div>

        </section>


        {{-- Blog Articles --}}

        <section class="ml-blog-articles" id="health-articles">

            <div class="container">

                <div class="ml-blog-layout">


                    {{-- Main Blog Content --}}

                    <main class="ml-blog-main">


                        {{-- Featured Article --}}

                        <div class="ml-blog-section-title ml-blog-featured-title">

                            <h2>
                                Featured Articles
                            </h2>

                            <a href="#all-articles" class="ml-blog-view-all">
                                View All Articles
                                <i class="bi bi-arrow-right"></i>
                            </a>

                        </div>


                        @if($featuredPost)

                            <article class="ml-blog-featured-card">

                                <a href="{{ route('blog.view', $featuredPost->slug) }}" class="ml-blog-featured-media">

                                    @if($featuredPost->featured_image)

                                        <img src="{{ asset('storage/' . $featuredPost->featured_image) }}"
                                            alt="{{ $featuredPost->featured_image_alt ?: $featuredPost->title }}" loading="lazy">

                                    @else

                                        <div class="ml-blog-image-placeholder">
                                            <i class="bi bi-image"></i>
                                        </div>

                                    @endif

                                </a>


                                <div class="ml-blog-featured-content">

                                    <span class="ml-blog-label">
                                        {{ $featuredPost->category?->name ?? 'Health & Wellness' }}
                                    </span>


                                    <h3>

                                        <a href="{{ route('blog.view', $featuredPost->slug) }}">
                                            {{ $featuredPost->title }}
                                        </a>

                                    </h3>


                                    @if($featuredPost->excerpt)

                                        <p>
                                            {{ $featuredPost->excerpt }}
                                        </p>

                                    @endif


                                    <div class="ml-blog-meta">

                                        <span>
                                            <i class="bi bi-leaf-fill"></i>

                                            {{ $featuredPost->author?->name ?? 'MediLeaf Team' }}
                                        </span>


                                        @if($featuredPost->published_at)

                                            <span>
                                                <i class="bi bi-calendar3"></i>

                                                {{ $featuredPost->published_at->format('M d, Y') }}
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </article>

                        @else

                            <div class="ml-blog-empty">

                                <div class="ml-blog-empty-icon">
                                    <i class="bi bi-journal-medical"></i>
                                </div>

                                <h3>
                                    No published articles yet
                                </h3>

                                <p>
                                    New health and wellness articles will appear here soon.
                                </p>

                            </div>

                        @endif


                        {{-- Other Articles --}}

                        @if($posts->count())

                            <div class="ml-blog-post-grid mb-5">

                                @foreach($posts as $post)

                                    <article class="ml-blog-post-card">


                                        <a href="{{ route('blog.view', $post->slug) }}" class="ml-blog-post-media">

                                            @if($post->featured_image)

                                                <img src="{{ asset($post->featured_image) }}"
                                                    alt="{{ $post->featured_image_alt ?: $post->title }}" loading="lazy">

                                            @else

                                                <div class="ml-blog-image-placeholder">
                                                    <i class="bi bi-image"></i>
                                                </div>

                                            @endif

                                        </a>


                                        <div class="ml-blog-post-content">


                                            <span class="ml-blog-label">
                                                {{ $post->category?->name ?? 'Health & Wellness' }}
                                            </span>


                                            <h3>

                                                <a href="{{ route('blog.view', $post->slug) }}">
                                                    {{ $post->title }}
                                                </a>

                                            </h3>


                                            @if($post->excerpt)

                                                <p>
                                                    {{ $post->excerpt }}
                                                </p>

                                            @endif


                                            <div class="ml-blog-meta">

                                                <span>

                                                    <i class="bi bi-leaf-fill"></i>

                                                    {{ $post->author?->name ?? 'MediLeaf Team' }}

                                                </span>


                                                @if($post->published_at)

                                                    <span>

                                                        <i class="bi bi-calendar3"></i>

                                                        {{ $post->published_at->format('M d, Y') }}

                                                    </span>

                                                @endif

                                            </div>

                                        </div>

                                    </article>

                                @endforeach

                            </div>


                            {{-- Pagination --}}

                            @if($posts->hasPages())

                                <div class="ml-blog-pagination">

                                    {{ $posts->links() }}

                                </div>

                            @endif

                        @endif

                    </main>


                    {{-- Sidebar --}}

                    <aside class="ml-blog-sidebar">


                        {{-- Search --}}

                        <form class="ml-blog-search" action="#" method="GET">

                            <label for="blogSearch" class="visually-hidden">
                                Search articles
                            </label>


                            <input id="blogSearch" type="search" name="q" placeholder="Search articles...">


                            <button type="submit" aria-label="Search articles">
                                <i class="bi bi-search"></i>
                            </button>

                        </form>


                        {{-- Popular Articles --}}

                        <section class="ml-blog-sidebar-card">

                            <h2>
                                Popular Articles
                            </h2>


                            @if($popularPosts->count())

                                <div class="ml-blog-popular">

                                    @foreach($popularPosts as $popular)

                                        <a href="{{ route('blog.view', $popular->slug) }}" class="ml-blog-popular-item">

                                            <span class="ml-blog-popular-image">

                                                @if($popular->featured_image)

                                                    <img src="{{ asset($popular->featured_image) }}"
                                                        alt="{{ $popular->featured_image_alt ?: $popular->title }}" loading="lazy">

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

                                <div class="ml-blog-sidebar-empty">

                                    <p>
                                        No published articles yet.
                                    </p>

                                </div>

                            @endif

                        </section>


                        {{-- Newsletter --}}

                        <section class="ml-blog-newsletter">

                            <div class="ml-blog-newsletter-icon">
                                <i class="bi bi-envelope-heart"></i>
                            </div>


                            <h2>
                                Stay Updated
                            </h2>


                            <p>
                                Subscribe to get the latest health tips and updates
                                straight to your inbox.
                            </p>


                            <form action="#" method="POST">

                                @csrf

                                <input type="email" name="email" placeholder="Enter your email" required>


                                <button type="submit">
                                    Subscribe
                                </button>

                            </form>


                            <small>
                                We respect your privacy.
                            </small>

                        </section>

                    </aside>

                </div>

            </div>

        </section>


        {{-- Pharmacy CTA --}}

        <section class="ml-pharmacy-cta">

            <div class="container">

                <div class="ml-pharmacy-cta-card">


                    <div class="ml-pharmacy-botanical left">

                        <svg viewBox="0 0 200 300" fill="none">

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

                        <svg viewBox="0 0 200 300" fill="none">

                            <path d="M100 285C98 210 104 120 120 25" stroke="currentColor" stroke-width="3"></path>

                            <path d="M112 95C58 80 35 48 25 22C70 25 100 52 112 95Z" fill="currentColor"></path>

                            <path d="M104 150C50 142 20 110 8 80C58 82 92 108 104 150Z" fill="currentColor"></path>

                            <path d="M100 205C52 203 22 174 10 145C55 142 90 165 100 205Z" fill="currentColor"></path>

                            <path d="M122 72C164 54 184 30 192 8C154 10 130 34 122 72Z" fill="currentColor"></path>

                            <path d="M113 130C160 120 188 90 196 62C152 66 124 92 113 130Z" fill="currentColor"></path>

                            <path d="M106 188C154 182 180 154 190 126C146 128 116 151 106 188Z" fill="currentColor"></path>

                        </svg>

                    </div>


                    <div class="row align-items-center g-4">

                        <div class="col-lg-8">

                            <div class="ml-pharmacy-cta-content">

                                <div class="ml-commitment-badge px-4">

                                    <i class="bi bi-headset"></i>

                                    Patient Support

                                </div>


                                <h2>
                                    Need Guidance Before You Begin?
                                </h2>


                                <p>
                                    Connect with the Medileaf team for consultation enquiries,
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

                        </div>


                        <div class="col-lg-4">

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

            </div>

        </section>

    </section>

@endsection


@push('scripts')

    <script src="{{ asset('js/blog.js') }}"></script>

@endpush