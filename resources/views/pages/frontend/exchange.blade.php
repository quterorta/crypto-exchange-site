@extends('layouts.main-layout')

@section('page-title')
    {{ $appName }} | Exchange
@endsection

@section('header')@include('layouts.frontend.header')@endsection

@section('main-content')
<div class="main-container">
    <section class="exchange-form_container plr5 ptb5">
        <p class="exchange-form-header">{{ __('Applying request for exchange') }}</p>
        <p class="exchange-hint">
            <b><i class="fa-solid fa-triangle-exclamation"></i> {{ __('Attention!') }}</b>
            <br>
            {{ __('This operation is performed by the operator in manual mode and takes from 30 to 240 minutes during working hours.') }}
            <br>
            {{ __('If the exchange rate of the requested currency changes by more than 0.3% from the moment the application was created to the moment the currency arrives at the wallet, the final value can be recalculated! Payment for the exchange of stablecoins is made on request!') }}
        </p>
        <hr class="separator">
        <form class="exchange-form" action="{{ route('user-order.store') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="form-group">
                <label for="from_currency_id" class="big_label">{{ __('Give') }} <i class="fa-solid fa-right-long"></i></label>
                <div class="exchange-form-flex_container">
                    <select name="from_currency_id" id="from_currency_id" class="form-control form-select main_form-select"></select>
                    <div class="number-flex_container">
                        <label for="sum" class="small_label">{{ __('Amount:') }}</label>
                        <input type="number" class="custom-input" required name="sum" id="sum">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="wallet" class="small_label mt2">{{ __('From wallet (for AML validation)') }}</label>
                <input type="text" name="wallet" id="wallet" class="custom-input form-control" required value="{{ $user->wallet ?? '' }}">
            </div>
            <div class="form-group">
                <label for="to_currency_id" class="big_label">{{ __('Receive') }} <i class="fa-solid fa-left-long"></i></label>
                <div class="exchange-form-flex_container">
                    <select name="to_currency_id" id="to_currency_id" class="form-control form-select main_form-select"></select>
                    <div class="number-flex_container">
                        <label for="total" class="small_label">{{ __('Amount:') }}</label>
                        <input type="text" class="custom-input" name="total" id="total" required>
                    </div>
                </div>
            </div>
            <div class="form-group small">
                <label for="email" class="small_label mt2">{{ __('Email') }}</label>
                <input type="email" name="email" id="email" class="form-control custom-input" required value="{{ $user->email ?? '' }}">
            </div>
            <div class="form-group small">
                <label for="phone" class="small_label mt2">{{ __('Phone') }}</label>
                <input type="tel" name="phone" id="phone" class="form-control custom-input" required value="{{ $user->phone ?? '' }}">
            </div>
            <div class="form-group small">
                <label for="telegram" class="small_label mt2">{{ __('Telegram') }}</label>
                <input type="text" name="telegram" id="telegram" class="form-control custom-input" required value="{{ $user->telegram ?? '' }}">
            </div>
            <div class="form-group">
                <button class="exchange-form-button" type="submit">{{ __('Apply') }}</button>
            </div>
        </form>
    </section>
</div>
@endsection

@section('footer')@include('layouts.frontend.footer')@endsection
@section('additional-script')
<script>
    $(document).ready(function () {
        let data = [
            @foreach($currencies as $currency)
                {
                    id: {{ $currency->id }},
                    text: '<div class="select-card"><div class="select-card-from select-card-currency"><img src="{{ Storage::url($currency->image) }}" alt=""><span>{{ $currency->name }} {{ $currency->code }}</span></div></div>',
                    html: '<div class="select-card"><div class="select-card-from select-card-currency"><img src="{{ Storage::url($currency->image) }}" alt=""><span>{{ $currency->name }} {{ $currency->code }}</span></div></div>'
                }@if(!$loop->last),@endif
            @endforeach
        ];
        $('.main_form-select').select2({
            data: data,
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: function (data) {
                return data.html;
            },
            templateSelection: function (data) {
                return data.text;
            },
            minimumResultsForSearch: Infinity
        });
        @if($request->give)
        @foreach($currencies as $currency)
        @if($request->give === $currency->code)
        $('#from_currency_id').val({{ $currency->id }});
        $('#from_currency_id').trigger('change');
        @endif
        @endforeach
        @endif
        @if($request->receive)
        @foreach($currencies as $currency)
        @if($request->receive === $currency->code)
        $('#to_currency_id').val({{ $currency->id }});
        $('#to_currency_id').trigger('change');
        @endif
        @endforeach
        @endif
        $('#to_currency_id, #sum, #from_currency_id').change(function () {
            $.ajax({
                url: "{{ route('get-rate-frontend') }}",
                type: "POST",
                data: {
                    'from': $('#from_currency_id').val(),
                    'to': $('#to_currency_id').val(),
                    'sum': $('#sum').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                },
                success: (data) => {
                    $('#total').empty();
                    $('#total').val(data);
                },
                error: (data) => {
                    console.log(data)
                },
                dataType: "json"
            });
        });
    });
</script>
@endsection
