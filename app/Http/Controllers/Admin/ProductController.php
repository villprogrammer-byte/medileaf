<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Product List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Product::query()
            ->withCount('variants');

        if ($request->filled('search')) {
            $search = trim((string) $request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('product_type', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%")
                    ->orWhereHas('variants', function ($variantQuery) use ($search) {
                        $variantQuery
                            ->where('sku', 'like', "%{$search}%")
                            ->orWhere('colour_name', 'like', "%{$search}%");
                    });
            });
        }

        $products = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.products.index',
            compact('products')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.products.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->validationRules()
        );

        $variants = $request->input(
            'variants',
            []
        );

        if (!empty($variants)) {
            $this->validateVariantRows($variants);
        }

        $uploadedFiles = [];

        try {
            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | Slug
            |--------------------------------------------------------------------------
            */

            $validated['slug'] = filled($validated['slug'] ?? null)
                ? Str::slug($validated['slug'])
                : $this->generateUniqueSlug(
                    $validated['name']
                );

            /*
            |--------------------------------------------------------------------------
            | Boolean Values
            |--------------------------------------------------------------------------
            */

            $validated['featured'] =
                $request->boolean('featured');

            $validated['prescription_required'] =
                $request->boolean('prescription_required');

            $validated['is_indexable'] =
                $request->boolean('is_indexable');

            /*
            |--------------------------------------------------------------------------
            | Remove non-product fields
            |--------------------------------------------------------------------------
            */

            unset(
                $validated['variants'],
                $validated['gallery_items']
            );

            /*
            |--------------------------------------------------------------------------
            | Featured Image
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('featured_image')) {
                $featuredImage = $this->storeProductImage(
                    $request->file('featured_image'),
                    'products/featured',
                    $validated['name'] . '-featured'
                );

                $validated['featured_image'] = $featuredImage;

                $uploadedFiles[] = $featuredImage;
            }

            /*
            |--------------------------------------------------------------------------
            | OG Image
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('og_image')) {
                $ogImage = $this->storeProductImage(
                    $request->file('og_image'),
                    'products/seo',
                    $validated['name'] . '-social'
                );

                $validated['og_image'] = $ogImage;

                $uploadedFiles[] = $ogImage;
            }

            /*
            |--------------------------------------------------------------------------
            | Legacy Gallery
            |--------------------------------------------------------------------------
            |
            | New gallery uses product_images table.
            | Keep old field empty for compatibility.
            |
            */

            $validated['gallery_images'] = [];

            /*
            |--------------------------------------------------------------------------
            | Create Product
            |--------------------------------------------------------------------------
            */

            $product = Product::create($validated);

            /*
            |--------------------------------------------------------------------------
            | Gallery
            |--------------------------------------------------------------------------
            */

            $this->createGalleryImages(
                product: $product,
                request: $request,
                uploadedFiles: $uploadedFiles
            );

            /*
            |--------------------------------------------------------------------------
            | Variants
            |--------------------------------------------------------------------------
            */

            $this->createVariants(
                product: $product,
                request: $request,
                variants: $variants,
                uploadedFiles: $uploadedFiles
            );

            /*
            |--------------------------------------------------------------------------
            | Stock / Colours Summary
            |--------------------------------------------------------------------------
            */

            $this->syncProductSummary($product);

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with(
                    'success',
                    'Product added successfully.'
                );

        } catch (Throwable $exception) {

            DB::rollBack();

            $this->deleteFileCollection(
                array_unique($uploadedFiles)
            );

            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'product' =>
                        'Product save nahi hua. Please try again.',
                ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(Product $product)
    {
        $product->load([
            'variants',
            'images',
        ]);

        return view(
            'admin.products.show',
            compact('product')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(Product $product)
    {
        $product->load([
            'variants',
            'images',
        ]);

        return view(
            'admin.products.edit',
            compact('product')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Product $product
    ) {
        $validated = $request->validate(
            $this->validationRules($product)
        );

        $variants = $request->input(
            'variants',
            []
        );

        if (!empty($variants)) {
            $this->validateVariantRows(
                $variants,
                $product
            );
        }

        $uploadedFiles = [];
        $filesToDelete = [];

        try {
            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | Slug
            |--------------------------------------------------------------------------
            */

            $requestedSlug = trim(
                (string) ($validated['slug'] ?? '')
            );

            if ($requestedSlug !== '') {
                $validated['slug'] =
                    Str::slug($requestedSlug);
            } else {
                $validated['slug'] =
                    $this->generateUniqueSlugForUpdate(
                        $validated['name'],
                        $product->id
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Boolean Values
            |--------------------------------------------------------------------------
            */

            $validated['featured'] =
                $request->boolean('featured');

            $validated['prescription_required'] =
                $request->boolean('prescription_required');

            $validated['is_indexable'] =
                $request->boolean('is_indexable');

            unset(
                $validated['variants'],
                $validated['gallery_items']
            );

            /*
            |--------------------------------------------------------------------------
            | Featured Image
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('featured_image')) {

                $newImage = $this->storeProductImage(
                    $request->file('featured_image'),
                    'products/featured',
                    $validated['name'] . '-featured'
                );

                $uploadedFiles[] = $newImage;

                if ($product->featured_image) {
                    $filesToDelete[] =
                        $product->featured_image;
                }

                $validated['featured_image'] =
                    $newImage;
            }

            /*
            |--------------------------------------------------------------------------
            | OG Image
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('og_image')) {

                $newOgImage = $this->storeProductImage(
                    $request->file('og_image'),
                    'products/seo',
                    $validated['name'] . '-social'
                );

                $uploadedFiles[] = $newOgImage;

                if ($product->og_image) {
                    $filesToDelete[] =
                        $product->og_image;
                }

                $validated['og_image'] =
                    $newOgImage;
            }

            if (
                $request->boolean('remove_og_image') &&
                !$request->hasFile('og_image')
            ) {
                if ($product->og_image) {
                    $filesToDelete[] =
                        $product->og_image;
                }

                $validated['og_image'] = null;
            }

            /*
            |--------------------------------------------------------------------------
            | Update Product
            |--------------------------------------------------------------------------
            */

            $product->update($validated);

            /*
            |--------------------------------------------------------------------------
            | Gallery
            |--------------------------------------------------------------------------
            */

            $this->syncGalleryImages(
                product: $product,
                request: $request,
                uploadedFiles: $uploadedFiles,
                filesToDelete: $filesToDelete
            );

            /*
            |--------------------------------------------------------------------------
            | Variants
            |--------------------------------------------------------------------------
            */

            $this->syncVariants(
                product: $product,
                request: $request,
                variants: $variants,
                uploadedFiles: $uploadedFiles,
                filesToDelete: $filesToDelete
            );

            $this->syncProductSummary($product);

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | Delete replaced/removed files only after successful DB commit
            |--------------------------------------------------------------------------
            */

            $this->deleteFileCollection(
                array_unique($filesToDelete)
            );

            return redirect()
                ->route('admin.products.index')
                ->with(
                    'success',
                    'Product updated successfully.'
                );

        } catch (Throwable $exception) {

            DB::rollBack();

            /*
            | New uploads should be removed when DB update fails.
            */

            $this->deleteFileCollection(
                array_unique($uploadedFiles)
            );

            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'product' =>
                        'Product update nahi hua. Please try again.',
                ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Product
    |--------------------------------------------------------------------------
    */

    public function destroy(Product $product)
    {
        $product->load([
            'variants',
            'images',
        ]);

        $files = array_filter([
            $product->featured_image,
            $product->og_image,

            ...$this->normaliseArray(
                $product->gallery_images
            ),

            ...$product->images
                ->pluck('image')
                ->filter()
                ->all(),

            ...$product->variants
                ->pluck('image')
                ->filter()
                ->all(),
        ]);

        DB::transaction(function () use ($product) {
            $product->delete();
        });

        $this->deleteFileCollection(
            array_unique($files)
        );

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Product deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    private function validationRules(
        ?Product $product = null
    ): array {
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
                Rule::unique(
                    'products',
                    'slug'
                )->ignore($product?->id),
            ],

            'sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique(
                    'products',
                    'sku'
                )->ignore($product?->id),
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
                'lte:regular_price',
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
                Rule::in([
                    'in_stock',
                    'out_of_stock',
                    'low_stock',
                ]),
            ],


            /*
            |--------------------------------------------------------------------------
            | Featured Image
            |--------------------------------------------------------------------------
            */

            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            /*
            | Existing field retained as Featured Image ALT.
            */

            'image_alt' => [
                'nullable',
                'string',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | New Gallery
            |--------------------------------------------------------------------------
            */

            'gallery_items' => [
                'nullable',
                'array',
            ],

            'gallery_items.*.id' => [
                'nullable',
                'integer',
            ],

            'gallery_items.*.image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'gallery_items.*.image_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'gallery_items.*.alt_text' => [
                'nullable',
                'string',
                'max:255',
            ],

            'gallery_items.*.sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'gallery_items.*.remove' => [
                'nullable',
                'boolean',
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
                'max:500',
            ],

            'canonical_url' => [
                'nullable',
                'url',
                'max:2048',
            ],

            'is_indexable' => [
                'nullable',
                'boolean',
            ],


            /*
            |--------------------------------------------------------------------------
            | Open Graph
            |--------------------------------------------------------------------------
            */

            'og_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'og_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'og_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'remove_og_image' => [
                'nullable',
                'boolean',
            ],


            /*
            |--------------------------------------------------------------------------
            | Product Status
            |--------------------------------------------------------------------------
            */

            'status' => [
                'required',
                Rule::in([
                    'published',
                    'draft',
                    'hidden',
                ]),
            ],


            /*
            |--------------------------------------------------------------------------
            | Variants
            |--------------------------------------------------------------------------
            */

            'variants' => [
                'nullable',
                'array',
            ],

            'variants.*.id' => [
                'nullable',
                'integer',
            ],

            'variants.*.colour_name' => [
                'required',
                'string',
                'max:100',
            ],

            'variants.*.colour_code' => [
                'nullable',
                'string',
                'max:20',
            ],

            'variants.*.sku' => [
                'required',
                'string',
                'max:100',
            ],

            'variants.*.quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'variants.*.image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'variants.*.image_alt' => [
                'nullable',
                'string',
                'max:255',
            ],

            'variants.*.price_adjustment' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'variants.*.status' => [
                'nullable',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],

            'variants.*.remove_image' => [
                'nullable',
                'boolean',
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Extra Variant Validation
    |--------------------------------------------------------------------------
    */

    private function validateVariantRows(
        array $variants,
        ?Product $product = null
    ): void {
        $errors = [];

        $seenSkus = [];
        $seenColours = [];

        foreach ($variants as $index => $variant) {

            $sku = trim(
                (string) ($variant['sku'] ?? '')
            );

            $colour = trim(
                (string) ($variant['colour_name'] ?? '')
            );

            $variantId = isset($variant['id'])
                ? (int) $variant['id']
                : null;

            $skuKey = strtolower($sku);
            $colourKey = strtolower($colour);

            if (
                $skuKey !== '' &&
                in_array(
                    $skuKey,
                    $seenSkus,
                    true
                )
            ) {
                $errors["variants.{$index}.sku"] =
                    'Each variant SKU must be unique.';
            }

            if (
                $colourKey !== '' &&
                in_array(
                    $colourKey,
                    $seenColours,
                    true
                )
            ) {
                $errors[
                    "variants.{$index}.colour_name"
                ] =
                    'Each colour can only be added once.';
            }

            if ($skuKey !== '') {
                $seenSkus[] = $skuKey;
            }

            if ($colourKey !== '') {
                $seenColours[] = $colourKey;
            }

            if ($sku !== '') {

                $exists = ProductVariant::query()
                    ->where('sku', $sku)
                    ->when(
                        $variantId,
                        fn($query) =>
                        $query->whereKeyNot(
                            $variantId
                        )
                    )
                    ->exists();

                if ($exists) {
                    $errors[
                        "variants.{$index}.sku"
                    ] =
                        'This variant SKU is already in use.';
                }
            }
        }

        if ($errors) {
            throw ValidationException::withMessages(
                $errors
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Create Variants
    |--------------------------------------------------------------------------
    */

    private function createVariants(
        Product $product,
        Request $request,
        array $variants,
        array &$uploadedFiles
    ): void {
        if (empty($variants)) {
            return;
        }

        foreach (
            $variants as $index => $variantData
        ) {
            $image = null;

            if (
                $request->hasFile(
                    "variants.{$index}.image"
                )
            ) {
                $image = $this->storeProductImage(
                    $request->file(
                        "variants.{$index}.image"
                    ),
                    'products/variants',
                    $product->name . '-' .
                    ($variantData['colour_name'] ?? 'variant')
                );

                $uploadedFiles[] = $image;
            }

            $product->variants()->create([
                'colour_name' => trim(
                    $variantData['colour_name']
                ),

                'colour_code' =>
                    $this->cleanColourCode(
                        $variantData['colour_code']
                        ?? null
                    ),

                'sku' => trim(
                    $variantData['sku']
                ),

                'quantity' =>
                    (int) $variantData['quantity'],

                'image' => $image,

                'image_alt' => $this->nullableString(
                    $variantData['image_alt']
                    ?? null
                ),

                'price_adjustment' =>
                    (float) (
                        $variantData[
                            'price_adjustment'
                        ] ?? 0
                    ),

                'status' =>
                    $variantData['status']
                    ?? 'active',

                'sort_order' => $index,
            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Sync Variants
    |--------------------------------------------------------------------------
    */

    private function syncVariants(
        Product $product,
        Request $request,
        array $variants,
        array &$uploadedFiles,
        array &$filesToDelete
    ): void {
        if (empty($variants)) {
            $product->variants()->delete();
            return;
        }

        $existing = $product
            ->variants()
            ->get()
            ->keyBy('id');

        $keptIds = [];

        foreach (
            $variants as $index => $variantData
        ) {
            $variantId = isset(
                $variantData['id']
            )
                ? (int) $variantData['id']
                : null;

            /*
            | Security:
            | only variants belonging to this product
            | can be updated.
            */

            $variant = $variantId
                ? $existing->get($variantId)
                : null;

            $image = $variant?->image;

            /*
            |--------------------------------------------------------------------------
            | Remove existing image
            |--------------------------------------------------------------------------
            */

            if (
                !empty(
                $variantData['remove_image']
            ) &&
                $image
            ) {
                $filesToDelete[] = $image;
                $image = null;
            }

            /*
            |--------------------------------------------------------------------------
            | Replace / Upload image
            |--------------------------------------------------------------------------
            */

            if (
                $request->hasFile(
                    "variants.{$index}.image"
                )
            ) {
                $newImage =
                    $this->storeProductImage(
                        $request->file(
                            "variants.{$index}.image"
                        ),
                        'products/variants',
                        $product->name . '-' .
                        (
                            $variantData[
                                'colour_name'
                            ] ?? 'variant'
                        )
                    );

                $uploadedFiles[] = $newImage;

                if ($image) {
                    $filesToDelete[] = $image;
                }

                $image = $newImage;
            }

            $values = [
                'colour_name' => trim(
                    $variantData['colour_name']
                ),

                'colour_code' =>
                    $this->cleanColourCode(
                        $variantData['colour_code']
                        ?? null
                    ),

                'sku' => trim(
                    $variantData['sku']
                ),

                'quantity' =>
                    (int) $variantData['quantity'],

                'image' => $image,

                'image_alt' => $this->nullableString(
                    $variantData['image_alt']
                    ?? null
                ),

                'price_adjustment' =>
                    (float) (
                        $variantData[
                            'price_adjustment'
                        ] ?? 0
                    ),

                'status' =>
                    $variantData['status']
                    ?? 'active',

                'sort_order' => $index,
            ];

            if ($variant) {
                $variant->update($values);

                $keptIds[] =
                    $variant->id;
            } else {
                $newVariant =
                    $product
                        ->variants()
                        ->create($values);

                $keptIds[] =
                    $newVariant->id;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Remove variants deleted from form
        |--------------------------------------------------------------------------
        */

        $variantsToDelete =
            $product->variants();

        if (!empty($keptIds)) {
            $variantsToDelete
                ->whereNotIn(
                    'id',
                    $keptIds
                );
        }

        $variantsToDelete
            ->get()
            ->each(
                function (ProductVariant $variant) use (&$filesToDelete) {
                    if ($variant->image) {
                        $filesToDelete[] =
                            $variant->image;
                    }

                    $variant->delete();
                }
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Create Gallery
    |--------------------------------------------------------------------------
    */

    private function createGalleryImages(
        Product $product,
        Request $request,
        array &$uploadedFiles
    ): void {
        $galleryItems = $request->input(
            'gallery_items',
            []
        );

        foreach (
            $galleryItems as $index => $item
        ) {
            if (
                !$request->hasFile(
                    "gallery_items.{$index}.image"
                )
            ) {
                continue;
            }

            /** @var UploadedFile $file */
            $file = $request->file(
                "gallery_items.{$index}.image"
            );

            $imageName =
                $this->nullableString(
                    $item['image_name'] ?? null
                );

            $storedImage =
                $this->storeProductImage(
                    $file,
                    'products/gallery',
                    $imageName
                    ?: $product->name .
                    '-gallery-' .
                    ($index + 1)
                );

            $uploadedFiles[] =
                $storedImage;

            $product->images()->create([
                'image' => $storedImage,

                'image_name' =>
                    $imageName
                    ?: $this->humanImageName(
                        $file
                    ),

                'alt_text' =>
                    $this->nullableString(
                        $item['alt_text']
                        ?? null
                    ),

                'sort_order' =>
                    isset(
                    $item['sort_order']
                )
                    ? max(
                        0,
                        (int) $item[
                            'sort_order'
                        ]
                    )
                    : $index,
            ]);
        }

        $this->syncLegacyGalleryField(
            $product
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Gallery
    |--------------------------------------------------------------------------
    */

    private function syncGalleryImages(
        Product $product,
        Request $request,
        array &$uploadedFiles,
        array &$filesToDelete
    ): void {
        $galleryItems = $request->input(
            'gallery_items',
            []
        );

        $existingImages = $product
            ->images()
            ->get()
            ->keyBy('id');

        $keptIds = [];

        foreach (
            $galleryItems as $index => $item
        ) {
            $imageId = isset($item['id'])
                ? (int) $item['id']
                : null;

            /*
            | Only an image actually belonging to this
            | product can be edited.
            */

            $productImage = $imageId
                ? $existingImages->get(
                    $imageId
                )
                : null;

            /*
            |--------------------------------------------------------------------------
            | Remove
            |--------------------------------------------------------------------------
            */

            if (
                $productImage &&
                !empty($item['remove'])
            ) {
                if ($productImage->image) {
                    $filesToDelete[] =
                        $productImage->image;
                }

                $productImage->delete();

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Existing gallery image
            |--------------------------------------------------------------------------
            */

            if ($productImage) {

                $values = [
                    'image_name' =>
                        $this->nullableString(
                            $item['image_name']
                            ?? null
                        ),

                    'alt_text' =>
                        $this->nullableString(
                            $item['alt_text']
                            ?? null
                        ),

                    'sort_order' =>
                        isset(
                        $item[
                            'sort_order'
                        ]
                    )
                        ? max(
                            0,
                            (int) $item[
                                'sort_order'
                            ]
                        )
                        : $index,
                ];

                /*
                |--------------------------------------------------------------------------
                | Replace image
                |--------------------------------------------------------------------------
                */

                if (
                    $request->hasFile(
                        "gallery_items.{$index}.image"
                    )
                ) {
                    /** @var UploadedFile $file */
                    $file = $request->file(
                        "gallery_items.{$index}.image"
                    );

                    $newImage =
                        $this->storeProductImage(
                            $file,
                            'products/gallery',
                            $values['image_name']
                            ?: $product->name .
                            '-gallery-' .
                            ($index + 1)
                        );

                    $uploadedFiles[] =
                        $newImage;

                    if ($productImage->image) {
                        $filesToDelete[] =
                            $productImage->image;
                    }

                    $values['image'] =
                        $newImage;
                }

                $productImage->update(
                    $values
                );

                $keptIds[] =
                    $productImage->id;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | New gallery image
            |--------------------------------------------------------------------------
            */

            if (
                !$request->hasFile(
                    "gallery_items.{$index}.image"
                )
            ) {
                continue;
            }

            /** @var UploadedFile $file */
            $file = $request->file(
                "gallery_items.{$index}.image"
            );

            $imageName =
                $this->nullableString(
                    $item['image_name'] ?? null
                );

            $newImage =
                $this->storeProductImage(
                    $file,
                    'products/gallery',
                    $imageName
                    ?: $product->name .
                    '-gallery-' .
                    ($index + 1)
                );

            $uploadedFiles[] =
                $newImage;

            $newRecord =
                $product->images()->create([
                    'image' => $newImage,

                    'image_name' =>
                        $imageName
                        ?: $this->humanImageName(
                            $file
                        ),

                    'alt_text' =>
                        $this->nullableString(
                            $item['alt_text']
                            ?? null
                        ),

                    'sort_order' =>
                        isset(
                        $item['sort_order']
                    )
                        ? max(
                            0,
                            (int) $item[
                                'sort_order'
                            ]
                        )
                        : $index,
                ]);

            $keptIds[] =
                $newRecord->id;
        }

        /*
        |--------------------------------------------------------------------------
        | Existing images omitted from submitted form
        |--------------------------------------------------------------------------
        |
        | Normally the edit UI will submit all current images.
        | If an image disappears from the submitted gallery, remove it.
        |
        */

        $omittedImages =
            $existingImages->filter(
                fn(ProductImage $image) =>
                !in_array(
                    $image->id,
                    $keptIds,
                    true
                ) &&
                $image->exists
            );

        foreach (
            $omittedImages as $image
        ) {
            /*
            | If it was explicitly removed earlier,
            | its model no longer exists.
            */

            if (!$image->exists) {
                continue;
            }

            if ($image->image) {
                $filesToDelete[] =
                    $image->image;
            }

            $image->delete();
        }

        $this->syncLegacyGalleryField(
            $product
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Keep Legacy gallery_images Synced
    |--------------------------------------------------------------------------
    |
    | This prevents old public code from immediately breaking while we move
    | the frontend to the new ProductImage relationship.
    |
    */

    private function syncLegacyGalleryField(
        Product $product
    ): void {
        $paths = $product
            ->images()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('image')
            ->values()
            ->all();

        $product->forceFill([
            'gallery_images' => $paths,
        ])->save();
    }


    /*
    |--------------------------------------------------------------------------
    | Product Summary
    |--------------------------------------------------------------------------
    */

    private function syncProductSummary(
        Product $product
    ): void {
        $variants = $product
            ->variants()
            ->orderBy('sort_order')
            ->get();

        $hasVariants = $variants->isNotEmpty();

        $totalStock = $hasVariants
            ? (int) $variants->sum('quantity')
            : (int) $product->stock_quantity;

        $lowStockAlert =
            (int) (
                $product->low_stock_alert
                ?? 5
            );

        $stockStatus = match (true) {
            $totalStock <= 0 =>
            'out_of_stock',

            $totalStock <=
            $lowStockAlert =>
            'low_stock',

            default =>
            'in_stock',
        };

        $product->forceFill([
            'colors' =>
                $variants
                    ->pluck('colour_name')
                    ->values()
                    ->all(),

            'color_images' =>
                $variants
                    ->filter(
                        fn($variant) =>
                        filled(
                            $variant->image
                        )
                    )
                    ->pluck(
                        'image',
                        'colour_name'
                    )
                    ->all(),

            'stock_quantity' =>
                $totalStock,

            'stock_status' =>
                $stockStatus,
        ])->save();
    }


    /*
    |--------------------------------------------------------------------------
    | Store Image with SEO-friendly Filename
    |--------------------------------------------------------------------------
    */

    private function storeProductImage(
        UploadedFile $image,
        string $directory,
        string $preferredName
    ): string {
        $extension = strtolower(
            $image->getClientOriginalExtension()
        );

        $baseName = Str::slug(
            $preferredName
        );

        if ($baseName === '') {
            $baseName = 'product-image';
        }

        $filename =
            $baseName .
            '-' .
            Str::lower(
                Str::random(8)
            ) .
            '.' .
            $extension;

        return $image->storeAs(
            $directory,
            $filename,
            'public'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Human-readable Original Image Name
    |--------------------------------------------------------------------------
    */

    private function humanImageName(
        UploadedFile $image
    ): string {
        $filename = pathinfo(
            $image->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        return Str::of($filename)
            ->replace(
                ['_', '-'],
                ' '
            )
            ->squish()
            ->title()
            ->toString();
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Files
    |--------------------------------------------------------------------------
    */

    private function deleteFileCollection(
        array $files
    ): void {
        foreach ($files as $file) {

            if (
                $file &&
                Storage::disk('public')
                    ->exists($file)
            ) {
                Storage::disk('public')
                    ->delete($file);
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Normalise Legacy JSON Array
    |--------------------------------------------------------------------------
    */

    private function normaliseArray(
        array|string|null $value
    ): array {
        if (is_array($value)) {
            return $value;
        }

        if (
            is_string($value) &&
            trim($value) !== ''
        ) {
            $decoded = json_decode(
                $value,
                true
            );

            return is_array($decoded)
                ? $decoded
                : [];
        }

        return [];
    }


    /*
    |--------------------------------------------------------------------------
    | Colour Code
    |--------------------------------------------------------------------------
    */

    private function cleanColourCode(
        mixed $value
    ): ?string {
        if (
            !is_string($value) ||
            trim($value) === ''
        ) {
            return null;
        }

        $value = trim($value);

        if (
            preg_match(
                '/^#?[0-9a-fA-F]{6}$/',
                $value
            )
        ) {
            return '#' .
                strtoupper(
                    ltrim(
                        $value,
                        '#'
                    )
                );
        }

        return $value;
    }


    /*
    |--------------------------------------------------------------------------
    | Nullable String
    |--------------------------------------------------------------------------
    */

    private function nullableString(
        mixed $value
    ): ?string {
        if (!is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value !== ''
            ? $value
            : null;
    }


    /*
    |--------------------------------------------------------------------------
    | Slug Generation
    |--------------------------------------------------------------------------
    */

    private function generateUniqueSlug(
        string $name
    ): string {
        return $this->uniqueSlug(
            $name
        );
    }


    private function generateUniqueSlugForUpdate(
        string $name,
        int $productId
    ): string {
        return $this->uniqueSlug(
            $name,
            $productId
        );
    }


    private function uniqueSlug(
        string $name,
        ?int $ignoreProductId = null
    ): string {
        $base = Str::slug($name)
            ?: 'product';

        $slug = $base;
        $counter = 1;

        while (
            Product::query()
                ->where(
                    'slug',
                    $slug
                )
                ->when(
                    $ignoreProductId,
                    fn($query) =>
                    $query->whereKeyNot(
                        $ignoreProductId
                    )
                )
                ->exists()
        ) {
            $slug =
                "{$base}-{$counter}";

            $counter++;
        }

        return $slug;
    }
}