<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('posts')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.blog.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate Slug Automatically
        |--------------------------------------------------------------------------
        */

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['slug'] ?: $validated['name']
        );

        $validated['is_active'] = $request->boolean('is_active', true);

        BlogCategory::create($validated);

        return redirect()
            ->route('admin.blog.categories')
            ->with('success', 'Category created successfully.');
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
            ],
            'description' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate Slug Automatically
        |--------------------------------------------------------------------------
        */

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['slug'] ?: $validated['name'],
            $blogCategory->id
        );

        $validated['is_active'] = $request->boolean('is_active');

        $blogCategory->update($validated);

        return redirect()
            ->route('admin.blog.categories')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        if ($blogCategory->posts()->exists()) {
            return redirect()
                ->route('admin.blog.categories')
                ->with(
                    'error',
                    'This category cannot be deleted while blog posts are assigned to it.'
                );
        }

        $blogCategory->delete();

        return redirect()
            ->route('admin.blog.categories')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Generate a unique slug.
     *
     * Examples:
     * Wellness
     * wellness
     *
     * If already exists:
     * wellness-2
     * wellness-3
     */
    private function generateUniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $slug = Str::slug($value);

        /*
        |--------------------------------------------------------------------------
        | Fallback if name/slug contains no usable characters
        |--------------------------------------------------------------------------
        */

        if ($slug === '') {
            $slug = 'category';
        }

        $originalSlug = $slug;
        $counter = 2;

        while (
            BlogCategory::where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}