<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'category',
        'brand',
        'product_type',
        'reference_number',

        'colors',
        'color_images',

        'regular_price',
        'sale_price',
        'cost_price',

        'short_description',
        'description',

        'stock_quantity',
        'low_stock_alert',
        'stock_status',

        /*
        |--------------------------------------------------------------------------
        | Legacy image fields
        |--------------------------------------------------------------------------
        |
        | featured_image stays in products table.
        | gallery_images is temporarily retained for backward compatibility.
        | New gallery management will use ProductImage records.
        |
        */
        'featured_image',
        'gallery_images',

        /*
        |--------------------------------------------------------------------------
        | Shipping
        |--------------------------------------------------------------------------
        */
        'weight',
        'length',
        'width',
        'height',

        /*
        |--------------------------------------------------------------------------
        | SEO
        |--------------------------------------------------------------------------
        */
        'seo_title',
        'meta_description',

        /*
        | Legacy field retained so existing products do not break.
        | New image ALT text will be stored per image.
        */
        'image_alt',

        'canonical_url',
        'is_indexable',

        /*
        |--------------------------------------------------------------------------
        | Open Graph
        |--------------------------------------------------------------------------
        */
        'og_title',
        'og_description',
        'og_image',

        /*
        |--------------------------------------------------------------------------
        | Product Options
        |--------------------------------------------------------------------------
        */
        'featured',
        'prescription_required',
        'status',
    ];


    protected $casts = [
        'colors' => 'array',
        'gallery_images' => 'array',
        'color_images' => 'array',

        'featured' => 'boolean',
        'prescription_required' => 'boolean',
        'is_indexable' => 'boolean',

        'regular_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',

        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',

        'stock_quantity' => 'integer',
        'low_stock_alert' => 'integer',
    ];


    /*
    |--------------------------------------------------------------------------
    | Colour Variants
    |--------------------------------------------------------------------------
    */

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }


    public function activeVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->orderBy('id');
    }


    /*
    |--------------------------------------------------------------------------
    | Product Gallery Images
    |--------------------------------------------------------------------------
    |
    | New one-by-one gallery system:
    | image
    | alt_text
    | image_name
    | sort_order
    |
    */

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }


    /*
    |--------------------------------------------------------------------------
    | Category Slug
    |--------------------------------------------------------------------------
    |
    | Example:
    | Vaporisers -> vaporisers
    |
    */

    public function getCategorySlugAttribute(): string
    {
        return Str::slug(
            $this->category ?: 'uncategorised'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Public Product Path
    |--------------------------------------------------------------------------
    |
    | Final MediLeaf URL:
    |
    | /vaporizers/mighty-plus-medic
    |
    */

    public function getPublicPathAttribute(): string
    {
        return '/' .
            $this->category_slug .
            '/' .
            $this->slug;
    }


    /*
    |--------------------------------------------------------------------------
    | Public Product URL
    |--------------------------------------------------------------------------
    */

    public function getPublicUrlAttribute(): string
    {
        return url($this->public_path);
    }


    /*
    |--------------------------------------------------------------------------
    | Canonical URL
    |--------------------------------------------------------------------------
    |
    | If admin provides an override, use it.
    | Otherwise automatically use the public product URL.
    |
    */

    public function getCanonicalUrlValueAttribute(): string
    {
        return filled($this->canonical_url)
            ? $this->canonical_url
            : $this->public_url;
    }


    /*
    |--------------------------------------------------------------------------
    | SEO Title
    |--------------------------------------------------------------------------
    |
    | Manual SEO title first.
    | Product name is the fallback.
    |
    */

    public function getSeoTitleValueAttribute(): string
    {
        return filled($this->seo_title)
            ? $this->seo_title
            : $this->name;
    }


    /*
    |--------------------------------------------------------------------------
    | SEO Description
    |--------------------------------------------------------------------------
    */

    public function getMetaDescriptionValueAttribute(): string
    {
        if (filled($this->meta_description)) {
            return $this->meta_description;
        }

        if (filled($this->short_description)) {
            return Str::limit(
                trim(strip_tags($this->short_description)),
                160,
                ''
            );
        }

        return '';
    }


    /*
    |--------------------------------------------------------------------------
    | Robots
    |--------------------------------------------------------------------------
    */

    public function getRobotsContentAttribute(): string
    {
        return $this->is_indexable
            ? 'index,follow'
            : 'noindex,follow';
    }


    /*
    |--------------------------------------------------------------------------
    | Open Graph Title
    |--------------------------------------------------------------------------
    */

    public function getOgTitleValueAttribute(): string
    {
        return filled($this->og_title)
            ? $this->og_title
            : $this->seo_title_value;
    }


    /*
    |--------------------------------------------------------------------------
    | Open Graph Description
    |--------------------------------------------------------------------------
    */

    public function getOgDescriptionValueAttribute(): string
    {
        return filled($this->og_description)
            ? $this->og_description
            : $this->meta_description_value;
    }


    /*
    |--------------------------------------------------------------------------
    | Open Graph Image
    |--------------------------------------------------------------------------
    |
    | Custom OG image first.
    | Otherwise featured product image.
    |
    */

    public function getOgImageUrlAttribute(): ?string
    {
        if (filled($this->og_image)) {
            return asset(
                'storage/' . ltrim($this->og_image, '/')
            );
        }

        if (filled($this->featured_image)) {
            return asset(
                'storage/' . ltrim($this->featured_image, '/')
            );
        }

        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | Featured Image ALT
    |--------------------------------------------------------------------------
    |
    | `image_alt` is retained as fallback for existing products.
    | New implementation will allow proper image-level ALT management.
    |
    */

    public function getFeaturedImageAltAttribute(): string
    {
        return filled($this->image_alt)
            ? $this->image_alt
            : $this->name;
    }


    /*
    |--------------------------------------------------------------------------
    | Current Selling Price
    |--------------------------------------------------------------------------
    */

    public function getCurrentPriceAttribute(): float
    {
        if (
            $this->sale_price !== null &&
            (float) $this->sale_price < (float) $this->regular_price
        ) {
            return (float) $this->sale_price;
        }

        return (float) $this->regular_price;
    }


    /*
    |--------------------------------------------------------------------------
    | Variant Stock
    |--------------------------------------------------------------------------
    */

    public function getVariantStockAttribute(): int
    {
        if ($this->relationLoaded('variants')) {
            return (int) $this->variants->sum('quantity');
        }

        return (int) $this->variants()->sum('quantity');
    }


    /*
    |--------------------------------------------------------------------------
    | Has Variants
    |--------------------------------------------------------------------------
    */

    public function hasVariants(): bool
    {
        if ($this->relationLoaded('variants')) {
            return $this->variants->isNotEmpty();
        }

        return $this->variants()->exists();
    }


    /*
    |--------------------------------------------------------------------------
    | Available Stock
    |--------------------------------------------------------------------------
    */

    public function availableStock(): int
    {
        return $this->hasVariants()
            ? $this->variant_stock
            : (int) $this->stock_quantity;
    }


    /*
    |--------------------------------------------------------------------------
    | Refresh Stock Summary
    |--------------------------------------------------------------------------
    */

    public function refreshStockSummary(): void
    {
        if (!$this->hasVariants()) {
            return;
        }

        $totalStock = $this->variant_stock;

        $lowStockAlert = (int) (
            $this->low_stock_alert ?? 5
        );

        $stockStatus = match (true) {
            $totalStock <= 0 => 'out_of_stock',

            $totalStock <= $lowStockAlert => 'low_stock',

            default => 'in_stock',
        };

        $this->forceFill([
            'stock_quantity' => $totalStock,
            'stock_status' => $stockStatus,
        ])->save();
    }
}