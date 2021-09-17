<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@lang('main.online_shop'): @yield('title')</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('/css/starter-template.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('home') }}">@lang('main.online_shop')</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li @routeactive('home')><a href="{{ route('home') }}">@lang('main.all_products')</a></li>
                <li @routeactive('categor*')><a href="{{ route('categories') }}">Категории</a>
                <li @routeactive('basket*')><a href="{{ route('basket') }}">В корзину</a></li>
                <li><a href="{{ route('reset') }}">Сбросить проект в начальное состояние</a></li>
                <li><a href="{{ route('locale', __('main.set_lang')) }}">@lang('main.set_lang')</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle"
                        data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ App\Services\CurrencyConversion::getCurrencySymbol() }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        @foreach (App\Services\CurrencyConversion::getCurrencies() as $currency)
                            <li><a href="{{ route('currency', $currency->code) }}">{{ $currency->symbol }}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>

             <ul class="nav navbar-nav navbar-right">
                @guest
                    <li><a href="{{ route('login') }}">Войти</a></li>
                @endguest

                @auth
                    @admin
                        <li><a href="{{ route('orders') }}">Панель администратора</a></li>
                    @else
                        <li><a href="{{ route('person.orders.index') }}">Мои заказы</a></li>
                    @endadmin
                    <li><a href="{{ route('get-logout') }}">Выйти</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="starter-template">
        @if(session()->has('success'))
            <p class="alert alert-success">{{ session()->get('success') }}</p>
        @endif
        @if(session()->has('warning'))
            <p class="alert alert-warning">{{ session()->get('warning') }}</p>
        @endif
        @yield('content')
    </div>
</div>
</body>
</html>
