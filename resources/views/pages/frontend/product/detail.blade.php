@extends('layouts.main-layout')

@section('page-title')
    {{ $product->title }}
@endsection

@section('meta-tags')
    <meta name="description" content="{{ $product->seo_description }}">
    <meta property="og:image" content="{{ Storage::url($product->images->first()->image_path) }}">
    <meta property="og:title" content="{{ $product->seo_title }}">
    <meta property="og:description" content="{{ $product->seo_description }}">
    <meta name="keywords" content="{{ $product->seo_keywords }}">
@endsection

@section('header')@include('layouts.frontend.header')@endsection

@section('main-content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <section class="main-product-content block-plr-5 block-ptb-5">
        <div class="main-product-content-grid">
            <div class="main-product-content-grid-gallery">
                <h1 class="main-product-content-grid-gallery-header">{{ $product->title }}</h1>
                <div class="product-detail-slick">
                    @foreach($product->images as $image)
                        <img class="product-detail-slick-image" src="{{ Storage::url($image->image_path) }}" alt="">
                    @endforeach
                </div>
                <div class="product-detail-nav-slick">
                    @foreach($product->images as $image)
                        <img class="product-detail-nav-slick-image" src="{{ Storage::url($image->image_path) }}" alt="">
                    @endforeach
                </div>
            </div>

            <div class="main-product-content-grid-text">
                <div class="product-detail-manufacturer-container">
                    <p class="product-detail-manufacturer">Producător: <a href="{{ $product->manufacturer->url }}">{{ $product->manufacturer->title }}</a></p>
                    <a href="{{ $product->manufacturer->url }}"><img src="{{ Storage::url($product->manufacturer->image) }}" alt=""></a>
                </div>
                @if($product->in_stock)
                    <p class="product-detail-stock product-detail-in-stock">Disponibilitate: In stoc</p>
                @else
                    <p class="product-detail-stock product-detail-out-of-stock">Nu e disponibil</p>
                @endif
                <p class="product-detail-adv">
                    @if($product->popular)<span class="product-detail-adv-popular">Popular</span>@endif
                    @if($product->new_to_date > \Carbon\Carbon::now()->toDateString())<span class="product-detail-adv-new">Nou</span>@endif
                </p>
                <p class="product-detail-price">{{ $product->price }} MDL</p>
                <button class="product-detail-wishlist add-to-favorite" data-product="{{ $product->id }}">Adaugă la favorite <i class="fa-solid fa-heart"></i></button>
                <a href="tel:+3731111111" class="product-detail-buy">+3731111111</a>
            </div>
        </div>
        <div class="product-detail-description">
            <p class="product-detail-description-header">Descrierea produsului</p>
            <p class="product-detail-description-text">{{ $product->description }}</p>
        </div>
        <div class="product-detail-specifications">
            <p class="product-detail-specifications-header">Caracteristicile produsului</p>
            @foreach($product->specifications as $specification)
                <p class="product-detail-specifications-values">
                    <b>{{ $specification->title }}:</b> {{ $specification->specification_values->first()->value }}@if($specification->dimension), {{ $specification->dimension }}@endif
                </p>
            @endforeach
        </div>
        <div class="product-detail-contact-form">
            <p class="product-detail-contact-form-header">Pune o intrebare</p>
            <form action="{{ route('product-contact-form') }}" method="POST">
                @csrf
                <input type="text" name="productId" readonly hidden value="{{ $product->id }}">
                <div class="form-group">
                    <label for="name">Nume</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Nume" value="{{ old('name') ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="phone">Telefon</label>
                    <input type="tel" name="phone" id="phone" class="form-control" required placeholder="Telefon" value="{{ old('phone') ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="comment">Un comentariu</label>
                    <textarea name="comment" id="comment" rows="3" class="form-control">{{ old('comment') ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <button class="submit-button" type="submit">Trimite</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            $('.product-detail-slick').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                asNavFor: '.product-detail-nav-slick',
            });
            $('.product-detail-nav-slick').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                asNavFor: '.product-detail-slick',
                centerMode: true,
                focusOnSelect: true
            });
        });
    </script>
@endsection

@section('footer')@include('layouts.frontend.footer')@endsection
