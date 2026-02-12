{{-- resources/views/products/index.blade.php --}}
@foreach ($products as $product)
  <div>
    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
    <div>${{ $product->price }}</div>
  </div>
@endforeach