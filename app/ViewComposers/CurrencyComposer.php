<?php 

namespace App\ViewComposers;

use Illuminate\View\View;
use App\Models\Category;
use App\Services\CurrencyConversion;

class CurrencyComposer
{
	public function compose(View $view)
	{
		$currencies = CurrencyConversion::getCurrencies();

		$view->with('currencies', $currencies);
	}
}