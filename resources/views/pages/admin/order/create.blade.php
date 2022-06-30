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
                        <label for="from_currency_id">From Currency</label>
                        <select name="from_currency_id" id="from_currency_id" class="form-select" required>
                            <option value=null disabled>--- Select Currency ---</option>
                            @foreach($currencies as $currency)
                                <option value={{ $currency->id }}>{{ $currency->name }} | {{ $currency->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="to_currency_id">To Currency</label>
                        <select name="to_currency_id" id="to_currency_id" class="form-select" required>
                            <option value=null disabled>--- Select Currency ---</option>
                            @foreach($currencies as $currency)
                                <option value={{ $currency->id }}>{{ $currency->name }} | {{ $currency->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sum">Total</label>
                        <input type="number" name="sum" id="sum" class="form-control" placeholder="Total" required min="0" step="0.00001">
                    </div>
                    <div class="form-group">
                        <label for="user_id">User</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value=null disabled>--- Select User ---</option>
                            @foreach($users as $user)
                                <option @if($user->name === 'Guest') selected @endif value={{ $user->id }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value=null disabled>--- Select Status ---</option>
                            <option value=0>{{ __('Canceled') }}</option>
                            <option value=1>{{ __('Completed') }}</option>
                            <option value=2 selected>{{ __('New') }}</option>
                            <option value=3>{{ __('Awaiting payment') }}</option>
                            <option value=4>{{ __('Paid, awaiting confirmation') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Create</button>
                    </div>
                </form>
            </div>
    </section>
    </section>
@endsection
