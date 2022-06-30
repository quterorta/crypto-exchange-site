<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpecification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class CategoryController extends Controller
{
    public function categoryDetailView($slug, Request $request)
    {
        $specifications = ProductSpecification::all()->unique('title');
        $currentCategory = Category::where('slug', $slug)->first();
        $products = $currentCategory->products();
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

        return view('pages.frontend.product.all-category-products', compact('products', 'specifications', 'currentCategory'));
    }

    public function getSortParams($sortType)
    {
        if ($sortType == 'sort_by_name_asc') {
            return 'title';
        }
        if ($sortType == 'sort_by_name_desc') {
            return ['title', BaseController::ORDER_BY_DESC];
        }
        if ($sortType == 'sort_by_price_asc') {
            return 'price';
        }
        if ($sortType == 'sort_by_price_desc') {
            return ['price', BaseController::ORDER_BY_DESC];
        }
        if ($sortType == 'sort_by_date_acs') {
            return 'created_at';
        }
        if ($sortType == 'sort_by_date_desc') {
            return ['created_at', BaseController::ORDER_BY_DESC];
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
}
