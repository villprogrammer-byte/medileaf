<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Show all products.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('sku', 'LIKE', "%{$search}%")
                    ->orWhere('brand', 'LIKE', "%{$search}%")
                    ->orWhere('category', 'LIKE', "%{$search}%")
                    ->orWhere('product_type', 'LIKE', "%{$search}%");

            });
        }

        $products = $query->latest()->paginate(10);

        $products->appends([
            'search' => $request->search
        ]);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show add product form.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Save a new product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Basic information
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'sku' => ['nullable', 'string', 'max:100', 'unique:products,sku'],
            'category' => ['nullable', 'string', 'max:150'],
            'brand' => ['nullable', 'string', 'max:150'],
            'product_type' => ['nullable', 'string', 'max:100'],
            'reference_number' => ['nullable', 'string', 'max:255'],

            // Colours
            'colors' => ['nullable', 'array'],
            'colors.*' => ['nullable', 'string', 'max:100'],
            'custom_colour' => ['nullable', 'string', 'max:100'],

            // Pricing
            'regular_price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],

            // Descriptions
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],

            // Inventory
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'low_stock_alert' => ['nullable', 'integer', 'min:0'],
            'stock_status' => [
                'required',
                'in:in_stock,out_of_stock,low_stock',
            ],

            // Images
            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            // Shipping
            'weight' => ['nullable', 'numeric', 'min:0'],
            'length' => ['nullable', 'numeric', 'min:0'],
            'width' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],

            // SEO
            'seo_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'image_alt' => ['nullable', 'string', 'max:255'],

            // Product options
            'status' => ['required', 'in:published,draft,hidden'],
        ]);

        // Generate slug automatically when empty.
        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateUniqueSlug($validated['name']);
        }

        // Merge custom colour with selected colours.
        $colors = $validated['colors'] ?? [];

        if (!empty($validated['custom_colour'])) {
            $colors[] = trim($validated['custom_colour']);
        }

        $validated['colors'] = array_values(
            array_unique(array_filter($colors))
        );

        unset($validated['custom_colour']);

        // Featured image upload.
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('products/featured', 'public');
        }

        // Product gallery upload.
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];

            foreach ($request->file('gallery_images') as $image) {
                $galleryImages[] = $image->store(
                    'products/gallery',
                    'public'
                );
            }

            $validated['gallery_images'] = $galleryImages;
        }

        // Checkbox values.
        $validated['featured'] = $request->boolean('featured');

        $validated['prescription_required'] = $request->boolean(
            'prescription_required'
        );

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product added successfully.');
    }

    /**
     * Show one product.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show product edit form.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update a product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            // Basic information
            'name' => ['required', 'string', 'max:255'],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:products,slug,' . $product->id,
            ],

            'sku' => [
                'nullable',
                'string',
                'max:100',
                'unique:products,sku,' . $product->id,
            ],

            'category' => ['nullable', 'string', 'max:150'],
            'brand' => ['nullable', 'string', 'max:150'],
            'product_type' => ['nullable', 'string', 'max:100'],
            'reference_number' => ['nullable', 'string', 'max:255'],

            // Colours
            'colors' => ['nullable', 'array'],
            'colors.*' => ['nullable', 'string', 'max:100'],
            'custom_colour' => ['nullable', 'string', 'max:100'],

            // Pricing
            'regular_price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],

            // Descriptions
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],

            // Inventory
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'low_stock_alert' => ['nullable', 'integer', 'min:0'],

            'stock_status' => [
                'required',
                'in:in_stock,out_of_stock,low_stock',
            ],

            // Images
            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'gallery_images' => ['nullable', 'array'],

            'gallery_images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            // Shipping
            'weight' => ['nullable', 'numeric', 'min:0'],
            'length' => ['nullable', 'numeric', 'min:0'],
            'width' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],

            // SEO
            'seo_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'image_alt' => ['nullable', 'string', 'max:255'],

            // Product options
            'status' => ['required', 'in:published,draft,hidden'],
        ]);

        // Generate slug if empty.
        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateUniqueSlugForUpdate(
                $validated['name'],
                $product->id
            );
        }

        // Merge selected and custom colours.
        $colors = $validated['colors'] ?? [];

        if (!empty($validated['custom_colour'])) {
            $colors[] = trim($validated['custom_colour']);
        }

        $validated['colors'] = array_values(
            array_unique(array_filter($colors))
        );

        unset($validated['custom_colour']);

        // Replace featured image when a new image is uploaded.
        if ($request->hasFile('featured_image')) {
            if ($product->featured_image) {
                Storage::disk('public')->delete(
                    $product->featured_image
                );
            }

            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('products/featured', 'public');
        }

        // Replace gallery when new gallery images are uploaded.
        if ($request->hasFile('gallery_images')) {
            foreach ($product->gallery_images ?? [] as $galleryImage) {
                Storage::disk('public')->delete($galleryImage);
            }

            $galleryImages = [];

            foreach ($request->file('gallery_images') as $image) {
                $galleryImages[] = $image->store(
                    'products/gallery',
                    'public'
                );
            }

            $validated['gallery_images'] = $galleryImages;
        }

        // Checkbox values.
        $validated['featured'] = $request->boolean('featured');

        $validated['prescription_required'] = $request->boolean(
            'prescription_required'
        );

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product)
    {
        if (!empty($product->featured_image)) {
            $featuredImage = trim((string) $product->featured_image);

            if (
                $featuredImage !== '' &&
                Storage::disk('public')->exists($featuredImage)
            ) {
                Storage::disk('public')->delete($featuredImage);
            }
        }

        $galleryImages = $product->gallery_images;

        if (is_string($galleryImages)) {
            $galleryImages = json_decode($galleryImages, true) ?? [];
        }

        foreach ($galleryImages ?? [] as $galleryImage) {
            $galleryImage = trim((string) $galleryImage);

            if (
                $galleryImage !== '' &&
                Storage::disk('public')->exists($galleryImage)
            ) {
                Storage::disk('public')->delete($galleryImage);
            }
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Generate a unique slug while creating.
     */
    private function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Generate a unique slug while updating.
     */
    private function generateUniqueSlugForUpdate(
        string $name,
        int $productId
    ): string {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Product::where('slug', $slug)
                ->where('id', '!=', $productId)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}