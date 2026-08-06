<?php

namespace App\Http\Controllers;

use App\Models\Product;

class StoreController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->where('status', 'published')
            ->withCount('activeVariants')
            ->latest()
            ->get();

        return view('shop.store', compact('products'));
    }

    public function show(Product $product)
    {
        abort_if($product->status !== 'published', 404);

        $product->load([
            'activeVariants',
        ]);

        $relatedProducts = Product::query()
            ->where('status', 'published')
            ->whereKeyNot($product->id)
            ->latest()
            ->take(4)
            ->get();

        return view(
            'shop.product-view',
            compact('product', 'relatedProducts')
        );
    }
}
