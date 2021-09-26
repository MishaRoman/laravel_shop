<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\CurrencyConversion;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['layouts.layout', 'categories'], 'App\ViewComposers\CategoriesComposer');
        View::composer(['layouts.layout', 'auth.coupons.form'], 'App\ViewComposers\CurrencyComposer');
        View::composer(['layouts.layout'], 'App\ViewComposers\BestProductsComposer');

        View::composer('*', function ($view) {
            $currencySymbol = CurrencyConversion::getCurrencySymbol();
            $view->with('currencySymbol', $currencySymbol);
        });
        
    }
}
