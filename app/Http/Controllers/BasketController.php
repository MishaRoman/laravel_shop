<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Classes\Basket;

class BasketController extends Controller
{
    public function basket()
    {
        $order = (new Basket())->getOrder();
        

        return view('basket', compact('order'));
    }

    public function basketPlace()
    {
        $order = (new Basket())->getOrder();

        return view('order', compact('order'));
    }

    public function basketConfirm(Request $request)
    {

        $success = (new Basket())->saveOrder($request->name, $request->phone);

        if ($success) {
            session()->flash('success', 'Ваш заказ принят на обработку');
        } else {
            session()->flash('warning', 'Случилась ошибка');
        }

        Order::eraseOrderSum();

        return redirect()->route('home');
    }

    public function basketAdd(Product $product)
    {
        (new Basket(true))->addProduct($product);

        session()->flash('success', 'Добавлен товар ' . $product->name);

        return redirect()->route('basket');
    }

    public function basketRemove(Product $product)
    {
        (new Basket())->removeProduct($product);

        session()->flash('warning', 'Удален товар ' . $product->name);

        return redirect()->route('basket');
    }
    
}
