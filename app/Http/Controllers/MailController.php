<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use stdClass;
use App\Mail\ContactMailer;
use App\Mail\FooterContactMail;
use App\Mail\PageContactMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function productDetailContactForm(Request $request)
    {
        $product = Product::find($request->productId);

        $data = new stdClass();

        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->comment = $request->comment;
        $data->product_link = route('product-detail', $product->slug);

        Mail::to($this->getAdminMail())->send(new ContactMailer($data));

        return redirect()->back()->withSuccess('Aplicația ta a fost trimisă!');
    }

    public function footerContactForm(Request $request)
    {
        $data = new stdClass();

        $data->name = $request->name;
        $data->phone = $request->phone;

        Mail::to($this->getAdminMail())->send(new FooterContactMail($data));

        return redirect()->back()->withSuccess('Aplicația ta a fost trimisă!');
    }

    public function pageContactForm(Request $request)
    {
        $data = new stdClass();

        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->comment = $request->comment;

        Mail::to($this->getAdminMail())->send(new PageContactMail($data));

        return redirect()->back()->withSuccess('Aplicația ta a fost trimisă!');
    }

    public function getAdminMail()
    {
        return env('ADMIN_MAIL_FOR_CONTACTS');
    }
}
