@extends('layouts.main-layout')

@section('page-title')AdminPanel | Add {{ $title }} @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Add {{ $title }}</li>
                    <li class="admin-navbar-link"><a href="{{ route('user.index') }}">All {{ $titleMany }}</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-form-container">
                <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('Email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">{{ __('Phone') }}</label>
                        <input type="tel" name="phone" id="phone" class="form-control" placeholder="{{ __('Phone') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="telegram">{{ __('Telegram') }}</label>
                        <input type="text" name="telegram" id="telegram" class="form-control" placeholder="{{ __('Telegram') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="wallet">{{ __('Wallet') }}</label>
                        <input type="text" name="wallet" id="wallet" class="form-control" placeholder="{{ __('Wallet') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input type="text" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Create</button>
                    </div>
                </form>
            </div>
    </section>
    </section>
@endsection
