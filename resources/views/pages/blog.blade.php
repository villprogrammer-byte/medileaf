@extends('layouts.app')

@section('title', 'MediLeaf Blog | Health Tips, Wellness & Medical Insights')
@section('meta_description', 'Trusted health information, wellness tips and medical insights from MediLeaf Australia to help you live a healthier, happier life.')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endpush

@section('content')

    @php
        $blogCategories = $categories ?? [
            ['name' => 'All Articles', 'icon' => 'bi-grid-fill', 'slug' => 'all'],
            ['name' => 'Health Tips', 'icon' => 'bi-heart-pulse', 'slug' => 'health-tips'],
            ['name' => 'Medications', 'icon' => 'bi-capsule-pill', 'slug' => 'medications'],
            ['name' => 'Wellness', 'icon' => 'bi-person-arms-up', 'slug' => 'wellness'],
            ['name' => 'Conditions', 'icon' => 'bi-stethoscope', 'slug' => 'conditions'],
            ['name' => 'Nutrition', 'icon' => 'bi-apple', 'slug' => 'nutrition'],
            ['name' => 'Mental Health', 'icon' => 'bi-head-side-heart', 'slug' => 'mental-health'],
        ];

        $featuredPost = $featuredPost ?? [
            'title' => '10 Simple Daily Habits for a Healthier You',
            'excerpt' => 'Small changes can lead to big results. Discover 10 easy habits that can improve your physical and mental well-being.',
            'category' => 'Health Tips',
            'author' => 'MediLeaf Team',
            'date' => 'May 8, 2026',
            'image' => 'img/blog/featured-health-habits.webp',
            'slug' => 'top-7-natural-remedies-for-common-cold',
        ];

        $posts = $posts ?? [
            [
                'title' => 'The Importance of Quality Sleep',
                'excerpt' => 'Learn how quality sleep impacts your overall health and simple tips to improve it.',
                'category' => 'Wellness',
                'author' => 'MediLeaf Team',
                'date' => 'May 5, 2026',
                'image' => 'img/blog/quality-sleep.webp',
                'slug' => 'importance-of-quality-sleep',
            ],
            [
                'title' => 'Understanding Generic vs. Brand Name Medications',
                'excerpt' => 'Know the differences, benefits and which option may be right for you.',
                'category' => 'Medications',
                'author' => 'MediLeaf Team',
                'date' => 'May 2, 2026',
                'image' => 'img/blog/generic-vs-brand.webp',
                'slug' => 'generic-vs-brand-name-medications',
            ],
            [
                'title' => 'Foods That Boost Immunity Naturally',
                'excerpt' => 'Add these immunity-supporting foods to your diet and stay protected all year.',
                'category' => 'Nutrition',
                'author' => 'MediLeaf Team',
                'date' => 'Apr 28, 2026',
                'image' => 'img/blog/immunity-foods.webp',
                'slug' => 'foods-that-boost-immunity-naturally',
            ],
        ];

        $popularPosts = $popularPosts ?? [
            ['title' => 'Managing Stress in Busy Times', 'date' => 'May 3, 2026', 'image' => 'img/blog/stress.webp', 'slug' => 'managing-stress-in-busy-times'],
            ['title' => 'A Complete Guide to Vitamins & Minerals', 'date' => 'Apr 30, 2026', 'image' => 'img/blog/vitamins.webp', 'slug' => 'complete-guide-vitamins-minerals'],
            ['title' => 'How to Read Your Prescription Correctly', 'date' => 'Apr 26, 2026', 'image' => 'img/blog/prescription.webp', 'slug' => 'how-to-read-your-prescription-correctly'],
            ['title' => 'Hydration: The Key to Good Health', 'date' => 'Apr 22, 2026', 'image' => 'img/blog/hydration.webp', 'slug' => 'hydration-the-key-to-good-health'],
        ];
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

        <section class="ml-blog-categories" id="all-articles">
            <div class="container">

                <div class="ml-blog-section-title">
                    <h2>Explore by Category</h2>
                </div>

                <div class="ml-blog-category-row">
                    @foreach($blogCategories as $category)
                        <a href="#" class="ml-blog-category {{ ($category['slug'] ?? '') === 'all' ? 'active' : '' }}">
                            <i class="bi {{ $category['icon'] ?? 'bi-folder' }}"></i>
                            <span>{{ $category['name'] }}</span>
                        </a>
                    @endforeach
                </div>

            </div>
        </section>

        <section class="ml-blog-articles" id="health-articles">
            <div class="container">

                <div class="ml-blog-layout">

                    <main class="ml-blog-main">

                        <div class="ml-blog-section-title ml-blog-featured-title">
                            <h2>Featured Articles</h2>

                            <a href="#all-articles" class="ml-blog-view-all">
                                View All Articles
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>

                        <article class="ml-blog-featured-card">

                            <a href="{{ url('/blog/' . ($featuredPost['slug'] ?? 'top-7-natural-remedies-for-common-cold')) }}" class="ml-blog-featured-media">
                                <img src="{{ asset($featuredPost['image']) }}" alt="{{ $featuredPost['title'] }}"
                                    loading="lazy">
                            </a>

                            <div class="ml-blog-featured-content">
                                <span class="ml-blog-label">
                                    {{ $featuredPost['category'] }}
                                </span>

                                <h3>
                                    <a href="{{ url('/blog/' . ($featuredPost['slug'] ?? 'top-7-natural-remedies-for-common-cold')) }}">
                                        {{ $featuredPost['title'] }}
                                    </a>
                                </h3>

                                <p>{{ $featuredPost['excerpt'] }}</p>

                                <div class="ml-blog-meta">
                                    <span>
                                        <i class="bi bi-leaf-fill"></i>
                                        {{ $featuredPost['author'] }}
                                    </span>
                                    <span>
                                        <i class="bi bi-calendar3"></i>
                                        {{ $featuredPost['date'] }}
                                    </span>
                                </div>
                            </div>

                        </article>

                        <div class="ml-blog-post-grid mb-5">

                            @foreach($posts as $post)
                                <article class="ml-blog-post-card">

                                    <a href="{{ url('/blog/' . ($post['slug'] ?? '')) }}" class="ml-blog-post-media">
                                        <img src="{{ asset($post['image']) }}" alt="{{ $post['title'] }}" loading="lazy">
                                    </a>

                                    <div class="ml-blog-post-content">
                                        <span class="ml-blog-label">
                                            {{ $post['category'] }}
                                        </span>

                                        <h3>
                                            <a href="{{ url('/blog/' . ($post['slug'] ?? '')) }}">
                                                {{ $post['title'] }}
                                            </a>
                                        </h3>

                                        <p>{{ $post['excerpt'] }}</p>

                                        <div class="ml-blog-meta">
                                            <span>
                                                <i class="bi bi-leaf-fill"></i>
                                                {{ $post['author'] }}
                                            </span>
                                            <span>
                                                <i class="bi bi-calendar3"></i>
                                                {{ $post['date'] }}
                                            </span>
                                        </div>
                                    </div>

                                </article>
                            @endforeach

                        </div>

                    </main>

                    <aside class="ml-blog-sidebar">

                        <form class="ml-blog-search" action="#" method="GET">
                            <label for="blogSearch" class="visually-hidden">
                                Search articles
                            </label>

                            <input id="blogSearch" type="search" name="q" placeholder="Search articles...">

                            <button type="submit" aria-label="Search articles">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>

                        <section class="ml-blog-sidebar-card">
                            <h2>Popular Articles</h2>

                            <div class="ml-blog-popular">

                                @foreach($popularPosts as $popular)
                                    <a href="{{ !empty($popular['slug']) ? url('/blog/' . $popular['slug']) : route('blog') }}" class="ml-blog-popular-item">

                                        <span class="ml-blog-popular-image">
                                            <img src="{{ asset($popular['image']) }}" alt="{{ $popular['title'] }}"
                                                loading="lazy">
                                        </span>

                                        <span class="ml-blog-popular-text">
                                            <strong>{{ $popular['title'] }}</strong>
                                            <small>{{ $popular['date'] }}</small>
                                        </span>

                                    </a>
                                @endforeach

                            </div>
                        </section>

                        <section class="ml-blog-newsletter">
                            <div class="ml-blog-newsletter-icon">
                                <i class="bi bi-envelope-heart"></i>
                            </div>

                            <h2>Stay Updated</h2>

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

                            <small>We respect your privacy.</small>
                        </section>

                    </aside>

                </div>

            </div>
        </section>

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
                                <h2>Need Guidance Before You Begin?</h2>
                                <p>
                                    Connect with the Medileaf team for consultation enquiries, prescription support,
                                    pharmacy guidance, and product information.
                                </p>

                                <div class="ml-pharmacy-trust-row">
                                    <div><i class="bi bi-shield-check"></i> Doctor Guided</div>
                                    <div><i class="bi bi-truck"></i> Pharmacy Support</div>
                                    <div><i class="bi bi-chat-dots"></i> Friendly Assistance</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="ml-pharmacy-cta-actions">
                                <a href="#medileaf-pharmacy-enquiry" class="ml-pharmacy-main-btn">Consultation Enquiry</a>
                                <a href="tel:+61460034851" class="ml-pharmacy-call-btn">Call Pharmacy</a>
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