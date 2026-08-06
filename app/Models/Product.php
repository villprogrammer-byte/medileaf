<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'regular_price',
        'sale_price',
        'cost_price',
        'short_description',
        'description',
        'stock_quantity',
        'low_stock_alert',
        'stock_status',
        'featured_image',
        'gallery_images',
        'color_images',
        'weight',
        'length',
        'width',
        'height',
        'seo_title',
        'meta_description',
        'image_alt',
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
        'regular_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'low_stock_alert' => 'integer',
    ];

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

    public function getVariantStockAttribute(): int
    {
        if ($this->relationLoaded('variants')) {
            return (int) $this->variants->sum('quantity');
        }

        return (int) $this->variants()->sum('quantity');
    }

    public function hasVariants(): bool
    {
        if ($this->relationLoaded('variants')) {
            return $this->variants->isNotEmpty();
        }

        return $this->variants()->exists();
    }

    public function availableStock(): int
    {
        return $this->hasVariants()
            ? $this->variant_stock
            : (int) $this->stock_quantity;
    }

    public function refreshStockSummary(): void
    {
        if (!$this->hasVariants()) {
            return;
        }

        $totalStock = $this->variant_stock;
        $lowStockAlert = (int) ($this->low_stock_alert ?? 5);

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
