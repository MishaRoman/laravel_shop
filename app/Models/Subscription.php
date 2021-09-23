<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendSubscriptionMessage;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'sku_id'];

    public function scopeActiveBySkuId($query, $skuId)
    {
        return $query->where('status', 0)->where('sku_id', $skuId);
    }

    public function product()
    {
        return $this->belongsTo(Sku::class);
    }

    public static function sendMailsBySubscription(Sku $sku)
    {
        $subscriptions = self::activeBySkutId($sku->id)->get();

        foreach($subscriptions as $subscription) {
            Mail::to($subscription->email)->send(new SendSubscriptionMessage($sku));

            $subscription->status = 1;
            $subscription->save();
        }
    }
}
