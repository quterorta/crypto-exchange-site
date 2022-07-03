<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public const RATE_API_URL = 'https://api.binance.com/api/v3/ticker/price';
    public const RATE_WITH_SYMBOL_API_URL = 'https://api.binance.com/api/v3/ticker/price?symbol=';
    public const RATE_WITH_SYMBOLS_API_URL = 'https://api.binance.com/api/v3/ticker/price?symbols=';
    public const CURRENCIES_API_URL = 'https://api.coingecko.com/api/v3/exchange_rates';
    public const SEARCH_CURRENCIES_API_URL = 'https://api.coingecko.com/api/v3/search';
    public const BIT_PAY_API_URL = 'https://bitpay.com/rates/';
    public const OPEN_ARRAY_BRACKET = '%5B';
    public const CLOSE_ARRAY_BRACKET = '%5D';
    public const QUOTES = '%22';

    private $currencyRateModel;

    public function __construct(
        CurrencyRate $currencyRateModel
    ) {
        $this->currencyRateModel = $currencyRateModel;
    }

    public function adminBase()
    {
        return view('pages.admin.admin-home');
    }

    public function searchCurrencyView(Request $request)
    {
        $q = $request->q;

        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->get(self::SEARCH_CURRENCIES_API_URL);

        $rates = json_decode($response, true)['coins'];

        $data = [];
        foreach ($rates as $rate) {
            if (stripos($rate['id'], $q) !== false || stripos($rate['name'], $q) !== false || stripos($rate['symbol'], $q) !== false) {
                $currency = [
                    'name' => $rate['name'],
                    'code' => $rate['symbol'],
                ];
                $data[] = $currency;
            }
        }

        return response()->json($data);
    }

    public function updateCurrencyRates()
    {
        $currencyRates = CurrencyRate::all();

        foreach ($currencyRates as $currencyRate) {
            if (Currency::find($currencyRate->from_currency_id)->exists() &&
                Currency::find($currencyRate->to_currency_id)->exists()
            ) {
                $from = Currency::find($currencyRate->from_currency_id);
                $to = Currency::find($currencyRate->to_currency_id);
                $rate = $this->currencyRateModel->getRate($from, $to);
                $currencyRate->rate = $rate;
                $currencyRate->save();
            }
        }

        return redirect()->back()->withSuccess('All Currency Rates has been updated!');
    }
}
