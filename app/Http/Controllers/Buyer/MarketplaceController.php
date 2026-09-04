<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    /**
     * Show all active products from all farmers.
     */
    public function index(Request $request)
{
    $search = $request->query('search');

    $products = Product::with(['images', 'farmer'])
        ->where('status', 'active')
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'ilike', "%{$search}%")
                  ->orWhere('commodity_type', 'ilike', "%{$search}%")
                  ->orWhere('category', 'ilike', "%{$search}%")
                  ->orWhere('variety', 'ilike', "%{$search}%");
            });
        })
        ->latest()
        ->get();

    return view('buyer.marketplace.index', compact('products', 'search'));
}

    /**
     * Show full details of a single product, from the buyer's perspective.
     */
    public function show(Product $product)
    {
        abort_unless($product->status === 'active', 404);
        $product->load(['images', 'farmer']);

        return view('buyer.marketplace.show', compact('product'));
    }
}