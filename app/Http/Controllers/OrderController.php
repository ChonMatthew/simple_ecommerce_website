<?php

namespace App\Http\Controllers;

use App\Models\Cart_item;
use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TEMP: no auth yet – use test user id 1
        $userId = 1;

        $orders = Order::with('order_items.product')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = 1;

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

        // Create order
        $order = Order::create([
            'user_id'     => $userId,
            'total_price' => $total,
            'status'      => 'pending',
        ]);

        foreach ($cartItems as $item) {
            Order_item::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price, // price at time of order
            ]);
        }

        // Clear cart
        Cart_item::where('user_id', $userId)->delete();

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order placed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $userId = 1;

        if ($order->user_id !== $userId) {
            abort(403);
        }

        $order->load('order_items.product');

        return view('orders.show', compact('order'));
    }
}
