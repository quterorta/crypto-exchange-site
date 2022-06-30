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
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\ResponseFactory;

class BaseController extends Controller
{
    public const ORDER_BY_DESC = 'DESC';
    public const ORDER_BY_ASC = 'ASC';

    private $responseFactory;

    public function __construct(
        ResponseFactory $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

    public function homePageView()
    {
        $currencies = Currency::all();
        $orders = Order::where('status', 1)->limit(10)->get();
        $reviews = Review::orderBy('created_at')->limit(10)->get();
        $currencyRates = CurrencyRate::where('reserve', '>', 0)->get();
        return $this->responseFactory->view(
            'pages.frontend.home',
            compact('currencies', 'orders', 'reviews', 'currencyRates')
        );
    }

    public function aboutUsPageView()
    {
        $partners = Partner::all();
        return view('pages.frontend.about-us', compact('partners'));
    }

    public function contactsPageView()
    {
        $partners = Partner::all();
        return view('pages.frontend.contacts', compact('partners'));
    }

    public function allProductsPageView(Request $request)
    {
        $specifications = ProductSpecification::all()->unique('title');
        $products = Product::query();
        if ($request->input()) {
            $filterParams = [];
            foreach (array_keys($request->input()) as $reqKey) {
                if (!str_contains($reqKey, 'sort_')) {
                    if (is_iterable($request->input($reqKey))) {
                        $filterParams[str_replace('_', ' ', $reqKey)] = $request->input($reqKey);
                    }
                }
            }
            $filter_products = $this->getFilterProducts($filterParams);
        }

        if ($request->sort_type) {
            $sortParams = $this->getSortParams($request->sort_type);
            if ($sortParams) {
                if (is_array($sortParams)) {
                    if (isset($filter_products) && $filter_products) {
                        $sort_products = $filter_products->orderBy($sortParams[0], $sortParams[1]);
                    } else {
                        $sort_products = Product::orderBy($sortParams[0], $sortParams[1]);
                    }
                } else {
                    if (isset($filter_products) && $filter_products) {
                        $sort_products = $filter_products->orderBy($sortParams);
                    } else {
                        $sort_products = Product::orderBy($sortParams);
                    }
                }
            }
        }

        if (isset($sort_products)) {
            $products = $sort_products;
        }
        if (isset($filter_products) && $filter_products) {
            $products = $filter_products;
        }

        if ($request->in_stock) {
            $products = $products->where('in_stock', 1);
        }
        if ($request->popular_input) {
            $products = $products->where('popular', 1);
        }
        if ($request->new_input) {
            $products = $products->where('new_to_date', '>', $this->getCurrentDate());
        }

        $products = $products->simplePaginate(8);

        return view('pages.frontend.product.all-products', compact('products', 'specifications'));
    }

    public function getSortParams($sortType)
    {
        if ($sortType == 'sort_by_name_asc') {
            return 'title';
        }
        if ($sortType == 'sort_by_name_desc') {
            return ['title', self::ORDER_BY_DESC];
        }
        if ($sortType == 'sort_by_price_asc') {
            return 'price';
        }
        if ($sortType == 'sort_by_price_desc') {
            return ['price', self::ORDER_BY_DESC];
        }
        if ($sortType == 'sort_by_date_acs') {
            return 'created_at';
        }
        if ($sortType == 'sort_by_date_desc') {
            return ['created_at', self::ORDER_BY_DESC];
        }
        return false;
    }

    public function getFilterProducts($filterParams)
    {
        foreach(array_keys($filterParams) as $product_spec) {
            if (isset($products)) {
                if($product_spec === 'productCategories') {
                    $products = $products->whereHas('category', function (Builder $query) use ($filterParams, $product_spec) {
                        $query->whereIn('id', array_values($filterParams[$product_spec]));
                    });
                } else {
                    $products = $products->whereHas('specifications', function (Builder $query) use ($filterParams, $product_spec) {
                        $query->whereIn('title', array_keys($filterParams));
                    })->whereHas('specification_values', function (Builder $query) use ($filterParams, $product_spec) {
                        $query->whereIn('value', array_values($filterParams[$product_spec]));
                    });
                }
            } else {
                if($product_spec === 'productCategories') {
                    $products = Product::whereHas('category', function (Builder $query) use ($filterParams, $product_spec) {
                        $query->whereIn('id', array_values($filterParams[$product_spec]));
                    });
                } else {
                    $products = Product::whereHas('specifications', function (Builder $query) use ($filterParams, $product_spec) {
                        $query->whereIn('title', array_keys($filterParams));
                    })->whereHas('specification_values', function (Builder $query) use ($filterParams, $product_spec) {
                        $query->whereIn('value', array_values($filterParams[$product_spec]));
                    });
                }
            }
        }
        if (isset($products)) {
            return $products;
        }
        return false;
    }

    public function getCurrentDate()
    {
        return Carbon::now()->toDateString();
    }

    public function searchView(Request $request)
    {
        $searchRequest = $request->search;
        $products = Product::where('title', 'like', '%'.$searchRequest.'%')->orderBy('id')->paginate(20);
        return view('pages.frontend.search', compact('products', 'searchRequest'));
    }

    public function wishlistPageView(Request $request)
    {
        $productIds = json_decode(Session::get('favoriteProductIds'));
        if (!$productIds == null) {
            $products = Product::whereIn('id', array_values($productIds))->paginate(20);
        } else {
            $products = [];
        }
        $partners = Partner::all();
        return view('pages.frontend.wishlist', compact('products', 'partners'));
    }

    public function setWishlist(Request $request)
    {
        Session::put('favoriteProductIds', $request->productIds);
        return response()->json(['success']);
    }

    public function exchangePageView()
    {
        return view('pages.frontend.home');
    }
    public function reviewsPageView()
    {
        return view('pages.frontend.home');
    }
    public function faqPageView()
    {
        return view('pages.frontend.home');
    }
    public function accountPageView($userId)
    {
        return view('pages.frontend.home');
    }
}

