@extends('layouts.main-layout')

@section('page-title')
    {{ $appName }} | {{ __('Account') }}
@endsection

@section('header')@include('layouts.frontend.header')@endsection

@section('main-content')
    <div class="main-container">
        <section class="account_container ptb5 plr5">
            <p class="account-header">{{ $user->name }}, {{ __('its your account. Here you can change your account information and seen your exchange history.') }}</p>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="account-grid_container">
                <div class="account-form_container">
                    <p class="account-form-header">{{ __('Account Info') }}</p>
                    <form action="{{ route('user-frontend.update', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" required placeholder="{{ __('Name') }}" value="{{ $user->name ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="{{ __('Email') }}" value="{{ $user->email ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ __('Phone') }}</label>
                            <input type="tel" name="phone" id="phone" class="form-control" required placeholder="{{ __('Phone') }}" value="{{ $user->phone ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="wallet">{{ __('Default Wallet') }}</label>
                            <input type="text" name="wallet" id="wallet" class="form-control" required placeholder="{{ __('Default Wallet') }}" value="{{ $user->wallet ?? '' }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="account-form-button">{{ __('Save account information') }}</button>
                        </div>
                    </form>
                </div>
                <div class="account-history_container">
                    <p class="account-history-header">{{ __('Exchanges history') }}</p>
                    @foreach($user->orders as $order)
                        <div class="account-history-item">
                            <div class="account-history-item-currencies">
                                <p><img src="{{ Storage::url($order->fromImage) }}" alt=""> {{ $order->sum }} {{ $order->fromCode }}</p>
                                <hr>
                                <p><img src="{{ Storage::url($order->toImage) }}" alt=""> {{ $order->total }} {{ $order->toCode }}</p>
                            </div>
                            <div class="account-history-item-wallet">
                                <p>{{ __('Wallet:') }} {{ $order->wallet }}</p>
                            </div>
                            <div class="account-history-item-status">
                                <p>{{ __('Status:') }}
                                    @if($order->status === 0) <b>{{ __('Canceled') }}</b>
                                    @elseif($order->status === 1) <b>{{ __('Completed') }}</b>
                                    @elseif($order->status === 2) <b>{{ __('New') }}</b>
                                    @elseif($order->status === 3) <b>{{ __('Awaiting payment') }}</b>
                                    @elseif($order->status === 4) <b>{{ __('Paid, awaiting confirmation') }}</b>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection

@section('footer')@include('layouts.frontend.footer')@endsection
