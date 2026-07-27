<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Show the buyer's cart.
     */
    public function index()
    {
        $cartItems = auth()->user()->buyer->cartItems()
            ->with(['product.images', 'product.farmer'])
            ->get();

        $total = $cartItems->sum(fn ($item) => $item->quantity * $item->product->selling_price);

        return view('buyer.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to the cart (or increase quantity if already in cart).
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0.01',
        ]);

        $buyer = auth()->user()->buyer;

        $cartItem = CartItem::where('buyer_id', $buyer->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Added to cart!');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        abort_unless($cartItem->buyer_id === auth()->user()->buyer->id, 403);

        $request->validate([
            'quantity' => 'required|numeric|min:0.01',
        ]);

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated.');
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy(CartItem $cartItem)
    {
        abort_unless($cartItem->buyer_id === auth()->user()->buyer->id, 403);

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}