<h1>Order #{{ $order->id }}</h1>

@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

<p>Date: {{ $order->created_at->format('Y-m-d H:i') }}</p>
<p>Status: {{ $order->status }}</p>
<p>Total: ${{ number_format($order->total_price, 2) }}</p>

<h2>Items</h2>

@if ($order->orderItems->isEmpty())
    <p>No items for this order.</p>
@else
    <table border="1" cellpadding="4" cellspacing="0">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price each</th>
                <th>Quantity</th>
                <th>Line total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Deleted product' }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<p>
    <a href="{{ route('orders.index') }}">Back to orders</a>
</p>