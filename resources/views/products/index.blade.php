@foreach ($products as $product)
  <div>
    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
    <div>${{ $product->price }}</div>
  </div>
  <form action="{{ route('cart.store') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="number" name="quantity" value="1" min="1">
    <button type="submit">Add to cart</button>
  </form>
@endforeach