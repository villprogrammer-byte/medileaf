@php($post = $post ?? null)

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

                <div class="mb-4">
                    <label class="ml-admin-label">
                        Title <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $post?->title) }}"
                        class="form-control ml-admin-input @error('title') is-invalid @enderror"
                        placeholder="Enter blog post title"
                        required
                    >

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="ml-admin-label">
                        Slug <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="slug"
                        value="{{ old('slug', $post?->slug) }}"
                        class="form-control ml-admin-input @error('slug') is-invalid @enderror"
                        placeholder="your-blog-post-slug"
                        required
                    >

                    <div class="ml-admin-blog-help">
                        Use a short, descriptive, lowercase URL slug.
                    </div>

                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="ml-admin-label">Excerpt</label>

                    <textarea name="excerpt" rows="4" class="form-control ml-admin-input ml-admin-blog-textarea @error('excerpt') is-invalid @enderror" placeholder="Write a short summary of this article...">@php($textareaValue = old('excerpt', $post?->excerpt))@if(filled(trim((string) $textareaValue))){{ $textareaValue }}@endif</textarea>

                    @error('excerpt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="ml-admin-label">Full Description</label>

                    <textarea name="content" id="blogContentEditor" rows="12" class="form-control ml-admin-input ml-admin-blog-editor ml-admin-blog-textarea @error('content') is-invalid @enderror" placeholder="Write the full article content...">@php($textareaValue = old('content', $post?->content))@if(filled(trim((string) $textareaValue))){{ $textareaValue }}@endif</textarea>

                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>


        {{-- SEO --}}
        <div class="ml-admin-card ml-admin-blog-form-card">

            <div class="ml-admin-card-head">
                <h4>
                    <i class="bi bi-search"></i>
                    SEO Settings
                </h4>
            </div>

            <div class="ml-admin-blog-form-body">

                <div class="mb-4">
                    <label class="ml-admin-label">Meta Title</label>

                    <input
                        type="text"
                        name="meta_title"
                        value="{{ old('meta_title', $post?->meta_title) }}"
                        class="form-control ml-admin-input"
                        placeholder="SEO title"
                    >
                </div>

                <div class="mb-4">
                    <label class="ml-admin-label">Meta Description</label>

                    <textarea name="meta_description" rows="4" class="form-control ml-admin-input ml-admin-blog-textarea" placeholder="Write a concise search engine description...">@php($textareaValue = old('meta_description', $post?->meta_description))@if(filled(trim((string) $textareaValue))){{ $textareaValue }}@endif</textarea>
                </div>

                <div class="mb-4">
                    <label class="ml-admin-label">Canonical URL</label>

                    <input
                        type="url"
                        name="canonical_url"
                        value="{{ old('canonical_url', $post?->canonical_url) }}"
                        class="form-control ml-admin-input"
                        placeholder="https://medileaf.com.au/blog/..."
                    >
                </div>

                <div class="mb-4">
                    <label class="ml-admin-label">Robots</label>

                    <input
                        type="text"
                        name="robots"
                        value="{{ old('robots', $post?->robots ?: 'index,follow') }}"
                        class="form-control ml-admin-input"
                        placeholder="index,follow"
                    >
                </div>

                <div class="mb-4">
                    <label class="ml-admin-label">OG Title</label>

                    <input
                        type="text"
                        name="og_title"
                        value="{{ old('og_title', $post?->og_title) }}"
                        class="form-control ml-admin-input"
                        placeholder="Social sharing title"
                    >
                </div>

                <div class="mb-4">
                    <label class="ml-admin-label">OG Description</label>

                    <textarea name="og_description" rows="3" class="form-control ml-admin-input ml-admin-blog-textarea ml-admin-blog-textarea-rows-3" placeholder="Social sharing description...">@php($textareaValue = old('og_description', $post?->og_description))@if(filled(trim((string) $textareaValue))){{ $textareaValue }}@endif</textarea>
                </div>

                <div>
                    <label class="ml-admin-label">Schema Type</label>

                    <select
                        name="schema_type"
                        class="form-select ml-admin-input"
                    >
                        <option
                            value="Article"
                            @selected(old('schema_type', $post?->schema_type ?: 'Article') === 'Article')
                        >
                            Article
                        </option>

                        <option
                            value="BlogPosting"
                            @selected(old('schema_type', $post?->schema_type) === 'BlogPosting')
                        >
                            BlogPosting
                        </option>
                    </select>
                </div>

            </div>
        </div>

    </div>


    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}
    <aside class="ml-admin-blog-form-side">

        {{-- Publishing --}}
        <div class="ml-admin-card ml-admin-blog-form-card">

            <div class="ml-admin-card-head">
                <h4>
                    <i class="bi bi-send"></i>
                    Publishing
                </h4>
            </div>

            <div class="ml-admin-blog-form-body">

                <div class="mb-4">
                    <label class="ml-admin-label">
                        Status <span class="text-danger">*</span>
                    </label>

                    <select
                        name="status"
                        class="form-select ml-admin-input"
                        required
                    >
                        @foreach(['draft', 'published', 'scheduled'] as $status)
                            <option
                                value="{{ $status }}"
                                @selected(old('status', $post?->status ?: 'draft') === $status)
                            >
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="ml-admin-label">Category</label>

                    <select
                        name="category_id"
                        class="form-select ml-admin-input"
                    >
                        <option value="">Select category</option>

                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id', $post?->category_id) == $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="ml-admin-label">Author</label>

                    <select
                        name="author_id"
                        class="form-select ml-admin-input"
                    >
                        <option value="">Select author</option>

                        @foreach($authors as $author)
                            <option
                                value="{{ $author->id }}"
                                @selected(old('author_id', $post?->author_id) == $author->id)
                            >
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="ml-admin-label">Reviewer</label>

                    <select
                        name="reviewer_id"
                        class="form-select ml-admin-input"
                    >
                        <option value="">Select reviewer</option>

                        @foreach($authors as $author)
                            <option
                                value="{{ $author->id }}"
                                @selected(old('reviewer_id', $post?->reviewer_id) == $author->id)
                            >
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="ml-admin-label">Reading Time</label>

                    <div class="input-group">
                        <input
                            type="number"
                            min="1"
                            name="reading_time"
                            value="{{ old('reading_time', $post?->reading_time ?: 5) }}"
                            class="form-control ml-admin-input"
                        >

                        <span class="input-group-text ml-admin-blog-input-addon">
                            min
                        </span>
                    </div>
                </div>

                <div>
                    <label class="ml-admin-label">Published At</label>

                    <input
                        type="datetime-local"
                        name="published_at"
                        value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i')) }}"
                        class="form-control ml-admin-input"
                    >
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

                <div class="mb-4">
                    <label class="ml-admin-label">Image Path</label>

                    <input
                        type="text"
                        name="featured_image"
                        value="{{ old('featured_image', $post?->featured_image) }}"
                        class="form-control ml-admin-input"
                        placeholder="img/blog/example.webp"
                    >
                </div>

                <div>
                    <label class="ml-admin-label">Image Alt Text</label>

                    <input
                        type="text"
                        name="featured_image_alt"
                        value="{{ old('featured_image_alt', $post?->featured_image_alt) }}"
                        class="form-control ml-admin-input"
                        placeholder="Describe the image"
                    >
                </div>

            </div>
        </div>


        {{-- Publish Options --}}
        <div class="ml-admin-card ml-admin-blog-form-card">

            <div class="ml-admin-blog-form-body">

                <label class="ml-admin-blog-featured-check">
                    <input
                        type="checkbox"
                        name="is_featured"
                        value="1"
                        @checked(old('is_featured', $post?->is_featured))
                    >

                    <span>Feature this post</span>
                </label>


                <button
                    type="submit"
                    class="ml-admin-blog-submit-btn"
                >
                    <i class="bi bi-check2-circle"></i>

                    {{ $post ? 'Update Post' : 'Create Post' }}
                </button>

            </div>
        </div>

    </aside>

</div>