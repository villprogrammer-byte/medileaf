<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogAuthor;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Blog Admin Index
     */
    public function index(Request $request)
    {
        $query = BlogPost::with([
            'category',
            'author',
            'reviewer',
            'tags',
        ]);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('featured')) {
            $query->where(
                'is_featured',
                $request->featured === 'yes'
            );
        }

        $posts = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = BlogCategory::orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.blog.index', compact(
            'posts',
            'categories'
        ));
    }

    /**
     * Create Blog Post
     */
    public function create()
    {
        $categories = BlogCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $authors = BlogAuthor::where('is_active', true)
            ->orderBy('name')
            ->get();

        $tags = BlogTag::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.blog.create', compact(
            'categories',
            'authors',
            'tags'
        ));
    }

    /**
     * Store Blog Post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_posts,slug'],
            'category_id' => ['nullable', 'exists:blog_categories,id'],
            'author_id' => ['nullable', 'exists:blog_authors,id'],
            'reviewer_id' => ['nullable', 'exists:blog_authors,id'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'string', 'max:255'],
            'featured_image_alt' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published'],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'reading_time' => ['nullable', 'integer', 'min:1'],
            'last_reviewed_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'robots' => ['nullable', 'string', 'max:255'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'schema_type' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:blog_tags,id'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug(
                $validated['title']
            );
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $post = BlogPost::create($validated);

        $post->tags()->sync($tags);

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Blog post created successfully.');
    }

    /**
     * Public Blog Listing
     */
    public function publicIndex(Request $request)
    {
        $categories = BlogCategory::where('is_active', true)
            ->withCount([
                'posts' => function ($query) {
                    $query->published();
                }
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $featuredPost = BlogPost::published()
            ->with(['category', 'author'])
            ->where('is_featured', true)
            ->latest('published_at')
            ->first();

        if (!$featuredPost) {
            $featuredPost = BlogPost::published()
                ->with(['category', 'author'])
                ->latest('published_at')
                ->first();
        }

        $postsQuery = BlogPost::published()
            ->with(['category', 'author'])
            ->latest('published_at');

        if ($featuredPost) {
            $postsQuery->where('id', '!=', $featuredPost->id);
        }

        $posts = $postsQuery
            ->paginate(9)
            ->withQueryString();

        $popularPosts = BlogPost::published()
            ->with(['category', 'author'])
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('pages.blog', compact(
            'categories',
            'featuredPost',
            'posts',
            'popularPosts'
        ));
    }

    /**
     * Admin Blog Preview
     */
    public function show(BlogPost $blogPost)
    {
        $blogPost->load([
            'category',
            'author',
            'reviewer',
            'tags',
        ]);

        return view(
            'admin.blog.show',
            compact('blogPost')
        );
    }

    /**
     * Public Blog Article
     *
     * This method is intentionally separate from the admin show()
     * method because the public route uses a blog slug.
     */
    public function publicShow(string $slug)
    {
        $blogPost = BlogPost::published()
            ->with([
                'category',
                'author',
                'reviewer',
                'tags',
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPosts = BlogPost::published()
            ->with([
                'category',
                'author',
            ])
            ->where('id', '!=', $blogPost->id)
            ->when(
                $blogPost->category_id,
                function ($query) use ($blogPost) {
                    $query->where(
                        'category_id',
                        $blogPost->category_id
                    );
                }
            )
            ->latest('published_at')
            ->take(3)
            ->get();

        $popularPosts = BlogPost::published()
            ->with([
                'category',
                'author',
            ])
            ->where('id', '!=', $blogPost->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        /*
        | The existing public Blade uses $post.
        | Keep both names available so the template remains compatible.
        */

        $post = $blogPost;

        return view(
            'pages.blog-view',
            compact(
                'post',
                'blogPost',
                'relatedPosts',
                'popularPosts'
            )
        );
    }

    /**
     * Edit Blog Post
     */
    public function edit(BlogPost $blogPost)
    {
        $categories = BlogCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $authors = BlogAuthor::where('is_active', true)
            ->orderBy('name')
            ->get();

        $tags = BlogTag::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.blog.edit', compact(
            'blogPost',
            'categories',
            'authors',
            'tags'
        ));
    }

    /**
     * Update Blog Post
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique(
                    'blog_posts',
                    'slug'
                )->ignore($blogPost->id),
            ],
            'category_id' => ['nullable', 'exists:blog_categories,id'],
            'author_id' => ['nullable', 'exists:blog_authors,id'],
            'reviewer_id' => ['nullable', 'exists:blog_authors,id'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'string', 'max:255'],
            'featured_image_alt' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published'],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'reading_time' => ['nullable', 'integer', 'min:1'],
            'last_reviewed_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'robots' => ['nullable', 'string', 'max:255'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'schema_type' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:blog_tags,id'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug(
                $validated['title']
            );
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $blogPost->update($validated);

        $blogPost->tags()->sync($tags);

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Blog post updated successfully.');
    }

    /**
     * Delete Blog Post
     */
    public function destroy(BlogPost $blogPost)
    {
        $blogPost->tags()->detach();

        $blogPost->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Blog post deleted successfully.');
    }
}