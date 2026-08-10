<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image',
        'image_name',
        'alt_text',
        'sort_order',
    ];


    protected $casts = [
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
    | Image ALT
    |--------------------------------------------------------------------------
    |
    | Use manual ALT text when available.
    | Otherwise fallback to image name.
    | Final fallback is product name.
    |
    */

    public function getAltTextValueAttribute(): string
    {
        if (filled($this->alt_text)) {
            return $this->alt_text;
        }

        if (filled($this->image_name)) {
            return $this->image_name;
        }

        return $this->product?->name ?: 'Product image';
    }


    /*
    |--------------------------------------------------------------------------
    | Image Display Name
    |--------------------------------------------------------------------------
    */

    public function getDisplayNameAttribute(): string
    {
        if (filled($this->image_name)) {
            return $this->image_name;
        }

        return 'Product Image';
    }


    /*
    |--------------------------------------------------------------------------
    | Public Image URL
    |--------------------------------------------------------------------------
    */

    public function getImageUrlAttribute(): string
    {
        return asset(
            'storage/' . ltrim($this->image, '/')
        );
    }
}