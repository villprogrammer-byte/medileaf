<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [

        // Basic
        'name',
        'slug',
        'sku',
        'category',
        'brand',
        'product_type',
        'reference_number',
        'colors',

        // Pricing
        'regular_price',
        'sale_price',
        'cost_price',

        // Description
        'short_description',
        'description',

        // Inventory
        'stock_quantity',
        'low_stock_alert',
        'stock_status',

        // Images
        'featured_image',
        'gallery_images',

        // Shipping
        'weight',
        'length',
        'width',
        'height',

        // SEO
        'seo_title',
        'meta_description',
        'image_alt',

        // Options
        'featured',
        'prescription_required',
        'status',

    ];

    protected $casts = [

        'colors' => 'array',

        'gallery_images' => 'array',

        'featured' => 'boolean',

        'prescription_required' => 'boolean',

    ];
}