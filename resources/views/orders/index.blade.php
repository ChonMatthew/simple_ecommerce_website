
    <h1>My Orders</h1>

    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if ($orders->isEmpty())
        <p>You have no orders yet.</p>
    @else
        <ul>
            @foreach ($orders as $order)
                <li>
                    <a href="{{ route('orders.show', $order) }}">
                        Order #{{ $order->id }}
                    </a>
                    – {{ $order->created_at->format('Y-m-d H:i') }}
                    – Status: {{ $order->status }}
                    – Total: ${{ number_format($order->total_price, 2) }}
                </li>
            @endforeach
        </ul>
    @endif
