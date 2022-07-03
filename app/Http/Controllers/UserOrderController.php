<?php

namespace App\Http\Controllers;

use App\Mail\OrderMailer;
use App\Models\Currency;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use stdClass;
use Illuminate\Routing\ResponseFactory;

class UserOrderController extends Controller
{
    private $responseFactory;

    public function __construct(
        ResponseFactory $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

        $user = Auth::user() ? Auth::user() : User::where('name', 'Guest')->first();
        $user_id = $user->id;
        $status = 2;

        $order = Order::create([
            'user_id' => $user_id,
            'from_currency_id' => $fromId,
            'fromCode' => $fromCode,
            'fromImage' => $fromImage,
            'to_currency_id' => $toId,
            'toCode' => $toCode,
            'toImage' => $toImage,
            'sum' => $request->sum,
            'total' => $request->total,
            'wallet' => $request->wallet,
            'email' => $request->email,
            'phone' => $request->phone,
            'telegram' => $request->telegram,
            'status' => $status,
        ]);

        $orderId = $order->id;
        $data = new stdClass();
        $data->name = $user->name;
        $data->email = $order->email;
        $data->phone = $order->phone;
        $data->telegram = $order->telegram;
        $data->order = $orderId;
        $data->link = route('order.edit', $orderId);

        $email = $this->getEmail();
        Mail::to($email)->send(new OrderMailer($data));

        return redirect()->route('order-success', compact('orderId'))->withSuccess('Exchange request successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function getEmail()
    {
        return env('ADMIN_MAIL_FOR_CONTACTS');
    }

    public function cancelOrder($orderId)
    {
        if (!Order::find($orderId)->exists()) {
            $message = 'Ticket #'.$orderId.' not fined!';
            return $this->responseFactory->view(
                'pages.frontend.order-status',
                compact('orderId', 'message')
            );
        }
        $order = Order::find($orderId);
        $user = Auth::user() ?? User::where('name', 'Guest')->first();
        if ($order->user_id !== $user->id) {
            $message = 'You can\'t cancel someone else\'s application!';
            return $this->responseFactory->view(
                'pages.frontend.order-status',
                compact('orderId', 'message')
            );
        }

        $order->status = 0;

        $order->save();

        $message = 'Your ticket #'.$orderId.' canceled!';

        return $this->responseFactory->view(
            'pages.frontend.order-status',
            compact('orderId', 'message')
        );
    }

    public function confirmOrder($orderId)
    {
        if (!Order::find($orderId)->exists()) {
            $message = 'Ticket #'.$orderId.' not fined!';
            return $this->responseFactory->view(
                'pages.frontend.order-status',
                compact('orderId', 'message')
            );
        }
        $order = Order::find($orderId);
        $user = Auth::user() ?? User::where('name', 'Guest')->first();
        if ($order->user_id !== $user->id) {
            $message = 'You can\'t cancel someone else\'s application!';
            return $this->responseFactory->view(
                'pages.frontend.order-status',
                compact('orderId', 'message')
            );
        }

        $order->status = 4;

        $order->save();

        $message = 'Thank you for the ticket #'.$orderId.' fee. Wait for confirmation of payment from our side.';

        return $this->responseFactory->view(
            'pages.frontend.order-status',
            compact('orderId', 'message')
        );
    }
}
