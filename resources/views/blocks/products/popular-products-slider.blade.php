<div class="popular-products-slider">
    @foreach($popularProducts as $product)
        @include('blocks.products.product-card')
    @endforeach
</div>
