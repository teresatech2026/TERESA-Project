<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class MarketplaceController extends Controller
{
    /**
     * Show all active products from all farmers.
     */
    public function index()
    {
        $products = Product::with(['images', 'farmer'])
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('buyer.marketplace.index', compact('products'));
    }

    /**
     * Show full details of a single product, from the buyer's perspective.
     */
    public function show(Product $product)
    {
        $product->load(['images', 'farmer']);

        return view('buyer.marketplace.show', compact('product'));
    }
}