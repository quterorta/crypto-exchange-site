@extends('layouts.main-layout')

@section('page-title')
    {{ $appName }} | Success
@endsection

@section('header')@include('layouts.frontend.header')@endsection

@section('main-content')
    <div class="main-container">
        <section class="success_container plr5 ptb5">
            <p class="exchange-form-header">{{ __('Ticket ID #') }} {{ $order->id }}</p>
            <p class="exchange-hint">
                <b><i class="fa-solid fa-triangle-exclamation"></i> {{ __('Attention!') }}</b>
                <br>
                {{ __('This operation is performed by the operator in manual mode and takes from 30 to 240 minutes during working hours.') }}
                <br>
                {{ __('If the exchange rate of the requested currency changes by more than 0.3% from the moment the application was created to the moment the currency arrives at the wallet, the final value can be recalculated! Payment for the exchange of stablecoins is made on request!') }}
            </p>
            <hr class="separator">
            <p class="success-step">
                {{ __('Step 1.') }} {{ __('Contact the operator using the online chat on the site.') }}
                <br>
                {{ __('To clarify payment details and details, tell the operator the application number and please go through a simple verification.') }}
            </p>
            <button class="success-button" type="button"><i class="fa-solid fa-headset"></i> {{ __('Online chat') }}</button>
            <p class="success-step">
                {{ __('Step 2.') }} {{ __('Confirm payment.') }}
                <br>
                {{ __('Make a payment and click the "I paid for the application" button.') }}
            </p>
            <p class="success-step">
                {{ __('Step 3.') }} {{ __('Wait exchange.') }}
            </p>
            <p class="success-sum">
                {{ __('Amount of payment:') }} {{ $order->sum }} {{ $order->fromCode }}
            </p>
            <p class="success-hint">
                <b>{{ __('Please pay attention!') }}</b><br>{{ __('All fields must be filled in according to the instructions, otherwise the payment may not go through.') }}
            </p>
            <p class="success-info">
                {{ __('Created At:') }} {{ $order->created_at }}
                <br>
                {{ __('Application status:') }}
                @if($order->status === 0) {{ __('Canceled') }}
                @elseif($order->status === 1) {{ __('Completed') }}
                @elseif($order->status === 2) {{ __('New') }}
                @elseif($order->status === 3) {{ __('Awaiting payment') }}
                @elseif($order->status === 4) {{ __('Paid, awaiting confirmation') }}
                @endif
            </p>
            <div class="success-buttons_container">
                <a class="success-button_cancel" href="{{ route('user-order.cancel', $order->id) }}">{{ __('Cancel order') }}</a>
                <div>
                    <button class="success-button" type="button"><i class="fa-solid fa-headset"></i> {{ __('Online chat') }}</button>
                    <a class="success-button_confirm" href="{{ route('user-order.confirm-payment', $order->id) }}">{{ __('I paid for the application') }}</a>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('footer')@include('layouts.frontend.footer')@endsection
