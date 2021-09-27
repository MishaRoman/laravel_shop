<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\CurrencyConversion;


class Sku extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['count', 'product_id', 'price'];

    protected $visible = ['id', 'count', 'price', 'product_name'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function propertyOptions()
    {
        return $this->belongsToMany(PropertyOption::class, 'sku_proprety_option')->withTimestamps();
    }

    public function isAvailable()
    {
        return !$this->product->trashed() && $this->count > 0;
    }

    public function getPriceForCount()
    {
        if(!is_null($this->pivot)) {
            return $this->pivot->count * $this->price;
        }
        return $this->price;
    }

    public function getPriceAttribute($value)
    {
        return round(CurrencyConversion::convert($value), 2);
    }

    public function scopeAvailable($query)
    {
        return $query->where('count', '>', 0);
    }

    public function getProductNameAttribute()
    {
        return $this->product->name;
    }
}
