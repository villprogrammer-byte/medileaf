<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $inStockPcs = Product::where('stock_quantity', '>', 0)
            ->sum('stock_quantity');

        $outOfStockProducts = Product::where(function ($query) {
            $query->where('stock_quantity', '<=', 0)
                ->orWhere('stock_status', 'out_of_stock');
        })->count();

        $lowStockProducts = Product::where('stock_quantity', '>', 0)
            ->where(function ($query) {
                $query->whereColumn('stock_quantity', '<=', 'low_stock_alert')
                    ->orWhereNull('low_stock_alert');
            })
            ->orderBy('stock_quantity', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'inStockPcs',
            'outOfStockProducts',
            'lowStockProducts'
        ));
    }
}