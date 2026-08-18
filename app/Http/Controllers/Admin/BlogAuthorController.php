<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogAuthor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BlogAuthorController extends Controller
{
    public function index()
    {
        $authors = BlogAuthor::withCount([
            'authoredPosts',
            'reviewedPosts',
        ])
            ->orderBy('name')
            ->paginate(20);

        return view('admin.blog.authors', compact('authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_authors,slug'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'bio' => ['nullable', 'string'],
            'credentials' => ['nullable', 'string'],
            'profile_url' => ['nullable', 'url', 'max:255'],
            'role' => ['required', Rule::in(['author', 'reviewer', 'both'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('blog/authors', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        BlogAuthor::create($validated);

        return redirect()->route('admin.blog.authors')
            ->with('success', 'Author / reviewer created successfully.');
    }

    public function update(Request $request, BlogAuthor $blogAuthor)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blog_authors', 'slug')->ignore($blogAuthor->id),
            ],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'bio' => ['nullable', 'string'],
            'credentials' => ['nullable', 'string'],
            'profile_url' => ['nullable', 'url', 'max:255'],
            'role' => ['required', Rule::in(['author', 'reviewer', 'both'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('photo')) {
            if ($blogAuthor->photo) {
                Storage::disk('public')->delete($blogAuthor->photo);
            }

            $validated['photo'] = $request->file('photo')->store('blog/authors', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $blogAuthor->update($validated);

        return redirect()->route('admin.blog.authors')
            ->with('success', 'Author / reviewer updated successfully.');
    }

    public function destroy(BlogAuthor $blogAuthor)
    {
        if ($blogAuthor->authoredPosts()->exists() || $blogAuthor->reviewedPosts()->exists()) {
            return redirect()->route('admin.blog.authors')
                ->with('error', 'This author / reviewer cannot be deleted while assigned to blog posts.');
        }

        if ($blogAuthor->photo) {
            Storage::disk('public')->delete($blogAuthor->photo);
        }

        $blogAuthor->delete();

        return redirect()->route('admin.blog.authors')
            ->with('success', 'Author / reviewer deleted successfully.');
    }
}
