<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogTagController extends Controller
{
    public function index()
    {
        $tags = BlogTag::withCount('posts')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.blog.tags', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate Unique Slug Automatically
        |--------------------------------------------------------------------------
        */

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['slug'] ?: $validated['name']
        );

        $validated['is_active'] = $request->boolean('is_active', true);

        BlogTag::create($validated);

        return redirect()
            ->route('admin.blog.tags')
            ->with('success', 'Tag created successfully.');
    }

    public function update(Request $request, BlogTag $blogTag)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
            ],
            'is_active' => ['nullable', 'boolean'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate Unique Slug Automatically
        |--------------------------------------------------------------------------
        */

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['slug'] ?: $validated['name'],
            $blogTag->id
        );

        $validated['is_active'] = $request->boolean('is_active');

        $blogTag->update($validated);

        return redirect()
            ->route('admin.blog.tags')
            ->with('success', 'Tag updated successfully.');
    }

    public function destroy(BlogTag $blogTag)
    {
        if ($blogTag->posts()->exists()) {
            return redirect()
                ->route('admin.blog.tags')
                ->with(
                    'error',
                    'This tag cannot be deleted while blog posts are using it.'
                );
        }

        $blogTag->delete();

        return redirect()
            ->route('admin.blog.tags')
            ->with('success', 'Tag deleted successfully.');
    }

    /**
     * Generate a unique slug.
     *
     * Examples:
     *
     * Wellness
     * → wellness
     *
     * If wellness already exists:
     * → wellness-2
     *
     * If wellness-2 also exists:
     * → wellness-3
     */
    private function generateUniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $slug = Str::slug($value);

        /*
        |--------------------------------------------------------------------------
        | Fallback
        |--------------------------------------------------------------------------
        */

        if ($slug === '') {
            $slug = 'tag';
        }

        $originalSlug = $slug;
        $counter = 2;

        while (
            BlogTag::where('slug', $slug)
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