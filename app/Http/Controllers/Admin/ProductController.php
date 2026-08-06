<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
    public function index(Request $request)
    {
        $query = Product::query()->withCount('variants');

        if ($request->filled('search')) {
            $search = trim((string) $request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhereHas('variants', function ($variantQuery) use ($search) {
                        $variantQuery
                            ->where('sku', 'like', "%{$search}%")
                            ->orWhere('colour_name', 'like', "%{$search}%");
                    });
            });
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());
        $variants = $request->input('variants', []);

        $this->validateVariantRows($variants);

        $uploadedFiles = [];

        try {
            DB::beginTransaction();

            $validated['slug'] = $validated['slug']
                ?: $this->generateUniqueSlug($validated['name']);

            unset($validated['variants']);

            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $request
                    ->file('featured_image')
                    ->store('products/featured', 'public');

                $uploadedFiles[] = $validated['featured_image'];
            }

            $validated['gallery_images'] = $request->hasFile('gallery_images')
                ? $this->storeGalleryImages($request->file('gallery_images'))
                : [];

            $uploadedFiles = array_merge(
                $uploadedFiles,
                $validated['gallery_images']
            );

            $validated['featured'] = $request->boolean('featured');
            $validated['prescription_required'] = $request->boolean('prescription_required');

            $product = Product::create($validated);

            $this->createVariants(
                product: $product,
                request: $request,
                variants: $variants,
                uploadedFiles: $uploadedFiles
            );

            $this->syncProductSummary($product);

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product added successfully.');
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->deleteFileCollection(array_unique($uploadedFiles));
            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'product' => 'Product save nahi hua. Please try again.',
                ]);
        }
    }

    public function show(Product $product)
    {
        $product->load('variants');

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('variants');

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate($this->validationRules($product));
        $variants = $request->input('variants', []);

        $this->validateVariantRows($variants, $product);

        $uploadedFiles = [];
        $filesToDelete = [];

        try {
            DB::beginTransaction();

            $validated['slug'] = $validated['slug']
                ?: $this->generateUniqueSlugForUpdate(
                    $validated['name'],
                    $product->id
                );

            unset($validated['variants']);

            if ($request->hasFile('featured_image')) {
                $newImage = $request
                    ->file('featured_image')
                    ->store('products/featured', 'public');

                $uploadedFiles[] = $newImage;

                if ($product->featured_image) {
                    $filesToDelete[] = $product->featured_image;
                }

                $validated['featured_image'] = $newImage;
            }

            if ($request->hasFile('gallery_images')) {
                $newGallery = $this->storeGalleryImages(
                    $request->file('gallery_images')
                );

                $uploadedFiles = array_merge($uploadedFiles, $newGallery);
                $filesToDelete = array_merge(
                    $filesToDelete,
                    $this->normaliseArray($product->gallery_images)
                );

                $validated['gallery_images'] = $newGallery;
            }

            $validated['featured'] = $request->boolean('featured');
            $validated['prescription_required'] = $request->boolean('prescription_required');

            $product->update($validated);

            $this->syncVariants(
                product: $product,
                request: $request,
                variants: $variants,
                uploadedFiles: $uploadedFiles,
                filesToDelete: $filesToDelete
            );

            $this->syncProductSummary($product);

            DB::commit();

            $this->deleteFileCollection(array_unique($filesToDelete));

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->deleteFileCollection(array_unique($uploadedFiles));
            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'product' => 'Product update nahi hua. Please try again.',
                ]);
        }
    }

    public function destroy(Product $product)
    {
        $product->load('variants');

        $files = array_filter([
            $product->featured_image,
            ...$this->normaliseArray($product->gallery_images),
            ...$product->variants->pluck('image')->filter()->all(),
        ]);

        DB::transaction(function () use ($product) {
            $product->delete();
        });

        $this->deleteFileCollection(array_unique($files));

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function validationRules(?Product $product = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product?->id),
            ],
            'sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($product?->id),
            ],
            'category' => ['nullable', 'string', 'max:150'],
            'brand' => ['nullable', 'string', 'max:150'],
            'product_type' => ['nullable', 'string', 'max:100'],
            'reference_number' => ['nullable', 'string', 'max:255'],

            'regular_price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lte:regular_price'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],

            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],

            'stock_quantity' => ['required', 'integer', 'min:0'],
            'low_stock_alert' => ['nullable', 'integer', 'min:0'],
            'stock_status' => [
                'required',
                Rule::in([
                    'in_stock',
                    'out_of_stock',
                    'low_stock',
                ])
            ],

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

            'weight' => ['nullable', 'numeric', 'min:0'],
            'length' => ['nullable', 'numeric', 'min:0'],
            'width' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],

            'seo_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'image_alt' => ['nullable', 'string', 'max:255'],

            'status' => [
                'required',
                Rule::in([
                    'published',
                    'draft',
                    'hidden',
                ])
            ],

            'variants' => ['required', 'array', 'min:1'],
            'variants.*.id' => ['nullable', 'integer'],
            'variants.*.colour_name' => ['required', 'string', 'max:100'],
            'variants.*.colour_code' => ['nullable', 'string', 'max:20'],
            'variants.*.sku' => ['required', 'string', 'max:100'],
            'variants.*.quantity' => ['required', 'integer', 'min:0'],
            'variants.*.image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'variants.*.price_adjustment' => ['nullable', 'numeric', 'min:0'],
            'variants.*.status' => ['nullable', Rule::in(['active', 'inactive'])],
            'variants.*.remove_image' => ['nullable', 'boolean'],
        ];
    }

    private function validateVariantRows(
        array $variants,
        ?Product $product = null
    ): void {
        $errors = [];
        $seenSkus = [];
        $seenColours = [];

        foreach ($variants as $index => $variant) {
            $sku = trim((string) ($variant['sku'] ?? ''));
            $colour = trim((string) ($variant['colour_name'] ?? ''));
            $variantId = isset($variant['id']) ? (int) $variant['id'] : null;

            $skuKey = strtolower($sku);
            $colourKey = strtolower($colour);

            if (in_array($skuKey, $seenSkus, true)) {
                $errors["variants.{$index}.sku"] =
                    'Each variant SKU must be unique.';
            }

            if (in_array($colourKey, $seenColours, true)) {
                $errors["variants.{$index}.colour_name"] =
                    'Each colour can only be added once.';
            }

            $seenSkus[] = $skuKey;
            $seenColours[] = $colourKey;

            $exists = ProductVariant::query()
                ->where('sku', $sku)
                ->when(
                    $variantId,
                    fn($query) => $query->whereKeyNot($variantId)
                )
                ->exists();

            if ($exists) {
                $errors["variants.{$index}.sku"] =
                    'This variant SKU is already in use.';
            }
        }

        if ($errors) {
            throw ValidationException::withMessages($errors);
        }
    }

    private function createVariants(
        Product $product,
        Request $request,
        array $variants,
        array &$uploadedFiles
    ): void {
        foreach ($variants as $index => $variantData) {
            $image = null;

            if ($request->hasFile("variants.{$index}.image")) {
                $image = $request
                    ->file("variants.{$index}.image")
                    ->store('products/variants', 'public');

                $uploadedFiles[] = $image;
            }

            $product->variants()->create([
                'colour_name' => trim($variantData['colour_name']),
                'colour_code' => $this->cleanColourCode(
                    $variantData['colour_code'] ?? null
                ),
                'sku' => trim($variantData['sku']),
                'quantity' => (int) $variantData['quantity'],
                'image' => $image,
                'price_adjustment' => (float) ($variantData['price_adjustment'] ?? 0),
                'status' => $variantData['status'] ?? 'active',
                'sort_order' => $index,
            ]);
        }
    }

    private function syncVariants(
        Product $product,
        Request $request,
        array $variants,
        array &$uploadedFiles,
        array &$filesToDelete
    ): void {
        $existing = $product->variants()->get()->keyBy('id');
        $keptIds = [];

        foreach ($variants as $index => $variantData) {
            $variantId = isset($variantData['id'])
                ? (int) $variantData['id']
                : null;

            $variant = $variantId
                ? $existing->get($variantId)
                : null;

            $image = $variant?->image;

            if (!empty($variantData['remove_image']) && $image) {
                $filesToDelete[] = $image;
                $image = null;
            }

            if ($request->hasFile("variants.{$index}.image")) {
                $newImage = $request
                    ->file("variants.{$index}.image")
                    ->store('products/variants', 'public');

                $uploadedFiles[] = $newImage;

                if ($image) {
                    $filesToDelete[] = $image;
                }

                $image = $newImage;
            }

            $values = [
                'colour_name' => trim($variantData['colour_name']),
                'colour_code' => $this->cleanColourCode(
                    $variantData['colour_code'] ?? null
                ),
                'sku' => trim($variantData['sku']),
                'quantity' => (int) $variantData['quantity'],
                'image' => $image,
                'price_adjustment' => (float) ($variantData['price_adjustment'] ?? 0),
                'status' => $variantData['status'] ?? 'active',
                'sort_order' => $index,
            ];

            if ($variant) {
                $variant->update($values);
                $keptIds[] = $variant->id;
            } else {
                $newVariant = $product->variants()->create($values);
                $keptIds[] = $newVariant->id;
            }
        }

        $product->variants()
            ->whereNotIn('id', $keptIds)
            ->get()
            ->each(function (ProductVariant $variant) use (&$filesToDelete) {
                if ($variant->image) {
                    $filesToDelete[] = $variant->image;
                }

                $variant->delete();
            });
    }

    private function syncProductSummary(Product $product): void
    {
        $variants = $product->variants()->get();
        $totalStock = (int) $variants->sum('quantity');
        $lowStockAlert = (int) ($product->low_stock_alert ?? 5);

        $stockStatus = match (true) {
            $totalStock <= 0 => 'out_of_stock',
            $totalStock <= $lowStockAlert => 'low_stock',
            default => 'in_stock',
        };

        $product->forceFill([
            'colors' => $variants->pluck('colour_name')->values()->all(),
            'color_images' => $variants
                ->filter(fn($variant) => filled($variant->image))
                ->pluck('image', 'colour_name')
                ->all(),
            'stock_quantity' => $totalStock,
            'stock_status' => $stockStatus,
        ])->save();
    }

    private function storeGalleryImages(array $images): array
    {
        $stored = [];

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $stored[] = $image->store(
                    'products/gallery',
                    'public'
                );
            }
        }

        return $stored;
    }

    private function deleteFileCollection(array $files): void
    {
        foreach ($files as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }
    }

    private function normaliseArray(array|string|null $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && trim($value) !== '') {
            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    private function cleanColourCode(mixed $value): ?string
    {
        if (!is_string($value) || trim($value) === '') {
            return null;
        }

        $value = trim($value);

        if (preg_match('/^#?[0-9a-fA-F]{6}$/', $value)) {
            return '#' . strtoupper(ltrim($value, '#'));
        }

        return $value;
    }

    private function generateUniqueSlug(string $name): string
    {
        return $this->uniqueSlug($name);
    }

    private function generateUniqueSlugForUpdate(
        string $name,
        int $productId
    ): string {
        return $this->uniqueSlug($name, $productId);
    }

    private function uniqueSlug(
        string $name,
        ?int $ignoreProductId = null
    ): string {
        $base = Str::slug($name) ?: 'product';
        $slug = $base;
        $counter = 1;

        while (
            Product::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreProductId,
                    fn($query) => $query->whereKeyNot($ignoreProductId)
                )
                ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
