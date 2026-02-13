<?php

namespace App\Http\Controllers;

use App\Models\Cart_item;
use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        $cartItems = Cart_item::with('product')
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $total = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->product->price * $item->quantity);
        }, 0);

        // Get status from request, default to 'pending'
        $status = $request->input('status', 'pending');

        // Validate status
        if (!in_array($status, ['pending', 'paid'])) {
            $status = 'pending';
        }

        // Create order
        $order = Order::create([
            'user_id' => $userId,
            'total_price' => $total,
            'status' => $status,
        ]);

        foreach ($cartItems as $item) {
            Order_item::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price, // price at time of order
            ]);
        }

        // Clear cart
        Cart_item::where('user_id', $userId)->delete();

        return redirect()
            ->route('cart.index', $order)
            ->with('success', 'Order placed successfully.');
    }

    /**
     * Display the specified resource.
     */

     // TODO: Currently unused for showing the Modal
    public function show(Order $order)
    {
        $userId = Auth::id();

        if ($order->user_id !== $userId) {
            abort(403);
        }

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Updates the order from the database
     */
    public function update(Request $request, Order $order)
    {
        $userId = Auth::id();

        // Ensure this order belongs to the authenticated user
        if ($order->user_id !== $userId) {
            abort(403);
        }

        // Only allow updating status for pending orders
        if ($order->status !== 'pending') {
            return redirect()
                ->route('account.show')
                ->with('error', 'Only pending orders can be updated.');
        }

        $status = $request->input('status');

        // Validate status
        if (!in_array($status, ['paid'])) {
            return redirect()
                ->route('account.show')
                ->with('error', 'Invalid status.');
        }

        $order->update([
            'status' => $status,
        ]);

        return redirect()
            ->route('account.show')
            ->with('success', 'Order status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $userId = Auth::id();

        // Ensure this order belongs to the authenticated user
        if ($order->user_id !== $userId) {
            abort(403);
        }

        // Only allow deleting pending orders
        if ($order->status !== 'pending') {
            return redirect()
                ->route('account.show')
                ->with('error', 'Only pending orders can be cancelled.');
        }

        $order->delete();

        return redirect()
            ->route('account.show')
            ->with('success', 'Order cancelled successfully.');
    }
}
