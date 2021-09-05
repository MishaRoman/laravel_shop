<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;


Auth::routes([
	'reset' => false,
	'confirm' => false,
	'verify' => false,

]);

Route::get('/logout', [LoginController::class, 'logout'])->name('get-logout');

Route::get('/home', [HomeController::class, 'index'])->name('index');

Route::get('/',  [MainController::class, 'home'])->name('home');

Route::get('/categories', [MainController::class, 'categories'])->name('categories');

Route::get('/basket', [BasketController::class, 'basket'])->name('basket');
Route::get('/basket/place', [BasketController::class, 'basketPlace'])->name('basket-place');
Route::post('/basketconfirm', [BasketController::class, 'basketConfirm'])->name('basket-confirm');
Route::post('/basket/add/{id}', [BasketController::class, 'basketAdd'])->name('basket-add');
Route::post('/basket/remove/{id}', [BasketController::class, 'basketRemove'])->name('basket-remove');

Route::get('/{category}', [MainController::class, 'category'])->name('category');

Route::get('/{category}/{param?}', [MainController::class, 'product'])->name('product');





