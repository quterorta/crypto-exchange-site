<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurrencyController extends Controller
{
    private $title = 'Currency';
    private $titleMany = 'Currencies';

    public function index()
    {
        $title = $this->titleMany;
        $currencies = Currency::paginate(20);
        return view('pages.admin.currency.index', compact('title', 'currencies'));
    }

    public function create()
    {
        $title = $this->title;
        $titleMany = $this->titleMany;
        return view('pages.admin.currency.create', compact('title', 'titleMany'));
    }

    public function store(Request $request)
    {
        $currency = new Currency();

        $currency->name = $request->name;
        $currency->code = $request->code;
        $path_image = $request->file('image')->store('currency');
        $currency->image = $path_image;

        $currency->save();

        return redirect()->route('currency.index')->withSuccess('Currency successfully added!');
    }

    public function show(Currency $currency)
    {
        //
    }

    public function edit(Currency $currency)
    {
        $title = $this->title;
        $titleMany = $this->titleMany;
        return view('pages.admin.currency.edit', compact('title', 'titleMany', 'currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $currency->name = $request->name;
        if ($request->file('image')) {
            Storage::delete($currency->image);
            $path_image = $request->file('image')->store('currency');
            $currency->image = $path_image;
        }
        $currency->code = $request->code;

        $currency->save();

        return redirect()->route('currency.index')->withSuccess('Currency changed successfully');
    }

    public function destroy(Currency $currency)
    {
        $currencyName = $currency->name;
        Storage::delete($currency->image);
        $currency->delete();

        return redirect()->back()->withSuccess('Currency "'.$currencyName.'" deleted!');
    }
}
