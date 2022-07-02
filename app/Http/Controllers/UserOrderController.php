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

class UserOrderController extends Controller
{
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
            'status' => $status,
        ]);

        $orderId = $order->id;
        $data = new stdClass();
        $data->name = $user->name;
        $data->email = $user->email;
        $data->phone = $user->phone;
        $data->order = $orderId;
        $data->link = route('order.edit', $orderId);

        Mail::to(env('ADMIN_MAIL_FOR_CONTACTS'))->send(new OrderMailer($data));

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
}
