<?php

namespace App\Http\Controllers;

use App\Models\Product;

class StoreController extends Controller
{
    /**
     * Show published products on the frontend store.
     */
    public function index()
    {
        $products = Product::query()
            ->where('status', 'published')
            ->latest()
            ->get();

        return view('shop.store', compact('products'));
    }
}