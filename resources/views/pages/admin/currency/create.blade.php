@extends('layouts.main-layout')

@section('page-title')AdminPanel | Add {{ $title }} @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Add {{ $title }}</li>
                    <li class="admin-navbar-link"><a href="{{ route('currency.index') }}">All {{ $titleMany }}</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-form-container">
                <form action="{{ route('currency.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Title</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <label for="code">
                            {{ __('Currency Code') }}
                            <i class="fa-solid fa-circle-info" style="cursor:pointer;" title="{{ __('Currency code for getting exchange rates by API. If you dont know needed code, use Search code') }}"></i>
                        </label>
                        <button class="search-currency-admin-button" type="button" data-bs-toggle="modal" data-bs-target="#currencyCodeModal">
                            {{ __('Search code') }}
                        </button>
                        <input type="text" name="code" id="code" class="form-control" placeholder="Currency Code" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image (Icon)</label>
                        <img src="" alt="" id="admin-item-image-preview">
                        <input type="file" name="image" id="image" class="form-control admin-item-image-input" placeholder="Image">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Create</button>
                    </div>
                </form>
            </div>
        </section>
    </section>
    @include('components.admin.modal.currency-search')
@endsection
