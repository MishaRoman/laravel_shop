<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Subscription;
use App\Http\Requests\SubscriptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class MainController extends Controller
{
    public function home(ProductsFilterRequest $request)
    {
        $productQuery = Product::with('category');

        if($request->filled('price_from')) {
            $productQuery->where('price', '>=', $request->price_from);
        }

        if($request->filled('price_to')) {
            $productQuery->where('price', '<=', $request->price_to);
        }

        foreach(['hit', 'new', 'recommend'] as $field) {
            if($request->has($field)) {
                $productQuery->$field();
            }
        }

        $products = $productQuery->paginate(6)->withPath('?' . $request->getQueryString());
        return view('index', compact('products'));
    }

    public function categories()
    {
        $categories = Category::get();
        return view('categories', compact('categories'));
    }

    public function product($category, $productCode)
    {
        $product = Product::withTrashed()->byCode($productCode)->firstOrFail();
        return view('product', compact('product'));
    }

    public function category($code)
    {
        $category = Category::where('code', $code)->firstOrFail();
        return view('category', compact('category'));
    }

    public function subscribe(SubscriptionRequest $request, Product $product)
    {
        Subscription::create([
            'email' => $request->email,
            'product_id' => $product->id,
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
