@extends('layouts.layout')

@section('title', 'Товар')

@section('content')
    <h1>{{ $product->__('name') }}</h1>
    <h2>{{ $product->category->name }}</h2>
    <p>Цена: <b>{{ $product->price }} ₽</b></p>
    <img src="{{ Storage::url($product->image) }}">
    <p>{{ $product->__('description') }}</p>

     @if($product->isAvailable())
        <form action="{{ route('basket-add', $product) }}" method="POST">
            <button type="submit" class="btn btn-success" role="button">Добавить в корзину</button>

            @csrf
        </form>
    @else

        <span>Не доступен</span>
        <br>
        <span>Сообщить мне, когда товар появится в наличии:</span>
        @include('layouts.error', ['fieldName' => 'email'])
        <form method="POST" action="{{ route('subscription', $product) }}">
            @csrf
            <input type="email" name="email"></input>
            <button type="submit">Отправить</button>
        </form>
    @endif

@endsection