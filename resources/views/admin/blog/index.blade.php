@extends('admin.layouts.app')

@section('title', 'Blog')

@section('content')

    <div class="ml-admin-blog-page">

        {{-- Page Header --}}
        <div class="ml-admin-blog-header">

            <div>
                <span class="ml-admin-eyebrow">BLOG</span>

                <h1>Blog Posts</h1>

                <p>
                    Manage, review and publish your MediLeaf health content.
                </p>
            </div>

            <a href="{{ route('admin.blog.create') }}" class="ml-admin-blog-primary">
                <i class="bi bi-plus-lg"></i>
                Add New Post
            </a>

        </div>


        {{-- Success Message --}}
        @if(session('success'))

            <div class="ml-admin-alert ml-admin-alert-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>

        @endif


        {{-- =========================================================
        FILTER BLOG POSTS
        ========================================================== --}}

        <div class="ml-admin-blog-filter-card">

            <div class="ml-admin-blog-filter-title">
                <i class="bi bi-funnel-fill"></i>
                Filter Blog Posts
            </div>


            <form method="GET" action="{{ route('admin.blog.index') }}" class="ml-admin-blog-filter-form">

                {{-- Search --}}
                <div class="ml-admin-blog-filter-search">

                    <label class="ml-admin-label">
                        Search Posts
                    </label>

                    <div class="ml-admin-blog-search-wrap">

                        <i class="bi bi-search"></i>

                        <input type="search" name="search" value="{{ request('search') }}"
                            placeholder="Search by title, slug or excerpt...">

                    </div>

                </div>


                {{-- Category --}}
                <div>

                    <label class="ml-admin-label">
                        Category
                    </label>

                    <select name="category">

                        <option value="">
                            All Categories
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Status --}}
                <div>

                    <label class="ml-admin-label">
                        Status
                    </label>

                    <select name="status">

                        <option value="">
                            All Status
                        </option>

                        <option value="published" @selected(request('status') === 'published')>
                            Published
                        </option>

                        <option value="draft" @selected(request('status') === 'draft')>
                            Draft
                        </option>

                        <option value="scheduled" @selected(request('status') === 'scheduled')>
                            Scheduled
                        </option>

                    </select>

                </div>


                {{-- Featured --}}
                <div>

                    <label class="ml-admin-label">
                        Featured
                    </label>

                    <select name="featured">

                        <option value="">
                            All Posts
                        </option>

                        <option value="yes" @selected(request('featured') === 'yes')>
                            Featured
                        </option>

                        <option value="no" @selected(request('featured') === 'no')>
                            Not Featured
                        </option>

                    </select>

                </div>


                {{-- Filter Button --}}
                <div class="ml-admin-blog-filter-actions">

                    <button type="submit" class="ml-admin-blog-filter-btn">
                        <i class="bi bi-funnel"></i>
                        Filter
                    </button>

                    @if(
                            request()->hasAny([
                                'search',
                                'category',
                                'status',
                                'featured'
                            ])
                        )

                        <a href="{{ route('admin.blog.index') }}" class="ml-admin-blog-reset" title="Reset Filters">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Reset
                        </a>

                    @endif

                </div>

            </form>

        </div>


        {{-- =========================================================
        ALL POSTS
        ========================================================== --}}

        <div class="ml-admin-blog-table-card">

            <div class="ml-admin-blog-table-head">

                <div>

                    <strong>
                        All Posts
                    </strong>

                    <span>
                        {{ $posts->total() }}
                        {{ Str::plural('post', $posts->total()) }}
                    </span>

                </div>

            </div>


            @if($posts->count())

                <div class="ml-admin-blog-table-wrap">

                    <table class="ml-admin-blog-table">

                        <thead>

                            <tr>

                                <th>Post</th>

                                <th>Category</th>

                                <th>Author</th>

                                <th>Status</th>

                                <th>Published</th>

                                <th class="text-end">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($posts as $post)

                                        <tr>

                                            {{-- Post --}}
                                            <td>

                                                <div class="ml-admin-blog-post-cell">

                                                    <div class="ml-admin-blog-thumb">

                                                        @if($post->featured_image)

                                                            <img src="{{ asset($post->featured_image) }}"
                                                                alt="{{ $post->featured_image_alt ?: $post->title }}">

                                                        @else

                                                            <span>
                                                                <i class="bi bi-file-earmark-text"></i>
                                                            </span>

                                                        @endif

                                                    </div>


                                                    <div>

                                                        <div class="ml-admin-blog-post-title">

                                                            {{ $post->title }}

                                                            @if($post->is_featured)

                                                                <i class="bi bi-star-fill" title="Featured"></i>

                                                            @endif

                                                        </div>

                                                        <small>
                                                            /blog/{{ $post->slug }}
                                                        </small>

                                                    </div>

                                                </div>

                                            </td>


                                            {{-- Category --}}
                                            <td>

                                                {{ $post->category?->name ?? '—' }}

                                            </td>


                                            {{-- Author --}}
                                            <td>

                                                {{ $post->author?->name ?? '—' }}

                                            </td>


                                            {{-- Status --}}
                                            <td>

                                                @php

                                                    $statusClass = match ($post->status) {

                                                        'published' => 'published',

                                                        'scheduled' => 'scheduled',

                                                        default => 'draft',

                                                    };

                                                @endphp

                                                <span class="ml-admin-blog-status {{ $statusClass }}">
                                                    {{ ucfirst($post->status) }}
                                                </span>

                                            </td>


                                            {{-- Published --}}
                                            <td>

                                                {{ $post->published_at
                                ? $post->published_at->format('d M Y')
                                : '—'
                                                                                                                                                                                                                                                                                                    }}

                                            </td>


                                            {{-- Actions --}}
                                            <td>

                                                <div class="ml-admin-blog-actions">

                                                    <a href="{{ route('admin.blog.show', $post) }}" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>


                                                    <a href="{{ route('admin.blog.edit', $post) }}" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>


                                                    <form method="POST" action="{{ route('admin.blog.destroy', $post) }}"
                                                        onsubmit="return confirm('Delete this blog post?');">

                                                        @csrf

                                                        @method('DELETE')

                                                        <button type="submit" title="Delete">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                <div class="ml-admin-blog-pagination">

                    {{ $posts->links() }}

                </div>


            @else

                <div class="ml-admin-blog-empty">

                    <div>
                        <i class="bi bi-journal-text"></i>
                    </div>

                    <h3>
                        No blog posts found
                    </h3>

                    <p>
                        Try changing your filters or create your first blog post.
                    </p>

                    <a href="{{ route('admin.blog.create') }}" class="ml-admin-blog-primary">
                        <i class="bi bi-plus-lg"></i>
                        Add New Post
                    </a>

                </div>

            @endif

        </div>

    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-blog.css') }}">
@endpush