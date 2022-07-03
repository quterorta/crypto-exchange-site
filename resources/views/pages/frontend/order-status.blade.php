@extends('layouts.main-layout')

@section('page-title')
    {{ $appName }} | Success
@endsection

@section('header')@include('layouts.frontend.header')@endsection

@section('main-content')
    <div class="main-container">
        <section class="order-status-container">
            <p class="order-status-message">{{ $message }}</p>
            <a class="order-status-link" href="{{ route('home') }}">{{ __('Return to main page') }}</a>
        </section>
    </div>
@endsection

@section('footer')@include('layouts.frontend.footer')@endsection
