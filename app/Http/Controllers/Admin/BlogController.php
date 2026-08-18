<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogAuthor;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    /**
     * Admin Blog Posts
     */
    public function index(Request $request)
    {
        $query = BlogPost::with([
            'category',
            'author',
            'reviewer',
            'tags',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        /*
        |--------------------------------------------------------------------------
        | Featured Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('featured')) {
            $query->where(
                'is_featured',
                $request->featured === 'yes'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Posts
        |--------------------------------------------------------------------------
        */

        $posts = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = BlogCategory::orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view(
            'admin.blog.index',
            compact(
                'posts',
                'categories'
            )
        );
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

        return view(
            'admin.blog.create',
            compact(
                'categories',
                'authors',
                'tags'
            )
        );
    }


    /**
     * Store Blog Post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:blog_posts,slug',
            ],

            'category_id' => [
                'nullable',
                'exists:blog_categories,id',
            ],

            'author_id' => [
                'nullable',
                'exists:blog_authors,id',
            ],

            'reviewer_id' => [
                'nullable',
                'exists:blog_authors,id',
            ],

            'excerpt' => [
                'nullable',
                'string',
            ],

            'content' => [
                'required',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Featured Image Upload
            |--------------------------------------------------------------------------
            */

            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'featured_image_alt' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:draft,published',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],

            'reading_time' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'last_reviewed_at' => [
                'nullable',
                'date',
            ],

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
            ],

            'canonical_url' => [
                'nullable',
                'url',
                'max:255',
            ],

            'robots' => [
                'nullable',
                'string',
                'max:255',
            ],

            'og_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'og_description' => [
                'nullable',
                'string',
            ],

            'og_image' => [
                'nullable',
                'string',
                'max:255',
            ],

            'schema_type' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Tags
            |--------------------------------------------------------------------------
            */

            'tags' => [
                'nullable',
                'array',
            ],

            'tags.*' => [
                'exists:blog_tags,id',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug(
                $validated['title']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Featured
        |--------------------------------------------------------------------------
        */

        $validated['is_featured'] = $request->boolean(
            'is_featured'
        );


        /*
        |--------------------------------------------------------------------------
        | Published Date
        |--------------------------------------------------------------------------
        */

        if (
            $validated['status'] === 'published'
            && empty($validated['published_at'])
        ) {
            $validated['published_at'] = now();
        }


        /*
        |--------------------------------------------------------------------------
        | Featured Image Upload
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('featured_image')) {

            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('blog', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Tags
        |--------------------------------------------------------------------------
        */

        $tags = $validated['tags'] ?? [];

        unset($validated['tags']);


        /*
        |--------------------------------------------------------------------------
        | Create Post
        |--------------------------------------------------------------------------
        */

        $post = BlogPost::create(
            $validated
        );


        /*
        |--------------------------------------------------------------------------
        | Attach Tags
        |--------------------------------------------------------------------------
        */

        $post->tags()->sync($tags);


        return redirect()
            ->route('admin.blog.index')
            ->with(
                'success',
                'Blog post created successfully.'
            );
    }


    /**
     * Admin Blog Post View
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

        return view(
            'admin.blog.edit',
            compact(
                'blogPost',
                'categories',
                'authors',
                'tags'
            )
        );
    }


    /**
     * Update Blog Post
     */
    public function update(
        Request $request,
        BlogPost $blogPost
    ) {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique(
                    'blog_posts',
                    'slug'
                )->ignore($blogPost->id),
            ],

            'category_id' => [
                'nullable',
                'exists:blog_categories,id',
            ],

            'author_id' => [
                'nullable',
                'exists:blog_authors,id',
            ],

            'reviewer_id' => [
                'nullable',
                'exists:blog_authors,id',
            ],

            'excerpt' => [
                'nullable',
                'string',
            ],

            'content' => [
                'required',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Featured Image Upload
            |--------------------------------------------------------------------------
            */

            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'featured_image_alt' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:draft,published',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],

            'reading_time' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'last_reviewed_at' => [
                'nullable',
                'date',
            ],

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
            ],

            'canonical_url' => [
                'nullable',
                'url',
                'max:255',
            ],

            'robots' => [
                'nullable',
                'string',
                'max:255',
            ],

            'og_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'og_description' => [
                'nullable',
                'string',
            ],

            'og_image' => [
                'nullable',
                'string',
                'max:255',
            ],

            'schema_type' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Tags
            |--------------------------------------------------------------------------
            */

            'tags' => [
                'nullable',
                'array',
            ],

            'tags.*' => [
                'exists:blog_tags,id',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug(
                $validated['title']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Featured
        |--------------------------------------------------------------------------
        */

        $validated['is_featured'] = $request->boolean(
            'is_featured'
        );


        /*
        |--------------------------------------------------------------------------
        | Published Date
        |--------------------------------------------------------------------------
        */

        if (
            $validated['status'] === 'published'
            && empty($validated['published_at'])
        ) {
            $validated['published_at'] = now();
        }


        /*
        |--------------------------------------------------------------------------
        | New Featured Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('featured_image')) {

            /*
            | Delete old image first
            */

            if ($blogPost->featured_image) {

                $oldPath = $blogPost->featured_image;

                if (Str::startsWith($oldPath, 'storage/')) {

                    $oldPath = Str::after(
                        $oldPath,
                        'storage/'
                    );
                }

                Storage::disk('public')->delete(
                    $oldPath
                );
            }


            /*
            | Store new image
            */

            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('blog', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Tags
        |--------------------------------------------------------------------------
        */

        $tags = $validated['tags'] ?? [];

        unset($validated['tags']);


        /*
        |--------------------------------------------------------------------------
        | Update Post
        |--------------------------------------------------------------------------
        */

        $blogPost->update(
            $validated
        );


        /*
        |--------------------------------------------------------------------------
        | Sync Tags
        |--------------------------------------------------------------------------
        */

        $blogPost->tags()->sync($tags);


        return redirect()
            ->route('admin.blog.index')
            ->with(
                'success',
                'Blog post updated successfully.'
            );
    }


    /**
     * Delete Blog Post
     */
    public function destroy(BlogPost $blogPost)
    {
        /*
        |--------------------------------------------------------------------------
        | Remove Tags
        |--------------------------------------------------------------------------
        */

        $blogPost->tags()->detach();


        /*
        |--------------------------------------------------------------------------
        | Delete Featured Image
        |--------------------------------------------------------------------------
        */

        if ($blogPost->featured_image) {

            $imagePath = $blogPost->featured_image;

            if (Str::startsWith($imagePath, 'storage/')) {

                $imagePath = Str::after(
                    $imagePath,
                    'storage/'
                );
            }

            Storage::disk('public')->delete(
                $imagePath
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Post
        |--------------------------------------------------------------------------
        */

        $blogPost->delete();


        return redirect()
            ->route('admin.blog.index')
            ->with(
                'success',
                'Blog post deleted successfully.'
            );
    }


    /**
     * Public Blog Article
     *
     * Current web.php uses:
     * /blog/{slug} -> BlogController@show
     *
     * If your current public route points to show(),
     * use this method only if your route/controller setup
     * has been separated accordingly.
     */
    public function publicShow(string $slug)
    {
        $post = BlogPost::published()
            ->with([
                'category',
                'author',
                'reviewer',
                'tags',
            ])
            ->where('slug', $slug)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Related Posts
        |--------------------------------------------------------------------------
        */

        $relatedPosts = BlogPost::published()
            ->with([
                'category',
                'author',
            ])
            ->where(
                'id',
                '!=',
                $post->id
            )
            ->when(
                $post->category_id,
                function ($query) use ($post) {

                    $query->where(
                        'category_id',
                        $post->category_id
                    );
                }
            )
            ->latest('published_at')
            ->take(3)
            ->get();


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
            ->where(
                'id',
                '!=',
                $post->id
            )
            ->latest('published_at')
            ->take(4)
            ->get();


        return view(
            'pages.blog-view',
            compact(
                'post',
                'relatedPosts',
                'popularPosts'
            )
        );
    }
}