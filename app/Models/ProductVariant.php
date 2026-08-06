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
        'price_adjustment',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price_adjustment' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getFinalPriceAttribute(): float
    {
        $basePrice = $this->product->sale_price
            ?: $this->product->regular_price;

        return (float) $basePrice
            + (float) $this->price_adjustment;
    }

    public function isInStock(): bool
    {
        return $this->quantity > 0
            && $this->status === 'active';
    }
}
