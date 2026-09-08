<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogGalleryController extends Controller
{
    /**
     * Blog Gallery
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Blogs having featured image
        |--------------------------------------------------------------------------
        */

        $blogs = BlogPost::query()
            ->whereNotNull('featured_image')
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | All Blog Posts
        | Used inside Upload Image modal
        |--------------------------------------------------------------------------
        */

        $allBlogs = BlogPost::query()
            ->orderBy('title')
            ->get([
                'id',
                'title',
                'featured_image',
            ]);


        return view(
            'admin.blog-gallery.index',
            compact(
                'blogs',
                'allBlogs'
            )
        );
    }


    /**
     * Upload / Add Blog Featured Image
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'blog_id' => [
                'required',
                'integer',
                'exists:blog_posts,id',
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        $blog = BlogPost::findOrFail(
            $validated['blog_id']
        );


        /*
        |--------------------------------------------------------------------------
        | Store New Image First
        |--------------------------------------------------------------------------
        */

        $file = $request->file('image');

        $newPath = $file->store(
            'blogs/featured',
            'public'
        );


        /*
        |--------------------------------------------------------------------------
        | Keep Old Path
        |--------------------------------------------------------------------------
        */

        $oldPath = $blog->featured_image;


        /*
        |--------------------------------------------------------------------------
        | Update Blog
        |--------------------------------------------------------------------------
        */

        $blog->update([
            'featured_image' => $newPath,

            'featured_image_name' => pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Remove Old Image
        |--------------------------------------------------------------------------
        */

        if (
            filled($oldPath) &&
            $oldPath !== $newPath &&
            Storage::disk('public')->exists($oldPath)
        ) {
            Storage::disk('public')->delete(
                $oldPath
            );
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
        $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Store New Image
        |--------------------------------------------------------------------------
        */

        $file = $request->file('image');

        $newPath = $file->store(
            'blogs/featured',
            'public'
        );


        /*
        |--------------------------------------------------------------------------
        | Existing Image
        |--------------------------------------------------------------------------
        */

        $oldPath = $blog->featured_image;


        /*
        |--------------------------------------------------------------------------
        | Update Database
        |--------------------------------------------------------------------------
        */

        $blog->update([
            'featured_image' => $newPath,

            'featured_image_name' => pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Delete Old File
        |--------------------------------------------------------------------------
        */

        if (
            filled($oldPath) &&
            $oldPath !== $newPath &&
            Storage::disk('public')->exists($oldPath)
        ) {
            Storage::disk('public')->delete(
                $oldPath
            );
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
        /*
        |--------------------------------------------------------------------------
        | Delete Physical File
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Clear Database Fields
        |--------------------------------------------------------------------------
        */

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