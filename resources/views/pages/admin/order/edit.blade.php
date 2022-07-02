@extends('layouts.main-layout')

@section('page-title')AdminPanel | Edit {{ $title }} @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Edit {{ $title }} #{{ $order->id }}</li>
                    <li class="admin-navbar-link"><a href="{{ route('order.index') }}">All {{ $titleMany }}</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-form-container">
                <form action="{{ route('order.update', $order->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="from_currency_id">{{ __('From Currency') }}</label>
                        <select name="from_currency_id" id="from_currency_id" class="form-select" required>
                            <option value=null disabled>--- {{ __ ('Select Currency') }} ---</option>
                            @foreach($currencies as $currency)
                                <option @if($order->from_currency_id === $currency->id) selected @endif value={{ $currency->id }}>
                                    {{ $currency->name }} | {{ $currency->code }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="to_currency_id">{{ __('To Currency') }}</label>
                        <select name="to_currency_id" id="to_currency_id" class="form-select" required>
                            <option value=null disabled>--- {{ __('Select Currency') }} ---</option>
                            @foreach($currencies as $currency)
                                <option @if($order->to_currency_id === $currency->id) selected @endif value={{ $currency->id }}>
                                    {{ $currency->name }} | {{ $currency->code }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sum">{{ __('Sum') }}</label>
                        <input type="number" name="sum" id="sum" class="form-control" placeholder="{{ __('Sum') }}" value="{{ $order->sum }}" required min="0" step="0.00001">
                    </div>
                    <div class="form-group">
                        <label for="total">{{ __('Total') }}</label>
                        <input type="number" name="total" id="total" class="form-control" placeholder="{{ __('Total') }}" value="{{ $order->total ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="user_id">{{ __('User') }}</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value=null disabled>--- {{ __('Select User') }} ---</option>
                            @foreach($users as $user)
                                <option @if($order->user_id === $user->id) selected @endif value={{ $user->id }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="wallet">{{ __('Wallet') }}</label>
                        <input type="text" name="wallet" id="wallet" class="form-control" placeholder="{{ __('Wallet') }}" required value="{{ $order->wallet ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('Email') }}" required value="{{ $order->email ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">{{ __('Phone') }}</label>
                        <input type="tel" name="phone" id="phone" class="form-control" placeholder="{{ __('Phone') }}" required value="{{ $order->phone ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value=null disabled>--- {{ __('Select Status') }} ---</option>
                            <option @if($order->status === 0) selected @endif value=0>{{ __('Canceled') }}</option>
                            <option @if($order->status === 1) selected @endif value=1>{{ __('Completed') }}</option>
                            <option @if($order->status === 2) selected @endif value=2>{{ __('New') }}</option>
                            <option @if($order->status === 3) selected @endif value=3>{{ __('Awaiting payment') }}</option>
                            <option @if($order->status === 4) selected @endif value=4>{{ __('Paid, awaiting confirmation') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">{{ __('Edit') }}</button>
                    </div>
                </form>
            </div>
        </section>
    </section>
    @include('components.admin.modal.currency-search')
@endsection
