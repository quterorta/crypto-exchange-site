<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurrencyRateController extends Controller
{
    private $title = 'Currency Rate';
    private $titleMany = 'Currency Rates';

    private $currencyRateModel;

    public function __construct(
        CurrencyRate $currencyRateModel
    ) {
        $this->currencyRateModel = $currencyRateModel;
    }

    public function index()
    {
        $title = $this->titleMany;
        $currencyRates = CurrencyRate::paginate(20);

        return view('pages.admin.currency-rate.index', compact('title', 'currencyRates'));
    }

    public function create()
    {
        $title = $this->title;
        $titleMany = $this->titleMany;
        $currencies = Currency::all();

        return view('pages.admin.currency-rate.create', compact('title', 'titleMany', 'currencies'));
    }

    public function store(Request $request)
    {
        $currencyRates = CurrencyRate::where('from_currency_id', $request->from_currency_id)
            ->where('to_currency_id', $request->to_currency_id)
            ->exists();

        if ($currencyRates) {
            return redirect()->back()->withError('Currency Rate already exists!');
        }

        $currencyRate = new CurrencyRate();

        $currencyRate->from_currency_id = $request->from_currency_id;
        $currencyRate->to_currency_id = $request->to_currency_id;
        $currencyRate->reserve = $request->reserve;

        if (Currency::find($request->from_currency_id)->exists()) {
            $currencyFrom = Currency::find($request->from_currency_id);
        }
        if (!isset($currencyFrom)) {
            return redirect()->back()->withError('One of currency not fined, check currency code for "From Currency"!');
        }

        if (Currency::find($request->to_currency_id)->exists()) {
            $currencyTo = Currency::find($request->to_currency_id);
        }
        if (!isset($currencyTo)) {
            return redirect()->back()->withError('One of currency not fined, check currency code for "To Currency"!');
        }

        $currencyRate->rate = $this->currencyRateModel->getRate($currencyFrom, $currencyTo);

        $currencyRate->save();

        return redirect()->route('currency-rate.index')->withSuccess('Currency rate added!');
    }

    public function show(CurrencyRate $currencyRate)
    {
        //
    }

    public function edit(CurrencyRate $currencyRate)
    {
        $title = $this->title;
        $titleMany = $this->titleMany;
        $currencies = Currency::all();

        return view('pages.admin.currency-rate.edit', compact('title', 'titleMany', 'currencyRate', 'currencies'));
    }

    public function update(Request $request, CurrencyRate $currencyRate)
    {
        $currencyRate->from_currency_id = $request->from_currency_id;
        $currencyRate->to_currency_id = $request->to_currency_id;
        $currencyRate->reserve = $request->reserve;

        if (Currency::find($request->from_currency_id)->exists()) {
            $currencyFrom = Currency::find($request->from_currency_id);
        }
        if (!isset($currencyFrom)) {
            return redirect()->back()->withError('One of currency not fined, check currency code for "From Currency"!');
        }

        if (Currency::find($request->to_currency_id)->exists()) {
            $currencyTo = Currency::find($request->to_currency_id);
        }
        if (!isset($currencyTo)) {
            return redirect()->back()->withError('One of currency not fined, check currency code for "To Currency"!');
        }

        $currencyRate->rate = $this->currencyRateModel->getRate($currencyFrom, $currencyTo);

        $currencyRate->save();

        return redirect()->route('currency-rate.index')->withSuccess('Currency rate changed!');
    }

    public function destroy(CurrencyRate $currencyRate)
    {
        $title = Currency::find($currencyRate->from_currency_id)->code.' - '.Currency::find($currencyRate->to_currency_id)->code;
        $currencyRate->delete();

        return redirect()->back()->withSuccess('Currency Rate "'.$title.'" deleted!');
    }
}
