@extends('layouts.main-layout')

@section('page-title')AdminPanel | Add {{ $title }} @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Add {{ $title }}</li>
                    <li class="admin-navbar-link"><a href="{{ route('order.index') }}">All {{ $titleMany }}</a></li>
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
                <form action="{{ route('order.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="from_currency_id">{{ __('From Currency') }}</label>
                        <select name="from_currency_id" id="from_currency_id" class="form-select" required>
                            <option value=null disabled>--- {{ __('Select Currency') }} ---</option>
                            @foreach($currencies as $currency)
                                <option value={{ $currency->id }}>{{ $currency->name }} | {{ $currency->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="to_currency_id">{{ __('To Currency') }}</label>
                        <select name="to_currency_id" id="to_currency_id" class="form-select" required>
                            <option value=null disabled>--- {{ __('Select Currency') }} ---</option>
                            @foreach($currencies as $currency)
                                <option value={{ $currency->id }}>{{ $currency->name }} | {{ $currency->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sum">{{ __('Sum') }}</label>
                        <input type="number" name="sum" id="sum" class="form-control" placeholder="{{ __('Sum') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="total">{{ __('Total') }}</label>
                        <input type="number" name="total" id="total" class="form-control" placeholder="{{ __('Total set automatically') }}">
                    </div>
                    <div class="form-group">
                        <label for="user_id">{{ __('User') }}</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value=null disabled>--- {{ __('Select User') }} ---</option>
                            @foreach($users as $user)
                                <option @if($user->name === 'Guest') selected @endif value={{ $user->id }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="wallet">{{ __('Wallet') }}</label>
                        <input type="text" name="wallet" id="wallet" class="form-control" placeholder="{{ __('Wallet') }}">
                    </div>
                    <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value=null disabled>--- {{ __('Select Status') }} ---</option>
                            <option value=0>{{ __('Canceled') }}</option>
                            <option value=1>{{ __('Completed') }}</option>
                            <option value=2 selected>{{ __('New') }}</option>
                            <option value=3>{{ __('Awaiting payment') }}</option>
                            <option value=4>{{ __('Paid, awaiting confirmation') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">{{ __('Create') }}</button>
                    </div>
                </form>
            </div>
    </section>
    </section>
@endsection
