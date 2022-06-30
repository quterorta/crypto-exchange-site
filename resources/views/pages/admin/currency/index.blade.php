@extends('layouts.main-layout')

@section('page-title')AdminPanel | {{ $title }} @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">All {{ $title }}</li>
                    <li class="admin-navbar-link"><a href="{{ route('currency.create') }}">Add</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-items-container g5">
                @foreach($currencies as $currency)
                    <div class="admin-item">
                        <div class="admin-item-image">
                            <a href="{{ route('currency.edit', $currency->id) }}">
                                <img src="{{ Storage::url($currency->image) }}" alt="">
                            </a>
                        </div>
                        <a class="admin-item-header-link" href="{{ route('currency.edit', $currency->id) }}">{{ $currency->name }}</a>
                        <a class="admin-item-header-link" href="{{ route('currency.edit', $currency->code) }}">Code: {{ $currency->code }}</a>
                        <div class="admin-item-control">
                            <ul>
                                <li><a class="admin-item-control-edit" href="{{ route('currency.edit', $currency->id) }}"><i class="bi bi-pencil-fill"></i></a></li>
                                <li><form action="{{ route('currency.destroy', $currency->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn admin-item-control-delete" data-title="{{ $currency->name }}">
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
