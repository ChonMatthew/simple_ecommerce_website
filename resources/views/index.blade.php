<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Simple Store</title>
</head>
<body>
    <header>
        <h1>Simple E-Commerce Store</h1>
        <p>One-Stop Shop</p>
        <p>
            <a href="{{ route('products.index') }}">Shop now</a>
        </p>
    </header>

    <main>
    <section>
            <h2>Featured products</h2>

            @if ($featuredProducts->isEmpty())
                <p>No featured products yet. <a href="{{ route('products.index') }}">View all products</a></p>
            @else
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    @foreach ($featuredProducts as $product)
                        <div style="border: 1px solid #ccc; padding: 1rem; width: 200px;">
                            <h3>{{ $product->name }}</h3>
                            <p>${{ number_format($product->price, 2) }}</p>
                            <p>
                                <a href="{{ route('products.show', $product) }}">View</a>
                            </p>
                        </div>
                    @endforeach
                </div>

                <p style="margin-top: 1rem;">
                    <a href="{{ route('products.index') }}">View all products</a>
                </p>
            @endif
        </section>
    </main>
</body>
</html>