<?php

namespace App\Http\Controllers;

use App\Models\Cart_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        // Must be logged in
        $userId = Auth::id();

        $items = Cart_item::with('product')
            ->where('user_id', $userId)
            ->get();

        $total = $items->reduce(
            fn ($carry, $item) => $carry + ($item->product->price * $item->quantity),
            0
        );

        return Inertia::render('Cart', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $quantity = $data['quantity'] ?? 1;
        $userId = Auth::id();

        $item = Cart_item::where('user_id', $userId)
            ->where('product_id', $data['product_id'])
            ->first();

        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            Cart_item::create([
                'user_id' => $userId,
                'product_id' => $data['product_id'],
                'quantity' => $quantity,
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Item added to cart.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart_item $cart_item)
    {
        $userId = Auth::id();

        // Ensure this cart item belongs to the authenticated user
        if ($cart_item->user_id !== $userId) {
            abort(403);
        }

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart_item->update([
            'quantity' => $data['quantity'],
        ]);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart_item $cart_item)
    {
        $userId = Auth::id();

        if ($cart_item->user_id !== $userId) {
            abort(403);
        }

        $cart_item->delete();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Item removed from cart.');
    }
}
