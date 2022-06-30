@extends('layouts.main-layout')

@section('page-title')
    Produse MED-EL
@endsection

@section('header')@include('layouts.frontend.header')@endsection

@section('main-content')
    <div class="all-products-main block-plr-5 block-ptb-5">
        <div class="filters">
            <a href="{{ route('all-products') }}" class="delete-filters">Scoateți toate filtrele</a>
            <form action="" id="specificationsForm">
                <div class="filter-input-block">
                    <p class="filter-header">Categorii</p>
                    <div class="filter-values">
                        @foreach($categoriesForMenu as $category)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="category_input_{{ $category->id }}"
                                       value="{{ $category->id }}"
                                       name="productCategories[]"
                                       @if (Request::input('productCategories') && in_array($category->id, array_values(Request::input('productCategories')))) checked @endif>
                                <label class="form-check-label" for="category_input_{{ $category->id }}">{{ $category->title }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="filter-input-block">
                    <div class="filter-values">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="in_stock"
                                   value="1"
                                   name="in_stock"
                                   @if (Request::input('in_stock') && Request::input('in_stock') == 1) checked @endif>
                                <label class="form-check-label" for="in_stock">Doar in stoc</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="popular_input"
                                   value="1"
                                   name="popular_input"
                                   @if (Request::input('popular_input') && Request::input('popular_input') == 1) checked @endif>
                            <label class="form-check-label" for="popular_input">Doar popular</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="new_input"
                                   value="1"
                                   name="new_input"
                                   @if (Request::input('new_input') && Request::input('new_input') == 1) checked @endif>
                            <label class="form-check-label" for="new_input">Numai nou</label>
                        </div>
                    </div>
                </div>
                @foreach($specifications as $specification)
                    <div class="filter-input-block">
                        <p class="filter-header">{{ $specification->title }}@if($specification->dimension), {{$specification->dimension}}@endif</p>
                        <div class="filter-values">
                            @foreach($specification->specification_values->unique('value') as $value)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="specification_input_{{ $value->id }}"
                                           value="{{ $value->value }}"
                                           name="{{ $specification->title }}[]"
                                           @if (Request::input(str_replace(' ', '_', $specification->title)) && in_array($value->value, array_values(Request::input(str_replace(' ', '_', $specification->title))))) checked @endif>
                                    <label class="form-check-label" for="specification_input_{{ $value->id }}">{{ $value->value }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </form>
        </div>
        <div class="products-section">
            <div class="sort-section">
                <div class="product-sort-dropdown">
                    <span>Sortați produsele</span>
                    <div class="dropdown-content">
                        <input type="text" id="sortType" name="sort_type" hidden readonly form="specificationsForm">
                        <button class="dropdown-button @if (Request::input('sort_type') && Request::input('sort_type') == 'sort_by_name_asc') active @endif" type="button" data-sort_type="sort_by_name_asc">Nume: ascendent</button>
                        <button class="dropdown-button @if (Request::input('sort_type') && Request::input('sort_type') == 'sort_by_name_desc') active @endif" type="button" data-sort_type="sort_by_name_desc">Nume: descendent</button>
                        <button class="dropdown-button @if (Request::input('sort_type') && Request::input('sort_type') == 'sort_by_price_asc') active @endif" type="button" data-sort_type="sort_by_price_asc">Pret: ascendent</button>
                        <button class="dropdown-button @if (Request::input('sort_type') && Request::input('sort_type') == 'sort_by_price_desc') active @endif" type="button" data-sort_type="sort_by_price_desc">Pret: descendent</button>
                        <button class="dropdown-button @if (Request::input('sort_type') && Request::input('sort_type') == 'sort_by_date_acs') active @endif" type="button" data-sort_type="sort_by_date_acs">Mai întâi cei vechi</button>
                        <button class="dropdown-button @if (Request::input('sort_type') && Request::input('sort_type') == 'sort_by_date_desc') active @endif" type="button" data-sort_type="sort_by_date_desc">Cele noi mai întâi</button>
                    </div>
                </div>
                <div class="products-paginate-section">
                    {{ $products->appends(Request::input())->links('layouts.pagination.simple-paginate') }}
                </div>
            </div>
            <div class="products gb-4">
                @foreach($products as $product)
                    @include('blocks.products.product-card')
                @endforeach
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.dropdown-button').click(function () {
                let sortType = $(this).data('sort_type');
                $('#sortType').val(sortType);
                $('#specificationsForm').submit();
            });
            $('.form-check-input').click(function () {
                $('#specificationsForm').submit();
            });
        });
    </script>
@endsection

@section('footer')@include('layouts.frontend.footer')@endsection
