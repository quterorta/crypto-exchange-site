<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;

    public function inRatesLikeTo(): HasMany
    {
        return $this->hasMany(CurrencyRate::class, 'to_currency_id');
    }

    public function inRatesLikeFrom()
    {
        return $this->hasMany(CurrencyRate::class, 'from_currency_id');
    }

    public function hasExchangeRates(): bool
    {
        if (CurrencyRate::where('from_currency_id', $this->id)->exists()) {
            return true;
        }
        return false;
    }

    public function getExchangeRates()
    {
        if (CurrencyRate::where('from_currency_id', $this->id)->exists()) {
            $currencyRates = CurrencyRate::where('from_currency_id', $this->id)->get();
            $data = [];
            if (is_iterable($currencyRates)) {
                foreach ($currencyRates as $currencyRate) {
                    $from = Currency::find($currencyRate->from_currency_id);
                    $to = Currency::find($currencyRate->to_currency_id);
                    $fromCode = $from->code;
                    $fromImage = $from->image;
                    $toCode = $to->code;
                    $toImage = $to->image;
                    $rate = $currencyRate->rate;
                    $reserve = $currencyRate->reserve;
                    $data[] = [
                        'from' => $fromCode,
                        'fromImage' => $fromImage,
                        'to' => $toCode,
                        'toImage' => $toImage,
                        'rate' => $rate,
                        'reserve' => $reserve,
                    ];
                }
                return $data;
            } else {
                $from = Currency::find($currencyRates->from_currency_id);
                $to = Currency::find($currencyRates->to_currency_id);
                $fromCode = $from->code;
                $fromImage = $from->image;
                $toCode = $to->code;
                $toImage = $to->image;
                $rate = $currencyRates->rate;
                $reserve = $currencyRates->reserve;
                $data = [
                    'from' => $fromCode,
                    'fromImage' => $fromImage,
                    'to' => $toCode,
                    'toImage' => $toImage,
                    'rate' => $rate,
                    'reserve' => $reserve,
                ];
            }
                return $data;
            }
        return null;
    }
}
