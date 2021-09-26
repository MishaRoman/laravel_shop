<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Coupon;
use App\Http\Requests\AddCouponRequest;
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
        $basket = new Basket();
        if ($basket->getOrder()->hasCoupon() && !$basket->getOrder()->coupon->availableForUse()) {
            $basket->clearCoupon();
            session()->flash('warning', 'Купон не доступен для использования');
            return redirect()->route('basket');
        }

        $email = Auth::check() ? Auth::user()->email : $request->email;
        $success = (new Basket())->saveOrder($request->name, $request->phone, $email);

        if ($success) {
            session()->flash('success', __('basket.order_confirmed'));
        } else {
            session()->flash('warning', 'Случилась ошибка');
        }

        return redirect()->route('home');
    }

    public function basketAdd(Sku $sku)
    {
        $result = (new Basket(true))->addSku($sku);

        if ($result) {
            session()->flash('success', 'Добавлен товар ' . $sku->product->name);
        } else {
            session()->flash('warning', 'Товар ' . $sku->product->name . ' в большем количестве недоступен для заказа');
        }

        return redirect()->route('basket');
    }

    public function basketRemove(Sku $sku)
    {
        (new Basket())->removeSku($sku);

        session()->flash('warning', 'Удален товар ' . $sku->product->name);

        return redirect()->route('basket');
    }

    public function setCoupon(AddCouponRequest $request)
    {
        $coupon = Coupon::where('code', $request->coupon)->first();
        if ($coupon->availableForUse()) {
            (new Basket())->setCoupon($coupon);
            session()->flash('success', 'Купон был добавлен к заказу');
        } else {
            session()->flash('warning', 'Купон не может быть использован');
        }

        return redirect()->route('basket');
    }
    
}
