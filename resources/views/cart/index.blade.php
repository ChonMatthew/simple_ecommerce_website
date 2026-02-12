@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

<h1>Your Cart</h1>

@if ($items->isEmpty())
    <p>Your cart is empty.</p>
@else
    <table border="1" cellpadding="4" cellspacing="0">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price each</th>
                <th>Quantity</th>
                <th>Line total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>${{ number_format($item->product->price, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.update', $item) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total:</strong> ${{ number_format($total, 2) }}</p>

    <form action="{{ route('checkout') }}" method="POST">
        @csrf
        <button type="submit">Checkout</button>
    </form>
@endif