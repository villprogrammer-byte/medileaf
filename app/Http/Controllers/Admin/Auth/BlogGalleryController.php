<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogGalleryController extends Controller
{
    public function index()
    {
        $blogs = BlogPost::query()
            ->whereNotNull('featured_image')
            ->latest()
            ->get();

        $allBlogs = BlogPost::query()
            ->orderBy('title')
            ->get([
                'id',
                'title',
                'featured_image',
            ]);

        return view(
            'admin.blog-gallery.index',
            compact('blogs', 'allBlogs')
        );
    }


    /**
     * Upload Blog Featured Image
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'blog_id' => [
                    'required',
                    'integer',
                    'exists:blog_posts,id',
                ],

                'image' => [
                    'required',
                    'file',
                    'mimes:webp',
                    'mimetypes:image/webp',
                    'max:500',
                ],
            ],
            [
                'blog_id.required' =>
                    'Please select a blog post.',

                'blog_id.exists' =>
                    'Selected blog post is invalid.',

                'image.required' =>
                    'Please select an image.',

                'image.mimes' =>
                    'Only WebP images are allowed.',

                'image.mimetypes' =>
                    'Only WebP images are allowed.',

                'image.max' =>
                    'Image size must not exceed 500 KB.',
            ]
        );


        $blog = BlogPost::findOrFail(
            $validated['blog_id']
        );


        $file = $request->file('image');


        /**
         * Store new image first
         */
        $newPath = $file->store(
            'blogs/featured',
            'public'
        );


        /**
         * Existing image path
         */
        $oldPath = $blog->featured_image;


        /**
         * Update database
         */
        $blog->update([
            'featured_image' => $newPath,

            'featured_image_name' => pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ),
        ]);


        /**
         * Delete previous image
         */
        if (
            filled($oldPath) &&
            $oldPath !== $newPath &&
            Storage::disk('public')->exists($oldPath)
        ) {
            Storage::disk('public')->delete($oldPath);
        }


        return back()->with(
            'success',
            'Blog image uploaded successfully.'
        );
    }


    /**
     * Update Image Name & ALT Text
     */
    public function updateFeatured(
        Request $request,
        BlogPost $blog
    ) {
        $validated = $request->validate([
            'featured_image_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'featured_image_alt' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);


        $blog->update([
            'featured_image_name' =>
                $validated['featured_image_name'] ?? null,

            'featured_image_alt' =>
                $validated['featured_image_alt'] ?? null,
        ]);


        return back()->with(
            'success',
            'Blog image details updated successfully.'
        );
    }


    /**
     * Replace Featured Image
     */
    public function replaceFeatured(
        Request $request,
        BlogPost $blog
    ) {
        $request->validate(
            [
                'image' => [
                    'required',
                    'file',
                    'mimes:webp',
                    'mimetypes:image/webp',
                    'max:500',
                ],
            ],
            [
                'image.required' =>
                    'Please select an image.',

                'image.mimes' =>
                    'Only WebP images are allowed.',

                'image.mimetypes' =>
                    'Only WebP images are allowed.',

                'image.max' =>
                    'Image size must not exceed 500 KB.',
            ]
        );


        $file = $request->file('image');


        /**
         * Store new image
         */
        $newPath = $file->store(
            'blogs/featured',
            'public'
        );


        /**
         * Existing image
         */
        $oldPath = $blog->featured_image;


        /**
         * Update database
         */
        $blog->update([
            'featured_image' => $newPath,

            'featured_image_name' => pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ),
        ]);


        /**
         * Delete old image
         */
        if (
            filled($oldPath) &&
            $oldPath !== $newPath &&
            Storage::disk('public')->exists($oldPath)
        ) {
            Storage::disk('public')->delete($oldPath);
        }


        return back()->with(
            'success',
            'Blog featured image replaced successfully.'
        );
    }


    /**
     * Delete Featured Image
     */
    public function destroyFeatured(BlogPost $blog)
    {
        if (
            filled($blog->featured_image) &&
            Storage::disk('public')->exists(
                $blog->featured_image
            )
        ) {
            Storage::disk('public')->delete(
                $blog->featured_image
            );
        }


        $blog->update([
            'featured_image' => null,
            'featured_image_name' => null,
            'featured_image_alt' => null,
        ]);


        return back()->with(
            'success',
            'Blog featured image deleted successfully.'
        );
    }
}