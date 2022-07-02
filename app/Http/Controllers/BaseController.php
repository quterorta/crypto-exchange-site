<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\CurrencyRate;
use App\Models\Order;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\ResponseFactory;

class BaseController extends Controller
{
    public const ORDER_BY_DESC = 'DESC';
    public const ORDER_BY_ASC = 'ASC';

    private $responseFactory;

    private $currencyRateModel;

    public function __construct(
        ResponseFactory $responseFactory,
        CurrencyRate $currencyRateModel
    ) {
        $this->responseFactory = $responseFactory;
        $this->currencyRateModel = $currencyRateModel;
    }

    public function homePageView()
    {
        $currencies = Currency::all();
        $orders = Order::where('status', 1)->limit(10)->get();
        $reviews = Review::where('moderated', 1)->orderByDesc('created_at')->limit(10)->get();
        $currencyRates = CurrencyRate::where('reserve', '>', 0)->get();
        return $this->responseFactory->view(
            'pages.frontend.home',
            compact('currencies', 'orders', 'reviews', 'currencyRates')
        );
    }

    public function aboutUsPageView()
    {
        return $this->responseFactory->view(
            'pages.frontend.about-us',
        );
    }

    public function exchangePageView(Request $request)
    {
        $currencies = Currency::all();
        $user = Auth::user() ? Auth::user() : null;

        return $this->responseFactory->view(
            'pages.frontend.exchange',
            compact('currencies', 'request', 'user')
        );
    }
    public function reviewsPageView()
    {
        return view('pages.frontend.home');
    }
    public function faqPageView()
    {
        return $this->responseFactory->view(
            'pages.frontend.faq'
        );
    }
    public function accountPageView()
    {
        $user = Auth::user();

        return $this->responseFactory->view(
            'pages.frontend.account',
            compact('user')
        );
    }

    public function getRateFrontend(Request $request)
    {
        $from = Currency::find($request->from);
        $to = Currency::find($request->to);
        $sum = $request->sum;

        $rate = $this->currencyRateModel->getRate($from, $to) * $sum;

        return response()->json($rate);
    }

    public function orderSuccessView(Request $request)
    {
        $order = Order::find($request->orderId);

        return $this->responseFactory->view(
            'pages.frontend.order-success',
            compact('request', 'order')
        );
    }
}

