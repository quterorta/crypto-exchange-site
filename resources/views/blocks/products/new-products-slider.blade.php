<div class="new-products-slider">
    @foreach($newProducts as $product)
        @include('blocks.products.product-card')
    @endforeach
</div>
