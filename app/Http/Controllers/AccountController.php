<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Order;

class AccountController extends Controller
{
    /**
     * Display the authenticated user's account page.
     */
    public function show(): Response
    {
        $user = Auth::user();

        // Collects all orders tied to the user's id.
        $orders = Order::with('orderItems.product')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return Inertia::render('Account', [
            'user' => $user,
            'orders'=> $orders
        ]);
    }
}
