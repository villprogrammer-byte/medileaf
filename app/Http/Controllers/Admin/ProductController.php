<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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
            $search = trim((string) $request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('sku', 'LIKE', "%{$search}%")
                    ->orWhere('brand', 'LIKE', "%{$search}%")
                    ->orWhere('category', 'LIKE', "%{$search}%")
                    ->orWhere('product_type', 'LIKE', "%{$search}%");
            });
        }

        $products = $query
            ->latest()
            ->paginate(10);

        $products->appends([
            'search' => $request->search,
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
        $validated = $request->validate($this->validationRules());

        /*
        |--------------------------------------------------------------------------
        | Generate Slug
        |--------------------------------------------------------------------------
        */

        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateUniqueSlug(
                $validated['name']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Prepare Colours
        |--------------------------------------------------------------------------
        */

        $customColour = $this->cleanColourName(
            $validated['custom_colour'] ?? null
        );

        $colors = $this->prepareColours(
            $validated['colors'] ?? [],
            $customColour
        );

        $validated['colors'] = $colors;

        unset(
            $validated['custom_colour'],
            $validated['color_images'],
            $validated['custom_colour_image'],
            $validated['remove_color_images']
        );

        /*
        |--------------------------------------------------------------------------
        | Featured Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('products/featured', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Gallery Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('gallery_images')) {
            $validated['gallery_images'] = $this->storeGalleryImages(
                $request->file('gallery_images')
            );
        } else {
            $validated['gallery_images'] = [];
        }

        /*
        |--------------------------------------------------------------------------
        | Colour Images
        |--------------------------------------------------------------------------
        */

        $validated['color_images'] = $this->processColourImages(
            request: $request,
            selectedColours: $colors,
            existingImages: [],
            customColour: $customColour
        );

        /*
        |--------------------------------------------------------------------------
        | Checkbox Values
        |--------------------------------------------------------------------------
        */

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
        $validated = $request->validate(
            $this->validationRules($product)
        );

        /*
        |--------------------------------------------------------------------------
        | Generate Slug
        |--------------------------------------------------------------------------
        */

        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateUniqueSlugForUpdate(
                $validated['name'],
                $product->id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Prepare Colours
        |--------------------------------------------------------------------------
        */

        $customColour = $this->cleanColourName(
            $validated['custom_colour'] ?? null
        );

        $colors = $this->prepareColours(
            $validated['colors'] ?? [],
            $customColour
        );

        $validated['colors'] = $colors;

        unset(
            $validated['custom_colour'],
            $validated['color_images'],
            $validated['custom_colour_image'],
            $validated['remove_color_images']
        );

        /*
        |--------------------------------------------------------------------------
        | Replace Featured Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('featured_image')) {
            $this->deletePublicFile($product->featured_image);

            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('products/featured', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Replace Gallery Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('gallery_images')) {
            $this->deleteFileCollection(
                $this->normaliseArray($product->gallery_images)
            );

            $validated['gallery_images'] = $this->storeGalleryImages(
                $request->file('gallery_images')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Colour Images
        |--------------------------------------------------------------------------
        */

        $existingColourImages = $this->normaliseArray(
            $product->color_images
        );

        $validated['color_images'] = $this->processColourImages(
            request: $request,
            selectedColours: $colors,
            existingImages: $existingColourImages,
            customColour: $customColour
        );

        /*
        |--------------------------------------------------------------------------
        | Checkbox Values
        |--------------------------------------------------------------------------
        */

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
        /*
        |--------------------------------------------------------------------------
        | Delete Featured Image
        |--------------------------------------------------------------------------
        */

        $this->deletePublicFile($product->featured_image);

        /*
        |--------------------------------------------------------------------------
        | Delete Gallery Images
        |--------------------------------------------------------------------------
        */

        $this->deleteFileCollection(
            $this->normaliseArray($product->gallery_images)
        );

        /*
        |--------------------------------------------------------------------------
        | Delete Colour Images
        |--------------------------------------------------------------------------
        */

        $this->deleteFileCollection(
            array_values(
                $this->normaliseArray($product->color_images)
            )
        );

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Product validation rules.
     */
    private function validationRules(?Product $product = null): array
    {
        $productId = $product?->id;

        return [
            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:products,slug,' . ($productId ?? 'NULL'),
            ],

            'sku' => [
                'nullable',
                'string',
                'max:100',
                'unique:products,sku,' . ($productId ?? 'NULL'),
            ],

            'category' => [
                'nullable',
                'string',
                'max:150',
            ],

            'brand' => [
                'nullable',
                'string',
                'max:150',
            ],

            'product_type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'reference_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Colours
            |--------------------------------------------------------------------------
            */

            'colors' => [
                'nullable',
                'array',
            ],

            'colors.*' => [
                'nullable',
                'string',
                'max:100',
            ],

            'custom_colour' => [
                'nullable',
                'string',
                'max:100',
            ],

            'color_images' => [
                'nullable',
                'array',
            ],

            'color_images.*' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'custom_colour_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'remove_color_images' => [
                'nullable',
                'array',
            ],

            'remove_color_images.*' => [
                'nullable',
                'string',
                'max:100',
            ],

            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            'regular_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'sale_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'cost_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */

            'short_description' => [
                'nullable',
                'string',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Inventory
            |--------------------------------------------------------------------------
            */

            'stock_quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'low_stock_alert' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'stock_status' => [
                'required',
                'in:in_stock,out_of_stock,low_stock',
            ],

            /*
            |--------------------------------------------------------------------------
            | Main Images
            |--------------------------------------------------------------------------
            */

            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'gallery_images' => [
                'nullable',
                'array',
            ],

            'gallery_images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            /*
            |--------------------------------------------------------------------------
            | Shipping
            |--------------------------------------------------------------------------
            */

            'weight' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'length' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'width' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'height' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            'seo_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
            ],

            'image_alt' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Product Options
            |--------------------------------------------------------------------------
            */

            'status' => [
                'required',
                'in:published,draft,hidden',
            ],
        ];
    }

    /**
     * Combine default and custom colours.
     */
    private function prepareColours(
        array $selectedColours,
        ?string $customColour = null
    ): array {
        $colours = [];

        foreach ($selectedColours as $colour) {
            $cleanColour = $this->cleanColourName($colour);

            if ($cleanColour !== null) {
                $colours[] = $cleanColour;
            }
        }

        if ($customColour !== null) {
            $colours[] = $customColour;
        }

        return array_values(
            array_unique($colours)
        );
    }

    /**
     * Store and update colour-wise images.
     */
    private function processColourImages(
        Request $request,
        array $selectedColours,
        array $existingImages = [],
        ?string $customColour = null
    ): array {
        $colourImages = [];

        /*
        |--------------------------------------------------------------------------
        | Keep Images Only for Currently Selected Colours
        |--------------------------------------------------------------------------
        */

        foreach ($existingImages as $colour => $imagePath) {
            $cleanColour = $this->cleanColourName($colour);

            if (
                $cleanColour !== null &&
                in_array($cleanColour, $selectedColours, true)
            ) {
                $colourImages[$cleanColour] = $imagePath;
            } else {
                $this->deletePublicFile($imagePath);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Remove Specifically Selected Colour Images
        |--------------------------------------------------------------------------
        */

        $removeColourImages = $request->input(
            'remove_color_images',
            []
        );

        foreach ($removeColourImages as $colour) {
            $cleanColour = $this->cleanColourName($colour);

            if (
                $cleanColour !== null &&
                isset($colourImages[$cleanColour])
            ) {
                $this->deletePublicFile(
                    $colourImages[$cleanColour]
                );

                unset($colourImages[$cleanColour]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Default and Existing Colour Images
        |--------------------------------------------------------------------------
        */

        $uploadedColourImages = $request->file(
            'color_images',
            []
        );

        foreach ($uploadedColourImages as $colour => $image) {
            if (!$image instanceof UploadedFile) {
                continue;
            }

            $cleanColour = $this->cleanColourName($colour);

            if (
                $cleanColour === null ||
                !in_array($cleanColour, $selectedColours, true)
            ) {
                continue;
            }

            if (!empty($colourImages[$cleanColour])) {
                $this->deletePublicFile(
                    $colourImages[$cleanColour]
                );
            }

            $colourImages[$cleanColour] = $image->store(
                'products/colors',
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Custom Colour Image
        |--------------------------------------------------------------------------
        */

        if (
            $customColour !== null &&
            $request->hasFile('custom_colour_image')
        ) {
            if (!empty($colourImages[$customColour])) {
                $this->deletePublicFile(
                    $colourImages[$customColour]
                );
            }

            $colourImages[$customColour] = $request
                ->file('custom_colour_image')
                ->store('products/colors', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Preserve Selected Colour Order
        |--------------------------------------------------------------------------
        */

        $orderedImages = [];

        foreach ($selectedColours as $colour) {
            if (!empty($colourImages[$colour])) {
                $orderedImages[$colour] = $colourImages[$colour];
            }
        }

        return $orderedImages;
    }

    /**
     * Store gallery images.
     */
    private function storeGalleryImages(array $images): array
    {
        $galleryImages = [];

        foreach ($images as $image) {
            if (!$image instanceof UploadedFile) {
                continue;
            }

            $galleryImages[] = $image->store(
                'products/gallery',
                'public'
            );
        }

        return $galleryImages;
    }

    /**
     * Delete multiple files.
     */
    private function deleteFileCollection(array $files): void
    {
        foreach ($files as $file) {
            $this->deletePublicFile($file);
        }
    }

    /**
     * Delete one file safely from public storage.
     */
    private function deletePublicFile(
        string|null $filePath
    ): void {
        if (empty($filePath)) {
            return;
        }

        $filePath = trim($filePath);

        if (
            $filePath !== '' &&
            Storage::disk('public')->exists($filePath)
        ) {
            Storage::disk('public')->delete($filePath);
        }
    }

    /**
     * Convert JSON/string data to an array.
     */
    private function normaliseArray(
        array|string|null $value
    ): array {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && trim($value) !== '') {
            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    /**
     * Clean colour name.
     */
    private function cleanColourName(
        mixed $colour
    ): ?string {
        if (!is_string($colour)) {
            return null;
        }

        $colour = trim($colour);

        if ($colour === '') {
            return null;
        }

        return $colour;
    }

    /**
     * Generate a unique slug while creating.
     */
    private function generateUniqueSlug(
        string $name
    ): string {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'product';
        }

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

        if ($baseSlug === '') {
            $baseSlug = 'product';
        }

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