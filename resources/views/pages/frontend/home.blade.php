@extends('layouts.main-layout')

@section('page-title')
    Home
@endsection

@section('header')@include('layouts.frontend.header')@endsection

@section('main-content')
<div class="main-container">

    <section class="hint_container">
        <p class="hint">{{ __('When creating an application from 500,000 rubles - a cashback of 1,000 rubles to your card!') }}</p>
    </section>

    <section class="exchange_container">
        <div class="exchange-pills_container">
            @foreach($currencies as $currency)
                @if($currency->hasExchangeRates())
                    <button class="exchange-button @if($loop->first) active @endif" data-currency="{{ $currency->code }}">
                        <img src="{{ Storage::url($currency->image) }}" alt="">{{ $currency->name }}
                    </button>
                @endif
            @endforeach
        </div>
        <div class="exchange-info_container">
            <table class="exchange-rate_info-table">
                <tr class="exchange-rate_info-table-header_row">
                    <th class="exchange-rate_info-table-header exchange-rate_info-table-header_give">{{ __('Give') }}</th>
                    <th class="exchange-rate_info-table-header exchange-rate_info-table-header_rate">{{ __('Rate') }}</th>
                    <th class="exchange-rate_info-table-header exchange-rate_info-table-header_reserve">{{ __('Reserve') }}</th>
                    <th class="exchange-rate_info-table-header exchange-rate_info-table-header_button"></th>
                </tr>
                @foreach($currencies as $currency)
                    @if($currency->getExchangeRates())
                        @if(is_iterable($currency->getExchangeRates()))
                            @foreach($currency->getExchangeRates() as $cur)
                                <tr class="exchange-rate_info-table-item_row exchange-rate_info" data-parent-currency="{{ $cur['from'] }}">
                                    <td class="exchange-rate_info-table-item_give"><img src="{{ Storage::url($cur['toImage']) }}" alt="">{{ $cur['to'] }}</td>
                                    <td class="exchange-rate_info-table-item_rate">{{ round($cur['rate'], 5) }}</td>
                                    <td class="exchange-rate_info-table-item_reserve">{{ $cur['reserve'] }}</td>
                                    <td class="exchange-rate_info-table-item_button">
                                        <button type="button" class="exchange-order-button">
                                            <span class="exchange-order-button-text">+</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="exchange-rate_info-table-item_row exchange-rate_info" data-parent-currency="{{ $cur['from'] }}">
                                <td class="exchange-rate_info-table-item_give"><img src="{{ Storage::url($cur['toImage']) }}" alt="">{{ $cur['to'] }}</td>
                                <td class="exchange-rate_info-table-item_rate">{{ round($cur['rate'], 5) }}</td>
                                <td class="exchange-rate_info-table-item_reserve">{{ $cur['reserve'] }}</td>
                                <td class="exchange-rate_info-table-item_button">
                                    <button type="button" class="exchange-order-button">
                                        <span class="exchange-order-button-text">+</span>
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            </table>
        </div>
    </section>

    <section class="steps_container plr5 ptb5">
        <div class="steps-text_container">
            <p class="steps-header block_header">{{ __('How to make a cryptocurrency exchange on site?') }}</p>
            <p class="steps-regular">
                {{ __('Before making an exchange, we recommend that you read the exchange instructions below. If something is not clear to you, then write to the ') }}
                <a href="#">{{ __('online chat') }}</a>
                {{__('to the operator during business hours or to our mail:')}}
                <a href="">obmen@grambit.net</a>
            </p>
        </div>
        <div class="steps-list_container">
            <div class="steps-list_item">
                <div class="steps-list_item-number_container">
                    <p class="steps-list_item-number">1</p>
                </div>
                <div class="steps-list_item-text_container">
                    <p>{{ __('Choose the one to give and received currency') }}</p>
                </div>
            </div>
            <div class="steps-list_item">
                <div class="steps-list_item-number_container">
                    <p class="steps-list_item-number">2</p>
                </div>
                <div class="steps-list_item-text_container">
                    <p>{{ __('Specify the wallet number or account on which you want to receive funds') }}</p>
                </div>
            </div>
            <div class="steps-list_item">
                <div class="steps-list_item-number_container">
                    <p class="steps-list_item-number">3</p>
                </div>
                <div class="steps-list_item-text_container">
                    <p>{{ __('Enter your E-mail and confirm that you read the terms of service') }}</p>
                </div>
            </div>
            <div class="steps-list_item">
                <div class="steps-list_item-number_container">
                    <p class="steps-list_item-number">4</p>
                </div>
                <div class="steps-list_item-text_container">
                    <p>{{ __('Make a payment and click "I paid" button') }}</p>
                </div>
            </div>
            <div class="steps-list_item">
                <div class="steps-list_item-number_container">
                    <p class="steps-list_item-number">5</p>
                </div>
                <div class="steps-list_item-text_container">
                    <p>{{ __('Write to the operator online chat, he will confirm the receipt of funds') }}</p>
                </div>
            </div>
            <div class="steps-list_item">
                <div class="steps-list_item-number_container">
                    <p class="steps-list_item-number">6</p>
                </div>
                <div class="steps-list_item-text_container">
                    <p>{{ __('Wait for the exchange, the funds will arrive within 5 minutes') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="history gb-3">
        <div class="history-last_exchange_container">
            <p class="history-last_exchange_header">{{ __('Last exchanges') }} <a href="#"><i class="fa-solid fa-circle-plus"></i></a></p>
            <div class="history-last_exchange-list_container">
                @foreach($orders as $order)
                    <div class="history-last_exchange-list_item">
                        <img src="{{ Storage::url($order->fromImage) }}" alt="">
                        <p><b>{{ round($order->sum, 2) }} {{ $order->fromCode }}</b><br>{{ $order->created_at }}</p>
                        <img src="{{ Storage::url($order->toImage) }}" alt="">
                    </div>
                @endforeach
            </div>
        </div>
        <div class="history-last_review_container">
            <p class="history-last_review_header">{{ __('Last reviews') }} <a href="#"><i class="fa-solid fa-circle-plus"></i></a></p>
            <div class="history-last_review-list_container">
                @foreach($reviews as $review)
                    <div class="history-last_review-list_item">
                        <p class="history-last_review-list_item-user">{{ $review->user->name }} <i>{{ $review->created_at }}</i></p>
                        <p class="history-last_review-list_item-text">{{ $review->text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="history-reserve_container">
            <p class="history-reserve_header">{{ __('Our reserves') }}</p>
            <div class="history-reserve-list_container">
                @foreach($currencyRates as $currencyRate)
                    <div class="history-reserve-list_item">
                        <div class="history-reserve-list_item-rate">
                            <div class="history-reserve-list_item-rate_from">
                                <img src="{{ Storage::url($currencyRate->getFromCurrency()->image) }}" alt=""> {{ $currencyRate->getFromCurrency()->code }}
                            </div>
                            <hr>
                            <div class="history-reserve-list_item-rate_to">
                                {{ $currencyRate->getToCurrency()->code }} <img src="{{ Storage::url($currencyRate->getToCurrency()->image) }}" alt="">
                            </div>
                        </div>
                        <div class="history-reserve-list_item-reserve">
                            <p>{{ round($currencyRate->reserve, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</div>
<!-- pills script -->
<script>
    $(document).ready(function () {
        let parentRate = null;

        parentRate = getParentRate();

        hideBlocks(parentRate);

        $('.exchange-button').click(function () {
            clickButton($(this))
        });

        function getParentRate() {
            $('.exchange-button').each(function () {
                if ($(this).hasClass('active')) {
                    parentRate = $(this).data('currency');
                }
            });
            return parentRate;
        }

        function clickButton(element) {
            if (!element.hasClass('active')) {
                removeActiveClass();
                parentRate = element.data('currency');
                element.addClass('active');
                showBlocks(parentRate);
            }
        }

        function removeActiveClass() {
            $('.exchange-button').each(function () {
                if ($(this).hasClass('active')) {
                    parentRate = $(this).removeClass('active');
                }
            });
        }

        function hideBlocks(parentRate) {
            $('.exchange-rate_info').each(function () {
                if (parentRate != null && $(this).data('parent-currency') !== parentRate) {
                    $(this).hide();
                }
            });
        }

        function showBlocks(parentRate) {
            hideBlocks(parentRate);
            $('.exchange-rate_info').each(function () {
                if (parentRate != null && $(this).data('parent-currency') === parentRate) {
                    $(this).show(100);
                }
            });
        }
    });
</script>
@endsection

@section('footer')@include('layouts.frontend.footer')@endsection
