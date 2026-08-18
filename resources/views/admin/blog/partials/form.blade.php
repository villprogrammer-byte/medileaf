@php
    $post = $post ?? null;

    /*
    |--------------------------------------------------------------------------
    | Current Form Values
    |--------------------------------------------------------------------------
    */

    $currentStatus = old(
        'status',
        $post?->status ?: 'draft'
    );

    $currentCategory = old(
        'category_id',
        $post?->category_id
    );

    $selectedCategory = $categories->firstWhere(
        'id',
        $currentCategory
    );

    $currentAuthor = old(
        'author_id',
        $post?->author_id
    );

    $selectedAuthor = $authors->firstWhere(
        'id',
        $currentAuthor
    );

    $currentReviewer = old(
        'reviewer_id',
        $post?->reviewer_id
    );

    $selectedReviewer = $authors->firstWhere(
        'id',
        $currentReviewer
    );

    $currentSchemaType = old(
        'schema_type',
        $post?->schema_type ?: 'Article'
    );
@endphp


<div class="ml-admin-blog-form-grid">

    {{-- =====================================================
    MAIN CONTENT
    ====================================================== --}}

    <div class="ml-admin-blog-form-main">

        {{-- Article Content --}}
        <div class="ml-admin-card ml-admin-blog-form-card">

            <div class="ml-admin-card-head">

                <h4>
                    <i class="bi bi-file-earmark-text"></i>
                    Article Content
                </h4>

            </div>

            <div class="ml-admin-blog-form-body">

                {{-- Title --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Title <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="title" value="{{ old('title', $post?->title) }}"
                        class="form-control ml-admin-input @error('title') is-invalid @enderror"
                        placeholder="Enter blog post title" required>

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Slug --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Slug <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="slug" value="{{ old('slug', $post?->slug) }}"
                        class="form-control ml-admin-input @error('slug') is-invalid @enderror"
                        placeholder="your-blog-post-slug" required>

                    <div class="ml-admin-blog-help">
                        Use a short, descriptive, lowercase URL slug.
                    </div>

                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Excerpt --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Excerpt
                    </label>

                    <textarea name="excerpt" rows="4"
                        class="form-control ml-admin-input ml-admin-blog-textarea @error('excerpt') is-invalid @enderror"
                        placeholder="Write a short summary of this article...">{{ old('excerpt', $post?->excerpt) }}</textarea>

                    @error('excerpt')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div>

                    <label class="ml-admin-label">
                        Full Description
                    </label>

                    <textarea id="description" name="content"
                        class="ml-admin-textarea ml-admin-long-textarea @error('content') is-invalid @enderror"
                        rows="8">{{ old('content', $post?->content ?? '') }}</textarea>

                    @error('content')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>


        {{-- =====================================================
        SEO
        ====================================================== --}}

        <div class="ml-admin-card ml-admin-blog-form-card">

            <div class="ml-admin-card-head">

                <h4>
                    <i class="bi bi-search"></i>
                    SEO Settings
                </h4>

            </div>

            <div class="ml-admin-blog-form-body">

                {{-- Meta Title --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Meta Title
                    </label>

                    <input type="text" name="meta_title" value="{{ old('meta_title', $post?->meta_title) }}"
                        class="form-control ml-admin-input" placeholder="SEO title">

                    @error('meta_title')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Meta Description --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Meta Description
                    </label>

                    <textarea name="meta_description" rows="4"
                        class="form-control ml-admin-input ml-admin-blog-textarea"
                        placeholder="Write a concise search engine description...">{{ old('meta_description', $post?->meta_description) }}</textarea>

                    @error('meta_description')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Canonical URL --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Canonical URL
                    </label>

                    <input type="url" name="canonical_url" value="{{ old('canonical_url', $post?->canonical_url) }}"
                        class="form-control ml-admin-input" placeholder="https://medileaf.com.au/blog/...">

                    @error('canonical_url')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Robots --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Robots
                    </label>

                    <input type="text" name="robots" value="{{ old('robots', $post?->robots ?: 'index,follow') }}"
                        class="form-control ml-admin-input" placeholder="index,follow">

                    @error('robots')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- OG Title --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        OG Title
                    </label>

                    <input type="text" name="og_title" value="{{ old('og_title', $post?->og_title) }}"
                        class="form-control ml-admin-input" placeholder="Social sharing title">

                    @error('og_title')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- OG Description --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        OG Description
                    </label>

                    <textarea name="og_description" rows="3"
                        class="form-control ml-admin-input ml-admin-blog-textarea ml-admin-blog-textarea-rows-3"
                        placeholder="Social sharing description...">{{ old('og_description', $post?->og_description) }}</textarea>

                    @error('og_description')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Schema Type --}}
                <div>

                    <label class="ml-admin-label">
                        Schema Type
                    </label>

                    <div class="ml-custom-select">

                        <button type="button" class="ml-custom-select-btn">

                            <span class="ml-custom-select-value">
                                {{ $currentSchemaType }}
                            </span>

                            <i class="bi bi-chevron-down"></i>

                        </button>


                        <div class="ml-custom-select-menu">

                            <button type="button"
                                class="ml-custom-option {{ $currentSchemaType === 'Article' ? 'selected' : '' }}"
                                data-value="Article">
                                Article
                            </button>

                            <button type="button"
                                class="ml-custom-option {{ $currentSchemaType === 'BlogPosting' ? 'selected' : '' }}"
                                data-value="BlogPosting">
                                BlogPosting
                            </button>

                        </div>


                        <input type="hidden" name="schema_type" value="{{ $currentSchemaType }}">

                    </div>

                    @error('schema_type')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
    SIDEBAR
    ====================================================== --}}

    <aside class="ml-admin-blog-form-side">

        {{-- =====================================================
        Publishing
        ====================================================== --}}

        <div class="ml-admin-card ml-admin-blog-form-card">

            <div class="ml-admin-card-head">

                <h4>
                    <i class="bi bi-send"></i>
                    Publishing
                </h4>

            </div>


            <div class="ml-admin-blog-form-body">

                {{-- Status --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Status <span class="text-danger">*</span>
                    </label>


                    <div class="ml-custom-select">

                        <button type="button" class="ml-custom-select-btn">

                            <span class="ml-custom-select-value">
                                {{ ucfirst($currentStatus) }}
                            </span>

                            <i class="bi bi-chevron-down"></i>

                        </button>


                        <div class="ml-custom-select-menu">

                            <button type="button"
                                class="ml-custom-option {{ $currentStatus === 'draft' ? 'selected' : '' }}"
                                data-value="draft">
                                Draft
                            </button>

                            <button type="button"
                                class="ml-custom-option {{ $currentStatus === 'published' ? 'selected' : '' }}"
                                data-value="published">
                                Published
                            </button>

                        </div>


                        <input type="hidden" name="status" value="{{ $currentStatus }}" required>

                    </div>


                    @error('status')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Category --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Category
                    </label>


                    <div class="ml-custom-select">

                        <button type="button" class="ml-custom-select-btn">

                            <span class="ml-custom-select-value">
                                {{ $selectedCategory?->name ?? 'Select category' }}
                            </span>

                            <i class="bi bi-chevron-down"></i>

                        </button>


                        <div class="ml-custom-select-menu">

                            <button type="button" class="ml-custom-option {{ !$currentCategory ? 'selected' : '' }}"
                                data-value="">
                                Select category
                            </button>


                            @foreach($categories as $category)

                                <button type="button"
                                    class="ml-custom-option {{ (string) $currentCategory === (string) $category->id ? 'selected' : '' }}"
                                    data-value="{{ $category->id }}">
                                    {{ $category->name }}
                                </button>

                            @endforeach

                        </div>


                        <input type="hidden" name="category_id" value="{{ $currentCategory }}">

                    </div>


                    @error('category_id')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Author --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Author
                    </label>


                    <div class="ml-custom-select">

                        <button type="button" class="ml-custom-select-btn">

                            <span class="ml-custom-select-value">
                                {{ $selectedAuthor?->name ?? 'Select author' }}
                            </span>

                            <i class="bi bi-chevron-down"></i>

                        </button>


                        <div class="ml-custom-select-menu">

                            <button type="button" class="ml-custom-option {{ !$currentAuthor ? 'selected' : '' }}"
                                data-value="">
                                Select author
                            </button>


                            @foreach($authors as $author)

                                <button type="button"
                                    class="ml-custom-option {{ (string) $currentAuthor === (string) $author->id ? 'selected' : '' }}"
                                    data-value="{{ $author->id }}">
                                    {{ $author->name }}
                                </button>

                            @endforeach

                        </div>


                        <input type="hidden" name="author_id" value="{{ $currentAuthor }}">

                    </div>


                    @error('author_id')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Reviewer --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Reviewer
                    </label>


                    <div class="ml-custom-select">

                        <button type="button" class="ml-custom-select-btn">

                            <span class="ml-custom-select-value">
                                {{ $selectedReviewer?->name ?? 'Select reviewer' }}
                            </span>

                            <i class="bi bi-chevron-down"></i>

                        </button>


                        <div class="ml-custom-select-menu">

                            <button type="button" class="ml-custom-option {{ !$currentReviewer ? 'selected' : '' }}"
                                data-value="">
                                Select reviewer
                            </button>


                            @foreach($authors as $author)

                                <button type="button"
                                    class="ml-custom-option {{ (string) $currentReviewer === (string) $author->id ? 'selected' : '' }}"
                                    data-value="{{ $author->id }}">
                                    {{ $author->name }}
                                </button>

                            @endforeach

                        </div>


                        <input type="hidden" name="reviewer_id" value="{{ $currentReviewer }}">

                    </div>


                    @error('reviewer_id')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Tags --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Tags
                    </label>


                    <div class="ml-admin-blog-tags-list">

                        @forelse($tags as $tag)

                            <label class="ml-admin-blog-tag-option">

                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(
                                    collect(
                                        old(
                                            'tags',
                                            $post?->tags?->pluck('id')->toArray() ?? []
                                        )
                                    )->contains($tag->id)
                                )>

                                <span>
                                    {{ $tag->name }}
                                </span>

                            </label>

                        @empty

                            <div class="ml-admin-blog-help">
                                No active tags available. Create tags first.
                            </div>

                        @endforelse

                    </div>


                    @error('tags')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                    @error('tags.*')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Reading Time --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Reading Time
                    </label>


                    <div class="input-group">

                        <input type="number" min="1" name="reading_time"
                            value="{{ old('reading_time', $post?->reading_time ?: 5) }}"
                            class="form-control ml-admin-input">

                        <span class="input-group-text ml-admin-blog-input-addon">
                            min
                        </span>

                    </div>


                    @error('reading_time')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Published At --}}
                <div>

                    <label class="ml-admin-label">
                        Published At
                    </label>


                    <input type="datetime-local" name="published_at"
                        value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i')) }}"
                        class="form-control ml-admin-input">


                    @error('published_at')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Featured Image --}}
        <div class="ml-admin-card ml-admin-blog-form-card">

            <div class="ml-admin-card-head">
                <h4>
                    <i class="bi bi-image"></i>
                    Featured Image
                </h4>
            </div>

            <div class="ml-admin-blog-form-body">

                {{-- Image Upload --}}
                <div class="mb-4">

                    <label class="ml-upload-box" id="featuredUpload">

                        <input type="file" name="featured_image" id="featuredImageInput" accept=".jpg,.jpeg,.png,.webp"
                            hidden>

                        <div id="featuredPreview">

                            <i class="bi bi-cloud-arrow-up"></i>

                            <strong>
                                Upload Image
                            </strong>

                            <span>
                                PNG, JPG, WEBP up to 5MB
                            </span>

                        </div>

                    </label>

                    @error('featured_image')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Image Name --}}
                <div class="mb-4">

                    <label class="ml-admin-label">
                        Featured Image ALT Text
                    </label>

                    <input type="text" name="featured_image_name"
                        value="{{ old('featured_image_name', $post?->featured_image ? pathinfo($post->featured_image, PATHINFO_FILENAME) : '') }}"
                        class="form-control ml-admin-input @error('featured_image_name') is-invalid @enderror"
                        placeholder="e.g. natural-remedies-for-common-cold">

                    @error('featured_image_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Image Alt Text --}}
                <div>

                    <label class="ml-admin-label">
                        Image Alt Text
                    </label>

                    <input type="text" name="featured_image_alt"
                        value="{{ old('featured_image_alt', $post?->featured_image_alt) }}"
                        class="form-control ml-admin-input @error('featured_image_alt') is-invalid @enderror"
                        placeholder="Describe the image">

                    @error('featured_image_alt')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Existing Image --}}
                @if($post?->featured_image)

                    <div class="mt-4">

                        <label class="ml-admin-label">
                            Current Image
                        </label>

                        <div class="ml-admin-blog-current-image">

                            <img src="{{ asset('storage/' . $post->featured_image) }}"
                                alt="{{ $post->featured_image_alt ?: $post->title }}">

                        </div>

                    </div>

                @endif
            </div>

        </div>

        {{-- =====================================================
        Publish Options
        ====================================================== --}}

        <div class="ml-admin-card ml-admin-blog-form-card">

            <div class="ml-admin-blog-form-body">

                <label class="ml-admin-blog-featured-check">

                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $post?->is_featured))>

                    <span>
                        Feature this post
                    </span>

                </label>


                <button type="submit" class="ml-admin-blog-submit-btn">

                    <i class="bi bi-check2-circle"></i>

                    {{ $post ? 'Update Post' : 'Create Post' }}

                </button>

            </div>

        </div>

    </aside>

</div>

@push('scripts')

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <script src="{{ asset('js/blog.js') }}"></script>

@endpush