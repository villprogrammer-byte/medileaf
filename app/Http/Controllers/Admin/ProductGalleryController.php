<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductGalleryController extends Controller
{
    public function index()
    {
        $galleryImages = ProductImage::with('product')
            ->latest()
            ->get();

        $featuredImages = Product::query()
            ->whereNotNull('featured_image')
            ->where('featured_image', '!=', '')
            ->latest()
            ->get();

        $galleryMeta = [];
        $featuredMeta = [];

        foreach ($galleryImages as $image) {
            $galleryMeta[$image->id] = $this->getImageMeta(
                $image->image,
                $image->created_at
            );
        }

        foreach ($featuredImages as $product) {
            $featuredMeta[$product->id] = $this->getImageMeta(
                $product->featured_image
            );
        }

        return view('admin.product-gallery.index', compact(
            'galleryImages',
            'featuredImages',
            'galleryMeta',
            'featuredMeta'
        ));
    }

    public function update(Request $request, ProductImage $productImage)
    {
        $validated = $request->validate([
            'image_name' => ['nullable', 'string', 'max:255'],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ]);

        $productImage->update([
            'image_name' => $validated['image_name'] ?? null,
            'alt_text' => $validated['alt_text'] ?? null,
        ]);

        return back()->with(
            'success',
            'Image details updated successfully.'
        );
    }

    public function replace(Request $request, ProductImage $productImage)
    {
        $request->validate([
            'image' => [
                'required',
                'file',
                'mimes:webp',
                'mimetypes:image/webp',
                'max:5120',
            ],
        ]);

        $oldImage = $productImage->image;

        $newImage = $request->file('image')
            ->store('products/gallery', 'public');

        $productImage->update([
            'image' => $newImage,
        ]);

        if (
            filled($oldImage) &&
            Storage::disk('public')->exists($oldImage)
        ) {
            Storage::disk('public')->delete($oldImage);
        }

        return back()->with(
            'success',
            'Image replaced successfully.'
        );
    }

    public function destroy(ProductImage $productImage)
    {
        $imagePath = $productImage->image;

        $productImage->delete();

        if (
            filled($imagePath) &&
            Storage::disk('public')->exists($imagePath)
        ) {
            Storage::disk('public')->delete($imagePath);
        }

        return back()->with(
            'success',
            'Image deleted successfully.'
        );
    }

    public function updateFeatured(Request $request, Product $product)
    {
        $validated = $request->validate([
            'featured_image_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'image_alt' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $product->update([
            'featured_image_name' =>
                $validated['featured_image_name'] ?? null,

            'image_alt' =>
                $validated['image_alt'] ?? null,
        ]);

        return back()->with(
            'success',
            'Featured image details updated successfully.'
        );
    }

    public function replaceFeatured(
        Request $request,
        Product $product
    ) {
        $request->validate([
            'image' => [
                'required',
                'file',
                'mimes:webp',
                'mimetypes:image/webp',
                'max:5120',
            ],
        ]);

        $oldImage = $product->featured_image;

        $newImage = $request->file('image')
            ->store('products/featured', 'public');

        $product->update([
            'featured_image' => $newImage,
        ]);

        if (
            filled($oldImage) &&
            Storage::disk('public')->exists($oldImage)
        ) {
            Storage::disk('public')->delete($oldImage);
        }

        return back()->with(
            'success',
            'Featured image replaced successfully.'
        );
    }

    public function destroyFeatured(Product $product)
    {
        $imagePath = $product->featured_image;

        $product->update([
            'featured_image' => null,
            'featured_image_name' => null,
            'image_alt' => null,
        ]);

        if (
            filled($imagePath) &&
            Storage::disk('public')->exists($imagePath)
        ) {
            Storage::disk('public')->delete($imagePath);
        }

        return back()->with(
            'success',
            'Featured image deleted successfully.'
        );
    }

    private function getImageMeta(
        ?string $imagePath,
        $createdAt = null
    ): array {
        $meta = [
            'type' => 'WEBP',
            'width' => null,
            'height' => null,
            'dimensions' => 'Unknown',
            'size' => 'Unknown',
            'date' => 'Unknown',
            'filename' => null,
        ];

        if (blank($imagePath)) {
            return $meta;
        }

        $cleanPath = ltrim($imagePath, '/');

        $meta['filename'] = basename($cleanPath);

        $extension = pathinfo(
            $cleanPath,
            PATHINFO_EXTENSION
        );

        if (filled($extension)) {
            $meta['type'] = strtoupper($extension);
        }

        if (!Storage::disk('public')->exists($cleanPath)) {
            if ($createdAt) {
                $meta['date'] = $createdAt->format(
                    'd M Y, h:i A'
                );
            }

            return $meta;
        }

        try {
            $absolutePath = Storage::disk('public')
                ->path($cleanPath);

            if (is_file($absolutePath)) {
                $imageSize = @getimagesize($absolutePath);

                if ($imageSize !== false) {
                    $meta['width'] = $imageSize[0] ?? null;
                    $meta['height'] = $imageSize[1] ?? null;

                    if (
                        $meta['width'] !== null &&
                        $meta['height'] !== null
                    ) {
                        $meta['dimensions'] =
                            $meta['width'] .
                            ' × ' .
                            $meta['height'] .
                            ' px';
                    }
                }
            }

            $bytes = Storage::disk('public')
                ->size($cleanPath);

            $meta['size'] = $this->formatBytes($bytes);

            if ($createdAt) {
                /*
                 * ProductImage has its own created_at,
                 * so this is the actual DB record date.
                 */
                $meta['date'] = $createdAt->format(
                    'd M Y, h:i A'
                );
            } else {
                /*
                 * Featured image does not currently have
                 * its own upload timestamp column.
                 * Storage modified time is therefore used.
                 */
                $lastModified = Storage::disk('public')
                    ->lastModified($cleanPath);

                $meta['date'] = Carbon::createFromTimestamp(
                    $lastModified
                )->format('d M Y, h:i A');
            }
        } catch (\Throwable $e) {
            if ($createdAt) {
                $meta['date'] = $createdAt->format(
                    'd M Y, h:i A'
                );
            }
        }

        return $meta;
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes . ' B';
        }

        if ($bytes < 1048576) {
            return round($bytes / 1024, 1) . ' KB';
        }

        return round($bytes / 1048576, 2) . ' MB';
    }
}