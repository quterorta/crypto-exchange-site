@extends('layouts.main-layout')

@section('page-title')
    Home
@endsection

@section('header')@include('layouts.frontend.header')@endsection

@section('main-content')

    <section class="search-result block-ptb-5 block-plr-5">
        <p class="search-result-header block_header">Rezultatele căutării pentru interogare: {{ $searchRequest }}</p>
        <div class="search-result-products products gb-4">
            @foreach($products as $product)
                @include('blocks.products.product-card')
            @endforeach
        </div>
        <div class="shop_page__paginate">
            {{ $products->appends(Request::input())->links('layouts.pagination.paginate') }}
        </div>
    </section>

@endsection

@section('footer')@include('layouts.frontend.footer')@endsection
