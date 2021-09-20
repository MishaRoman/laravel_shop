<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Classes\Basket;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function basket()
    {
        $order = (new Basket())->getOrder();
        

        return view('basket', compact('order'));
    }

    public function basketPlace()
    {
        $basket = new Basket();
        $order = $basket->getOrder();
        if(!$basket->countAvailable()) {
            session()->flash('warning', "Товар недоступен для заказа в полном объеме");
            return redirect()->route('basket');
        }

        return view('order', compact('order'));
    }

    public function basketConfirm(Request $request)
    {
        $email = Auth::check() ? Auth::user()->email : $request->email;
        $success = (new Basket())->saveOrder($request->name, $request->phone, $email);

        if ($success) {
            session()->flash('success', __('basket.order_confirmed'));
        } else {
            session()->flash('warning', 'Случилась ошибка');
        }

        return redirect()->route('home');
    }

    public function basketAdd(Product $product)
    {
        $result = (new Basket(true))->addProduct($product);

        if ($result) {
            session()->flash('success', "Добавлен товар $product->name");
        } else {
            session()->flash('warning', "Товар $product->name в большем количестве недоступен для заказа");
        }

        return redirect()->route('basket');
    }

    public function basketRemove(Product $product)
    {
        (new Basket())->removeProduct($product);

        session()->flash('warning', "Удален товар $product->name");

        return redirect()->route('basket');
    }
    
}
