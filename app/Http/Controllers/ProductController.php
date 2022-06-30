<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productDetailView($slug)
    {
        $product = Product::where('slug', $slug)->first();
        return view('pages.frontend.product.detail', compact('product'));
    }
}
