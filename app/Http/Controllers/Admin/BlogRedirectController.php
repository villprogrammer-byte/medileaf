<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogRedirect;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogRedirectController extends Controller
{
    public function index()
    {
        $redirects = BlogRedirect::latest()->paginate(20);

        return view('admin.blog.redirects', compact('redirects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'old_path' => ['required', 'string', 'max:255', 'unique:blog_redirects,old_path'],
            'new_path' => ['required', 'string', 'max:255'],
            'status_code' => ['required', Rule::in([301, 302])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        BlogRedirect::create($validated);

        return redirect()->route('admin.blog.redirects')
            ->with('success', 'Redirect created successfully.');
    }

    public function update(Request $request, BlogRedirect $blogRedirect)
    {
        $validated = $request->validate([
            'old_path' => [
                'required',
                'string',
                'max:255',
                Rule::unique('blog_redirects', 'old_path')->ignore($blogRedirect->id),
            ],
            'new_path' => ['required', 'string', 'max:255'],
            'status_code' => ['required', Rule::in([301, 302])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $blogRedirect->update($validated);

        return redirect()->route('admin.blog.redirects')
            ->with('success', 'Redirect updated successfully.');
    }

    public function destroy(BlogRedirect $blogRedirect)
    {
        $blogRedirect->delete();

        return redirect()->route('admin.blog.redirects')
            ->with('success', 'Redirect deleted successfully.');
    }
}
