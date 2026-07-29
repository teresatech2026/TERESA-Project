<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = auth()->user()->farmer->products()->latest()->get();

        return view('farmer.products.index', compact('products'));
    }

    public function create()
    {
        return view('farmer.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:150',
            'commodity_type' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'variety' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'selling_price' => 'required|numeric|min:0',
            'unit_of_measurement' => 'required|string|max:30',
            'available_quantity' => 'required|numeric|min:0',
            'minimum_order_quantity' => 'nullable|numeric|min:0',
            'harvest_date' => 'required|date',
            'estimated_shelf_life_days' => 'nullable|integer|min:0',
            'product_grade' => 'nullable|string|max:50',
            'product_condition' => 'nullable|string|max:50',
            'production_method' => 'nullable|string|max:50',
            'size_weight_classification' => 'nullable|string|max:50',
            'images' => 'nullable|array',
            'images.*' => 'image|max:4096',
        ]);

        $product = auth()->user()->farmer->products()->create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('product-images', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('farmer.products.index')
            ->with('success', 'Product added successfully!');
    }

    /**
     * Show full details of a single product.
     */
   public function show(Product $product)
{
    abort_unless($product->farmer_id === auth()->user()->farmer->id, 403);

    $product->load('images', 'farmer.reviews.buyer');

    return view('farmer.products.show', compact('product'));
}
}