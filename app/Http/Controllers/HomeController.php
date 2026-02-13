<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index(): \Inertia\Response
    {
        // Shows the 4 latest products added
        $featuredProducts = Product::query()
            ->latest()
            ->take(4)
            ->get();

        return Inertia::render('Home', [
            'featuredProducts' => $featuredProducts,
        ]);
    }
}
