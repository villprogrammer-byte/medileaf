<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->where('status', 'published')
            ->withCount('activeVariants')
            ->latest()
            ->get();

        return view('shop.store', compact('products'));
    }

    public function show(string $categorySlug, string $productSlug): View|RedirectResponse
    {
        $product = Product::query()
            ->where('slug', $productSlug)
            ->where('status', 'published')
            ->with(['activeVariants', 'images'])
            ->firstOrFail();

        if ($categorySlug !== $product->category_slug) {
            return redirect($product->public_url, 301);
        }

        $relatedProducts = Product::query()
            ->where('status', 'published')
            ->whereKeyNot($product->id)
            ->where('category', $product->category)
            ->latest()
            ->take(4)
            ->get();

        if ($relatedProducts->count() < 4) {
            $remaining = 4 - $relatedProducts->count();

            $excludedIds = $relatedProducts
                ->pluck('id')
                ->push($product->id)
                ->all();

            $fallbackProducts = Product::query()
                ->where('status', 'published')
                ->whereNotIn('id', $excludedIds)
                ->latest()
                ->take($remaining)
                ->get();

            $relatedProducts = $relatedProducts->concat($fallbackProducts);
        }

        return view('shop.product-view', compact('product', 'relatedProducts'));
    }

    public function legacyRedirect(Product $product): RedirectResponse
    {
        abort_if($product->status !== 'published', 404);

        return redirect($product->public_url, 301);
    }
}