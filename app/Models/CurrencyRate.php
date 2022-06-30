<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Http;

class CurrencyRate extends Model
{
    use HasFactory;

    public function getFromCurrency()
    {
        $currencyId = $this->from_currency_id;
        return Currency::find($currencyId);
    }

    public function getToCurrency()
    {
        $currencyId = $this->to_currency_id;
        return Currency::find($currencyId);
    }

    public function getRate($from, $to)
    {
        $from = $from->code;
        $to = $to->code;

        if ($from == $to) {
            return 1;
        }

        if ($this->isFiat($to)) {
            $rate = $this->sendRequest($from, $to);
            if (!$rate) {
                $rate = $this->sendRequest($to, $from);
                if (!$rate) {
                    return 0;
                }
            }
            return $rate;
        } else {
            if ($from == 'BTC') {
                $inverseRate = $this->sendRequest($to, $from);
                if (!$inverseRate) {
                    $inverseRate = $this->sendRequest($to, $from);
                    if (!$inverseRate) {
                        return 0;
                    }
                    return 1/$inverseRate;
                }
                return 1/$inverseRate;
            } else {
                $rate = $this->sendRequest($from, $to);
                if (!$rate) {
                    $rate = $this->sendRequest($to, $from);
                    if (!$rate) {
                        return 0;
                    }
                }
                return $rate;
            }
        }
    }

    public function isFiat($code)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->get(AdminController::CURRENCIES_API_URL);

        if ($response->failed() || $response->clientError() || $response->serverError()) {
            return false;
        }

        $rates = json_decode($response, true)['rates'];
        $i = 0;
        $codes = array_keys($rates);

        foreach ($rates as $rate) {
            if (stripos($codes[$i], $code)) {
                if ($rate['type'] == 'fiat') {
                    return true;
                }
            }
            $i++;
        }
        return false;
    }

    public function sendRequest($from, $to)
    {
        $urlApi = AdminController::RATE_WITH_SYMBOL_API_URL.$from.$to;
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->get($urlApi);

        if ($response->failed() || $response->clientError() || $response->serverError()) {
            return false;
        }

        return json_decode($response, true)['price'];
    }
}
