<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    /**
     * Display the buyer's cart.
     */
    public function index()
    {
        $cartItems = auth()->user()->buyer->cartItems()
            ->with(['product.images', 'product.farmer'])
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->selling_price;
        });

        return view('buyer.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Determine whether a product is sold by a whole-number ("piece") unit.
     */
    private function isPieceUnit(Product $product): bool
    {
        return in_array(
            strtolower(trim($product->unit_of_measurement)),
            ['piece', 'pieces', 'pc', 'pcs']
        );
    }

    /**
     * The quantity validation rule, adjusted for piece-based products.
     */
    private function quantityRule(Product $product): array
    {
        return [
            'required',
            'numeric',
            'min:' . ($this->isPieceUnit($product) ? 1 : 0.01),
            Rule::when($this->isPieceUnit($product), ['integer']),
        ];
    }

    /**
     * Add a product to the cart.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => $this->quantityRule($product),
        ]);

        $buyer = auth()->user()->buyer;

        $cartItem = CartItem::where('buyer_id', $buyer->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'buyer_id'   => $buyer->id,
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Added to cart!');
    }

    /**
     * Buy Now - Add the product to the cart then proceed to checkout.
     */
    public function buyNow(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => $this->quantityRule($product),
        ]);

        $buyer = auth()->user()->buyer;

        $cartItem = CartItem::where('buyer_id', $buyer->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'buyer_id'   => $buyer->id,
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
            ]);
        }

        return redirect()->route('checkout');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        abort_unless(
            $cartItem->buyer_id === auth()->user()->buyer->id,
            403
        );

        $request->validate([
            'quantity' => $this->quantityRule($cartItem->product),
        ]);

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Cart updated.');
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy(CartItem $cartItem)
    {
        abort_unless(
            $cartItem->buyer_id === auth()->user()->buyer->id,
            403
        );

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}