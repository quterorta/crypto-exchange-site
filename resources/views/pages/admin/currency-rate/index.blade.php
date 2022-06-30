@extends('layouts.main-layout')

@section('page-title')AdminPanel | {{ $title }} @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">All {{ $title }}</li>
                    <li class="admin-navbar-link">
                        <a href="{{ route('currency-rate.create') }}">Add</a>
                        <a href="{{ route('update-currency-rates') }}">Update all rates</a>
                    </li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-items-list_container">
                @foreach($currencyRates as $currencyRate)
                    <div class="admin-list_item">
                        <div class="admin-list_item-id_container">
                            <p>#{{ $currencyRate->id }}</p>
                        </div>
                        <div class="admin-list_item-currency_container">
                            <a href="{{ route('currency.edit', $currencyRate->getFromCurrency()->id) }}">
                                <img src="{{ Storage::url($currencyRate->getFromCurrency()->image) }}" alt=""> | {{ $currencyRate->getFromCurrency()->name }} | {{ $currencyRate->getFromCurrency()->code }}
                            </a>
                        </div>
                        <div class="admin-list_item-currency_container">
                            <a href="{{ route('currency.edit', $currencyRate->getToCurrency()->id) }}">
                                <img src="{{ Storage::url($currencyRate->getToCurrency()->image) }}" alt=""> | {{ $currencyRate->getToCurrency()->name }} | {{ $currencyRate->getToCurrency()->code }}
                            </a>
                        </div>
                        <div class="admin-list_item-reserve_container"><p><b>Reserve:</b><br>{{ round($currencyRate->reserve, 2) }}</p></div>
                        <div class="admin-list_item-rate_container"><p><b>Rate:</b><br>{{ round($currencyRate->rate, 8) }}</p></div>
                        <div class="admin-item-control">
                            <ul>
                                <li><a class="admin-item-control-edit" href="{{ route('currency-rate.edit', $currencyRate->id) }}"><i class="bi bi-pencil-fill"></i></a></li>
                                <li><form action="{{ route('currency-rate.destroy', $currencyRate->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn admin-item-control-delete" data-title="#{{ $currencyRate->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </section>
@endsection
