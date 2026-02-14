<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
        ]);

        $products = Product::query()
            ->when(! empty($validated['q'] ?? null), function ($query) use ($validated) {
                $term = $validated['q'];
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->get();

        return Inertia::render('Shop', [
            'products' => $products,
            'filters' => [
                'q' => $validated['q'] ?? null,
            ],
        ]);
    }

    public function show(Product $product): Response
    {
        return Inertia::render('Product', [
            'product' => $product,
        ]);
    }
}
