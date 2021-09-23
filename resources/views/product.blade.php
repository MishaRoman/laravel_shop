@extends('layouts.layout')

@section('title', 'Товар')

@section('content')
    <h1>{{ $sku->product->__('name') }}</h1>
    <h2>{{ $sku->product->category->name }}</h2>
    <p>Цена: 
        <b>
            {{ $sku->price }}
            {{-- Переменная $currencySymbol передана из App\Providers\ViewServiceProvider --}}
            {{ $currencySymbol }}
        </b>
    </p>
    @isset($sku->product->properties)
        @foreach($sku->propertyOptions as $propertyOption)
            <h4>{{ $propertyOption->property->name }}: {{ $propertyOption->name }}</h4>
        @endforeach
    @endisset
    
    <img src="{{ Storage::url($sku->product->image) }}">
    <p>{{ $sku->product->__('description') }}</p>

     @if($sku->isAvailable())
        <form action="{{ route('basket-add', $sku->product) }}" method="POST">
            <button type="submit" class="btn btn-success" role="button">Добавить в корзину</button>

            @csrf
        </form>
    @else

        <span>Не доступен</span>
        <br>
        <span>Сообщить мне, когда товар появится в наличии:</span>
        @include('layouts.error', ['fieldName' => 'email'])
        <form method="POST" action="{{ route('subscription', $sku) }}">
            @csrf
            <input type="email" name="email"></input>
            <button type="submit">Отправить</button>
        </form>
    @endif

@endsection