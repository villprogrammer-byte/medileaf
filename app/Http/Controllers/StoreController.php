<?php

namespace App\Http\Controllers;

use App\Models\Product;

class StoreController extends Controller
{
    /**
     * Store Listing
     */
    public function index()
    {
        $products = Product::query()
            ->where('status', 'published')
            ->latest()
            ->get();

        return view('shop.store', compact('products'));
    }

    /**
     * Product Detail Page
     */
    public function show(Product $product)
    {
        // Only published products on frontend
        abort_if($product->status !== 'published', 404);

        $relatedProducts = Product::where('status', 'published')
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        return view('shop.product-view', compact('product', 'relatedProducts'));
    }
}