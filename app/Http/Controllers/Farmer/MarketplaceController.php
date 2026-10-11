<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    /**
     * Show all active products from all farmers (same data the buyer sees).
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $myFarmerId = auth()->user()->farmer?->id;

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

        return view('farmer.marketplace.index', compact('products', 'search', 'myFarmerId'));
    }

    /**
     * Show full details of a single product (view-only for farmers).
     */
    public function show(Product $product)
    {
        abort_unless($product->status === 'active', 404);
        $product->load(['images', 'farmer.user']);

        $myFarmerId = auth()->user()->farmer?->id;

        return view('farmer.marketplace.show', compact('product', 'myFarmerId'));
    }
}
