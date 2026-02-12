<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index()
    {
        $featuredProducts = Product::query()
            ->latest()
            ->take(4)
            ->get();

        return view('index', [
            'featuredProducts' => $featuredProducts,
        ]);
    }
}

