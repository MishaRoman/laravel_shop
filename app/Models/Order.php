<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public static function eraseOrderSum()
    {
        session()->forget('full_order_sum');
    }

    public static function changeFullPrice($changeSum)
    {
        $sum = self::getFullPrice() + $changeSum;
        session(['full_order_sum' => $sum]);
    }

    public static function getFullPrice()
    {
        return session('full_order_sum', 0);
    }

    public function calculateFullPrice()
    {
        $sum = 0;
        foreach ($this->products()->withTrashed()->get() as $product) {
            $sum += $product->getPriceForCount();
        }
        return $sum;
    }

    public function saveOrder($name, $phone)
    {
        if($this->status == 0) {
            $this->name = $name;
            $this->phone = $phone;
            $this->status = 1;
            $this->save();

            session()->forget('orderId');

            return true;
        } else {
            return false;
        }
        
    }
}
