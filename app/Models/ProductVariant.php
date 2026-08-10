<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'colour_name',
        'colour_code',
        'sku',
        'quantity',
        'image',
        'image_alt',
        'price_adjustment',
        'status',
        'sort_order',
    ];


    protected $casts = [
        'quantity' => 'integer',
        'price_adjustment' => 'decimal:2',
        'sort_order' => 'integer',
    ];


    /*
    |--------------------------------------------------------------------------
    | Product
    |--------------------------------------------------------------------------
    */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Final Variant Price
    |--------------------------------------------------------------------------
    |
    | Uses the product sale price when available.
    | Otherwise regular price is used.
    | Variant price adjustment is then added.
    |
    */

    public function getFinalPriceAttribute(): float
    {
        $basePrice = $this->product->sale_price
            ?: $this->product->regular_price;

        return (float) $basePrice
            + (float) $this->price_adjustment;
    }


    /*
    |--------------------------------------------------------------------------
    | Variant Image ALT
    |--------------------------------------------------------------------------
    |
    | Admin ALT text is used when supplied.
    | Otherwise a meaningful fallback is generated automatically.
    |
    */

    public function getImageAltValueAttribute(): string
    {
        if (filled($this->image_alt)) {
            return $this->image_alt;
        }

        $productName = $this->product?->name;

        if ($productName) {
            return trim(
                $productName . ' - ' . $this->colour_name
            );
        }

        return $this->colour_name ?: 'Product variant';
    }


    /*
    |--------------------------------------------------------------------------
    | Stock Availability
    |--------------------------------------------------------------------------
    */

    public function isInStock(): bool
    {
        return $this->quantity > 0
            && $this->status === 'active';
    }
}