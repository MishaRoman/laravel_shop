<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class MainController extends Controller
{
    public function home() {
        $products = Product::get();
        return view('home', compact('products'));
    }

    public function categories() {
        $categories = Category::get();
        return view('categories', compact('categories'));
    }

    public function product($category, $product = null) {
        return view('product', ['product' => $product]);
    }

    public function basket() {
        return view('basket');
    }

    public function basketPlace() {
        return view('order');
    }

    public function category($code) {
        $category = Category::where('code', $code)->first();
        return view('category', compact('category'));
    }
}
