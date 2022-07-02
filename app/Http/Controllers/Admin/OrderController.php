<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\CurrencyRate;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;

class OrderController extends Controller
{
    private $responseFactory;

    private $title = 'Order';
    private $titleMany = 'Orders';

    private $currencyRateModel;

    public function __construct(
        ResponseFactory $responseFactory,
        CurrencyRate $currencyRateModel
    ) {
        $this->responseFactory = $responseFactory;
        $this->currencyRateModel = $currencyRateModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $orders = Order::paginate(20);
        $titleMany = $this->titleMany;
        $title = $this->title;
        return $this->responseFactory->view(
            'pages.admin.order.index',
            compact('orders', 'titleMany', 'title')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titleMany = $this->titleMany;
        $title = $this->title;
        $currencies = Currency::all();
        $users = User::all();
        return $this->responseFactory->view(
            'pages.admin.order.create',
            compact('titleMany', 'title', 'currencies', 'users')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (!Currency::find($request->from_currency_id)->exists()) {
            return redirect()->back()->withError('You must select "From Currency"');
        }
        if (!Currency::find($request->to_currency_id)->exists()) {
            return redirect()->back()->withError('You must select "To Currency"');
        }
        $from = Currency::find($request->from_currency_id);
        $fromId = $from->id;
        $fromCode = $from->code;
        $fromImage = $from->image;

        $to = Currency::find($request->to_currency_id);
        $toId = $to->id;
        $toCode = $to->code;
        $toImage = $to->image;

        $user = User::find($request->user_id);
        $email = $user->email ? $user->email : 'User dont have email';
        $phone = $user->phone ? $user->phone : 'User dont have phone';
        $wallet = $request->wallet ? $request->wallet : $user->wallet ? $user->wallet : 'User dont have wallet';

        $order = Order::create([
            'user_id' => $request->user_id,
            'email' => $email,
            'phone' => $phone,
            'wallet' => $wallet,
            'from_currency_id' => $fromId,
            'fromCode' => $fromCode,
            'fromImage' => $fromImage,
            'to_currency_id' => $toId,
            'toCode' => $toCode,
            'toImage' => $toImage,
            'sum' => $request->sum,
            'total' => $this->currencyRateModel->getRate($from, $to),
            'status' => $request->status,
        ]);

        return redirect()->route('order.index')->withSuccess('Order successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return Response
     */
    public function edit(Order $order)
    {
        $titleMany = $this->titleMany;
        $title = $this->title;
        $currencies = Currency::all();
        $users = User::all();
        return $this->responseFactory->view(
            'pages.admin.order.edit',
            compact('titleMany', 'title', 'currencies', 'users', 'order')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order $order
     * @return Response
     */
    public function update(Request $request, Order $order)
    {
        if (!Currency::find($request->from_currency_id)->exists()) {
            return redirect()->back()->withError('You must select "From Currency"');
        }
        if (!Currency::find($request->to_currency_id)->exists()) {
            return redirect()->back()->withError('You must select "To Currency"');
        }
        $from = Currency::find($request->from_currency_id);
        $fromId = $from->id;
        $fromCode = $from->code;
        $fromImage = $from->image;

        $to = Currency::find($request->to_currency_id);
        $toId = $to->id;
        $toCode = $to->code;
        $toImage = $to->image;

        $order->update([
            'user_id' => $request->user_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'wallet' => $request->wallet,
            'from_currency_id' => $fromId,
            'fromCode' => $fromCode,
            'fromImage' => $fromImage,
            'to_currency_id' => $toId,
            'toCode' => $toCode,
            'toImage' => $toImage,
            'sum' => $request->sum,
            'total' => $request->total,
            'status' => $request->status,
        ]);

        return redirect()->route('order.index')->withSuccess('Order has been changed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->back()->withSuccess('Order has been deleted!');
    }
}
