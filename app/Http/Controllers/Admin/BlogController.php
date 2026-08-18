<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogAuthor;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * All Blog Posts
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
        | Latest First
        |--------------------------------------------------------------------------
        */
        $posts = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Filter Data
        |--------------------------------------------------------------------------
        */
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
        // Validation and post creation will be added
        // when the final Add Blog Post form is implemented.

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Blog post created successfully.');
    }

    /**
     * Public Blog Article View
     */
    public function show(BlogPost $blogPost)
    {
        $blogPost->load([
            'category',
            'author',
            'reviewer',
            'tags',
        ]);

        return view('pages.blog-view', compact('blogPost'));
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
        // Validation and update logic will be added
        // when the final Edit Blog Post form is implemented.

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Blog post updated successfully.');
    }

    /**
     * Delete Blog Post
     */
    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Blog post deleted successfully.');
    }
}