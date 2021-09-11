<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Person\OrderController as PersonOrderController;


Auth::routes([
	'reset' => false,
	'confirm' => false,
	'verify' => false,

]);

Route::get('reset', [ResetController::class, 'reset'])->name('reset');

Route::get('/logout', [LoginController::class, 'logout'])->name('get-logout');

Route::get('/', [MainController::class, 'home'])->name('home');

Route::middleware(['auth'])->group(function() {
	Route::group([
		'prefix' 	=> 'person',
		'namespace' => 'person',
	], function() {
		Route::get('orders',  [PersonOrderController::class, 'index'])->name('person.orders.index');
		Route::get('orders/{order}',  [PersonOrderController::class, 'show'])->name('person.orders.show');
	});
	Route::group([
		'prefix' => 'admin',
	], function() {
		Route::resource('categories', CategoryController::class);
		Route::resource('products', ProductController::class);

		Route::group(['middleware' => 'is_admin'], function() {
			Route::get('orders',  [OrderController::class, 'orders'])->name('orders');
			Route::get('orders/{order}',  [OrderController::class, 'show'])->name('orders.show');
		});
	});
});



Route::get('/categories', [MainController::class, 'categories'])->name('categories');

Route::group(['prefix'	 => 'basket',], function() {
	Route::post('/add/{id}', [BasketController::class, 'basketAdd'])->name('basket-add');

	Route::group([
		'middleware' => 'basket_not_empty',
	], function() {
		Route::get('/', [BasketController::class, 'basket'])->name('basket');
		Route::get('/place', [BasketController::class, 'basketPlace'])->name('basket-place');
		Route::post('/confirm', [BasketController::class, 'basketConfirm'])->name('basket-confirm');
		Route::post('/remove/{id}', [BasketController::class, 'basketRemove'])->name('basket-remove');
	});
});


Route::get('/{category}', [MainController::class, 'category'])->name('category');

Route::get('/{category}/{param?}', [MainController::class, 'product'])->name('product');





