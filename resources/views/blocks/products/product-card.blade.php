<div class="product-card">
    <div class="favorite-product-badge-container">
        <button type="button" class="add-to-favorite-min favorite-product-badge" data-product="{{ $product->id }}"></button>
    </div>
    <div class="product-card-image-container">
        <div class="product-card-image-container-slick">
            @foreach($product->images as $image)
                <a href="{{ route('product-detail', $product->slug) }}">
                    <img class="product-card-image-container-slick-image" src="{{ Storage::url($image->image_path) }}" alt="">
                </a>
            @endforeach
        </div>
    </div>
    <div class="product-card-title-container">
        <a href="{{ route('product-detail', $product->slug) }}" class="product-card-title">{{ $product->title }}</a>
    </div>
    @if($product->manufacturer)
    <div class="product-card-manufacturer-container">
        <img class="product-card-manufacturer" src="{{ Storage::url($product->manufacturer->image) }}" alt="">
    </div>
    @endif
    <div class="product-card-price-container">
        <p class="product-card-price">{{ $product->price }} MDL</p>
    </div>
    <div class="product-card-button-container">
        <a href="{{ route('product-detail', $product->slug) }}" class="product-card-button">Mai multe</a>
    </div>
</div>
