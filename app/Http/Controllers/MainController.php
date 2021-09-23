<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Subscription;
use App\Http\Requests\SubscriptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class MainController extends Controller
{
    public function home(ProductsFilterRequest $request)
    {
        $skuQuery = Sku::with(['product', 'product.category']);

        if($request->filled('price_from')) {
            $skuQuery->where('price', '>=', $request->price_from);
        }

        if($request->filled('price_to')) {
            $skuQuery->where('price', '<=', $request->price_to);
        }

        foreach(['hit', 'new', 'recommend'] as $field) {
            if($request->has($field)) {
                $skuQuery->whereHas('product', function($query) use ($field) {
                    $query->$field();
                });
            }
        }

        // $products = $productQuery->paginate(6)->withPath('?' . $request->getQueryString());
        $skus = $skuQuery->paginate(10)->withPath('?' . $request->getQueryString());

        return view('index', compact('skus'));
    }

    public function categories()
    {
        return view('categories');
    }

    public function sku($categoryCode, $productCode, Sku $sku)
    {
        if ($sku->product->code != $productCode) {
            abort(404, 'Product not found');
        }

        if ($sku->product->category->code != $categoryCode) {
            abort(404, 'Category not found');
        }
        return view('product', compact('sku'));
    }

    public function category($code)
    {
        $category = Category::where('code', $code)->firstOrFail();
        return view('category', compact('category'));
    }

    public function subscribe(SubscriptionRequest $request, Sku $sku)
    {
        Subscription::create([
            'email' => $request->email,
            'sku_id' => $sku->id,
        ]);

        return redirect()->back()->with('success', 'При появлении товара письмо придет вам на указанную почту');
    }

    public function changeLocale($locale)
    {
        $availableLocales = ['ru', 'en'];
        if (!in_array($locale, $availableLocales)) {
            $locale = config('app.locale');
        }
        session(['locale' => $locale]);
        App::setLocale($locale);

        return redirect()->back();
    }

    public function changeCurrency($currencyCode)
    {
        $currency = Currency::byCode($currencyCode)->firstOrFail();
        session(['currency' => $currency->code]);

        return redirect()->back();
    }
}
